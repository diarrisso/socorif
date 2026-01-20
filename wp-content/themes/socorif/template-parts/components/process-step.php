<?php
/**
 * Prozess-Schritt Komponente (Timeline-Stil)
 *
 * @param array $args {
 *     @type int    $number      Schrittnummer
 *     @type string $title       Schritttitel
 *     @type string $description Schrittbeschreibung
 *     @type bool   $is_last     Ist dies der letzte Schritt
 *     @type array  $image       Optionales Schrittbild
 *     @type array  $classes     Zusätzliche Klassen
 * }
 */

if (!defined('ABSPATH')) exit;

$defaults = [
    'number' => 1,
    'title' => '',
    'description' => '',
    'is_last' => false,
    'image' => null,
    'classes' => [],
];

$args = wp_parse_args($args ?? [], $defaults);

if (empty($args['title'])) return;

?>

<div class="relative">

    <!-- Mobile Layout (< md) -->
    <div class="md:hidden">
        <div class="flex gap-4">
            <!-- Schrittnummer mit Linie -->
            <div class="flex-shrink-0 flex flex-col items-center">
                <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-primary text-white flex items-center justify-center font-bold text-lg sm:text-xl z-10 transition-transform duration-300 hover:scale-110">
                    <?php echo esc_html($args['number']); ?>
                </div>
                <?php if (!$args['is_last']): ?>
                    <div class="w-0.5 flex-1 bg-gray-300 dark:bg-gray-700 mt-2"></div>
                <?php endif; ?>
            </div>

            <!-- Inhalt -->
            <div class="flex-1 pb-6">
                <h3 class="text-lg sm:text-xl font-bold dark:text-white mb-2">
                    <?php echo esc_html($args['title']); ?>
                </h3>
                <?php if ($args['description']): ?>
                    <p class="text-sm sm:text-base text-gray-600 dark:text-gray-300 leading-relaxed">
                        <?php echo esc_html($args['description']); ?>
                    </p>
                <?php endif; ?>

                <?php if ($args['image']): ?>
                    <div class="mt-4">
                        <img
                            src="<?php echo esc_url($args['image']['url']); ?>"
                            alt="<?php echo esc_attr($args['image']['alt'] ?? ''); ?>"
                            class="rounded-lg shadow-md w-full h-auto"
                            loading="lazy"
                        >
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Desktop Layout (>= md) -->
    <div class="hidden md:flex gap-6">
        <!-- Schrittnummer -->
        <div class="flex-shrink-0">
            <div class="w-12 h-12 lg:w-14 lg:h-14 rounded-full bg-primary text-white flex items-center justify-center font-bold text-xl lg:text-2xl transition-transform duration-300 hover:scale-110">
                <?php echo esc_html($args['number']); ?>
            </div>
            <?php if (!$args['is_last']): ?>
                <div class="w-0.5 h-full bg-gray-300 dark:bg-gray-700 mx-auto mt-2"></div>
            <?php endif; ?>
        </div>

        <!-- Schrittinhalt -->
        <div class="flex-1 pb-8">
            <h3 class="text-xl lg:text-2xl font-bold dark:text-white mb-3">
                <?php echo esc_html($args['title']); ?>
            </h3>

            <?php if ($args['description']): ?>
                <p class="text-gray-600 dark:text-gray-300 text-base lg:text-lg leading-relaxed">
                    <?php echo esc_html($args['description']); ?>
                </p>
            <?php endif; ?>

            <?php if ($args['image']): ?>
                <div class="mt-4">
                    <img
                        src="<?php echo esc_url($args['image']['url']); ?>"
                        alt="<?php echo esc_attr($args['image']['alt'] ?? ''); ?>"
                        class="rounded-lg shadow-md max-w-md"
                        loading="lazy"
                    >
                </div>
            <?php endif; ?>
        </div>
    </div>

</div>
