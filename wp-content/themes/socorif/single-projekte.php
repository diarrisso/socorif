<?php
/**
 * Template pour les projets portfolio individuels
 */

if (!defined('ABSPATH')) exit;

get_header();

while (have_posts()) : the_post();

    // Recuperer les donnees du projet
    $kunde = get_field('projekt_kunde');
    $standort = get_field('projekt_standort');
    $groesse = get_field('projekt_groesse');
    $dauer = get_field('projekt_dauer');
    $fertigstellung = get_field('projekt_fertigstellung');
    $status = get_field('projekt_status');
    $beschreibung_kurz = get_field('projekt_beschreibung_kurz');
    $galerie = get_field('projekt_galerie');
    $vorher_bild = get_field('projekt_vorher_bild');
    $nachher_bild = get_field('projekt_nachher_bild');
    $video_id = get_field('projekt_video_id');
    $leistungen = get_field('projekt_leistungen');
    $herausforderungen = get_field('projekt_herausforderungen');
    $testimonial = get_field('projekt_testimonial');
    $testimonial_autor = get_field('projekt_testimonial_autor');
    $testimonial_position = get_field('projekt_testimonial_position');
    $testimonial_bild = get_field('projekt_testimonial_bild');
    $phasen = get_field('projekt_phasen');

    // Taxonomies
    $kategorien = get_the_terms(get_the_ID(), 'projekt_kategorie');
    $typen = get_the_terms(get_the_ID(), 'projekt_typ');

    // Featured Image
    $featured_image = get_the_post_thumbnail_url(get_the_ID(), 'hero');

    // Generer le fil d'Ariane
    $breadcrumb = [
        ['label' => 'SOCORIF', 'link' => home_url('/')],
        ['label' => 'Projets', 'link' => get_post_type_archive_link('projekte')],
        ['label' => get_the_title(), 'link' => ''],
    ];
    ?>

    <!-- Hero Section -->
    <section class="hero-section relative min-h-[60vh] md:min-h-[70vh] lg:min-h-[75vh] flex flex-col justify-center overflow-hidden">

        <?php if ($featured_image) : ?>
            <!-- Background Image -->
            <div class="absolute inset-0">
                <img src="<?php echo esc_url($featured_image); ?>" alt="<?php echo esc_attr(get_the_title()); ?>" class="w-full h-full object-cover">
            </div>

            <!-- Gradient Overlay -->
            <div class="absolute inset-0 bg-gradient-to-br from-secondary-dark/70 via-secondary-dark/50 to-black/60"></div>
        <?php endif; ?>

        <!-- Content -->
        <div class="container relative z-10 px-4 py-16 md:py-20 lg:py-24">
            <div class="max-w-4xl">

                <!-- Breadcrumb -->
                <nav class="mb-4 md:mb-6" aria-label="Breadcrumb">
                    <ol class="flex flex-wrap items-center gap-2 text-sm md:text-base">
                        <?php foreach ($breadcrumb as $index => $item) :
                            $is_last = ($index === count($breadcrumb) - 1);
                        ?>
                            <li class="flex items-center gap-2">
                                <?php if ($item['link'] && !$is_last) : ?>
                                    <a href="<?php echo esc_url($item['link']); ?>" class="text-gray-300 hover:text-primary transition-colors duration-200 font-medium cursor-pointer">
                                        <?php echo esc_html($item['label']); ?>
                                    </a>
                                <?php else : ?>
                                    <span class="<?php echo $is_last ? 'text-primary font-semibold' : 'text-gray-300'; ?>">
                                        <?php echo esc_html($item['label']); ?>
                                    </span>
                                <?php endif; ?>

                                <?php if (!$is_last) : ?>
                                    <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                <?php endif; ?>
                            </li>
                        <?php endforeach; ?>
                    </ol>
                </nav>

                <!-- Categorie du projet -->
                <?php if ($kategorien) : ?>
                    <div class="mb-4">
                        <?php foreach ($kategorien as $kategorie) : ?>
                            <span class="inline-block px-4 py-1 bg-primary text-white text-sm font-semibold rounded-full">
                                <?php echo esc_html($kategorie->name); ?>
                            </span>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <!-- Titre -->
                <h1 class="text-2xl md:text-4xl lg:text-5xl xl:text-6xl font-bold text-white mb-4 leading-tight">
                    <?php the_title(); ?>
                </h1>

                <!-- Description courte -->
                <?php if ($beschreibung_kurz) : ?>
                    <p class="text-base md:text-lg text-gray-200 mb-6 max-w-2xl leading-relaxed">
                        <?php echo esc_html($beschreibung_kurz); ?>
                    </p>
                <?php endif; ?>

                <!-- Tags info du projet -->
                <div class="flex flex-wrap gap-3">
                    <?php if ($standort) : ?>
                        <div class="flex items-center gap-2 bg-white/10 backdrop-blur-md rounded-3xl px-4 py-2 border border-white/20 cursor-pointer">
                            <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <span class="text-white font-medium text-sm"><?php echo esc_html($standort); ?></span>
                        </div>
                    <?php endif; ?>

                    <?php if ($fertigstellung) : ?>
                        <div class="flex items-center gap-2 bg-white/10 backdrop-blur-md rounded-3xl px-4 py-2 border border-white/20 cursor-pointer">
                            <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <span class="text-white font-medium text-sm"><?php echo esc_html(date_i18n('F Y', strtotime($fertigstellung))); ?></span>
                        </div>
                    <?php endif; ?>

                    <?php if ($groesse) : ?>
                        <div class="flex items-center gap-2 bg-white/10 backdrop-blur-md rounded-3xl px-4 py-2 border border-white/20 cursor-pointer">
                            <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"/>
                            </svg>
                            <span class="text-white font-medium text-sm"><?php echo esc_html($groesse); ?></span>
                        </div>
                    <?php endif; ?>
                </div>

            </div>
        </div>
    </section>

    <!-- Section Details du projet -->
    <section class="section bg-white dark:bg-gray-900">
        <div class="container">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 lg:gap-12">

                <!-- Contenu principal -->
                <div class="lg:col-span-2">

                    <!-- Description du projet -->
                    <?php if (get_the_content()) : ?>
                        <div class="prose prose-lg max-w-none mb-12">
                            <?php the_content(); ?>
                        </div>
                    <?php endif; ?>

                    <!-- Defis -->
                    <?php if ($herausforderungen) : ?>
                        <div class="bg-gradient-to-br from-gray-50 to-white dark:from-gray-800 dark:to-gray-900 rounded-3xl p-6 md:p-8 mb-8 border-2 border-gray-200 dark:border-gray-700">
                            <h2 class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-white mb-4 border-l-4 border-primary pl-4">
                                Defis particuliers
                            </h2>
                            <p class="text-base md:text-lg text-gray-700 dark:text-gray-300 leading-relaxed">
                                <?php echo esc_html($herausforderungen); ?>
                            </p>
                        </div>
                    <?php endif; ?>

                    <!-- Video du projet -->
                    <?php
                    if ($video_id) :
                        // Determiner l'ID video - soit saisi directement soit extrait de l'URL
                        $youtube_video_id = '';

                        // Priorite 1: ID video saisie directement (11 caracteres)
                        if (strlen(trim($video_id)) === 11 && !strpos($video_id, '/') && !strpos($video_id, '?')) {
                            $youtube_video_id = trim($video_id);
                        }
                        // Priorite 2: Extraire l'ID video de l'URL
                        elseif (strpos($video_id, 'youtube.com') !== false || strpos($video_id, 'youtu.be') !== false) {
                            if (preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $video_id, $matches)) {
                                $youtube_video_id = $matches[1];
                            }
                        }

                        if ($youtube_video_id) :
                            $thumbnail_url = "https://img.youtube.com/vi/{$youtube_video_id}/maxresdefault.jpg";
                    ?>
                        <div class="mb-8">
                            <h2 class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-white mb-6 border-l-4 border-primary pl-4">
                                Video du projet
                            </h2>

                            <div class="rounded-3xl overflow-hidden shadow-2xl hover:shadow-3xl hover:shadow-primary/30 transition-all duration-500 border-4 border-white dark:border-gray-900 hover:border-primary/20"
                                 x-data="{ playing: false }">

                                <!-- Video Container -->
                                <div class="relative group/video"
                                     style="aspect-ratio: 16/9;">

                                    <!-- Thumbnail with play button -->
                                    <template x-if="!playing">
                                        <div class="absolute inset-0 cursor-pointer"
                                             @click="playing = true">
                                            <img src="<?php echo esc_url($thumbnail_url); ?>"
                                                 alt="Projekt-Video"
                                                 class="w-full h-full object-cover group-hover/video:scale-110 transition-transform duration-700">

                                            <!-- Overlay -->
                                            <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/40 to-black/30 group-hover/video:from-black/80 group-hover/video:via-black/50 group-hover/video:to-black/40 transition-all duration-500"></div>

                                            <!-- Play button -->
                                            <div class="absolute inset-0 flex items-center justify-center">
                                                <div class="relative">
                                                    <!-- Outer glow -->
                                                    <div class="absolute inset-0 bg-primary rounded-full blur-2xl opacity-40 group-hover/video:opacity-70 transition-opacity duration-500 scale-150"></div>

                                                    <!-- Pulse ring -->
                                                    <div class="absolute inset-0 -m-4 rounded-full border-4 border-primary/30 animate-ping"></div>

                                                    <!-- Main button -->
                                                    <div class="relative w-28 h-28 md:w-32 md:h-32 lg:w-36 lg:h-36 bg-gradient-to-br from-primary via-primary-dark to-primary rounded-full flex items-center justify-center shadow-2xl shadow-primary/50 transform group-hover/video:scale-125 active:scale-95 transition-all duration-500 border-4 border-white/20">
                                                        <svg class="w-12 h-12 md:w-14 md:h-14 lg:w-16 lg:h-16 text-white ml-2 drop-shadow-lg" fill="currentColor" viewBox="0 0 24 24">
                                                            <path d="M8 5v14l11-7z"/>
                                                        </svg>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </template>

                                    <!-- YouTube iframe -->
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
                    <?php
                        endif;
                    endif;
                    ?>

                </div>

                <!-- Sidebar: Infos du projet -->
                <div class="lg:col-span-1">
                    <div class="bg-gradient-to-br from-white via-white to-gray-50 dark:from-gray-800 dark:via-gray-800 dark:to-gray-900 rounded-3xl p-6 shadow-xl border-2 border-gray-200 dark:border-gray-700 sticky top-8">

                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-6 pb-3 border-b-2 border-primary">
                            Informations du projet
                        </h3>

                        <div class="space-y-4">
                            <?php if ($kunde) : ?>
                                <div>
                                    <dt class="text-sm font-semibold text-gray-500 dark:text-gray-400 mb-1">Client</dt>
                                    <dd class="text-base text-gray-900 dark:text-white"><?php echo esc_html($kunde); ?></dd>
                                </div>
                            <?php endif; ?>

                            <?php if ($standort) : ?>
                                <div>
                                    <dt class="text-sm font-semibold text-gray-500 dark:text-gray-400 mb-1">Localisation</dt>
                                    <dd class="text-base text-gray-900 dark:text-white"><?php echo esc_html($standort); ?></dd>
                                </div>
                            <?php endif; ?>

                            <?php if ($groesse) : ?>
                                <div>
                                    <dt class="text-sm font-semibold text-gray-500 dark:text-gray-400 mb-1">Taille du projet</dt>
                                    <dd class="text-base text-gray-900 dark:text-white"><?php echo esc_html($groesse); ?></dd>
                                </div>
                            <?php endif; ?>

                            <?php if ($dauer) : ?>
                                <div>
                                    <dt class="text-sm font-semibold text-gray-500 dark:text-gray-400 mb-1">Duree</dt>
                                    <dd class="text-base text-gray-900 dark:text-white"><?php echo esc_html($dauer); ?></dd>
                                </div>
                            <?php endif; ?>

                            <?php if ($fertigstellung) : ?>
                                <div>
                                    <dt class="text-sm font-semibold text-gray-500 dark:text-gray-400 mb-1">Achevement</dt>
                                    <dd class="text-base text-gray-900 dark:text-white"><?php echo esc_html(date_i18n('F Y', strtotime($fertigstellung))); ?></dd>
                                </div>
                            <?php endif; ?>

                            <?php if ($typen) : ?>
                                <div>
                                    <dt class="text-sm font-semibold text-gray-500 dark:text-gray-400 mb-1">Type de projet</dt>
                                    <dd class="text-base text-gray-900 dark:text-white">
                                        <?php echo esc_html(implode(', ', array_map(fn($t) => $t->name, $typen))); ?>
                                    </dd>
                                </div>
                            <?php endif; ?>

                            <?php if ($leistungen && is_array($leistungen)) : ?>
                                <div>
                                    <dt class="text-sm font-semibold text-gray-500 dark:text-gray-400 mb-2">Prestations</dt>
                                    <dd class="flex flex-wrap gap-2">
                                        <?php
                                        $leistungen_labels = [
                                            'gestion' => 'Gestion immobiliere',
                                            'promotion' => 'Promotion immobiliere',
                                            'amenagement' => 'Amenagement de domaines',
                                            'topographie' => 'Levee topographique',
                                            'plans' => 'Dressage de plans',
                                            'lotissement' => 'Lotissement',
                                            'vente_terrain' => 'Vente de terrains',
                                            'vente_maison' => 'Vente de maisons',
                                            'construction' => 'Construction',
                                            'renovation' => 'Renovation',
                                        ];
                                        foreach ($leistungen as $leistung) :
                                            $label = $leistungen_labels[$leistung] ?? $leistung;
                                        ?>
                                            <span class="inline-block px-3 py-1 bg-primary/10 text-primary text-xs font-semibold rounded-full">
                                                <?php echo esc_html($label); ?>
                                            </span>
                                        <?php endforeach; ?>
                                    </dd>
                                </div>
                            <?php endif; ?>
                        </div>

                    </div>

                    <?php
                    // Promotional banner in sidebar
                    get_template_part('template-parts/components/cpt-banniere-pub');
                    ?>
                </div>

            </div>
        </div>
    </section>

    <!-- Galerie du projet -->
    <?php if ($galerie && is_array($galerie)) :
        // Prepare images data for Alpine.js
        $images_data = array_values(array_map(function($img) {
            return [
                'url' => $img['url'] ?? '',
                'caption' => $img['caption'] ?? '',
                'alt' => $img['alt'] ?? ''
            ];
        }, $galerie));
    ?>
        <section class="section bg-gray-50 dark:bg-gray-800">
            <div class="container">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-8 text-center">
                    Galerie du projet
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8"
                     data-images='<?php echo esc_attr(wp_json_encode($images_data)); ?>'
                     x-data="{
                         lightbox: false,
                         currentIndex: 0,
                         images: [],
                         init() {
                             this.images = JSON.parse(this.$el.dataset.images);
                         },
                         openLightbox(index) {
                             this.currentIndex = index;
                             this.lightbox = true;
                         },
                         nextImage() {
                             this.currentIndex = (this.currentIndex + 1) % this.images.length;
                         },
                         prevImage() {
                             this.currentIndex = (this.currentIndex - 1 + this.images.length) % this.images.length;
                         }
                     }"
                     @keydown.arrow-right.window="if (lightbox) nextImage()"
                     @keydown.arrow-left.window="if (lightbox) prevImage()">

                    <?php foreach ($galerie as $index => $bild) : ?>
                        <div class="group relative overflow-hidden rounded-3xl cursor-pointer aspect-[4/3] shadow-xl hover:shadow-2xl transition-all duration-300 hover:-translate-y-1 border-2 border-transparent hover:border-primary/20"
                             @click="openLightbox(<?php echo $index; ?>)">
                            <img src="<?php echo esc_url($bild['url']); ?>"
                                 alt="<?php echo esc_attr($bild['alt'] ?? get_the_title()); ?>"
                                 class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">

                            <!-- Overlay on hover -->
                            <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-all duration-300 flex items-end justify-between p-4 md:p-6 rounded-3xl">
                                <?php if (!empty($bild['caption'])) : ?>
                                    <span class="text-white text-sm md:text-base font-medium opacity-0 group-hover:opacity-100 transition-opacity duration-300 bg-black/50 px-2 py-1 md:px-3 md:py-1.5 rounded-3xl">
                                        <?php echo esc_html($bild['caption']); ?>
                                    </span>
                                <?php endif; ?>

                                <!-- Expand icon -->
                                <button class="w-10 h-10 md:w-12 md:h-12 bg-gradient-to-br from-primary to-primary-dark rounded-3xl flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all duration-300 ml-auto hover:scale-110 active:scale-95 cursor-pointer shadow-lg shadow-primary/30">
                                    <svg class="w-5 h-5 md:w-6 md:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    <?php endforeach; ?>

                    <!-- Lightbox -->
                    <div x-show="lightbox"
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0"
                         x-transition:enter-end="opacity-100"
                         x-transition:leave="transition ease-in duration-200"
                         x-transition:leave-start="opacity-100"
                         x-transition:leave-end="opacity-0"
                         @click="lightbox = false"
                         @keydown.escape.window="lightbox = false"
                         class="fixed inset-0 bg-black/95 z-50 flex items-center justify-center p-4"
                         style="display: none;">

                        <!-- Close Button -->
                        <button @click="lightbox = false" class="absolute top-4 right-4 z-10 w-12 h-12 flex items-center justify-center bg-white/10 backdrop-blur-sm rounded-full text-white hover:bg-primary hover:scale-110 active:scale-95 transition-all duration-300 cursor-pointer">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>

                        <!-- Image Counter -->
                        <div class="absolute top-4 left-4 z-10 bg-white/10 backdrop-blur-sm rounded-full px-4 py-2 text-white font-semibold">
                            <span x-text="currentIndex + 1"></span> / <span x-text="images.length"></span>
                        </div>

                        <!-- Previous Button -->
                        <button @click.stop="prevImage()"
                                x-show="images.length > 1"
                                class="absolute left-4 top-1/2 -translate-y-1/2 z-10 w-12 h-12 md:w-14 md:h-14 flex items-center justify-center bg-white/10 backdrop-blur-sm rounded-full text-white hover:bg-primary hover:scale-110 active:scale-95 transition-all duration-300 cursor-pointer">
                            <svg class="w-6 h-6 md:w-7 md:h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/>
                            </svg>
                        </button>

                        <!-- Next Button -->
                        <button @click.stop="nextImage()"
                                x-show="images.length > 1"
                                class="absolute right-4 top-1/2 -translate-y-1/2 z-10 w-12 h-12 md:w-14 md:h-14 flex items-center justify-center bg-white/10 backdrop-blur-sm rounded-full text-white hover:bg-primary hover:scale-110 active:scale-95 transition-all duration-300 cursor-pointer">
                            <svg class="w-6 h-6 md:w-7 md:h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                            </svg>
                        </button>

                        <!-- Image Container -->
                        <div @click.stop class="flex flex-col items-center justify-center max-w-full max-h-full">
                            <img :src="images[currentIndex].url"
                                 :alt="images[currentIndex].alt"
                                 class="max-w-full max-h-[80vh] object-contain rounded-3xl shadow-2xl"
                                 x-transition:enter="transition ease-out duration-300"
                                 x-transition:enter-start="opacity-0 scale-95"
                                 x-transition:enter-end="opacity-100 scale-100">

                            <!-- Caption -->
                            <div x-show="images[currentIndex].caption"
                                 class="mt-4 bg-white/10 backdrop-blur-sm rounded-3xl px-6 py-3 text-white text-center max-w-2xl">
                                <p x-text="images[currentIndex].caption"></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <!-- Avant / Apres -->
    <?php if ($vorher_bild && $nachher_bild) : ?>
        <section class="section bg-white dark:bg-gray-900">
            <div class="container">
                <div class="text-center max-w-3xl mx-auto mb-12">
                    <p class="text-primary font-semibold uppercase tracking-wider mb-2 text-sm">
                        Avant / Apres
                    </p>
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white">
                        Decouvrez la transformation
                    </h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-6xl mx-auto">
                    <!-- Avant -->
                    <div class="group">
                        <div class="relative overflow-hidden rounded-3xl shadow-xl mb-4 aspect-[4/3]">
                            <img src="<?php echo esc_url($vorher_bild['url']); ?>"
                                 alt="Avant"
                                 class="w-full h-full object-cover">
                            <div class="absolute top-4 left-4 bg-gray-900/80 text-white px-4 py-2 rounded-full text-sm font-semibold">
                                Avant
                            </div>
                        </div>
                    </div>

                    <!-- Apres -->
                    <div class="group">
                        <div class="relative overflow-hidden rounded-3xl shadow-xl mb-4 aspect-[4/3]">
                            <img src="<?php echo esc_url($nachher_bild['url']); ?>"
                                 alt="Apres"
                                 class="w-full h-full object-cover">
                            <div class="absolute top-4 left-4 bg-primary text-white px-4 py-2 rounded-full text-sm font-semibold">
                                Apres
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <!-- Phases du projet -->
    <?php if ($phasen && is_array($phasen)) : ?>
        <section class="section bg-white dark:bg-gray-800">
            <div class="container">
                <div class="text-center max-w-3xl mx-auto mb-12">
                    <p class="text-primary font-semibold uppercase tracking-wider mb-2 text-sm">
                        Deroulement du projet
                    </p>
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white">
                        Les etapes du projet
                    </h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">
                    <?php foreach ($phasen as $index => $phase) : ?>
                        <div class="bg-gradient-to-br from-white via-white to-gray-50 dark:from-gray-800 dark:via-gray-800 dark:to-gray-900 rounded-3xl p-6 md:p-8 shadow-xl hover:shadow-2xl hover:shadow-primary/10 transition-all duration-300 hover:-translate-y-2 border-2 border-gray-200 dark:border-gray-700 hover:border-primary/30 group cursor-pointer">
                            <!-- Numero de phase -->
                            <div class="mb-4">
                                <span class="inline-flex items-center justify-center w-12 h-12 bg-gradient-to-br from-primary to-primary-dark text-white font-bold text-xl rounded-full">
                                    <?php echo esc_html($index + 1); ?>
                                </span>
                            </div>

                            <!-- Contenu -->
                            <div>
                                <h3 class="text-lg md:text-xl font-bold text-gray-900 dark:text-white mb-2 border-l-4 border-primary pl-4 group-hover:text-primary dark:group-hover:text-primary transition-colors duration-300">
                                    <?php echo esc_html($phase['titel']); ?>
                                </h3>

                                <?php if (!empty($phase['datum'])) : ?>
                                    <p class="text-sm text-primary font-semibold mb-3 pl-4">
                                        <?php echo esc_html($phase['datum']); ?>
                                    </p>
                                <?php endif; ?>

                                <?php if (!empty($phase['beschreibung'])) : ?>
                                    <p class="text-sm md:text-base text-gray-600 dark:text-gray-300 leading-relaxed pl-4">
                                        <?php echo esc_html($phase['beschreibung']); ?>
                                    </p>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <!-- Testimonial -->
    <?php if ($testimonial) : ?>
        <section class="section bg-gradient-to-br from-gray-50 to-gray-100 dark:from-secondary-dark dark:to-gray-900 text-gray-900 dark:text-white">
            <div class="container">
                <div class="max-w-4xl mx-auto text-center">
                    <svg class="w-16 h-16 text-primary mx-auto mb-6" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z"/>
                    </svg>

                    <blockquote class="text-xl md:text-2xl font-medium mb-8 leading-relaxed text-gray-800 dark:text-white">
                        "<?php echo esc_html($testimonial); ?>"
                    </blockquote>

                    <div class="flex items-center justify-center gap-4">
                        <?php if ($testimonial_bild) : ?>
                            <img src="<?php echo esc_url($testimonial_bild['url']); ?>"
                                 alt="<?php echo esc_attr($testimonial_autor); ?>"
                                 class="w-16 h-16 rounded-full object-cover border-2 border-primary">
                        <?php endif; ?>

                        <div class="text-left">
                            <p class="font-bold text-lg text-gray-900 dark:text-white"><?php echo esc_html($testimonial_autor); ?></p>
                            <?php if ($testimonial_position) : ?>
                                <p class="text-gray-600 dark:text-gray-300"><?php echo esc_html($testimonial_position); ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
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
    <?php endif; ?>

<?php endwhile; ?>

<?php get_footer(); ?>
