<?php
/**
 * Template pour les biens immobiliers individuels
 */

if (!defined('ABSPATH')) exit;

get_header();

while (have_posts()) : the_post();

    // Featured Image - with placeholder fallback
    $featured_image = get_the_post_thumbnail_url(get_the_ID(), 'hero');
    $property_type_field = get_field('property_type_field') ?: 'maison';
    if (!$featured_image) {
        $featured_image = socorif_get_property_placeholder($property_type_field, 'hero');
    }

    // Taxonomies
    $categories = get_the_terms(get_the_ID(), 'property_category');
    $types = get_the_terms(get_the_ID(), 'property_type');

    // ACF Fields
    $price = get_field('property_price');
    $surface = get_field('property_surface');
    $land_surface = get_field('property_land_surface');
    $rooms = get_field('property_rooms');
    $bedrooms = get_field('property_bedrooms');
    $address = get_field('property_address');
    $city = get_field('property_city');
    $reference = get_field('property_reference');
    $status = get_field('property_status');
    $gallery = get_field('property_gallery');

    // Breadcrumb
    $breadcrumb = [
        ['label' => 'Accueil', 'link' => home_url('/')],
        ['label' => 'Biens', 'link' => get_post_type_archive_link('property')],
        ['label' => get_the_title(), 'link' => ''],
    ];
    ?>

    <!-- Hero Section - Mobile Version -->
    <section class="lg:hidden relative bg-gray-900 min-h-[500px] md:min-h-[600px] flex items-center">

        <!-- Image de fond -->
        <?php if ($featured_image) : ?>
            <div class="absolute inset-0 z-0">
                <img src="<?php echo esc_url($featured_image); ?>"
                     alt="<?php echo esc_attr(get_the_title()); ?>"
                     class="w-full h-full object-cover"
                     loading="eager">
                <!-- Overlay sombre pour lisibilite -->
                <div class="absolute inset-0 bg-gradient-to-r from-black/80 via-black/60 to-black/40"></div>
            </div>
        <?php else : ?>
            <!-- Gradient de secours -->
            <div class="absolute inset-0 z-0 bg-gradient-to-br from-secondary via-secondary/80 to-primary/60"></div>
        <?php endif; ?>

        <!-- Contenu -->
        <div class="relative z-10 w-full">
            <div class="container py-16">
                <div class="max-w-3xl">

                    <!-- Breadcrumb -->
                    <nav class="mb-4" aria-label="Breadcrumb">
                        <ol class="flex flex-wrap items-center gap-2 text-sm">
                            <?php foreach ($breadcrumb as $index => $item) :
                                $is_last = ($index === count($breadcrumb) - 1);
                            ?>
                                <li class="flex items-center gap-2">
                                    <?php if ($item['link'] && !$is_last) : ?>
                                        <a href="<?php echo esc_url($item['link']); ?>"
                                           class="text-gray-300 hover:text-white transition-colors duration-200 font-medium cursor-pointer">
                                            <?php echo esc_html($item['label']); ?>
                                        </a>
                                    <?php else : ?>
                                        <span class="<?php echo $is_last ? 'text-primary font-semibold' : 'text-gray-300'; ?>">
                                            <?php echo esc_html($item['label']); ?>
                                        </span>
                                    <?php endif; ?>

                                    <?php if (!$is_last) : ?>
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                        </svg>
                                    <?php endif; ?>
                                </li>
                            <?php endforeach; ?>
                        </ol>
                    </nav>

                    <!-- Badges categorie et type -->
                    <div class="mb-6 flex flex-wrap gap-2">
                        <?php if ($categories) : ?>
                            <?php foreach ($categories as $category) : ?>
                                <span class="inline-block px-4 py-2 bg-primary text-white text-sm font-semibold rounded-full shadow-lg">
                                    <?php echo esc_html($category->name); ?>
                                </span>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        <?php if ($types) : ?>
                            <?php foreach ($types as $type) : ?>
                                <span class="inline-block px-4 py-2 bg-secondary text-white text-sm font-semibold rounded-full shadow-lg">
                                    <?php echo esc_html($type->name); ?>
                                </span>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>

                    <!-- Titre -->
                    <h1 class="page-title text-white mb-6">
                        <?php the_title(); ?>
                    </h1>

                    <!-- Prix -->
                    <?php if ($price) : ?>
                        <p class="text-3xl font-bold text-primary mb-4">
                            <?php echo number_format($price, 0, ',', ' '); ?> GNF
                        </p>
                    <?php endif; ?>

                    <!-- Description -->
                    <?php if (has_excerpt()) : ?>
                        <p class="section-description text-gray-200">
                            <?php echo get_the_excerpt(); ?>
                        </p>
                    <?php endif; ?>

                </div>
            </div>
        </div>
    </section>

    <!-- Hero Section - Desktop Version (Polygon Diagonal Split) -->
    <section class="hidden lg:block relative bg-white dark:bg-gray-900">
        <div class="mx-auto max-w-7xl flex flex-row">
            <div class="relative z-10 pt-14 w-full max-w-2xl order-1">
                <!-- SVG diagonal -->
                <svg viewBox="0 0 100 100" preserveAspectRatio="none" aria-hidden="true" class="absolute inset-y-0 right-0 h-full w-24 translate-x-1/4 sm:w-32 sm:translate-x-1/3 md:w-48 md:translate-x-1/2 lg:w-96 xl:w-[28rem] 2xl:w-[32rem] transform fill-white dark:fill-gray-900">
                    <polygon points="0,0 90,0 50,100 0,100" />
                </svg>

                <!-- Contenu texte -->
                <div class="relative px-6 py-32 lg:px-8 lg:py-56 lg:pr-0">
                    <div class="mx-auto max-w-2xl lg:mx-0 lg:max-w-xl">

                        <!-- Breadcrumb -->
                        <nav class="mb-6" aria-label="Breadcrumb">
                            <ol class="flex flex-wrap items-center gap-2 text-sm">
                                <?php foreach ($breadcrumb as $index => $item) :
                                    $is_last = ($index === count($breadcrumb) - 1);
                                ?>
                                    <li class="flex items-center gap-2">
                                        <?php if ($item['link'] && !$is_last) : ?>
                                            <a href="<?php echo esc_url($item['link']); ?>"
                                               class="text-gray-600 dark:text-gray-400 hover:text-primary transition-colors duration-200 font-medium cursor-pointer">
                                                <?php echo esc_html($item['label']); ?>
                                            </a>
                                        <?php else : ?>
                                            <span class="<?php echo $is_last ? 'text-primary font-semibold' : 'text-gray-600 dark:text-gray-400'; ?>">
                                                <?php echo esc_html($item['label']); ?>
                                            </span>
                                        <?php endif; ?>

                                        <?php if (!$is_last) : ?>
                                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                            </svg>
                                        <?php endif; ?>
                                    </li>
                                <?php endforeach; ?>
                            </ol>
                        </nav>

                        <!-- Badges categorie et type -->
                        <div class="mb-10 flex flex-wrap gap-2">
                            <?php if ($categories) : ?>
                                <?php foreach ($categories as $category) : ?>
                                    <span class="inline-block px-4 py-2 bg-primary text-white text-sm font-semibold rounded-full">
                                        <?php echo esc_html($category->name); ?>
                                    </span>
                                <?php endforeach; ?>
                            <?php endif; ?>
                            <?php if ($types) : ?>
                                <?php foreach ($types as $type) : ?>
                                    <span class="inline-block px-4 py-2 bg-secondary text-white text-sm font-semibold rounded-full">
                                        <?php echo esc_html($type->name); ?>
                                    </span>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>

                        <!-- Reference -->
                        <?php if ($reference) : ?>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">
                                Ref: <?php echo esc_html($reference); ?>
                            </p>
                        <?php endif; ?>

                        <!-- Titre -->
                        <h1 class="page-title">
                            <?php the_title(); ?>
                        </h1>

                        <!-- Prix -->
                        <?php if ($price) : ?>
                            <p class="text-3xl font-bold text-primary mt-6">
                                <?php echo number_format($price, 0, ',', ' '); ?> GNF
                            </p>
                        <?php endif; ?>

                        <!-- Description -->
                        <?php if (has_excerpt()) : ?>
                            <p class="section-description mt-8">
                                <?php echo get_the_excerpt(); ?>
                            </p>
                        <?php endif; ?>

                    </div>
                </div>
            </div>

            <!-- Image droite -->
            <div class="bg-gray-50 dark:bg-gray-800 absolute inset-y-0 right-0 w-2/5 md:w-[45%] lg:w-1/2">
                <?php if ($featured_image) : ?>
                    <img src="<?php echo esc_url($featured_image); ?>"
                         alt="<?php echo esc_attr(get_the_title()); ?>"
                         class="w-full h-full object-cover"
                         loading="eager">
                <?php else : ?>
                    <div class="w-full h-full bg-gradient-to-br from-primary/20 to-secondary/20"></div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- Caracteristiques du bien -->
    <section class="section bg-gray-50 dark:bg-gray-800">
        <div class="container">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Main content -->
                <div class="lg:col-span-2">
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                        <?php if ($surface) : ?>
                            <div class="bg-white dark:bg-gray-900 p-6 rounded-xl shadow-sm text-center">
                                <svg class="w-8 h-8 mx-auto text-primary mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"/>
                                </svg>
                                <p class="text-2xl font-bold text-gray-900 dark:text-white"><?php echo esc_html($surface); ?> m²</p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Surface</p>
                            </div>
                        <?php endif; ?>

                        <?php if ($land_surface) : ?>
                            <div class="bg-white dark:bg-gray-900 p-6 rounded-xl shadow-sm text-center">
                                <svg class="w-8 h-8 mx-auto text-primary mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <p class="text-2xl font-bold text-gray-900 dark:text-white"><?php echo esc_html($land_surface); ?> m²</p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Terrain</p>
                            </div>
                        <?php endif; ?>

                        <?php if ($rooms) : ?>
                            <div class="bg-white dark:bg-gray-900 p-6 rounded-xl shadow-sm text-center">
                                <svg class="w-8 h-8 mx-auto text-primary mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                </svg>
                                <p class="text-2xl font-bold text-gray-900 dark:text-white"><?php echo esc_html($rooms); ?></p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Pieces</p>
                            </div>
                        <?php endif; ?>

                        <?php if ($bedrooms) : ?>
                            <div class="bg-white dark:bg-gray-900 p-6 rounded-xl shadow-sm text-center">
                                <svg class="w-8 h-8 mx-auto text-primary mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                </svg>
                                <p class="text-2xl font-bold text-gray-900 dark:text-white"><?php echo esc_html($bedrooms); ?></p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Chambres</p>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Localisation -->
                    <?php if ($city || $address) : ?>
                        <div class="mt-8 p-6 bg-white dark:bg-gray-900 rounded-xl shadow-sm">
                            <div class="flex items-start gap-4">
                                <svg class="w-6 h-6 text-primary flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                <div>
                                    <h3 class="font-semibold text-gray-900 dark:text-white mb-1">Localisation</h3>
                                    <?php if ($address) : ?>
                                        <p class="text-gray-600 dark:text-gray-400"><?php echo esc_html($address); ?></p>
                                    <?php endif; ?>
                                    <?php if ($city) : ?>
                                        <p class="text-gray-600 dark:text-gray-400 font-medium"><?php echo esc_html($city); ?></p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Sidebar -->
                <div class="lg:col-span-1">
                    <div class="sticky top-8">
                        <?php
                        // Promotional banner in sidebar
                        get_template_part('template-parts/components/cpt-banniere-pub');
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section Galerie + Unites (si le bien a des unites) -->
    <?php
    $has_units = get_field('property_has_units');
    $units = get_field('property_units');

    // Use placeholder gallery if no real gallery
    $display_gallery = $gallery;
    if (!$display_gallery || count($display_gallery) === 0) {
        $display_gallery = socorif_get_placeholder_gallery(6, $property_type_field);
    }

    // Display gallery + units component if property has units
    if ($has_units && !empty($units)) :
        // Prepare gallery IDs for the component
        $gallery_ids = [];
        if ($display_gallery) {
            foreach ($display_gallery as $img) {
                $gallery_ids[] = is_array($img) ? ($img['ID'] ?? $img['id'] ?? 0) : $img;
            }
        }

        get_template_part('template-parts/components/property-gallery-units', null, [
            'title' => get_the_title(),
            'gallery' => $gallery_ids,
            'units' => $units,
            'bg_color' => 'white',
        ]);
    elseif ($display_gallery && count($display_gallery) > 0) :
        // Standard gallery display
    ?>
        <section class="section bg-white dark:bg-gray-900">
            <div class="container">
                <h2 class="section-title mb-8">Galerie photos</h2>
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    <?php foreach ($display_gallery as $image) : ?>
                        <a href="<?php echo esc_url($image['url']); ?>" class="block aspect-square overflow-hidden rounded-lg group">
                            <img src="<?php echo esc_url($image['sizes']['medium'] ?? $image['sizes']['medium_large'] ?? $image['url']); ?>"
                                 alt="<?php echo esc_attr($image['alt'] ?? get_the_title()); ?>"
                                 class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-110"
                                 loading="lazy">
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <!-- Contenu flexible ou standard -->
    <?php if (have_rows('flexible_content')) : ?>
        <?php while (have_rows('flexible_content')) : the_row(); ?>
            <?php
            $layout = get_row_layout();
            $block_file = get_template_directory() . '/template-parts/blocks/' . $layout . '/' . $layout . '.php';

            if (file_exists($block_file)) {
                include $block_file;
            }
            ?>
        <?php endwhile; ?>
    <?php else : ?>
        <!-- Fallback: Contenu standard -->
        <?php if (get_the_content()) : ?>
            <section class="section bg-white dark:bg-gray-900">
                <div class="container">
                    <div class="prose prose-lg max-w-none dark:prose-invert">
                        <?php the_content(); ?>
                    </div>
                </div>
            </section>
        <?php endif; ?>
    <?php endif; ?>

    <!-- Section contact -->
    <section class="section bg-gray-50 dark:bg-gray-800">
        <div class="container">
            <div class="max-w-3xl mx-auto text-center">
                <h2 class="section-title mb-4">Interesse par ce bien?</h2>
                <p class="section-description mb-8">
                    Contactez-nous pour plus d'informations ou pour planifier une visite.
                </p>
                <a href="<?php echo home_url('/contact'); ?>" class="btn-primary inline-flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    Nous contacter
                </a>
            </div>
        </div>
    </section>

<?php endwhile; ?>

<?php get_footer(); ?>
