<?php
/**
 * Template pour les services individuels
 */

if (!defined('ABSPATH')) exit;

get_header();

while (have_posts()) : the_post();

    // Image a la une
    $featured_image = get_the_post_thumbnail_url(get_the_ID(), 'hero');

    // Taxonomies
    $kategorien = get_the_terms(get_the_ID(), 'leistung_kategorie');

    // ACF Fields
    $galerie = get_field('service_galerie');
    $video_id = get_field('service_video_id');
    $vorher_bild = get_field('service_vorher_bild');
    $nachher_bild = get_field('service_nachher_bild');
    $process = get_field('service_process');
    $features = get_field('service_features');
    $testimonials = get_field('service_testimonials');
    $testimonials_title = get_field('service_testimonials_title') ?: 'Ce que disent nos clients';
    $faq = get_field('service_faq');
    $faq_title = get_field('service_faq_title') ?: 'Questions frequentes';

    // Texte avec image
    $text_image_title = get_field('service_text_image_title');
    $text_image_content = get_field('service_text_image_content');
    $text_image_image = get_field('service_text_image_image');
    $text_image_position = get_field('service_text_image_position') ?: 'right';
    $text_image_features = get_field('service_text_image_features');

    // CTA
    $cta_subtitle = get_field('service_cta_subtitle');
    $cta_title = get_field('service_cta_title');
    $cta_description = get_field('service_cta_description');
    $cta_button_text = get_field('service_cta_button_text');
    $cta_button_link = get_field('service_cta_button_link');

    // Generation du fil d'ariane
    $breadcrumb = [
        ['label' => 'Accueil', 'link' => home_url('/')],
        ['label' => 'Services', 'link' => get_post_type_archive_link('leistungen')],
        ['label' => get_the_title(), 'link' => ''],
    ];
    ?>

    <!-- Hero Section - Version Mobile (Image de fond avec overlay) -->
    <section class="lg:hidden relative bg-gray-900 min-h-[500px] md:min-h-[600px] flex items-center">

        <!-- Image de fond -->
        <?php if ($featured_image) : ?>
            <div class="absolute inset-0 z-0">
                <img src="<?php echo esc_url($featured_image); ?>"
                     alt="<?php echo esc_attr(get_the_title()); ?>"
                     class="w-full h-full object-cover"
                     loading="eager">
                <!-- Overlay sombre pour une meilleure lisibilite -->
                <div class="absolute inset-0 bg-gradient-to-r from-black/80 via-black/60 to-black/40"></div>
            </div>
        <?php else : ?>
            <!-- Gradient de secours si pas d'image -->
            <div class="absolute inset-0 z-0 bg-gradient-to-br from-secondary via-secondary/80 to-primary/60"></div>
        <?php endif; ?>

        <!-- Contenu -->
        <div class="relative z-10 w-full">
            <div class="container py-16">
                <div class="max-w-3xl">

                    <!-- Fil d'ariane -->
                    <nav class="mb-4" aria-label="Fil d'ariane">
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

                    <!-- Badge categorie -->
                    <?php if ($kategorien) : ?>
                        <div class="mb-6">
                            <?php foreach ($kategorien as $kategorie) : ?>
                                <span class="inline-block px-4 py-2 bg-primary text-white text-sm font-semibold rounded-full shadow-lg">
                                    <?php echo esc_html($kategorie->name); ?>
                                </span>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                    <!-- Titre -->
                    <h1 class="page-title text-white mb-6">
                        <?php the_title(); ?>
                    </h1>

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

    <!-- Hero Section - Version Desktop (Split diagonal polygone) -->
    <section class="hidden lg:block relative bg-white dark:bg-gray-900">
        <div class="mx-auto max-w-7xl flex flex-row">
            <div class="relative z-10 pt-14 w-full max-w-2xl order-1">
                <!-- SVG diagonal - Transition vers l'image -->
                <svg viewBox="0 0 100 100" preserveAspectRatio="none" aria-hidden="true" class="absolute inset-y-0 right-0 h-full w-24 translate-x-1/4 sm:w-32 sm:translate-x-1/3 md:w-48 md:translate-x-1/2 lg:w-96 xl:w-[28rem] 2xl:w-[32rem] transform fill-white dark:fill-gray-900">
                    <polygon points="0,0 90,0 50,100 0,100" />
                </svg>

                <!-- Contenu texte -->
                <div class="relative px-6 py-32 lg:px-8 lg:py-56 lg:pr-0">
                    <div class="mx-auto max-w-2xl lg:mx-0 lg:max-w-xl">

                        <!-- Fil d'ariane -->
                        <nav class="mb-6" aria-label="Fil d'ariane">
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

                        <!-- Badge categorie -->
                        <?php if ($kategorien) : ?>
                            <div class="mb-10">
                                <?php foreach ($kategorien as $kategorie) : ?>
                                    <span class="inline-block px-4 py-2 bg-primary text-white text-sm font-semibold rounded-full">
                                        <?php echo esc_html($kategorie->name); ?>
                                    </span>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>

                        <!-- Titre -->
                        <h1 class="page-title">
                            <?php the_title(); ?>
                        </h1>

                        <!-- Description -->
                        <?php if (has_excerpt()) : ?>
                            <p class="section-description mt-8">
                                <?php echo get_the_excerpt(); ?>
                            </p>
                        <?php endif; ?>

                    </div>
                </div>
            </div>

            <!-- Image a droite -->
            <div class="bg-gray-50 dark:bg-gray-800 absolute inset-y-0 right-0 w-2/5 md:w-[45%] lg:w-1/2">
                <?php if ($featured_image) : ?>
                    <img src="<?php echo esc_url($featured_image); ?>"
                         alt="<?php echo esc_attr(get_the_title()); ?>"
                         class="w-full h-full object-cover"
                         loading="eager">
                <?php else : ?>
                    <!-- Gradient de secours si pas d'image -->
                    <div class="w-full h-full bg-gradient-to-br from-primary/20 to-secondary/20"></div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- Video YouTube -->
    <?php
    if ($video_id) :
        $youtube_video_id = '';
        if (strlen(trim($video_id)) === 11 && !strpos($video_id, '/') && !strpos($video_id, '?')) {
            $youtube_video_id = trim($video_id);
        } elseif (strpos($video_id, 'youtube.com') !== false || strpos($video_id, 'youtu.be') !== false) {
            if (preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $video_id, $matches)) {
                $youtube_video_id = $matches[1];
            }
        }

        if ($youtube_video_id) :
            $thumbnail_url = "https://img.youtube.com/vi/{$youtube_video_id}/maxresdefault.jpg";
    ?>
        <section class="section bg-white dark:bg-gray-900">
            <div class="container">
                <h2 class="section-title text-center mb-8">Decouvrez notre service en video</h2>

                <div class="max-w-4xl mx-auto rounded-3xl overflow-hidden shadow-2xl"
                     x-data="{ playing: false }">
                    <div class="relative group/video" style="aspect-ratio: 16/9;">
                        <template x-if="!playing">
                            <div class="absolute inset-0 cursor-pointer" @click="playing = true">
                                <img src="<?php echo esc_url($thumbnail_url); ?>"
                                     alt="Video du service"
                                     class="w-full h-full object-cover group-hover/video:scale-105 transition-transform duration-500">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/30 to-black/20"></div>
                                <div class="absolute inset-0 flex items-center justify-center">
                                    <div class="w-20 h-20 md:w-24 md:h-24 bg-primary rounded-full flex items-center justify-center shadow-xl transform group-hover/video:scale-110 transition-transform duration-300">
                                        <svg class="w-8 h-8 md:w-10 md:h-10 text-white ml-1" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M8 5v14l11-7z"/>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </template>
                        <template x-if="playing">
                            <iframe
                                src="https://www.youtube.com/embed/<?php echo esc_attr($youtube_video_id); ?>?autoplay=1&rel=0"
                                class="absolute inset-0 w-full h-full"
                                frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                allowfullscreen>
                            </iframe>
                        </template>
                    </div>
                </div>
            </div>
        </section>
    <?php
        endif;
    endif;
    ?>

    <!-- Galerie du service -->
    <?php if ($galerie && is_array($galerie) && count($galerie) > 0) : ?>
        <section class="section bg-gray-50 dark:bg-gray-800">
            <div class="container">
                <h2 class="section-title text-center mb-8">Galerie</h2>
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    <?php foreach ($galerie as $image) : ?>
                        <a href="<?php echo esc_url($image['url']); ?>" class="block aspect-square overflow-hidden rounded-xl group">
                            <img src="<?php echo esc_url($image['sizes']['medium'] ?? $image['url']); ?>"
                                 alt="<?php echo esc_attr($image['alt'] ?? get_the_title()); ?>"
                                 class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-110"
                                 loading="lazy">
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <!-- Avant / Apres -->
    <?php if ($vorher_bild && $nachher_bild) : ?>
        <section class="section bg-white dark:bg-gray-900">
            <div class="container">
                <div class="text-center max-w-3xl mx-auto mb-12">
                    <p class="text-primary font-semibold uppercase tracking-wider mb-2 text-sm">Avant / Apres</p>
                    <h2 class="section-title">Decouvrez la transformation</h2>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-5xl mx-auto">
                    <div class="group">
                        <div class="relative overflow-hidden rounded-2xl shadow-xl aspect-[4/3]">
                            <img src="<?php echo esc_url($vorher_bild['url']); ?>" alt="Avant" class="w-full h-full object-cover">
                            <div class="absolute top-4 left-4 bg-gray-900/80 text-white px-4 py-2 rounded-full text-sm font-semibold">Avant</div>
                        </div>
                    </div>
                    <div class="group">
                        <div class="relative overflow-hidden rounded-2xl shadow-xl aspect-[4/3]">
                            <img src="<?php echo esc_url($nachher_bild['url']); ?>" alt="Apres" class="w-full h-full object-cover">
                            <div class="absolute top-4 left-4 bg-primary text-white px-4 py-2 rounded-full text-sm font-semibold">Apres</div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <!-- Processus / Etapes -->
    <?php if ($process && is_array($process) && count($process) > 0) : ?>
        <section class="section bg-gray-50 dark:bg-gray-800">
            <div class="container">
                <div class="text-center max-w-3xl mx-auto mb-12">
                    <p class="text-primary font-semibold uppercase tracking-wider mb-2 text-sm">Notre processus</p>
                    <h2 class="section-title">Comment nous travaillons</h2>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-<?php echo min(count($process), 4); ?> gap-6">
                    <?php foreach ($process as $index => $step) : ?>
                        <div class="bg-white dark:bg-gray-900 rounded-2xl p-6 shadow-lg hover:shadow-xl transition-shadow duration-300">
                            <div class="w-12 h-12 bg-primary text-white rounded-full flex items-center justify-center font-bold text-xl mb-4">
                                <?php echo $index + 1; ?>
                            </div>
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2"><?php echo esc_html($step['title']); ?></h3>
                            <?php if (!empty($step['description'])) : ?>
                                <p class="text-gray-600 dark:text-gray-400"><?php echo esc_html($step['description']); ?></p>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <!-- FAQ / Accordeon -->
    <?php if ($faq && is_array($faq) && count($faq) > 0) : ?>
        <section class="section bg-white dark:bg-gray-900">
            <div class="container">
                <div class="max-w-3xl mx-auto">
                    <h2 class="section-title text-center mb-8"><?php echo esc_html($faq_title); ?></h2>

                    <div class="space-y-4" x-data="{ openIndex: 0 }">
                        <?php foreach ($faq as $index => $item) : ?>
                            <div class="border border-gray-200 dark:border-gray-700 rounded-xl overflow-hidden">
                                <button
                                    @click="openIndex = openIndex === <?php echo $index; ?> ? null : <?php echo $index; ?>"
                                    class="w-full flex items-center justify-between p-5 text-left bg-gray-50 dark:bg-gray-800 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200 cursor-pointer"
                                >
                                    <span class="font-semibold text-gray-900 dark:text-white pr-4"><?php echo esc_html($item['question']); ?></span>
                                    <svg
                                        class="w-5 h-5 text-primary flex-shrink-0 transition-transform duration-300"
                                        :class="{ 'rotate-180': openIndex === <?php echo $index; ?> }"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </button>
                                <div
                                    x-show="openIndex === <?php echo $index; ?>"
                                    x-collapse
                                    class="bg-white dark:bg-gray-900"
                                >
                                    <div class="p-5 prose prose-sm dark:prose-invert max-w-none">
                                        <?php echo wp_kses_post($item['answer']); ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <!-- Texte avec image -->
    <?php if ($text_image_content || $text_image_image) : ?>
        <section class="section bg-white dark:bg-gray-900">
            <div class="container">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                    <!-- Contenu texte -->
                    <div class="<?php echo $text_image_position === 'left' ? 'lg:order-2' : 'lg:order-1'; ?>">
                        <?php if ($text_image_title) : ?>
                            <h2 class="section-title mb-6"><?php echo esc_html($text_image_title); ?></h2>
                        <?php endif; ?>

                        <?php if ($text_image_content) : ?>
                            <div class="prose prose-lg dark:prose-invert mb-8">
                                <?php echo wp_kses_post($text_image_content); ?>
                            </div>
                        <?php endif; ?>

                        <?php if ($text_image_features && is_array($text_image_features)) : ?>
                            <ul class="space-y-3">
                                <?php foreach ($text_image_features as $feature) : ?>
                                    <li class="flex items-center gap-3">
                                        <svg class="w-5 h-5 text-primary flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                        </svg>
                                        <span class="text-gray-700 dark:text-gray-300"><?php echo esc_html($feature['text']); ?></span>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                    </div>

                    <!-- Image -->
                    <div class="<?php echo $text_image_position === 'left' ? 'lg:order-1' : 'lg:order-2'; ?>">
                        <?php if ($text_image_image) : ?>
                            <div class="relative rounded-2xl overflow-hidden shadow-2xl">
                                <img src="<?php echo esc_url($text_image_image['url']); ?>"
                                     alt="<?php echo esc_attr($text_image_image['alt'] ?? $text_image_title); ?>"
                                     class="w-full h-auto">
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <!-- CTA Section -->
    <?php if ($cta_title || $cta_description) : ?>
        <section class="section bg-gradient-to-br from-primary to-primary-dark text-white">
            <div class="container">
                <div class="max-w-3xl mx-auto text-center">
                    <?php if ($cta_subtitle) : ?>
                        <p class="text-white/80 font-semibold uppercase tracking-wider mb-2 text-sm"><?php echo esc_html($cta_subtitle); ?></p>
                    <?php endif; ?>

                    <?php if ($cta_title) : ?>
                        <h2 class="text-3xl md:text-4xl font-bold mb-4"><?php echo esc_html($cta_title); ?></h2>
                    <?php endif; ?>

                    <?php if ($cta_description) : ?>
                        <p class="text-lg text-white/90 mb-8"><?php echo esc_html($cta_description); ?></p>
                    <?php endif; ?>

                    <?php if ($cta_button_link || $cta_button_text) : ?>
                        <a href="<?php echo esc_url($cta_button_link['url'] ?? home_url('/contact')); ?>"
                           class="inline-flex items-center gap-2 bg-white text-primary px-8 py-4 rounded-full font-bold hover:bg-gray-100 transition-colors duration-300 shadow-xl cursor-pointer"
                           <?php echo !empty($cta_button_link['target']) ? 'target="' . esc_attr($cta_button_link['target']) . '"' : ''; ?>>
                            <?php echo esc_html($cta_button_text ?: $cta_button_link['title'] ?? 'Nous contacter'); ?>
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                            </svg>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <!-- Temoignages clients -->
    <?php if ($testimonials && is_array($testimonials) && count($testimonials) > 0) : ?>
        <section class="section bg-gradient-to-br from-secondary to-secondary-dark text-white">
            <div class="container">
                <h2 class="text-3xl md:text-4xl font-bold text-center mb-12"><?php echo esc_html($testimonials_title); ?></h2>

                <?php if (count($testimonials) === 1) : ?>
                    <!-- Un seul temoignage - affichage centre -->
                    <?php $t = $testimonials[0]; ?>
                    <div class="max-w-4xl mx-auto text-center">
                        <svg class="w-16 h-16 text-primary mx-auto mb-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z"/>
                        </svg>
                        <blockquote class="text-xl md:text-2xl font-medium mb-8 leading-relaxed">
                            "<?php echo esc_html($t['quote']); ?>"
                        </blockquote>
                        <div class="flex items-center justify-center gap-4">
                            <?php if (!empty($t['image'])) : ?>
                                <img src="<?php echo esc_url($t['image']['url']); ?>"
                                     alt="<?php echo esc_attr($t['author']); ?>"
                                     class="w-16 h-16 rounded-full object-cover border-2 border-primary">
                            <?php endif; ?>
                            <div class="text-left">
                                <p class="font-bold text-lg"><?php echo esc_html($t['author']); ?></p>
                                <?php if (!empty($t['position'])) : ?>
                                    <p class="text-gray-300"><?php echo esc_html($t['position']); ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php else : ?>
                    <!-- Plusieurs temoignages - grille -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-<?php echo min(count($testimonials), 3); ?> gap-8">
                        <?php foreach ($testimonials as $t) : ?>
                            <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-6 md:p-8">
                                <svg class="w-10 h-10 text-primary mb-4" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z"/>
                                </svg>
                                <blockquote class="text-lg font-medium mb-6 leading-relaxed">
                                    "<?php echo esc_html($t['quote']); ?>"
                                </blockquote>
                                <div class="flex items-center gap-4">
                                    <?php if (!empty($t['image'])) : ?>
                                        <img src="<?php echo esc_url($t['image']['url']); ?>"
                                             alt="<?php echo esc_attr($t['author']); ?>"
                                             class="w-12 h-12 rounded-full object-cover border-2 border-primary">
                                    <?php endif; ?>
                                    <div>
                                        <p class="font-bold"><?php echo esc_html($t['author']); ?></p>
                                        <?php if (!empty($t['position'])) : ?>
                                            <p class="text-gray-300 text-sm"><?php echo esc_html($t['position']); ?></p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </section>
    <?php endif; ?>

    <!-- Flexible Content -->
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
    <?php elseif (get_the_content()) : ?>
        <!-- Fallback: Contenu standard -->
        <section class="section bg-white dark:bg-gray-900">
            <div class="container">
                <div class="prose prose-lg max-w-none dark:prose-invert">
                    <?php the_content(); ?>
                </div>
            </div>
        </section>
    <?php else : ?>
        <!-- Message si aucun contenu -->
        <section class="section bg-gray-50 dark:bg-gray-800">
            <div class="container">
                <div class="text-center py-12">
                    <p class="text-gray-500 dark:text-gray-400">
                        <?php esc_html_e('Ajoutez des blocs flexibles dans l\'administration pour afficher le contenu de ce service.', 'flavor'); ?>
                    </p>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <!-- Section Formulaire de Contact -->
    <?php
    $contact_form_id = get_field('contact_form');
    if ($contact_form_id) :
    ?>
        <section class="contact-form-section py-12 md:py-16">
            <div class="relative isolate bg-white dark:bg-gray-900">
                <div class="mx-auto grid max-w-7xl grid-cols-1 lg:grid-cols-2">

                    <!-- Colonne gauche: Informations de contact -->
                    <div class="relative px-6 pt-20 pb-16 sm:pt-24 lg:static lg:px-8 lg:py-24">
                        <div class="mx-auto max-w-xl lg:mx-0 lg:max-w-lg">

                            <!-- Fond decoratif -->
                            <div class="absolute inset-y-0 left-0 -z-10 w-full overflow-hidden bg-gray-100 ring-1 ring-gray-900/10 lg:w-1/2 dark:bg-gray-800 dark:ring-white/10">
                                <svg aria-hidden="true" class="absolute inset-0 size-full stroke-gray-200 dark:stroke-white/10">
                                    <defs>
                                        <pattern id="service-pattern" width="200" height="200" x="100%" y="-1" patternUnits="userSpaceOnUse">
                                            <path d="M130 200V.5M.5 .5H200" fill="none" />
                                        </pattern>
                                    </defs>
                                    <rect width="100%" height="100%" stroke-width="0" class="fill-white dark:fill-gray-900" />
                                    <svg x="100%" y="-1" class="overflow-visible fill-gray-50 dark:fill-gray-800/20">
                                        <path d="M-470.5 0h201v201h-201Z" stroke-width="0" />
                                    </svg>
                                    <rect width="100%" height="100%" fill="url(#service-pattern)" stroke-width="0" />
                                </svg>
                            </div>

                            <!-- Badge -->
                            <div class="mb-6">
                                <span class="inline-block px-4 py-1 bg-primary/10 text-primary text-sm font-semibold rounded-full">
                                    Devis gratuit
                                </span>
                            </div>

                            <!-- Titre -->
                            <h2 class="text-4xl font-bold tracking-tight text-gray-900 sm:text-5xl dark:text-white mb-6">
                                Demander un devis
                            </h2>

                            <!-- Description -->
                            <p class="text-lg leading-8 text-gray-600 dark:text-gray-400">
                                Demandez un devis gratuit et sans engagement pour <strong><?php the_title(); ?></strong>.
                            </p>

                            <?php
                            // Promotional banner in sidebar
                            get_template_part('template-parts/components/cpt-banniere-pub');
                            ?>
                        </div>
                    </div>

                    <!-- Colonne droite: Formulaire -->
                    <div class="px-6 pt-16 pb-20 sm:pb-24 lg:px-8 lg:py-24" x-data x-cloak>
                        <div class="mx-auto max-w-xl lg:mr-0 lg:max-w-lg">
                            <?php echo do_shortcode('[contact-form-7 id="' . $contact_form_id . '"]'); ?>
                        </div>
                    </div>

                </div>
            </div>
        </section>
    <?php endif; ?>

<?php endwhile; ?>

<?php get_footer(); ?>
