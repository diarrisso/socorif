<?php
/**
 * Script zur automatischen Aktualisierung von Block-Kommentaren
 *
 * Dieses Script fügt HTML-Identifikationskommentare zu allen Blocks hinzu
 * und übersetzt englische Kommentare ins Deutsche
 */

// Pfad zum Blocks-Verzeichnis
$blocks_dir = __DIR__ . '/wp-content/themes/beka/template-parts/blocks/';

// Liste der bereits aktualisierten Blocks (überspringen)
$updated_blocks = [
    'hero',
    'services-cards',
    'about',
    'accordion',
    'before-after',
    'blog-grid',
    'certifications',
    'clients',
    'contact-form'
];

// Liste der zu aktualisierenden Blocks
$blocks_to_update = [
    'cta-split',
    'details-page',
    'gallery',
    'hero-section',
    'location',
    'news',
    'partners',
    'projects-grid',
    'section-cta',
    'service-details',
    'services-icons',
    'slider',
    'stats',
    'team',
    'testimonials',
    'text-image',
    'timeline',
    'youtube-video'
];

// Übersetzungstabelle für häufige Kommentare
$translations = [
    'Get fields' => 'Felder abrufen',
    'Section Header' => 'Sektion Kopfbereich',
    'Content' => 'Inhalt',
    'Background Image' => 'Hintergrundbild',
    'Cards Grid' => 'Karten-Raster',
    'Build section classes' => 'Section-Klassen erstellen',
    'Mobile-first responsive' => 'Mobile-First Responsive',
    'Button' => 'Schaltfläche',
    'Submit Button' => 'Absenden-Button',
    'Image' => 'Bild',
    'Title' => 'Titel',
    'Description' => 'Beschreibung',
    'Text color based on background' => 'Textfarbe basierend auf Hintergrund',
    'Column classes' => 'Spalten-Klassen',
    'Height classes' => 'Höhen-Klassen',
    'Alignment classes' => 'Ausrichtungs-Klassen',
    'Block wrapper' => 'Block-Wrapper',
    'Section' => 'Bereich',
    'Grid' => 'Raster',
    'List' => 'Liste',
    'Item' => 'Element',
    'Link' => 'Link',
    'Icon' => 'Symbol'
];

echo "=== Block-Kommentare Aktualisierungs-Script ===\n\n";

$updated_count = 0;
$error_count = 0;

foreach ($blocks_to_update as $block_name) {
    $file_path = $blocks_dir . $block_name . '/' . $block_name . '.php';

    if (!file_exists($file_path)) {
        echo "⚠️  Datei nicht gefunden: $file_path\n";
        $error_count++;
        continue;
    }

    // Datei einlesen
    $content = file_get_contents($file_path);
    $original_content = $content;

    // Prüfen ob bereits aktualisiert
    if (strpos($content, 'beka_block_comment_start') !== false) {
        echo "ℹ️  Block '$block_name' bereits aktualisiert\n";
        continue;
    }

    // 1. Fuege beka_block_comment_start() nach ABSPATH-Check hinzu
    $abspath_pattern = "/if \(!defined\('ABSPATH'\)\) exit;\n/";
    if (preg_match($abspath_pattern, $content)) {
        $content = preg_replace(
            $abspath_pattern,
            "if (!defined('ABSPATH')) exit;\n\n// Block-Identifikation im HTML-Quellcode\nbeka_block_comment_start('$block_name');\n",
            $content,
            1
        );
    }

    // 2. Fuege beka_block_comment_end() vor dem letzten ?> oder am Ende hinzu
    if (preg_match('/<\?php\s*$/s', $content)) {
        // Datei endet mit PHP-Tag ohne Schliessen
        $content = rtrim($content) . "\n\n<?php\n// Block-Ende markieren\nbeka_block_comment_end('$block_name');\n";
    } elseif (preg_match('/\?>\s*$/s', $content)) {
        // Datei endet mit PHP-Close-Tag
        $content = preg_replace('/\?>\s*$/s', "<?php\n// Block-Ende markieren\nbeka_block_comment_end('$block_name');\n?>\n", $content);
    } else {
        // Kein PHP-Tag am Ende
        $content = rtrim($content) . "\n<?php\n// Block-Ende markieren\nbeka_block_comment_end('$block_name');\n";
    }

    // 3. Uebersetze haeufige Kommentare
    foreach ($translations as $english => $german) {
        // PHP-Kommentare
        $content = preg_replace("/\/\/ " . preg_quote($english, '/') . "/", "// " . $german, $content);
        // HTML-Kommentare
        $content = preg_replace("/<!-- " . preg_quote($english, '/') . " -->/", "<!-- " . $german . " -->", $content);
    }

    // Nur speichern wenn Änderungen vorhanden
    if ($content !== $original_content) {
        file_put_contents($file_path, $content);
        echo "✅ Block '$block_name' aktualisiert\n";
        $updated_count++;
    } else {
        echo "⚠️  Keine Änderungen für Block '$block_name'\n";
    }
}

echo "\n=== Zusammenfassung ===\n";
echo "Aktualisiert: $updated_count\n";
echo "Fehler: $error_count\n";
echo "Gesamt: " . count($blocks_to_update) . "\n";
echo "\n✅ Script abgeschlossen!\n";
