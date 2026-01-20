<?php

$blocks_dir = __DIR__ . '/wp-content/themes/beka/template-parts/blocks/';

$blocks_to_update = [
    'cta-split', 'details-page', 'gallery', 'hero-section', 'location', 'news',
    'partners', 'projects-grid', 'section-cta', 'service-details', 'services-icons',
    'slider', 'stats', 'team', 'testimonials', 'text-image', 'timeline', 'youtube-video'
];

$translations = [
    'Get fields' => 'Felder abrufen',
    'Section Header' => 'Sektion Kopfbereich',
    'Content' => 'Inhalt',
    'Background Image' => 'Hintergrundbild',
    'Cards Grid' => 'Karten-Raster',
    'Build section classes' => 'Section-Klassen erstellen',
    'Mobile-first responsive' => 'Mobile-First Responsive',
    'Column classes' => 'Spalten-Klassen',
    'Height classes' => 'Höhen-Klassen',
    'Block wrapper' => 'Block-Wrapper',
];

echo "=== Block-Kommentare Update ===\n\n";

$updated_count = 0;

foreach ($blocks_to_update as $block_name) {
    $file_path = $blocks_dir . $block_name . '/' . $block_name . '.php';

    if (!file_exists($file_path)) {
        echo "Skip: $file_path nicht gefunden\n";
        continue;
    }

    $content = file_get_contents($file_path);
    $original = $content;

    if (strpos($content, 'beka_block_comment_start') !== false) {
        echo "Skip: $block_name bereits aktualisiert\n";
        continue;
    }

    // Add start comment
    $pattern = "if (!defined('ABSPATH')) exit;";
    $replacement = "if (!defined('ABSPATH')) exit;\n\n// Block-Identifikation im HTML-Quellcode\nbeka_block_comment_start('" . $block_name . "');\n";
    $content = str_replace($pattern, $replacement, $content);

    // Add end comment before closing
    if (substr(rtrim($content), -2) === '?>') {
        $content = rtrim($content);
        $content = substr($content, 0, -2);
        $content .= "\n<?php\n// Block-Ende markieren\nbeka_block_comment_end('" . $block_name . "');\n?>\n";
    } else {
        $content = rtrim($content) . "\n\n<?php\n// Block-Ende markieren\nbeka_block_comment_end('" . $block_name . "');\n";
    }

    // Translate comments
    foreach ($translations as $en => $de) {
        $content = str_replace('// ' . $en, '// ' . $de, $content);
        $content = str_replace('<!-- ' . $en . ' -->', '<!-- ' . $de . ' -->', $content);
    }

    if ($content !== $original) {
        file_put_contents($file_path, $content);
        echo "OK: $block_name aktualisiert\n";
        $updated_count++;
    }
}

echo "\n=== Fertig ===\n";
echo "Aktualisiert: $updated_count\n";
