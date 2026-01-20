#!/bin/bash

# Script de déploiement des plugins WordPress
# Déploie et active les plugins de local vers production

set -e

# Couleurs pour les messages
GREEN='\033[0;32m'
RED='\033[0;31m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Répertoire du script
SCRIPT_DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"

# Configuration
LOCAL_WP_PATH="../../.."
REMOTE_WP_PATH="/home/www/p702794/html/wordpress"

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

# Vérifier la connexion SSH
if ! ssh mittwald "exit" 2>/dev/null; then
    error "Impossible de se connecter à mittwald"
    exit 1
fi

log "Déploiement des plugins WordPress"
echo ""

# Obtenir la liste des plugins actifs en local
log "Récupération de la liste des plugins actifs en local..."
cd "$SCRIPT_DIR/$LOCAL_WP_PATH"
ACTIVE_PLUGINS=$(wp plugin list --status=active --field=name --allow-root)

info "Plugins actifs en local:"
echo "$ACTIVE_PLUGINS" | while read plugin; do
    echo "  - $plugin"
done
echo ""

# Créer une archive des plugins
log "Création de l'archive des plugins..."
TIMESTAMP=$(date +%Y%m%d_%H%M%S)
PLUGINS_ARCHIVE="/tmp/plugins-${TIMESTAMP}.tar.gz"

tar -czf "$PLUGINS_ARCHIVE" -C "$LOCAL_WP_PATH/wp-content" plugins \
    --exclude='plugins/index.php'

# Transférer l'archive
log "Transfert des plugins vers le serveur..."
scp "$PLUGINS_ARCHIVE" mittwald:/tmp/

# Backup des plugins existants sur le serveur
log "Backup des plugins existants sur le serveur..."
ssh mittwald "cd $REMOTE_WP_PATH/wp-content && tar -czf /tmp/plugins-backup-${TIMESTAMP}.tar.gz plugins"

# Extraire les nouveaux plugins
log "Installation des plugins sur le serveur..."
ssh mittwald "cd $REMOTE_WP_PATH/wp-content && tar -xzf /tmp/plugins-${TIMESTAMP}.tar.gz && rm /tmp/plugins-${TIMESTAMP}.tar.gz"

# Corriger les permissions
log "Correction des permissions..."
ssh mittwald "cd $REMOTE_WP_PATH/wp-content/plugins && find . -type d -exec chmod 755 {} \; && find . -type f -exec chmod 644 {} \;"

# Activer les plugins sur le serveur
log "Activation des plugins sur le serveur..."
echo "$ACTIVE_PLUGINS" | while read plugin; do
    if [ ! -z "$plugin" ]; then
        info "Activation de: $plugin"
        ssh mittwald "cd $REMOTE_WP_PATH && wp plugin activate $plugin 2>&1" || warn "Impossible d'activer $plugin"
    fi
done

# Supprimer l'archive locale
rm "$PLUGINS_ARCHIVE"

# Vérifier l'état des plugins sur le serveur
echo ""
log "État des plugins sur le serveur:"
ssh mittwald "cd $REMOTE_WP_PATH && wp plugin list"

echo ""
log "═══════════════════════════════════════════"
log "Déploiement des plugins terminé avec succès!"
log "═══════════════════════════════════════════"
info "Backup des plugins: /tmp/plugins-backup-${TIMESTAMP}.tar.gz (sur le serveur)"
echo ""
