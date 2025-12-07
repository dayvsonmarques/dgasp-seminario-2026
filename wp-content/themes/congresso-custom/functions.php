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
    wp_enqueue_style('congresso-custom-style', get_stylesheet_uri(), [], filemtime(get_template_directory() . '/style.css'));
    wp_enqueue_script('bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js', [], null, true);
}
add_action('wp_enqueue_scripts', 'congresso_custom_enqueue_scripts');

// Hide admin bar on front-end
add_filter('show_admin_bar', '__return_false');

// Helper: WordPress native login URL
function congresso_get_login_page_url(){
    // Custom public login endpoint
    return home_url('/gerenciamento/');
}

// Helper: Certificados page URL
function congresso_get_certificados_page_url(){
    $page = get_page_by_path('certificados');
    return $page ? get_permalink($page->ID) : home_url('/certificados/');
}

// Update Primary Menu 'Login' item to point to native login page
function congresso_menu_login_link($atts, $item, $args){
    if (isset($args->theme_location) && $args->theme_location === 'primary') {
        $title = strtolower(trim($item->title));
        if (in_array($title, ['login','entrar'])) {
            // Public site behavior: if already logged-in, send to certificados; else to WP login
            if (is_user_logged_in()) {
                $atts['href'] = esc_url(congresso_get_certificados_page_url());
            } else {
                $atts['href'] = esc_url(congresso_get_login_page_url());
            }
        }
    }
    return $atts;
}
add_filter('nav_menu_link_attributes', 'congresso_menu_login_link', 10, 3);

// Redirect after login: admins/editors to dashboard; others to homepage
function congresso_login_redirect($redirect_to, $request, $user){
    if (is_wp_error($user) || !$user) { return $redirect_to; }

    if (user_can($user, 'administrator') || user_can($user, 'editor')) {
        return !empty($redirect_to) ? $redirect_to : admin_url();
    }
    // Non-admin/editor: go to Certificados page
    return congresso_get_certificados_page_url();
}
add_filter('login_redirect', 'congresso_login_redirect', 10, 3);

// When logged in, change "Login/Entrar" menu label to "Certificados"
function congresso_menu_login_title($title, $item, $args){
    if (isset($args->theme_location) && $args->theme_location === 'primary') {
        $normalized = strtolower(trim(strip_tags($title)));
        if (in_array($normalized, ['login','entrar'])) {
            if (is_user_logged_in()) {
                return 'Certificados';
            }
        }
    }
    return $title;
}
add_filter('nav_menu_item_title', 'congresso_menu_login_title', 10, 3);

// Route /gerenciamento to WordPress login page
function congresso_register_gerenciamento_route() {
    add_rewrite_rule('^gerenciamento/?$', 'index.php?congresso_gerenciamento=1', 'top');
}
add_action('init', 'congresso_register_gerenciamento_route');

function congresso_add_query_vars($vars) {
    $vars[] = 'congresso_gerenciamento';
    return $vars;
}
add_filter('query_vars', 'congresso_add_query_vars');

function congresso_handle_gerenciamento_route(){
    if (get_query_var('congresso_gerenciamento')) {
        // If already logged in, do not show login screen; redirect by role
        if (is_user_logged_in()) {
            $user = wp_get_current_user();
            if (user_can($user, 'administrator') || user_can($user, 'editor')) {
                wp_safe_redirect(admin_url());
            } else {
                wp_safe_redirect(congresso_get_certificados_page_url());
            }
            exit;
        }
        // Not logged in: show WordPress core login page
        require_once ABSPATH . 'wp-login.php';
        exit;
    }
}
add_action('template_redirect', 'congresso_handle_gerenciamento_route');

// Make wp_login_url point to our custom path
function congresso_filter_login_url($login_url, $redirect, $force_reauth){
    return home_url('/gerenciamento/');
}
add_filter('login_url', 'congresso_filter_login_url', 10, 3);

// Ensure core public pages exist: Sobre, Comissões
function congresso_ensure_core_pages(){
    $pages = [
        [ 'title' => 'Sobre', 'slug' => 'sobre' ],
        [ 'title' => 'Comissões', 'slug' => 'comissoes' ],
    ];
    foreach ($pages as $cfg) {
        $existing = get_page_by_path($cfg['slug']);
        if (!$existing) {
            $page_id = wp_insert_post([
                'post_title'  => $cfg['title'],
                'post_name'   => $cfg['slug'],
                'post_status' => 'publish',
                'post_type'   => 'page',
            ]);
            // Assign template
            if (!is_wp_error($page_id)) {
                $tpl = $cfg['slug'] === 'sobre' ? 'page-sobre.php' : ($cfg['slug'] === 'comissoes' ? 'page-comissoes.php' : '');
                if ($tpl) {
                    update_post_meta($page_id, '_wp_page_template', $tpl);
                }
            }
        }
    }
}
add_action('init', 'congresso_ensure_core_pages');

// Update menu link for "Contato" to scroll to footer
function congresso_menu_contact_scroll($atts, $item, $args){
    if (isset($args->theme_location) && $args->theme_location === 'primary') {
        $title = strtolower(trim($item->title));
        if (in_array($title, ['contato','contact'])) {
            // Scroll to footer element id (ensure your footer has id="footer")
            $atts['href'] = '#footer';
            // Add smooth scroll behavior via attributes/classes if desired
            $atts['class'] = isset($atts['class']) ? $atts['class'] . ' js-scroll' : 'js-scroll';
        }
    }
    return $atts;
}
add_filter('nav_menu_link_attributes', 'congresso_menu_contact_scroll', 10, 3);

// Ensure rewrite rules include /gerenciamento (one-time flush)
function congresso_flush_rewrite_for_gerenciamento_once(){
    if (!get_option('congresso_gerenciamento_rewrite_flushed')) {
        flush_rewrite_rules();
        update_option('congresso_gerenciamento_rewrite_flushed', 1);
    }
}
add_action('init', 'congresso_flush_rewrite_for_gerenciamento_once', 20);

// Block direct access to wp-admin for non-admin/editor: redirect to home
function congresso_block_admin_access_for_public(){
    if (is_admin()) {
        // Allow AJAX requests
        if (defined('DOING_AJAX') && DOING_AJAX) { return; }
        // Only allow administrators and editors
        if (!current_user_can('administrator') && !current_user_can('editor')) {
            wp_safe_redirect(home_url('/'));
            exit;
        }
    }
}
add_action('admin_init', 'congresso_block_admin_access_for_public');

// Block wp-login.php direct access for logged-in non-admin/editor: redirect to home
function congresso_block_wp_login_for_logged_in(){
    // Allow the logout flow to proceed unhindered
    $action = isset($_REQUEST['action']) ? strtolower(sanitize_text_field($_REQUEST['action'])) : '';
    if ($action === 'logout') {
        return;
    }
    // Runs on login form load
    if (is_user_logged_in()) {
        $user = wp_get_current_user();
        if (!user_can($user, 'administrator') && !user_can($user, 'editor')) {
            wp_safe_redirect(home_url('/'));
            exit;
        }
    }
}
add_action('login_init', 'congresso_block_wp_login_for_logged_in');
