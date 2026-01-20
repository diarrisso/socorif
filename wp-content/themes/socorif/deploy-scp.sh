#!/bin/bash

# Script de déploiement pour BEKA Theme via SCP (sans rsync)
# Utilise tar + scp pour déployer le thème

set -e

# Couleurs pour les messages
GREEN='\033[0;32m'
RED='\033[0;31m'
YELLOW='\033[1;33m'
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

log "Déploiement via SCP vers $SSH_USER@$SSH_HOST:$SSH_PATH"

# Vérifier la connexion SSH
if ! ssh mittwald "exit" 2>/dev/null; then
    error "Impossible de se connecter à mittwald"
    exit 1
fi

# Construction des assets
log "Construction des assets..."
npm run build

# Créer une archive temporaire en excluant les fichiers inutiles
log "Création de l'archive..."
TEMP_ARCHIVE="/tmp/beka-deploy-$(date +%s).tar.gz"

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

# Créer le répertoire du thème sur le serveur s'il n'existe pas
log "Création du répertoire distant si nécessaire..."
ssh mittwald "mkdir -p $SSH_PATH"

# Transférer l'archive
log "Transfert de l'archive..."
scp "$TEMP_ARCHIVE" mittwald:/tmp/

# Extraire l'archive sur le serveur
log "Extraction de l'archive sur le serveur..."
ARCHIVE_NAME=$(basename "$TEMP_ARCHIVE")
ssh mittwald "cd $SSH_PATH && tar -xzf /tmp/$ARCHIVE_NAME && rm /tmp/$ARCHIVE_NAME"

# Supprimer l'archive locale
rm "$TEMP_ARCHIVE"

# Correction des permissions
log "Correction des permissions..."
ssh mittwald "cd $SSH_PATH && find . -type d -exec chmod 755 {} \; && find . -type f -exec chmod 644 {} \;"

log "Déploiement terminé avec succès!"
log "Thème déployé sur: http://wordpress.p702794.webspaceconfig.de/"
