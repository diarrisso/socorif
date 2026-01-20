<?php
/**
 * Placeholder Images Helper
 * Generates contextual placeholder images for Guinean real estate
 */

if (!defined('ABSPATH')) exit;

/**
 * Get placeholder image URL based on context
 *
 * @param string $type Type of placeholder (property, hero, team, etc.)
 * @param int $width Image width
 * @param int $height Image height
 * @param int $index Optional index for variation
 * @return string Placeholder image URL
 */
function socorif_get_placeholder_image(string $type = 'property', int $width = 800, int $height = 600, int $index = 0): string {
    // Use picsum.photos for realistic placeholder images
    // Add seed based on type and index for consistent images
    $seed = abs(crc32($type . $index));

    return "https://picsum.photos/seed/{$seed}/{$width}/{$height}";
}

/**
 * Get property-specific placeholder based on property type
 *
 * @param string $property_type Type of property (terrain, maison, villa, etc.)
 * @param string $size Image size (thumbnail, card, hero)
 * @return string Placeholder image URL
 */
function socorif_get_property_placeholder(string $property_type = 'maison', string $size = 'card'): string {
    // Size dimensions
    $sizes = [
        'thumbnail' => [150, 150],
        'card' => [600, 400],
        'hero' => [1920, 1080],
        'gallery' => [800, 600],
        'large' => [1200, 800],
    ];

    $dimensions = $sizes[$size] ?? $sizes['card'];

    // Generate seed based on property type for consistent theming
    $type_seeds = [
        'terrain' => 100,
        'maison' => 200,
        'villa' => 300,
        'appartement' => 400,
        'immeuble' => 500,
        'local_commercial' => 600,
        'bureau' => 700,
        'entrepot' => 800,
    ];

    $seed = $type_seeds[$property_type] ?? 200;

    return "https://picsum.photos/seed/{$seed}/{$dimensions[0]}/{$dimensions[1]}";
}

/**
 * Get placeholder for hero/background images
 *
 * @param int $index Variation index
 * @return string Placeholder image URL
 */
function socorif_get_hero_placeholder(int $index = 0): string {
    // Use architecture/building themed seeds
    $seeds = [1000, 1001, 1002, 1003, 1004];
    $seed = $seeds[$index % count($seeds)];

    return "https://picsum.photos/seed/{$seed}/1920/1080";
}

/**
 * Get placeholder for team member photos
 *
 * @param int $index Member index
 * @param string $gender Gender hint (male, female, any)
 * @return string Placeholder image URL
 */
function socorif_get_team_placeholder(int $index = 0, string $gender = 'any'): string {
    // Use UI Faces alternative or random person placeholder
    $seed = 2000 + $index;

    return "https://picsum.photos/seed/{$seed}/400/400";
}

/**
 * Output placeholder image HTML
 *
 * @param string $type Type of placeholder
 * @param array $args Additional arguments (class, alt, width, height)
 * @return void
 */
function socorif_placeholder_image(string $type = 'property', array $args = []): void {
    $defaults = [
        'class' => 'w-full h-full object-cover',
        'alt' => 'Image placeholder',
        'width' => 800,
        'height' => 600,
        'index' => 0,
        'loading' => 'lazy',
    ];

    $args = wp_parse_args($args, $defaults);
    $url = socorif_get_placeholder_image($type, $args['width'], $args['height'], $args['index']);

    printf(
        '<img src="%s" alt="%s" class="%s" width="%d" height="%d" loading="%s">',
        esc_url($url),
        esc_attr($args['alt']),
        esc_attr($args['class']),
        intval($args['width']),
        intval($args['height']),
        esc_attr($args['loading'])
    );
}

/**
 * Get array of placeholder gallery images
 *
 * @param int $count Number of images
 * @param string $type Type of placeholder
 * @return array Array of placeholder image data
 */
function socorif_get_placeholder_gallery(int $count = 5, string $type = 'property'): array {
    $gallery = [];

    for ($i = 0; $i < $count; $i++) {
        $gallery[] = [
            'url' => socorif_get_placeholder_image($type, 1200, 800, $i),
            'sizes' => [
                'thumbnail' => socorif_get_placeholder_image($type, 150, 150, $i),
                'medium' => socorif_get_placeholder_image($type, 600, 400, $i),
                'large' => socorif_get_placeholder_image($type, 1200, 800, $i),
            ],
            'alt' => "Image {$i} - Placeholder",
        ];
    }

    return $gallery;
}

/**
 * Sample property data for demonstrations
 *
 * @return array Sample properties data
 */
function socorif_get_sample_properties(): array {
    return [
        [
            'title' => 'Villa moderne a Kipé',
            'price' => 850000000,
            'surface' => 350,
            'terrain' => 600,
            'bedrooms' => 5,
            'bathrooms' => 3,
            'commune' => 'ratoma',
            'quartier' => 'Kipé',
            'status' => 'disponible',
            'transaction' => 'vente',
            'type' => 'villa',
            'features' => ['eau', 'electricite', 'cloture', 'titre_foncier', 'garage', 'jardin'],
        ],
        [
            'title' => 'Terrain constructible a Nongo',
            'price' => 150000000,
            'surface' => 0,
            'terrain' => 500,
            'bedrooms' => 0,
            'bathrooms' => 0,
            'commune' => 'ratoma',
            'quartier' => 'Nongo',
            'status' => 'disponible',
            'transaction' => 'vente',
            'type' => 'terrain',
            'features' => ['cloture', 'titre_foncier'],
        ],
        [
            'title' => 'Appartement F4 a Kaloum',
            'price' => 25000000,
            'surface' => 120,
            'terrain' => 0,
            'bedrooms' => 3,
            'bathrooms' => 2,
            'commune' => 'kaloum',
            'quartier' => 'Centre-ville',
            'status' => 'disponible',
            'transaction' => 'location',
            'type' => 'appartement',
            'features' => ['eau', 'electricite', 'climatisation', 'gardiennage'],
        ],
        [
            'title' => 'Maison familiale a Matam',
            'price' => 450000000,
            'surface' => 200,
            'terrain' => 400,
            'bedrooms' => 4,
            'bathrooms' => 2,
            'commune' => 'matam',
            'quartier' => 'Madina',
            'status' => 'disponible',
            'transaction' => 'vente',
            'type' => 'maison',
            'features' => ['eau', 'electricite', 'cloture', 'parking', 'terrasse'],
        ],
        [
            'title' => 'Immeuble de bureaux a Dixinn',
            'price' => 2500000000,
            'surface' => 800,
            'terrain' => 300,
            'bedrooms' => 0,
            'bathrooms' => 6,
            'commune' => 'dixinn',
            'quartier' => 'Belle Vue',
            'status' => 'disponible',
            'transaction' => 'vente',
            'type' => 'immeuble',
            'features' => ['eau', 'electricite', 'titre_foncier', 'parking', 'climatisation', 'groupe_electrogene'],
        ],
        [
            'title' => 'Villa de luxe avec piscine a Lambanyi',
            'price' => 1200000000,
            'surface' => 450,
            'terrain' => 1000,
            'bedrooms' => 6,
            'bathrooms' => 4,
            'commune' => 'ratoma',
            'quartier' => 'Lambanyi',
            'status' => 'reserve',
            'transaction' => 'vente',
            'type' => 'villa',
            'features' => ['eau', 'electricite', 'cloture', 'titre_foncier', 'garage', 'jardin', 'piscine', 'climatisation', 'groupe_electrogene', 'forage'],
        ],
    ];
}

/**
 * Get communes data
 *
 * @return array Communes with descriptions
 */
function socorif_get_communes_data(): array {
    return [
        'kaloum' => [
            'name' => 'Kaloum',
            'description' => 'Centre administratif et commercial de Conakry',
            'quartiers' => ['Centre-ville', 'Almamya', 'Boulbinet', 'Sandervalia', 'Tombo'],
        ],
        'dixinn' => [
            'name' => 'Dixinn',
            'description' => 'Quartier residentiel et universitaire',
            'quartiers' => ['Belle Vue', 'Cameroun', 'Landreah', 'Dixinn Port', 'Universite'],
        ],
        'matam' => [
            'name' => 'Matam',
            'description' => 'Zone commerciale et residentielle',
            'quartiers' => ['Madina', 'Bonfi', 'Matam Port', 'Coleyah', 'Lansanaya'],
        ],
        'matoto' => [
            'name' => 'Matoto',
            'description' => 'Zone industrielle et residentielle en expansion',
            'quartiers' => ['Sangoyah', 'Dar es Salam', 'Matoto Centre', 'Kissosso', 'Dabompa'],
        ],
        'ratoma' => [
            'name' => 'Ratoma',
            'description' => 'Plus grande commune, en pleine expansion',
            'quartiers' => ['Kipé', 'Nongo', 'Cosa', 'Lambanyi', 'Kaporo', 'Taouyah', 'Hamdallaye'],
        ],
    ];
}
