# Block Slider/Carousel

Block ACF Flexible Content pour afficher des cards en mode slider/carousel.

## Fonctionnalites

- Slider responsive avec breakpoints personnalisables
- Support de plusieurs effets de transition (slide, fade, cube, coverflow)
- Navigation avec fleches prev/next
- Pagination avec dots cliquables
- Autoplay optionnel avec pause au hover
- Mode loop infini
- Integration avec Alpine.js et Swiper.js
- Utilise le composant Card reutilisable

## Fichiers

- `slider.php` - Template du block
- `config.php` - Configuration ACF du block

## Configuration ACF

### Champs disponibles

- Sous-titre et titre de section
- Repeater de slides avec image, titre, description et lien
- Parametres d'affichage (nombre de slides par breakpoint)
- Options de comportement (loop, autoplay, vitesse, effet)
- Options de navigation (fleches, pagination)
- Options de style (couleur de fond)

## Utilisation

Le block est disponible dans le Flexible Content sous le nom "Slider/Carousel".

### Configuration recommandee

- Desktop: 3 slides visibles
- Tablet: 2 slides visibles
- Mobile: 1 slide visible
- Espacement: 30px
- Autoplay: Desactive par defaut
- Loop: Active par defaut

## Dependencies

- Swiper.js 11.x (via CDN)
- Alpine.js 3.x
- Composant Card (`template-parts/components/card.php`)

## Personnalisation

Les styles peuvent etre modifies dans `assets/src/css/main.css` sous la section "Swiper Slider Custom Styles".
