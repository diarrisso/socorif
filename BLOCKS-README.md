# BEKA - Configuration des Blocks ACF

## Statut: TERMINE

Tous les blocks ACF ont ete configures et remplis avec des donnees de test sur la page d'accueil.

## Blocks Actifs (14 au total)

1. **HERO** - Section hero avec image de fond et CTA
2. **ABOUT** - Section A propos avec caracteristiques
3. **SERVICES CARDS** - Grille de cartes de services (3 colonnes)
4. **SERVICES ICONS** - Services avec icones (4 items)
5. **PROJECTS GRID** - Grille de projets/references (4 projets)
6. **BEFORE AFTER** - Comparaison avant/apres avec slider interactif
7. **TEAM** - Presentation de l'equipe (3 membres)
8. **TESTIMONIALS** - Temoignages clients (3 temoignages)
9. **CLIENTS** - Logos des clients/partenaires (6 logos)
10. **GALLERY** - Galerie d'images (6 images)
11. **ACCORDION** - FAQ/Questions frequentes (3 items)
12. **NEWS** - Actualites/Articles (3 articles)
13. **SECTION CTA** - Call-to-action avec image
14. **YOUTUBE VIDEO** - Integration video YouTube

## Modifications Apportees

### 1. Fichier `inc/acf/flexible-content.php`
- Ajout des layouts manquants :
  - News
  - Projects Grid
  - Before/After
- Correction du layout About pour correspondre au template
- Correction du layout Services Cards (subtitle, description, columns)
- Ajout du layout Slider (bonus)

### 2. Base de donnees
- Script SQL cree : `fill-blocks-final.sql`
- Toutes les donnees sont en allemand pour correspondre au site BEKA
- Chaque block contient des donnees de test coherentes

## Structure des Templates

Chaque block suit cette structure :
```
/template-parts/blocks/
  ├── hero/
  │   └── hero.php
  ├── about/
  │   └── about.php
  ├── services-cards/
  │   └── services-cards.php
  └── ... (autres blocks)
```

## Utilisation

La page d'accueil utilise le template `front-page.php` qui boucle automatiquement sur tous les blocks :

```php
if (function_exists('have_rows') && have_rows('flexible_content')) :
    while (have_rows('flexible_content')) : the_row();
        $layout = get_row_layout();
        $block_file = BEKA_DIR . '/template-parts/blocks/' . $layout . '/' . $layout . '.php';
        if (file_exists($block_file)) {
            include $block_file;
        }
    endwhile;
endif;
```

## Verification

Pour verifier que tous les blocks sont actifs, executez :
```bash
php -r "
define('WP_USE_THEMES', false);
require_once('./wp-load.php');
\$total = get_post_meta(2, 'flexible_content', true);
for (\$i = 0; \$i < \$total; \$i++) {
    \$layout = get_post_meta(2, 'flexible_content_' . \$i . '_acf_fc_layout', true);
    echo (\$i + 1) . '. ' . \$layout . PHP_EOL;
}
"
```

## Notes Importantes

1. Tous les blocks utilisent l'ID d'image `1` pour les tests - remplacer par de vraies images
2. Les textes sont en allemand pour correspondre au marche cible
3. Le block Before/After utilise Alpine.js pour l'interactivite
4. Le block Slider a ete ajoute comme bonus (non utilise actuellement)

## Prochaines Etapes

1. Remplacer les images de test (ID: 1) par de vraies images
2. Ajuster les textes selon les besoins du client
3. Tester chaque block individuellement dans l'editeur WordPress
4. Verifier la responsivite sur mobile/tablette
