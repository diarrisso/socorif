#!/bin/bash

# Script pour ajouter les commentaires d'identification aux blocks
# Usage: ./update-blocks.sh

BLOCKS_DIR="/Users/mdiarrisso/PhpstormProjects/beka/wp-content/themes/beka/template-parts/blocks"

# Liste des blocks à traiter (nom du dossier = nom du block)
BLOCKS=(
    "cta-split"
    "details-page"
    "gallery"
    "hero-section"
    "location"
    "news"
    "partners"
    "projects-grid"
    "section-cta"
    "service-details"
    "services-icons"
    "slider"
    "stats"
    "team"
    "testimonials"
    "text-image"
    "timeline"
    "youtube-video"
)

for block in "${BLOCKS[@]}"; do
    file="${BLOCKS_DIR}/${block}/${block}.php"

    if [ ! -f "$file" ]; then
        echo "Fichier non trouvé: $file"
        continue
    fi

    echo "Traitement de $block..."

    # Créer un fichier temporaire
    tmp_file=$(mktemp)

    # Lire le fichier ligne par ligne
    start_added=false
    end_added=false

    while IFS= read -r line; do
        # Ajouter le commentaire de début après les validations PHP et avant le HTML
        if ! $start_added && [[ $line =~ ^[[:space:]]*\<(section|div) || $line =~ ^\?\>[[:space:]]*$ ]]; then
            if [[ $line =~ ^\?\>[[:space:]]*$ ]]; then
                echo "$line" >> "$tmp_file"
                echo "" >> "$tmp_file"
                echo "<?php beka_block_comment_start('$block'); ?>" >> "$tmp_file"
            else
                echo "<?php beka_block_comment_start('$block'); ?>" >> "$tmp_file"
                echo "$line" >> "$tmp_file"
            fi
            start_added=true
        else
            echo "$line" >> "$tmp_file"
        fi
    done < "$file"

    # Ajouter le commentaire de fin si pas déjà présent
    if ! grep -q "beka_block_comment_end('$block')" "$file"; then
        echo "" >> "$tmp_file"
        echo "<?php beka_block_comment_end('$block'); ?>" >> "$tmp_file"
    fi

    # Remplacer le fichier original
    mv "$tmp_file" "$file"

    echo "✓ $block mis à jour"
done

echo "Terminé!"
