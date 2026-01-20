#!/bin/bash

# Script de déploiement complet pour BEKA Theme via SCP (sans rsync)
# Déploie: Code + Base de données + Uploads

set -e

# Couleurs pour les messages
GREEN='\033[0;32m'
RED='\033[0;31m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Répertoire du script
SCRIPT_DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"

# Charger la configuration
if [ ! -f "$SCRIPT_DIR/.deploy-config" ]; then
    echo -e "${RED}Erreur: Le fichier .deploy-config n'existe pas${NC}"
    echo "Copiez .deploy-config.example en .deploy-config et configurez-le"
    exit 1
fi

source "$SCRIPT_DIR/.deploy-config"

# Configuration WordPress
LOCAL_WP_PATH="${LOCAL_WP_PATH:-../../..}"
REMOTE_WP_PATH="${REMOTE_WP_PATH:-/home/www/p702794/html/wordpress}"
LOCAL_URL="${LOCAL_URL:-http://localhost:8000}"
REMOTE_URL="${REMOTE_URL:-http://wordpress.p702794.webspaceconfig.de/}"

# Fichiers temporaires
TIMESTAMP=$(date +%Y%m%d_%H%M%S)
DB_EXPORT_FILE="db_export_${TIMESTAMP}.sql"
DB_BACKUP_FILE="db_backup_prod_${TIMESTAMP}.sql"

# Fonction pour afficher les messages
log() {
    echo -e "${GREEN}[DEPLOY]${NC} $1"
}

error() {
    echo -e "${RED}[ERREUR]${NC} $1"
}

warn() {
    echo -e "${YELLOW}[ATTENTION]${NC} $1"
}

info() {
    echo -e "${BLUE}[INFO]${NC} $1"
}

# Fonction pour demander confirmation
confirm() {
    read -p "$1 (y/n) " -n 1 -r
    echo
    if [[ ! $REPLY =~ ^[Yy]$ ]]; then
        return 1
    fi
    return 0
}

# Vérification des prérequis
check_requirements() {
    log "Vérification des prérequis..."

    # Vérifier WP-CLI local
    if ! command -v wp &> /dev/null; then
        error "WP-CLI n'est pas installé localement"
        error "Installez-le: https://wp-cli.org/#installing"
        exit 1
    fi

    # Vérifier npm
    if ! command -v npm &> /dev/null; then
        error "npm n'est pas installé"
        exit 1
    fi

    # Vérifier la connexion SSH
    if ! ssh mittwald "exit" 2>/dev/null; then
        error "Impossible de se connecter à mittwald"
        exit 1
    fi

    # Vérifier WP-CLI sur le serveur
    if ! ssh mittwald "command -v wp" &> /dev/null; then
        error "WP-CLI n'est pas installé sur le serveur"
        exit 1
    fi

    log "Tous les prérequis sont satisfaits"
}

# Étape 1: Compilation des assets
build_assets() {
    log "Compilation des assets..."
    cd "$SCRIPT_DIR"
    npm run build
    log "Assets compilés avec succès"
}

# Étape 2: Déploiement des fichiers du thème
deploy_theme_files() {
    log "Déploiement des fichiers du thème..."

    # Créer une archive temporaire
    TEMP_ARCHIVE="/tmp/beka-deploy-${TIMESTAMP}.tar.gz"

    tar -czf "$TEMP_ARCHIVE" \
        --exclude='node_modules' \
        --exclude='.git' \
        --exclude='.claude' \
        --exclude='.DS_Store' \
        --exclude='*.log' \
        --exclude='.env' \
        --exclude='.deploy-config' \
        --exclude='package-lock.json' \
        --exclude='composer.lock' \
        --exclude='.gitignore' \
        --exclude='README.md' \
        --exclude='DEPLOYMENT.md' \
        --exclude='.deploy-config.example' \
        -C "$SCRIPT_DIR" .

    # Créer le répertoire du thème sur le serveur
    ssh mittwald "mkdir -p $SSH_PATH"

    # Transférer l'archive
    scp "$TEMP_ARCHIVE" mittwald:/tmp/

    # Extraire l'archive sur le serveur
    ARCHIVE_NAME=$(basename "$TEMP_ARCHIVE")
    ssh mittwald "cd $SSH_PATH && tar -xzf /tmp/$ARCHIVE_NAME && rm /tmp/$ARCHIVE_NAME"

    # Supprimer l'archive locale
    rm "$TEMP_ARCHIVE"

    # Correction des permissions
    log "Correction des permissions..."
    ssh mittwald "cd $SSH_PATH && find . -type d -exec chmod 755 {} \; && find . -type f -exec chmod 644 {} \;"

    log "Fichiers du thème déployés avec succès"
}

# Étape 3: Export de la base de données locale
export_local_database() {
    log "Export de la base de données locale..."
    cd "$LOCAL_WP_PATH"

    wp db export "$DB_EXPORT_FILE" --allow-root

    if [ ! -f "$DB_EXPORT_FILE" ]; then
        error "L'export de la base de données a échoué"
        exit 1
    fi

    log "Base de données locale exportée: $DB_EXPORT_FILE"
}

# Étape 4: Backup de la base de données de production
backup_remote_database() {
    log "Backup de la base de données de production..."

    ssh mittwald "cd $REMOTE_WP_PATH && wp db export $DB_BACKUP_FILE"

    log "Backup de production créé: $DB_BACKUP_FILE"
}

# Étape 5: Upload et import de la base de données
import_database() {
    log "Upload de la base de données vers le serveur..."

    # Convertir le chemin relatif en absolu
    cd "$SCRIPT_DIR"
    LOCAL_WP_ABS=$(cd "$LOCAL_WP_PATH" && pwd)

    # Upload du fichier SQL
    scp "$LOCAL_WP_ABS/$DB_EXPORT_FILE" mittwald:$REMOTE_WP_PATH/

    log "Import de la base de données sur le serveur..."

    # Import
    ssh mittwald "cd $REMOTE_WP_PATH && wp db import $DB_EXPORT_FILE"

    log "Base de données importée avec succès"
}

# Étape 6: Search-replace des URLs
search_replace_urls() {
    log "Remplacement des URLs ($LOCAL_URL → $REMOTE_URL)..."

    ssh mittwald "cd $REMOTE_WP_PATH && wp search-replace '$LOCAL_URL' '$REMOTE_URL' --all-tables --skip-columns=guid"

    log "URLs remplacées avec succès"
}

# Étape 7: Flush du cache
flush_cache() {
    log "Nettoyage du cache WordPress..."

    ssh mittwald "cd $REMOTE_WP_PATH && wp cache flush"

    log "Cache nettoyé"
}

# Étape 8: Nettoyage des fichiers temporaires
cleanup() {
    log "Nettoyage des fichiers temporaires..."

    # Convertir le chemin relatif en absolu
    cd "$SCRIPT_DIR"
    LOCAL_WP_ABS=$(cd "$LOCAL_WP_PATH" && pwd)

    # Local
    cd "$LOCAL_WP_ABS"
    rm -f "$DB_EXPORT_FILE"

    # Remote
    ssh mittwald "cd $REMOTE_WP_PATH && rm -f $DB_EXPORT_FILE"

    log "Nettoyage terminé"
}

# Étape optionnelle: Synchroniser les uploads
sync_uploads() {
    if confirm "Voulez-vous synchroniser les fichiers uploads (media) ?"; then
        log "Synchronisation des uploads..."

        # Convertir le chemin relatif en absolu
        cd "$SCRIPT_DIR"
        LOCAL_WP_ABS=$(cd "$LOCAL_WP_PATH" && pwd)

        # Créer une archive des uploads
        UPLOADS_ARCHIVE="/tmp/uploads-${TIMESTAMP}.tar.gz"
        tar -czf "$UPLOADS_ARCHIVE" -C "$LOCAL_WP_ABS/wp-content" uploads

        # Transférer l'archive
        scp "$UPLOADS_ARCHIVE" mittwald:/tmp/

        # Extraire sur le serveur
        ssh mittwald "cd $REMOTE_WP_PATH/wp-content && tar -xzf /tmp/uploads-${TIMESTAMP}.tar.gz && rm /tmp/uploads-${TIMESTAMP}.tar.gz"

        # Supprimer l'archive locale
        rm "$UPLOADS_ARCHIVE"

        log "Uploads synchronisés avec succès"
    else
        info "Synchronisation des uploads ignorée"
    fi
}

# Étape optionnelle: Synchroniser et activer les plugins
sync_plugins() {
    if confirm "Voulez-vous synchroniser et activer les plugins ?"; then
        log "Synchronisation des plugins..."

        # Convertir le chemin relatif en absolu
        cd "$SCRIPT_DIR"
        LOCAL_WP_ABS=$(cd "$LOCAL_WP_PATH" && pwd)

        # Obtenir la liste des plugins actifs en local
        log "Récupération de la liste des plugins actifs..."
        cd "$LOCAL_WP_ABS"
        ACTIVE_PLUGINS=$(wp plugin list --status=active --field=name --allow-root)

        # Créer une archive des plugins
        PLUGINS_ARCHIVE="/tmp/plugins-${TIMESTAMP}.tar.gz"
        tar -czf "$PLUGINS_ARCHIVE" -C "$LOCAL_WP_ABS/wp-content" plugins \
            --exclude='plugins/index.php'

        # Backup des plugins existants
        log "Backup des plugins existants..."
        ssh mittwald "cd $REMOTE_WP_PATH/wp-content && tar -czf /tmp/plugins-backup-${TIMESTAMP}.tar.gz plugins"

        # Transférer l'archive
        scp "$PLUGINS_ARCHIVE" mittwald:/tmp/

        # Extraire sur le serveur
        ssh mittwald "cd $REMOTE_WP_PATH/wp-content && tar -xzf /tmp/plugins-${TIMESTAMP}.tar.gz && rm /tmp/plugins-${TIMESTAMP}.tar.gz"

        # Corriger les permissions
        ssh mittwald "cd $REMOTE_WP_PATH/wp-content/plugins && find . -type d -exec chmod 755 {} \; && find . -type f -exec chmod 644 {} \;"

        # Supprimer l'archive locale
        rm "$PLUGINS_ARCHIVE"

        # Activer les plugins sur le serveur
        log "Activation des plugins sur le serveur..."
        echo "$ACTIVE_PLUGINS" | while read plugin; do
            if [ ! -z "$plugin" ]; then
                info "Activation de: $plugin"
                ssh mittwald "cd $REMOTE_WP_PATH && wp plugin activate $plugin 2>&1" || warn "Impossible d'activer $plugin"
            fi
        done

        log "Plugins synchronisés et activés avec succès"
        info "Backup des plugins: /tmp/plugins-backup-${TIMESTAMP}.tar.gz"
    else
        info "Synchronisation des plugins ignorée"
    fi
}

# Menu principal
show_menu() {
    echo ""
    echo -e "${BLUE}════════════════════════════════════════${NC}"
    echo -e "${BLUE}   Déploiement complet - BEKA Theme${NC}"
    echo -e "${BLUE}════════════════════════════════════════${NC}"
    echo ""
    echo "Ce script va:"
    echo "  1. Compiler les assets (npm run build)"
    echo "  2. Déployer les fichiers du thème"
    echo "  3. Backup la base de données de production"
    echo "  4. Exporter la base de données locale"
    echo "  5. Importer la base de données sur le serveur"
    echo "  6. Remplacer les URLs (${LOCAL_URL} → ${REMOTE_URL})"
    echo "  7. Nettoyer le cache"
    echo ""
    warn "ATTENTION: Cette opération va écraser la base de données de production!"
    warn "Un backup sera créé: $DB_BACKUP_FILE"
    echo ""
}

# Menu de sélection
deployment_menu() {
    echo "Que voulez-vous déployer ?"
    echo ""
    echo "  1) Tout (Code + Base de données + Uploads + Plugins)"
    echo "  2) Code uniquement (Thème)"
    echo "  3) Base de données uniquement"
    echo "  4) Uploads uniquement"
    echo "  5) Plugins uniquement"
    echo "  6) Annuler"
    echo ""
    read -p "Votre choix (1-6): " choice

    case $choice in
        1)
            deploy_full
            ;;
        2)
            deploy_code_only
            ;;
        3)
            deploy_database_only
            ;;
        4)
            deploy_uploads_only
            ;;
        5)
            deploy_plugins_only
            ;;
        6)
            log "Déploiement annulé"
            exit 0
            ;;
        *)
            error "Choix invalide"
            exit 1
            ;;
    esac
}

# Déploiement complet
deploy_full() {
    log "Déploiement complet en cours..."

    check_requirements
    build_assets
    deploy_theme_files
    backup_remote_database
    export_local_database
    import_database
    search_replace_urls
    flush_cache
    sync_uploads
    sync_plugins
    cleanup

    echo ""
    log "═══════════════════════════════════════════"
    log "Déploiement complet terminé avec succès!"
    log "═══════════════════════════════════════════"
    info "Backup de production: $DB_BACKUP_FILE (sur le serveur)"
    info "Site: $REMOTE_URL"
    echo ""
}

# Déploiement code uniquement
deploy_code_only() {
    log "Déploiement du code uniquement..."

    check_requirements
    build_assets
    deploy_theme_files
    flush_cache

    log "Déploiement du code terminé avec succès!"
}

# Déploiement base de données uniquement
deploy_database_only() {
    if ! confirm "Voulez-vous vraiment écraser la base de données de production ?"; then
        log "Déploiement annulé"
        exit 0
    fi

    log "Déploiement de la base de données uniquement..."

    check_requirements
    backup_remote_database
    export_local_database
    import_database
    search_replace_urls
    flush_cache
    cleanup

    log "Déploiement de la base de données terminé avec succès!"
}

# Déploiement uploads uniquement
deploy_uploads_only() {
    log "Synchronisation des uploads..."

    check_requirements

    # Convertir le chemin relatif en absolu
    cd "$SCRIPT_DIR"
    LOCAL_WP_ABS=$(cd "$LOCAL_WP_PATH" && pwd)

    # Créer une archive des uploads
    UPLOADS_ARCHIVE="/tmp/uploads-${TIMESTAMP}.tar.gz"
    tar -czf "$UPLOADS_ARCHIVE" -C "$LOCAL_WP_ABS/wp-content" uploads

    # Transférer l'archive
    scp "$UPLOADS_ARCHIVE" mittwald:/tmp/

    # Extraire sur le serveur
    ssh mittwald "cd $REMOTE_WP_PATH/wp-content && tar -xzf /tmp/uploads-${TIMESTAMP}.tar.gz && rm /tmp/uploads-${TIMESTAMP}.tar.gz"

    # Supprimer l'archive locale
    rm "$UPLOADS_ARCHIVE"

    log "Uploads synchronisés avec succès!"
}

# Déploiement plugins uniquement
deploy_plugins_only() {
    log "Synchronisation des plugins..."

    check_requirements

    # Convertir le chemin relatif en absolu
    cd "$SCRIPT_DIR"
    LOCAL_WP_ABS=$(cd "$LOCAL_WP_PATH" && pwd)

    # Obtenir la liste des plugins actifs
    cd "$LOCAL_WP_ABS"
    ACTIVE_PLUGINS=$(wp plugin list --status=active --field=name --allow-root)

    # Créer une archive des plugins
    PLUGINS_ARCHIVE="/tmp/plugins-${TIMESTAMP}.tar.gz"
    tar -czf "$PLUGINS_ARCHIVE" -C "$LOCAL_WP_ABS/wp-content" plugins \
        --exclude='plugins/index.php'

    # Backup des plugins existants
    log "Backup des plugins existants..."
    ssh mittwald "cd $REMOTE_WP_PATH/wp-content && tar -czf /tmp/plugins-backup-${TIMESTAMP}.tar.gz plugins"

    # Transférer l'archive
    scp "$PLUGINS_ARCHIVE" mittwald:/tmp/

    # Extraire sur le serveur
    ssh mittwald "cd $REMOTE_WP_PATH/wp-content && tar -xzf /tmp/plugins-${TIMESTAMP}.tar.gz && rm /tmp/plugins-${TIMESTAMP}.tar.gz"

    # Corriger les permissions
    ssh mittwald "cd $REMOTE_WP_PATH/wp-content/plugins && find . -type d -exec chmod 755 {} \; && find . -type f -exec chmod 644 {} \;"

    # Supprimer l'archive locale
    rm "$PLUGINS_ARCHIVE"

    # Activer les plugins
    log "Activation des plugins..."
    echo "$ACTIVE_PLUGINS" | while read plugin; do
        if [ ! -z "$plugin" ]; then
            info "Activation de: $plugin"
            ssh mittwald "cd $REMOTE_WP_PATH && wp plugin activate $plugin 2>&1" || warn "Impossible d'activer $plugin"
        fi
    done

    log "Plugins synchronisés et activés avec succès!"
    info "Backup: /tmp/plugins-backup-${TIMESTAMP}.tar.gz"
}

# Gestion des erreurs
trap 'error "Une erreur est survenue. Déploiement interrompu."; exit 1' ERR

# Exécution
show_menu

if confirm "Voulez-vous continuer ?"; then
    deployment_menu
else
    log "Déploiement annulé"
    exit 0
fi
