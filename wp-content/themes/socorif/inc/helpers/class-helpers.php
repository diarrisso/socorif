<?php
/**
 * CSS Class Helper Functions
 */

if (!defined('ABSPATH')) exit;

/**
 * Merge multiple class strings/arrays into one
 */
function socorif_merge_classes(...$classes) {
    $result = [];

    foreach ($classes as $class) {
        if (is_array($class)) {
            $result = array_merge($result, $class);
        } elseif (is_string($class) && !empty($class)) {
            $result = array_merge($result, explode(' ', $class));
        }
    }

    return implode(' ', array_unique(array_filter($result)));
}

/**
 * Conditional class helper
 */
function socorif_class_if($condition, $true_class, $false_class = '') {
    return $condition ? $true_class : $false_class;
}

/**
 * Get text alignment class
 */
function socorif_text_align_class($align = 'left') {
    $alignments = [
        'left' => 'text-left',
        'center' => 'text-center',
        'right' => 'text-right',
    ];

    return $alignments[$align] ?? 'text-left';
}

/**
 * Get container width class
 */
function socorif_container_class($width = 'default') {
    $widths = [
        'narrow' => 'max-w-3xl',
        'default' => 'max-w-6xl',
        'wide' => 'max-w-7xl',
        'full' => 'max-w-full',
    ];

    return $widths[$width] ?? 'max-w-6xl';
}

/**
 * Get color classes based on scheme
 */
function socorif_color_scheme_classes($scheme = 'light') {
    $schemes = [
        'light' => [
            'bg' => 'bg-white',
            'text' => 'text-gray-800',
            'heading' => '',
        ],
        'dark' => [
            'bg' => 'bg-secondary-dark',
            'text' => 'text-gray-200',
            'heading' => 'text-white',
        ],
        'primary' => [
            'bg' => 'bg-primary',
            'text' => 'text-white',
            'heading' => 'text-white',
        ],
        'secondary' => [
            'bg' => 'bg-secondary',
            'text' => 'text-white',
            'heading' => 'text-white',
        ],
    ];

    return $schemes[$scheme] ?? $schemes['light'];
}

/**
 * Get button variant classes
 */
function socorif_button_classes($variant = 'primary', $size = 'md') {
    $variants = [
        'primary' => 'btn btn-primary',
        'secondary' => 'btn btn-secondary',
        'outline' => 'btn border-2 border-primary text-primary hover:bg-primary hover:text-white',
        'ghost' => 'btn text-primary hover:bg-primary/10',
    ];

    $sizes = [
        'sm' => 'px-4 py-2 text-sm',
        'md' => 'px-6 py-3',
        'lg' => 'px-8 py-4 text-lg',
    ];

    $base = $variants[$variant] ?? $variants['primary'];
    $size_class = $sizes[$size] ?? $sizes['md'];

    return socorif_merge_classes($base, $size_class);
}
