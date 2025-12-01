<?php
// Theme setup
function congresso_custom_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('custom-logo');
    register_nav_menus([
        'primary' => __('Primary Menu', 'congresso-custom'),
    ]);
}
add_action('after_setup_theme', 'congresso_custom_setup');

// Enqueue styles and scripts
function congresso_custom_enqueue_scripts() {
    wp_enqueue_style('bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css');
    wp_enqueue_style('congresso-custom-style', get_stylesheet_uri());
    wp_enqueue_style('congresso-custom-main', get_template_directory_uri() . '/assets/css/main.css');
    wp_enqueue_script('bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js', [], null, true);
}
add_action('wp_enqueue_scripts', 'congresso_custom_enqueue_scripts');

// Hide admin bar on front-end
add_filter('show_admin_bar', '__return_false');
