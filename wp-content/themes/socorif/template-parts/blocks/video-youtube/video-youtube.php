<?php
/**
 * YouTube Video Block Template
 */

if (!defined('ABSPATH')) exit;

// Block-Identifikation im HTML-Quellcode
socorif_block_comment_start('youtube-video');


$display_style = socorif_get_field('display_style', 'custom');
$youtube_url = socorif_get_field('youtube_url');
$video_id_direct = socorif_get_field('video_id');
$title = socorif_get_field('video_title');
$description = socorif_get_field('video_description');
$custom_thumbnail = socorif_get_field('custom_thumbnail');
$aspect_ratio = socorif_get_field('aspect_ratio', '16/9');
$use_bg = socorif_get_field('use_thumbnail_background', false);
$overlay_opacity = socorif_get_field('overlay_opacity', 50);

// Video-ID ermitteln - entweder direkt eingegeben oder aus URL extrahieren
$video_id = '';

// Priorität 1: Direkt eingegebene Video-ID
if (!empty($video_id_direct)) {
    $video_id = trim($video_id_direct);
}
// Priorität 2: Video-ID aus URL extrahieren
elseif (!empty($youtube_url)) {
    // Unterstützt verschiedene YouTube-URL-Formate:
    // - https://www.youtube.com/watch?v=VIDEO_ID
    // - https://youtu.be/VIDEO_ID
    // - https://www.youtube.com/embed/VIDEO_ID
    if (preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $youtube_url, $matches)) {
        $video_id = $matches[1];
    }
}

// Wenn keine Video-ID gefunden wurde, Block nicht anzeigen
if (empty($video_id)) return;

$thumbnail_url = ($custom_thumbnail && isset($custom_thumbnail['url'])) ? $custom_thumbnail['url'] : "https://img.youtube.com/vi/{$video_id}/maxresdefault.jpg";

$section_classes = 'py-16 lg:py-24';
if ($use_bg) {
    $section_classes .= ' relative overflow-hidden';
}

if (isset($block)) {
    $block_id = 'youtube-' . $block['id'];
    $wrapper_attrs = socorif_get_block_wrapper_attributes($block, $section_classes);
    echo '<section ' . $wrapper_attrs . '>';
} else {
    $block_id = 'youtube-' . uniqid();
    echo '<section class="' . esc_attr($section_classes) . '">';
}

// Hintergrundbild wenn aktiviert
if ($use_bg) :
    $opacity_decimal = $overlay_opacity / 100;
    ?>
    <!-- Hintergrundbild -->
    <div class="absolute inset-0 z-0">
        <img src="<?php echo esc_url($thumbnail_url); ?>"
             alt=""
             class="w-full h-full object-cover"
             aria-hidden="true">
        <div class="absolute inset-0 bg-black"
             style="opacity: <?php echo esc_attr($opacity_decimal); ?>"></div>
    </div>
    <?php
endif;

// Container-Klassen: relative z-10 wenn Background verwendet wird
$container_classes = $use_bg ? 'container relative z-10' : 'container';
?>
    <div class="<?php echo esc_attr($container_classes); ?>">
        <?php if ($title || $description) : ?>
            <div class="text-center mb-8">
                <?php if ($title) : ?>
                    <h2 class="section-title mb-4 <?php echo $use_bg ? 'text-white' : ''; ?>">
                        <?php echo esc_html($title); ?>
                    </h2>
                <?php endif; ?>

                <?php if ($description) : ?>
                    <p class="section-description max-w-2xl mx-auto <?php echo $use_bg ? 'text-gray-200' : ''; ?>">
                        <?php echo esc_html($description); ?>
                    </p>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <?php if ($display_style === 'native') : ?>
            <!-- YouTube Nativ Embed -->
            <div class="max-w-6xl mx-auto">
                <div class="relative rounded-xl overflow-hidden shadow-2xl bg-black"
                     style="aspect-ratio: <?php echo esc_attr($aspect_ratio); ?>;">
                    <iframe
                        src="https://www.youtube.com/embed/<?php echo esc_attr($video_id); ?>?rel=0"
                        class="absolute inset-0 w-full h-full"
                        frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen>
                    </iframe>
                </div>
            </div>
        <?php else : ?>
            <!-- Personalisierter Stil -->
            <div class="max-w-6xl mx-auto"
                 x-data="{ playing: false }">

            <!-- Video Container -->
            <div class="relative rounded-3xl overflow-hidden shadow-2xl hover:shadow-3xl hover:shadow-primary/30 transition-all duration-500 group/video"
                 style="aspect-ratio: <?php echo esc_attr($aspect_ratio); ?>;">

                <!-- Thumbnail with play button -->
                <template x-if="!playing">
                    <div class="absolute inset-0 cursor-pointer"
                         @click="playing = true">
                        <img src="<?php echo esc_url($thumbnail_url); ?>"
                             alt="<?php echo esc_attr($title ?: 'Video'); ?>"
                             class="w-full h-full object-cover group-hover/video:scale-110 transition-transform duration-700">

                        <!-- Overlay -->
                        <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/40 to-black/30 group-hover/video:from-black/80 group-hover/video:via-black/50 group-hover/video:to-black/40 transition-all duration-500"></div>

                        <!-- Play button -->
                        <div class="absolute inset-0 flex items-center justify-center">
                            <div class="relative">
                                <!-- Outer glow -->
                                <div class="absolute inset-0 bg-primary rounded-full blur-xl opacity-20 group-hover/video:opacity-40 transition-opacity duration-300"></div>

                                <!-- Main button -->
                                <div class="relative w-24 h-24 md:w-28 md:h-28 lg:w-32 lg:h-32 bg-gradient-to-br from-primary to-primary-dark rounded-full flex items-center justify-center shadow-xl shadow-primary/30 transform group-hover/video:scale-110 active:scale-95 transition-all duration-300 border-2 border-white/20">
                                    <svg class="w-10 h-10 md:w-12 md:h-12 lg:w-14 lg:h-14 text-white ml-1" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M8 5v14l11-7z"/>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <!-- Optional text overlay -->
                        <?php if ($title) : ?>
                            <div class="absolute bottom-0 left-0 right-0 p-6 md:p-8 bg-gradient-to-t from-black/90 via-black/60 to-transparent">
                                <p class="text-white font-semibold text-lg md:text-xl lg:text-2xl text-center opacity-0 group-hover/video:opacity-100 transition-opacity duration-300 transform translate-y-4 group-hover/video:translate-y-0">
                                    Video abspielen
                                </p>
                            </div>
                        <?php endif; ?>
                    </div>
                </template>

                <!-- YouTube iframe -->
                <template x-if="playing">
                    <iframe
                        src="https://www.youtube.com/embed/<?php echo esc_attr($video_id); ?>?autoplay=1&rel=0"
                        class="absolute inset-0 w-full h-full"
                        frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen>
                    </iframe>
                </template>
            </div>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php
// Block-Ende markieren
socorif_block_comment_end('youtube-video');
