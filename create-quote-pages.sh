#!/bin/bash
# Script pour créer les pages de formulaires via WP-CLI
# Usage: bash create-quote-pages.sh

echo "Création des pages de formulaires de devis..."

# Vérifier que WP-CLI est installé
if ! command -v wp &> /dev/null; then
    echo "Erreur: WP-CLI n'est pas installé."
    echo "Installation: https://wp-cli.org/#installing"
    exit 1
fi

# Se déplacer dans le répertoire WordPress
cd "$(dirname "$0")"

echo ""
echo "1. Création: Balkonsanierung Angebot"
wp post create \
    --post_type=page \
    --post_title='Balkonsanierung Angebot' \
    --post_status=publish \
    --post_name='balkonsanierung-angebot' \
    --page_template='page-angebot-balkonsanierung.php' \
    --comment_status=closed \
    --ping_status=closed \
    --porcelain

echo "2. Création: Bauwerksabdichtung Angebot"
wp post create \
    --post_type=page \
    --post_title='Bauwerksabdichtung Angebot' \
    --post_status=publish \
    --post_name='bauwerksabdichtung-angebot' \
    --page_template='page-angebot-bauwerksabdichtung.php' \
    --comment_status=closed \
    --ping_status=closed \
    --porcelain

echo "3. Création: Beschichtung Angebot"
wp post create \
    --post_type=page \
    --post_title='Beschichtung Angebot' \
    --post_status=publish \
    --post_name='beschichtung-angebot' \
    --page_template='page-angebot-beschichtung.php' \
    --comment_status=closed \
    --ping_status=closed \
    --porcelain

echo "4. Création: Betonsanierung Angebot"
wp post create \
    --post_type=page \
    --post_title='Betonsanierung Angebot' \
    --post_status=publish \
    --post_name='betonsanierung-angebot' \
    --page_template='page-angebot-betonsanierung.php' \
    --comment_status=closed \
    --ping_status=closed \
    --porcelain

echo "5. Création: Sachverständigung Angebot"
wp post create \
    --post_type=page \
    --post_title='Sachverständigung Angebot' \
    --post_status=publish \
    --post_name='sachverstaendigung-angebot' \
    --page_template='page-angebot-sachverstaendigung.php' \
    --comment_status=closed \
    --ping_status=closed \
    --porcelain

echo "6. Création: Schimmelpilzsanierung Angebot"
wp post create \
    --post_type=page \
    --post_title='Schimmelpilzsanierung Angebot' \
    --post_status=publish \
    --post_name='schimmelpilzsanierung-angebot' \
    --page_template='page-angebot-schimmelpilzsanierung.php' \
    --comment_status=closed \
    --ping_status=closed \
    --porcelain

echo "7. Création: Page Danke"
wp post create \
    --post_type=page \
    --post_title='Vielen Dank' \
    --post_status=publish \
    --post_name='danke' \
    --page_template='page-danke.php' \
    --comment_status=closed \
    --ping_status=closed \
    --porcelain

echo ""
echo "✓ Toutes les pages ont été créées avec succès!"
echo ""
echo "Pages créées:"
echo "  - /balkonsanierung-angebot/"
echo "  - /bauwerksabdichtung-angebot/"
echo "  - /beschichtung-angebot/"
echo "  - /betonsanierung-angebot/"
echo "  - /sachverstaendigung-angebot/"
echo "  - /schimmelpilzsanierung-angebot/"
echo "  - /danke/"
echo ""
echo "Prochaines étapes:"
echo "1. Vérifier les pages dans WordPress Admin"
echo "2. Ajouter les liens dans votre menu 'Leistungen'"
