<?php
/**
 * Clients Block Template
 */

if (!defined('ABSPATH')) exit;

$logos = socorif_get_field('logos', []);
$grayscale = socorif_get_field('grayscale');

$section_classes = 'clients-block section bg-gray-50 dark:bg-gray-900';

if (isset($block)) {
    $wrapper_attrs = socorif_get_block_wrapper_attributes($block, $section_classes);
    socorif_block_comment_start('clients');
    echo '<section ' . $wrapper_attrs . '>';
} else {
    socorif_block_comment_start('clients');
    echo '<section class="' . esc_attr($section_classes) . '">';
}
?>
    <div class="container">
        <?php if ($logos) : ?>
            <div class="flex flex-wrap items-center justify-center gap-6 md:gap-8 lg:gap-10">
                <?php foreach ($logos as $client) : ?>
                    <?php if (!empty($client['logo'])) : ?>
                        <div class="group bg-gradient-to-br from-white to-gray-50 dark:from-gray-800 dark:to-gray-900 p-6 md:p-8 rounded-3xl shadow-lg hover:shadow-2xl hover:shadow-primary/10 transition-all duration-300 hover:-translate-y-2 border-2 border-gray-200 dark:border-gray-700 hover:border-primary/30 min-w-[140px] md:min-w-[180px]">
                            <?php if (!empty($client['url'])) : ?>
                                <a href="<?php echo esc_url($client['url']); ?>"
                                   target="_blank"
                                   rel="noopener noreferrer"
                                   class="block cursor-pointer">
                            <?php endif; ?>

                            <div class="flex items-center justify-center min-h-[60px] md:min-h-[80px]">
                                <?php echo socorif_image($client['logo'], 'medium', [
                                    'class' => socorif_merge_classes(
                                        'max-h-12 md:max-h-16 w-auto object-contain transition-all duration-300',
                                        $grayscale ? 'grayscale opacity-60 group-hover:grayscale-0 group-hover:opacity-100 group-hover:scale-110' : 'group-hover:scale-110'
                                    ),
                                    'alt' => $client['name'] ?? ''
                                ]); ?>
                            </div>

                            <?php if (!empty($client['url'])) : ?>
                                </a>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php socorif_block_comment_end('clients'); ?>
