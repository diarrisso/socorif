# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

Socorif is a WordPress theme built with TailwindCSS v4 and Alpine.js for a Senegalese real estate and property management company. The theme features a centralized ACF flexible content block system with 30+ pre-built layouts.

**Business sectors:** Gestion immobiliere, amenagement des domaines, levee topographique, dressage de plan, vente/achat de terrains et maisons.

## Development Commands

Run from `wp-content/themes/socorif/`:

```bash
npm run dev      # TailwindCSS watch mode
npm run build    # Production build (minified)
npm run format   # Prettier formatting
```

## Architecture

### Directory Structure

```
wp-content/themes/socorif/
├── assets/src/css/main.scss     # TailwindCSS v4 + SCSS entry
├── assets/dist/                  # Generated (never edit)
├── inc/
│   ├── acf/
│   │   ├── block-utils.php       # Block utilities (spacing, backgrounds, wrapper)
│   │   ├── blocks-loader.php     # Auto-loads template-parts/blocks/*/config.php
│   │   └── flexible-content.php  # All flexible content layouts
│   ├── acf-fields/               # ACF field group definitions per CPT
│   ├── post-types/               # CPT registrations
│   └── helpers/                  # html-helpers, data-helpers, class-helpers
├── template-parts/
│   ├── blocks/[name]/            # Block template + config.php
│   └── components/               # Reusable UI components
└── functions.php                 # Bootstrap + socorif_component(), socorif_block()
```

### ACF Flexible Content System

Dual-block architecture:

1. **Flexible Content** (`inc/acf/flexible-content.php`): Main layouts used via `flexible_content` field on pages
2. **Gutenberg Blocks** (`template-parts/blocks/*/config.php`): Auto-registered via blocks-loader for block editor

Block utilities (`inc/acf/block-utils.php`):
- `socorif_get_block_wrapper_attributes($block, $extra_classes)` - ID and classes
- `socorif_get_acf_spacing_classes()` - Padding/margin from ACF fields
- `socorif_get_background_color_classes()` - Light/dark mode backgrounds
- `socorif_block_comment_start/end()` - HTML debug comments

### Custom Post Types

| CPT | Slug | Taxonomies | Files |
|-----|------|------------|-------|
| Property | `property` | `property_category`, `property_type` | `inc/post-types/property.php`, `inc/acf-fields/property-fields.php` |
| Leistungen (Services) | `leistungen` | `leistung_kategorie` | `inc/post-types/leistungen.php` |
| Projekte (Projects) | `projekte` | - | `inc/post-types/projekte.php` |
| Emplois (Jobs) | `emplois` | - | `inc/post-types/emplois.php`, `inc/admin/emplois-admin.php` |

### Helper Functions

```php
socorif_component('card', $args);           // Load template-parts/components/card.php
socorif_block('hero', $args);               // Load template-parts/blocks/hero/hero.php
socorif_image($image, 'large', $attrs);     // Lazy-loaded image with srcset
socorif_icon('name', 'class');              // SVG icon from assets/icons/
socorif_build_attrs(['class' => 'foo']);    // Build HTML attributes string
```

## Styling

### TailwindCSS v4 Variables (`assets/src/css/main.scss`)

```scss
:root {
  --beka-primary: #fdb833;       // Jaune chantier
  --beka-secondary: #2d3142;     // Gris anthracite
  --beka-secondary-dark: #1a1d2e;
  --spacing-section: 5rem;
  --container-max: 1280px;
}
```

### Dark Mode

Selector strategy with `.dark` class:
```php
@custom-variant dark (&:where(.dark, .dark *));
```
Always provide dark variants: `dark:bg-gray-900`, `dark:text-white`

### JavaScript

- Alpine.js (CDN, defer) + Collapse plugin
- Swiper.js for carousels
- Custom: `assets/src/js/cf7-stepper.js` for multi-step forms

## Code Standards

### Language Requirements (CRITICAL)

| Element | Language |
|---------|----------|
| PHP comments, docblocks | French |
| ACF field labels | French (e.g., "Titre", "Description") |
| ACF field names | English snake_case (e.g., `title`, `description`) |
| Default/example content | French |
| User-facing text | French |

### PHP

- Function prefix: `socorif_` (or `beka_` for legacy)
- Type declarations required: `function foo(): void`
- Always sanitize input, escape output
- Security check: `if (!defined('ABSPATH')) exit;`

### Creating New Blocks

Use slash command: `/create-acf-block [name]`

Or manually:
1. Create `template-parts/blocks/[name]/[name].php` and `config.php`
2. Add layout to `inc/acf/flexible-content.php` if needed
3. Use French labels, English field names

## Critical Files

- `functions.php` - Theme bootstrap
- `inc/setup.php` - Theme support, scripts, SEO meta, Schema.org
- `inc/acf/flexible-content.php` - All flexible layouts
- `inc/acf/block-utils.php` - Shared block functions
- `assets/src/css/main.scss` - Global styles

## Git Rules

- NO Claude Code signatures or co-author tags
- NO emojis unless requested
- Ask confirmation before committing
- Clear, concise commit messages in present tense
