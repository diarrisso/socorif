<?php
/**
 * Script pour voir le contenu d'un formulaire CF7
 */

require_once('/Users/mdiarrisso/PhpstormProjects/beka/wp-load.php');

$form_id = 1462;
$post = get_post($form_id);

if ($post) {
    echo "=== Form ID: $form_id ===\n";
    echo "Title: " . $post->post_title . "\n\n";
    echo "Content:\n";
    echo "---\n";
    echo $post->post_content;
    echo "\n---\n";
} else {
    echo "Form not found.\n";
}
