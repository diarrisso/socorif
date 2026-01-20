# Systeme de Fonds Decoratifs pour Blocs ACF

Ce systeme permet d'ajouter facilement des fonds decoratifs SVG professionnels a tous vos blocs ACF flexibles, avec un controle total via l'interface WordPress.

## Caracteristiques

- 4 variants de patterns SVG (Grid, Dots, Waves, Radial)
- 3 schemas de couleurs (Neutre, Principal, Secondaire)
- 3 niveaux d'opacite (Leger, Moyen, Fort)
- 3 positions verticales (Haut, Centre, Bas)
- Animation optionnelle (pulse subtil)
- Support du mode sombre (dark mode)
- Entierement controle via ACF

## Fichiers du Systeme

```
wp-content/themes/ossenberg-engels/
├── template-parts/components/
│   └── decorative-background.php       # Composant de fond decoratif
└── inc/acf-blocks/
    └── block-helpers.php                # Fonctions helper
```

## Integration dans un Bloc ACF

### Etape 1 : Ajouter les champs ACF dans config.php

```php
<?php
// Dans votre fichier config.php du bloc (ex: hero/config.php)

$base_fields = array(
    // Vos champs existants...
);

// Ajouter les champs de fond decoratif
if (function_exists('get_decorative_background_fields')) {
    $background_fields = get_decorative_background_fields('hero'); // Remplacer 'hero' par votre nom de bloc
    $all_fields = array_merge($base_fields, $background_fields);
} else {
    $all_fields = $base_fields;
}

return array(
    'label' => 'Mon Bloc',
    'display' => 'block',
    'sub_fields' => $all_fields,
);
```

### Etape 2 : Ajouter le rendu dans le template PHP

```php
<?php
// Dans votre fichier template du bloc (ex: hero/hero.php)
?>

<section class="mon-bloc relative isolate overflow-hidden">
    <?php
    // Render decorative background if enabled
    if (get_block_field('show_background_pattern', false)) {
        render_decorative_background(array(
            'variant'  => get_block_field('background_variant', 'grid'),
            'color'    => get_block_field('background_color_scheme', 'neutral'),
            'opacity'  => get_block_field('background_opacity', 'light'),
            'position' => get_block_field('background_position', 'top'),
            'animated' => get_block_field('background_animated', false),
        ));
    }
    ?>

    <!-- Votre contenu de bloc ici -->
</section>
```

### Classes CSS Requises

Votre section principale doit avoir ces classes pour que le fond fonctionne correctement :

```html
<section class="relative isolate overflow-hidden"></section>
```

## Options Disponibles

### Variants de Pattern

1. **Grid** : Grille geometrique moderne
2. **Dots** : Points reguliers subtils
3. **Waves** : Vagues fluides
4. **Radial** : Gradient radial doux

### Schemas de Couleurs

1. **Neutral** : Gris (compatible avec tous les designs)
2. **Primary** : Rouge (couleur principale du theme)
3. **Secondary** : Bleu (couleur secondaire)

### Niveaux d'Opacite

1. **Light** : Leger (30%)
2. **Medium** : Moyen (50%)
3. **Strong** : Fort (70%)

### Positions

1. **Top** : En haut du bloc
2. **Center** : Centre du bloc
3. **Bottom** : En bas du bloc

### Animation

- **Oui** : Active une animation pulse subtile
- **Non** : Fond statique

## Utilisation dans l'Admin WordPress

1. Editez votre page dans WordPress
2. Ajoutez ou editez un bloc flexible
3. Allez dans l'onglet "Background Design"
4. Activez "Activer le fond decoratif"
5. Configurez les options selon vos besoins
6. Les options s'affichent uniquement si le fond est active (logique conditionnelle)

## Exemple d'Integration Avancee

```php
<?php
// Configuration dynamique basee sur le type de bloc
$bg_config = array(
    'variant'  => get_block_field('background_variant', 'grid'),
    'color'    => get_block_field('background_color_scheme', 'neutral'),
    'opacity'  => get_block_field('background_opacity', 'light'),
    'position' => get_block_field('background_position', 'top'),
    'animated' => get_block_field('background_animated', false),
    'class'    => 'mon-fond-personnalise', // Classe CSS additionnelle
);

if (get_block_field('show_background_pattern', false)) {
    render_decorative_background($bg_config);
}
?>
```

## Personnalisation CSS

Si vous souhaitez personnaliser davantage le fond :

```css
/* Dans votre fichier CSS personnalise */
.mon-fond-personnalise svg {
  /* Personnalisations SVG */
}

.mon-fond-personnalise path {
  /* Personnalisations des paths */
}
```

## Support du Mode Sombre

Le systeme supporte automatiquement le mode sombre via les classes Tailwind :

- `dark:stroke-gray-800` : Couleur de trait en mode sombre
- `dark:fill-gray-800/50` : Remplissage en mode sombre

## Blocs Deja Integres

- Hero (hero/hero.php)

## Prochaines Etapes pour Autres Blocs

Pour integrer le systeme dans d'autres blocs :

1. Copier l'integration de config.php du bloc Hero
2. Copier le code de rendu du template Hero
3. Adapter les noms de champs selon votre bloc
4. Tester dans l'admin WordPress

## Performance

Le systeme est optimise pour la performance :

- Patterns SVG legers
- Rendu conditionnel (seulement si active)
- ID uniques pour eviter les conflits
- Pas de JavaScript requis
- Compatible avec le cache

## Accessibilite

- Attribut `aria-hidden="true"` sur tous les elements decoratifs
- Pas d'impact sur les lecteurs d'ecran
- Respect des standards WCAG

## Support Navigateurs

Compatible avec tous les navigateurs modernes :

- Chrome/Edge 90+
- Firefox 88+
- Safari 14+
- Opera 76+

## Questions Frequentes

### Q: Le fond n'apparait pas ?

R: Verifiez que votre section a les classes `relative isolate overflow-hidden`

### Q: Puis-je avoir plusieurs fonds sur la meme page ?

R: Oui, chaque bloc peut avoir son propre fond decoratif

### Q: Comment desactiver le fond pour un bloc specifique ?

R: Dans l'admin WordPress, desactivez simplement "Activer le fond decoratif"

### Q: Le fond impacte-t-il les performances ?

R: Non, les SVG sont tres legers et optimises

## Changelog

### Version 1.0.0

- Creation du systeme de fonds decoratifs
- 4 variants de patterns
- 3 schemas de couleurs
- Support complet du mode sombre
- Integration avec ACF
- Documentation complete
