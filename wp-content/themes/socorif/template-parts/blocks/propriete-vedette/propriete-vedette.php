<?php
/**
 * Block: Propriete en Vedette
 * Met en avant un bien immobilier specifique - Marche guineen
 */

if (!defined('ABSPATH')) exit;

// Get block fields
$subtitle = get_sub_field('subtitle') ?: 'A la une';
$title = get_sub_field('title') ?: 'Propriete en vedette';
$property = get_sub_field('property');
$show_features = get_sub_field('show_features') ?? true;
$show_gallery = get_sub_field('show_gallery') ?? true;
$bg_color = get_sub_field('bg_color') ?: 'gray-50';

// Background classes
$bg_classes = [
    'white' => 'bg-white dark:bg-gray-900',
    'gray-50' => 'bg-gray-50 dark:bg-gray-800',
    'secondary-dark' => 'bg-secondary-dark text-white',
];
$bg_class = $bg_classes[$bg_color] ?? $bg_classes['gray-50'];
$text_dark = $bg_color === 'secondary-dark';

// Communes de Conakry
$communes = [
    'kaloum' => 'Kaloum',
    'dixinn' => 'Dixinn',
    'matam' => 'Matam',
    'matoto' => 'Matoto',
    'ratoma' => 'Ratoma',
];

if (!$property) return;

// Get property data
$property_id = $property->ID;
$prix = get_field('property_price', $property_id);
$surface = get_field('property_surface', $property_id);
$terrain = get_field('property_land_surface', $property_id);
$chambres = get_field('property_bedrooms', $property_id);
$salles_bain = get_field('property_bathrooms', $property_id);
$commune = get_field('property_commune', $property_id);
$quartier = get_field('property_quarter', $property_id);
$statut = get_field('property_status', $property_id) ?: 'disponible';
$galerie = get_field('property_gallery', $property_id);
$features = get_field('property_features', $property_id);
$transaction = get_field('property_transaction', $property_id) ?: 'vente';

// Status colors and labels
$statut_colors = [
    'disponible' => 'bg-green-500',
    'vendu' => 'bg-red-500',
    'reserve' => 'bg-yellow-500',
    'loue' => 'bg-blue-500',
];
$statut_labels = [
    'disponible' => 'Disponible',
    'vendu' => 'Vendu',
    'reserve' => 'Reserve',
    'loue' => 'Loue',
];

// Features labels
$features_labels = [
    'eau' => 'Eau courante',
    'electricite' => 'Electricite',
    'cloture' => 'Cloture',
    'titre_foncier' => 'Titre foncier',
    'parking' => 'Parking',
    'garage' => 'Garage',
    'jardin' => 'Jardin',
    'piscine' => 'Piscine',
    'terrasse' => 'Terrasse',
    'balcon' => 'Balcon',
    'climatisation' => 'Climatisation',
    'cuisine_equipee' => 'Cuisine equipee',
    'meuble' => 'Meuble',
    'gardiennage' => 'Gardiennage',
    'groupe_electrogene' => 'Groupe electrogene',
    'forage' => 'Forage',
];
?>

<section class="py-16 lg:py-24 <?php echo esc_attr($bg_class); ?>">
    <div class="container mx-auto px-4 lg:px-8">

        <!-- Header -->
        <div class="text-center mb-12">
            <?php if ($subtitle) : ?>
                <p class="text-primary font-semibold text-sm uppercase tracking-wider mb-2">
                    <?php echo esc_html($subtitle); ?>
                </p>
            <?php endif; ?>

            <?php if ($title) : ?>
                <h2 class="text-3xl lg:text-4xl font-bold <?php echo $text_dark ? 'text-white' : 'text-gray-900 dark:text-white'; ?>">
                    <?php echo esc_html($title); ?>
                </h2>
            <?php endif; ?>
        </div>

        <!-- Featured Property Card -->
        <div class="bg-white dark:bg-gray-900 rounded-2xl overflow-hidden shadow-2xl">
            <div class="grid grid-cols-1 lg:grid-cols-2">

                <!-- Image / Gallery Section -->
                <div class="relative" x-data="{ activeImage: 0 }">
                    <!-- Main Image -->
                    <div class="aspect-[4/3] lg:aspect-auto lg:h-full relative overflow-hidden">
                        <?php if ($show_gallery && $galerie && count($galerie) > 0) : ?>
                            <?php foreach ($galerie as $index => $image) : ?>
                                <img src="<?php echo esc_url($image['sizes']['large'] ?? $image['url']); ?>"
                                     alt="<?php echo esc_attr($image['alt'] ?: get_the_title($property_id)); ?>"
                                     class="absolute inset-0 w-full h-full object-cover transition-opacity duration-500"
                                     :class="activeImage === <?php echo $index; ?> ? 'opacity-100' : 'opacity-0'"
                                     loading="<?php echo $index === 0 ? 'eager' : 'lazy'; ?>">
                            <?php endforeach; ?>
                        <?php elseif (has_post_thumbnail($property_id)) : ?>
                            <?php echo get_the_post_thumbnail($property_id, 'hero', ['class' => 'w-full h-full object-cover']); ?>
                        <?php else :
                            $property_type_field = get_field('property_type_field', $property_id) ?: 'villa';
                            $placeholder_url = socorif_get_property_placeholder($property_type_field, 'hero');
                        ?>
                            <img src="<?php echo esc_url($placeholder_url); ?>"
                                 alt="<?php echo esc_attr(get_the_title($property_id)); ?>"
                                 class="w-full h-full object-cover min-h-[400px]"
                                 loading="eager">
                        <?php endif; ?>

                        <!-- Status badge -->
                        <span class="absolute top-4 left-4 <?php echo esc_attr($statut_colors[$statut] ?? 'bg-gray-500'); ?> text-white text-sm font-semibold px-4 py-2 rounded-full shadow-lg">
                            <?php echo esc_html($statut_labels[$statut] ?? 'Disponible'); ?>
                        </span>

                        <!-- Transaction badge -->
                        <span class="absolute top-4 right-4 bg-secondary-dark text-white text-sm font-semibold px-4 py-2 rounded-full shadow-lg">
                            <?php echo $transaction === 'location' ? 'A louer' : 'A vendre'; ?>
                        </span>
                    </div>

                    <!-- Gallery Thumbnails -->
                    <?php if ($show_gallery && $galerie && count($galerie) > 1) : ?>
                        <div class="absolute bottom-4 left-4 right-4 flex gap-2 overflow-x-auto pb-2">
                            <?php foreach ($galerie as $index => $image) : ?>
                                <button @click="activeImage = <?php echo $index; ?>"
                                        class="flex-shrink-0 w-16 h-16 rounded-lg overflow-hidden border-2 transition-all duration-300 cursor-pointer"
                                        :class="activeImage === <?php echo $index; ?> ? 'border-primary scale-110' : 'border-white/50 hover:border-white'">
                                    <img src="<?php echo esc_url($image['sizes']['thumbnail'] ?? $image['url']); ?>"
                                         alt=""
                                         class="w-full h-full object-cover">
                                </button>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Content Section -->
                <div class="p-8 lg:p-12 flex flex-col justify-center">
                    <!-- Price -->
                    <?php if ($prix) : ?>
                        <p class="text-primary font-bold text-3xl lg:text-4xl mb-4">
                            <?php echo number_format($prix, 0, ',', ' '); ?> GNF
                            <?php if ($transaction === 'location') : ?>
                                <span class="text-lg font-normal text-gray-500">/mois</span>
                            <?php endif; ?>
                        </p>
                    <?php endif; ?>

                    <!-- Title -->
                    <h3 class="text-2xl lg:text-3xl font-bold text-gray-900 dark:text-white mb-4">
                        <?php echo get_the_title($property_id); ?>
                    </h3>

                    <!-- Location -->
                    <?php if ($quartier || $commune) : ?>
                        <p class="text-gray-500 dark:text-gray-400 text-lg mb-6 flex items-center gap-2">
                            <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <?php
                            echo esc_html($quartier);
                            if ($quartier && $commune) echo ', ';
                            echo esc_html($communes[$commune] ?? $commune);
                            ?>, Conakry
                        </p>
                    <?php endif; ?>

                    <!-- Features Grid -->
                    <?php if ($show_features) : ?>
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-8 p-4 bg-gray-50 dark:bg-gray-800 rounded-xl">
                            <?php if ($surface) : ?>
                                <div class="text-center">
                                    <svg class="w-6 h-6 mx-auto text-primary mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"/>
                                    </svg>
                                    <p class="text-2xl font-bold text-gray-900 dark:text-white"><?php echo esc_html($surface); ?></p>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">m² habitable</p>
                                </div>
                            <?php endif; ?>

                            <?php if ($terrain) : ?>
                                <div class="text-center">
                                    <svg class="w-6 h-6 mx-auto text-primary mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                                    </svg>
                                    <p class="text-2xl font-bold text-gray-900 dark:text-white"><?php echo esc_html($terrain); ?></p>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">m² terrain</p>
                                </div>
                            <?php endif; ?>

                            <?php if ($chambres) : ?>
                                <div class="text-center">
                                    <svg class="w-6 h-6 mx-auto text-primary mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                    </svg>
                                    <p class="text-2xl font-bold text-gray-900 dark:text-white"><?php echo esc_html($chambres); ?></p>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Chambres</p>
                                </div>
                            <?php endif; ?>

                            <?php if ($salles_bain) : ?>
                                <div class="text-center">
                                    <svg class="w-6 h-6 mx-auto text-primary mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"/>
                                    </svg>
                                    <p class="text-2xl font-bold text-gray-900 dark:text-white"><?php echo esc_html($salles_bain); ?></p>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Salles de bain</p>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                    <!-- Additional Features -->
                    <?php if ($features && is_array($features)) : ?>
                        <div class="flex flex-wrap gap-2 mb-8">
                            <?php foreach ($features as $feature) : ?>
                                <span class="inline-flex items-center gap-1 bg-primary/10 text-primary px-3 py-1 rounded-full text-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    <?php echo esc_html($features_labels[$feature] ?? $feature); ?>
                                </span>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                    <!-- CTA Buttons -->
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="<?php echo get_permalink($property_id); ?>"
                           class="inline-flex items-center justify-center gap-2 bg-primary hover:bg-primary-dark text-white font-semibold py-4 px-8 rounded-xl transition-all duration-300 hover:scale-105 active:scale-95">
                            Voir les details
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                            </svg>
                        </a>

                        <a href="<?php echo home_url('/contact'); ?>?bien=<?php echo $property_id; ?>"
                           class="inline-flex items-center justify-center gap-2 bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-900 dark:text-white font-semibold py-4 px-8 rounded-xl transition-all duration-300">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            Demander des infos
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
