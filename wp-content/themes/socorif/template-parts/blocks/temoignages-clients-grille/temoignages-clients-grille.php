<?php
/**
 * Client Testimonials Grid Block
 * Displays testimonials in a 2-column grid with load more functionality
 */

if (!defined('ABSPATH')) exit;

// Block identification
socorif_block_comment_start('testimonials-grid');

// Get fields
$title = socorif_get_field('title', 'Mes clients temoignent');
$initial_count = socorif_get_field('initial_count', 4);
$load_more_count = socorif_get_field('load_more_count', 2);
$button_text = socorif_get_field('button_text', 'Voir les Temoignages');
$testimonials = socorif_get_field('testimonials', []);
$bg_color = socorif_get_field('bg_color', 'white');

if (empty($testimonials)) {
    return;
}

$total_count = count($testimonials);

// Background classes
$bg_classes = [
    'white' => 'bg-white dark:bg-gray-900',
    'gray-50' => 'bg-gray-50 dark:bg-gray-800',
];

$section_classes = socorif_merge_classes(
    'testimonials-grid-block section',
    $bg_classes[$bg_color] ?? 'bg-white dark:bg-gray-900'
);

// Unique ID for Alpine.js
$block_id = 'tcg-' . uniqid();
?>

<section class="<?php echo esc_attr($section_classes); ?>">
    <div class="container mx-auto px-4 lg:px-8">

        <?php if ($title) : ?>
            <h2 class="section-title text-center text-gray-900 dark:text-white mb-12 lg:mb-16">
                <?php echo esc_html($title); ?>
            </h2>
        <?php endif; ?>

        <div x-data="{
            visibleCount: <?php echo intval($initial_count); ?>,
            totalCount: <?php echo intval($total_count); ?>,
            loadMoreCount: <?php echo intval($load_more_count); ?>,
            loadMore() {
                this.visibleCount = Math.min(this.visibleCount + this.loadMoreCount, this.totalCount);
            }
        }">
            <!-- Testimonials Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 lg:gap-10">
                <?php foreach ($testimonials as $index => $testimonial) :
                    $quote = $testimonial['quote'] ?? '';
                    $photo = $testimonial['photo'] ?? null;
                    $name = $testimonial['name'] ?? '';
                    $position = $testimonial['position'] ?? '';
                    $company = $testimonial['company'] ?? '';
                    $company_logo = $testimonial['company_logo'] ?? null;

                    if (!$quote || !$name) continue;
                ?>
                    <article
                        class="testimonial-card bg-white dark:bg-gray-800 rounded-2xl p-6 lg:p-8 shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-100 dark:border-gray-700"
                        x-show="<?php echo $index; ?> < visibleCount"
                        x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 translate-y-4"
                        x-transition:enter-end="opacity-100 translate-y-0"
                    >
                        <!-- Quote -->
                        <div class="mb-6">
                            <svg class="w-8 h-8 text-primary/30 mb-4" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z"/>
                            </svg>
                            <blockquote class="text-gray-700 dark:text-gray-300 leading-relaxed">
                                <?php echo esc_html($quote); ?>
                            </blockquote>
                        </div>

                        <!-- Author Info -->
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-4">
                                <?php if ($photo) : ?>
                                    <div class="w-14 h-14 rounded-full overflow-hidden ring-2 ring-primary/20 flex-shrink-0">
                                        <?php echo socorif_image($photo, 'thumbnail', ['class' => 'w-full h-full object-cover']); ?>
                                    </div>
                                <?php else : ?>
                                    <div class="w-14 h-14 rounded-full bg-primary/10 flex items-center justify-center flex-shrink-0">
                                        <span class="text-primary font-bold text-lg">
                                            <?php echo esc_html(mb_substr($name, 0, 1)); ?>
                                        </span>
                                    </div>
                                <?php endif; ?>

                                <div>
                                    <p class="font-semibold text-gray-900 dark:text-white">
                                        <?php echo esc_html($name); ?>
                                    </p>
                                    <?php if ($position || $company) : ?>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">
                                            <?php
                                            $info_parts = array_filter([$position, $company]);
                                            echo esc_html(implode(', ', $info_parts));
                                            ?>
                                        </p>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <?php if ($company_logo) : ?>
                                <div class="hidden sm:block w-20 h-12 flex-shrink-0">
                                    <?php echo socorif_image($company_logo, 'thumbnail', ['class' => 'w-full h-full object-contain opacity-60 dark:opacity-40']); ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>

            <!-- Load More Button -->
            <?php if ($total_count > $initial_count) : ?>
                <div class="text-center mt-10 lg:mt-12" x-show="visibleCount < totalCount">
                    <button
                        @click="loadMore()"
                        class="inline-flex items-center gap-2 bg-primary hover:bg-primary-dark text-white font-semibold px-8 py-4 rounded-full transition-all duration-300 hover:scale-105 active:scale-95 shadow-lg shadow-primary/30"
                    >
                        <span><?php echo esc_html($button_text); ?></span>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                </div>
            <?php endif; ?>

            <!-- All loaded message -->
            <div
                class="text-center mt-10 lg:mt-12"
                x-show="visibleCount >= totalCount && totalCount > <?php echo intval($initial_count); ?>"
                x-transition
            >
                <p class="text-gray-500 dark:text-gray-400 text-sm">
                    Tous les temoignages ont ete charges
                </p>
            </div>
        </div>

    </div>
</section>

<?php
// Block end marker
socorif_block_comment_end('testimonials-grid');
