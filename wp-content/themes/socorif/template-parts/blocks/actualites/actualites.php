<?php
/**
 * News Block Template
 * Supports grid and slider display modes
 */

if (!defined('ABSPATH')) exit;

socorif_block_comment_start('news');

$subtitle = socorif_get_field('subtitle');
$title = socorif_get_field('title');
$articles = socorif_get_field('articles', []);
$display_mode = socorif_get_field('display_mode') ?: 'grid';
$bg_color = socorif_get_field('bg_color') ?: 'white';

$bg_classes = [
    'white' => 'bg-white dark:bg-gray-900',
    'gray' => 'bg-gray-50 dark:bg-gray-800',
    'dark' => 'bg-secondary dark:bg-gray-950',
];

$section_classes = 'news-block section ' . ($bg_classes[$bg_color] ?? $bg_classes['white']);
$is_dark_bg = $bg_color === 'dark';

if (isset($block)) {
    $wrapper_attrs = socorif_get_block_wrapper_attributes($block, $section_classes);
    echo '<section ' . $wrapper_attrs . '>';
} else {
    echo '<section class="' . esc_attr($section_classes) . '">';
}
?>
    <div class="container">

        <?php if ($subtitle || $title) : ?>
            <div class="text-center mb-8 md:mb-12">
                <?php if ($subtitle) : ?>
                    <p class="text-primary font-semibold uppercase tracking-wider mb-2 text-xs md:text-sm inline-flex items-center gap-2">
                        <span class="w-3 h-3 bg-primary"></span>
                        <?php echo esc_html($subtitle); ?>
                    </p>
                <?php endif; ?>

                <?php if ($title) : ?>
                    <h2 class="section-title <?php echo $is_dark_bg ? 'text-white' : 'text-gray-900 dark:text-white'; ?>">
                        <?php echo esc_html($title); ?>
                    </h2>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <?php if ($articles) : ?>

            <?php if ($display_mode === 'slider') : ?>
                <!-- Slider Mode -->
                <div class="relative news-slider-wrapper">
                    <div class="swiper news-swiper" data-slides-per-view="3">
                        <div class="swiper-wrapper">
                            <?php foreach ($articles as $article) : ?>
                                <div class="swiper-slide">
                                    <article class="group bg-white rounded-3xl shadow-xl hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 overflow-hidden dark:bg-gray-800 border-2 border-transparent hover:border-primary/20 cursor-pointer h-full">
                                        <?php if (!empty($article['image'])) : ?>
                                            <div class="relative aspect-[4/3] overflow-hidden">
                                                <?php echo socorif_image($article['image'], 'card', ['class' => 'w-full h-full object-cover group-hover:scale-110 transition-transform duration-500']); ?>
                                                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/20 to-transparent"></div>
                                                <?php if (!empty($article['category'])) : ?>
                                                    <span class="absolute bottom-4 left-4 bg-gradient-to-r from-primary to-primary-dark text-white text-xs font-bold uppercase tracking-wider px-4 py-2 rounded-3xl shadow-lg shadow-primary/30">
                                                        <?php echo esc_html($article['category']); ?>
                                                    </span>
                                                <?php endif; ?>
                                            </div>
                                        <?php endif; ?>

                                        <div class="p-6">
                                            <?php if (!empty($article['title'])) : ?>
                                                <h3 class="text-lg font-bold mb-3 leading-tight dark:text-white border-l-4 border-primary pl-4">
                                                    <?php if (!empty($article['link'])) : ?>
                                                        <a href="<?php echo esc_url($article['link']['url']); ?>" class="hover:text-primary transition-colors cursor-pointer">
                                                            <?php echo esc_html($article['title']); ?>
                                                        </a>
                                                    <?php else : ?>
                                                        <?php echo esc_html($article['title']); ?>
                                                    <?php endif; ?>
                                                </h3>
                                            <?php endif; ?>

                                            <?php if (!empty($article['excerpt'])) : ?>
                                                <p class="text-gray-600 mb-4 line-clamp-2 dark:text-gray-300 text-sm leading-relaxed">
                                                    <?php echo esc_html($article['excerpt']); ?>
                                                </p>
                                            <?php endif; ?>

                                            <?php if (!empty($article['link'])) : ?>
                                                <a href="<?php echo esc_url($article['link']['url']); ?>"
                                                   class="inline-flex items-center gap-2 text-primary font-bold uppercase text-xs tracking-wider hover:gap-3 transition-all duration-300 cursor-pointer">
                                                    <?php echo esc_html($article['link']['title'] ?? 'Lire la suite'); ?>
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                                    </svg>
                                                </a>
                                            <?php endif; ?>
                                        </div>
                                    </article>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <!-- Navigation Buttons -->
                    <button class="news-swiper-prev absolute left-0 top-1/2 -translate-y-1/2 -translate-x-4 z-10 w-12 h-12 bg-white dark:bg-gray-800 rounded-full shadow-xl flex items-center justify-center text-gray-900 dark:text-white hover:bg-primary hover:text-white transition-all duration-300 cursor-pointer">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                    </button>
                    <button class="news-swiper-next absolute right-0 top-1/2 -translate-y-1/2 translate-x-4 z-10 w-12 h-12 bg-white dark:bg-gray-800 rounded-full shadow-xl flex items-center justify-center text-gray-900 dark:text-white hover:bg-primary hover:text-white transition-all duration-300 cursor-pointer">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </button>

                    <!-- Pagination -->
                    <div class="news-swiper-pagination flex justify-center gap-2 mt-8"></div>
                </div>

                <script>
                document.addEventListener('DOMContentLoaded', function() {
                    new Swiper('.news-swiper', {
                        slidesPerView: 1,
                        spaceBetween: 24,
                        loop: <?php echo count($articles) > 3 ? 'true' : 'false'; ?>,
                        navigation: {
                            nextEl: '.news-swiper-next',
                            prevEl: '.news-swiper-prev',
                        },
                        pagination: {
                            el: '.news-swiper-pagination',
                            clickable: true,
                            bulletClass: 'w-3 h-3 rounded-full bg-gray-300 dark:bg-gray-600 cursor-pointer transition-all duration-300',
                            bulletActiveClass: '!bg-primary !w-8',
                        },
                        breakpoints: {
                            640: {
                                slidesPerView: 2,
                                spaceBetween: 24,
                            },
                            1024: {
                                slidesPerView: 3,
                                spaceBetween: 32,
                            },
                        },
                    });
                });
                </script>

            <?php else : ?>
                <!-- Grid Mode -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">
                    <?php foreach ($articles as $article) : ?>
                        <article class="group bg-white rounded-3xl shadow-xl hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 overflow-hidden dark:bg-gray-800 border-2 border-transparent hover:border-primary/20 cursor-pointer">
                            <?php if (!empty($article['image'])) : ?>
                                <div class="relative aspect-[4/3] overflow-hidden">
                                    <?php echo socorif_image($article['image'], 'card', ['class' => 'w-full h-full object-cover group-hover:scale-110 transition-transform duration-500']); ?>
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/20 to-transparent"></div>
                                    <?php if (!empty($article['category'])) : ?>
                                        <span class="absolute bottom-4 left-4 bg-gradient-to-r from-primary to-primary-dark text-white text-xs font-bold uppercase tracking-wider px-4 py-2 rounded-3xl shadow-lg shadow-primary/30">
                                            <?php echo esc_html($article['category']); ?>
                                        </span>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>

                            <div class="p-6 md:p-8">
                                <?php if (!empty($article['title'])) : ?>
                                    <h3 class="section-subtitle mb-4 leading-tight dark:text-white border-l-4 border-primary pl-4">
                                        <?php if (!empty($article['link'])) : ?>
                                            <a href="<?php echo esc_url($article['link']['url']); ?>" class="hover:text-primary transition-colors cursor-pointer">
                                                <?php echo esc_html($article['title']); ?>
                                            </a>
                                        <?php else : ?>
                                            <?php echo esc_html($article['title']); ?>
                                        <?php endif; ?>
                                    </h3>
                                <?php endif; ?>

                                <?php if (!empty($article['excerpt'])) : ?>
                                    <p class="section-text text-gray-600 mb-6 line-clamp-3 dark:text-gray-300 leading-relaxed">
                                        <?php echo esc_html($article['excerpt']); ?>
                                    </p>
                                <?php endif; ?>

                                <?php if (!empty($article['link'])) : ?>
                                    <a href="<?php echo esc_url($article['link']['url']); ?>"
                                       class="inline-flex items-center gap-2 text-primary font-bold uppercase text-xs md:text-sm tracking-wider hover:gap-4 transition-all duration-300 group-hover:translate-x-1 cursor-pointer">
                                        <span class="w-8 h-0.5 bg-gradient-to-r from-primary to-primary-dark"></span>
                                        <?php echo esc_html($article['link']['title'] ?? 'Lire la suite'); ?>
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                        </svg>
                                    </a>
                                <?php endif; ?>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

        <?php endif; ?>

    </div>
</section>

<?php
socorif_block_comment_end('news');
