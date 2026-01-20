<?php
/**
 * Gallery Block Template
 */

if (!defined('ABSPATH')) exit;

// Block-Identifikation im HTML-Quellcode
socorif_block_comment_start('gallery');


$title = socorif_get_field('title');
$images = socorif_get_field('images', []);
$columns = socorif_get_field('columns', '2');

$grid_cols = [
    '2' => 'grid-cols-1 md:grid-cols-2',
    '3' => 'grid-cols-1 md:grid-cols-2 lg:grid-cols-3',
    '4' => 'grid-cols-1 sm:grid-cols-2 lg:grid-cols-4',
];

// Prepare images data for Alpine.js
$images_data = array_values(array_map(function($img) {
    return [
        'url' => $img['url'] ?? '',
        'caption' => $img['caption'] ?? '',
        'alt' => $img['alt'] ?? ''
    ];
}, $images));

$section_classes = 'gallery-block section bg-white dark:bg-gray-900';

if (isset($block)) {
    $wrapper_attrs = socorif_get_block_wrapper_attributes($block, $section_classes);
    echo '<section ' . $wrapper_attrs . '>';
} else {
    echo '<section class="' . esc_attr($section_classes) . '">';
}
?>
    <div class="container">

        <?php if ($title) : ?>
            <div class="text-center mb-8 md:mb-12">
                <h2 class="section-title dark:text-white inline-block">
                    <?php
                    // Split title to underline last word
                    $words = explode(' ', $title);
                    $last_word = array_pop($words);
                    if ($words) {
                        echo esc_html(implode(' ', $words)) . ' ';
                    }
                    ?>
                    <span class="relative">
                        <?php echo esc_html($last_word); ?>
                        <span class="absolute bottom-0 left-0 w-full h-2 bg-primary/30 -z-10"></span>
                    </span>
                </h2>
            </div>
        <?php endif; ?>

        <?php if ($images) : ?>
            <div class="grid <?php echo esc_attr($grid_cols[$columns]); ?> gap-6 md:gap-8"
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

                <?php foreach ($images as $index => $image) : ?>
                    <?php if (!empty($image)) : ?>
                        <div class="group relative overflow-hidden rounded-3xl cursor-pointer aspect-[4/3] shadow-xl hover:shadow-2xl transition-all duration-300 hover:-translate-y-1 border-2 border-transparent hover:border-primary/20"
                             @click="openLightbox(<?php echo $index; ?>)">

                            <?php echo socorif_image($image, 'large', ['class' => 'w-full h-full object-cover transition-transform duration-500 group-hover:scale-110']); ?>

                            <!-- Overlay on hover -->
                            <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-all duration-300 flex items-end justify-between p-4 md:p-6 rounded-3xl">
                                <?php if (!empty($image['caption'])) : ?>
                                    <span class="text-white text-sm md:text-base font-medium opacity-0 group-hover:opacity-100 transition-opacity duration-300 bg-black/50 px-2 py-1 md:px-3 md:py-1.5 rounded-3xl">
                                        <?php echo esc_html($image['caption']); ?>
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
                    <?php endif; ?>
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
        <?php endif; ?>

    </div>
</section>

<?php
// Block-Ende markieren
socorif_block_comment_end('gallery');
