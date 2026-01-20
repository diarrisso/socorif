#!/bin/bash

# Script de déploiement pour BEKA Theme
# Utilise SSH/Rsync pour déployer le thème

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

# Vérifier la méthode de déploiement
if [ "$DEPLOY_METHOD" != "ssh" ] && [ "$DEPLOY_METHOD" != "ftp" ]; then
    error "Méthode de déploiement invalide: $DEPLOY_METHOD"
    exit 1
fi

# Construire la liste d'exclusions pour rsync
EXCLUDE_ARGS=""
for exclude in "${EXCLUDE_PATHS[@]}"; do
    EXCLUDE_ARGS="$EXCLUDE_ARGS --exclude='$exclude'"
done

# Fonction de déploiement SSH
deploy_ssh() {
    log "Déploiement via SSH/Rsync vers $SSH_USER@$SSH_HOST:$SSH_PATH"

    # Vérifier la connexion SSH
    if ! ssh -p "$SSH_PORT" "$SSH_USER@$SSH_HOST" "exit" 2>/dev/null; then
        error "Impossible de se connecter à $SSH_USER@$SSH_HOST"
        exit 1
    fi

    # Construction de npm
    log "Construction des assets..."
    npm run build

    # Vérifier si rsync est disponible sur le serveur
    if ssh mittwald "test -f /usr/local/bin/rsync" 2>/dev/null; then
        REMOTE_RSYNC="/usr/local/bin/rsync"
        log "Rsync trouvé sur le serveur: $REMOTE_RSYNC"
    else
        error "Rsync n'est pas disponible sur le serveur"
        error "Utilisez ./deploy-scp.sh à la place"
        exit 1
    fi

    # Rsync avec chemin complet sur le serveur
    log "Synchronisation des fichiers..."
    eval "rsync -avz --delete --rsync-path='$REMOTE_RSYNC' -e 'ssh -p $SSH_PORT' $EXCLUDE_ARGS '$SCRIPT_DIR/' '$SSH_USER@$SSH_HOST:$SSH_PATH/'"

    # Correction des permissions (évite erreurs 403)
    log "Correction des permissions..."
    ssh -p "$SSH_PORT" "$SSH_USER@$SSH_HOST" "cd $SSH_PATH && find . -type d -exec chmod 755 {} \; && find . -type f -exec chmod 644 {} \;"

    log "Déploiement terminé avec succès!"
}

# Fonction de déploiement FTP
deploy_ftp() {
    warn "Le déploiement FTP n'est pas encore implémenté"
    warn "Utilisez la méthode SSH pour le moment"
    exit 1
}

# Exécuter le déploiement
case "$DEPLOY_METHOD" in
    ssh)
        deploy_ssh
        ;;
    ftp)
        deploy_ftp
        ;;
    *)
        error "Méthode de déploiement non supportée: $DEPLOY_METHOD"
        exit 1
        ;;
esac
