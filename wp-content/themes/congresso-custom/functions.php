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

// Register Custom Post Type: Certificados (slug: certify)
function congresso_register_certificados_cpt() {
    $labels = [
        'name' => __('Certificados', 'congresso-custom'),
        'singular_name' => __('Certificado', 'congresso-custom'),
        'add_new' => __('Adicionar novo', 'congresso-custom'),
        'add_new_item' => __('Adicionar novo Certificado', 'congresso-custom'),
        'edit_item' => __('Editar Certificado', 'congresso-custom'),
        'new_item' => __('Novo Certificado', 'congresso-custom'),
        'view_item' => __('Ver Certificado', 'congresso-custom'),
        'search_items' => __('Buscar Certificados', 'congresso-custom'),
        'not_found' => __('Nenhum Certificado encontrado', 'congresso-custom'),
        'not_found_in_trash' => __('Nenhum Certificado na lixeira', 'congresso-custom'),
    ];

    $args = [
        'labels' => $labels,
        'public' => true,
        // Use a distinct archive slug to avoid conflict with the page 'certificados'
        'has_archive' => 'certificados-registros',
        'menu_icon' => 'dashicons-media-document',
        'rewrite' => ['slug' => 'certificados-registros'],
        'show_in_rest' => true,
        'supports' => ['title'],
    ];

    register_post_type('certify', $args);
}
add_action('init', 'congresso_register_certificados_cpt');

// After changing CPT rewrite rules, force a one-time flush of rewrites
function congresso_certificados_flush_rewrite_once() {
    if (!get_option('congresso_certificados_rewrite_flushed')) {
        flush_rewrite_rules();
        update_option('congresso_certificados_rewrite_flushed', 1);
    }
}
add_action('init', 'congresso_certificados_flush_rewrite_once');

// Meta keys
const CERTIFY_META_USER = 'certify_user_id';
const CERTIFY_META_PDF = 'certify_pdf_id';
const CERTIFY_META_DATE = 'certify_issue_date';

// Add meta boxes
function congresso_certify_add_meta_boxes() {
    add_meta_box('certify_user', __('Usuário', 'congresso-custom'), 'congresso_certify_user_meta_box', 'certify', 'side');
    add_meta_box('certify_pdf', __('PDF do Certificado', 'congresso-custom'), 'congresso_certify_pdf_meta_box', 'certify', 'normal');
    add_meta_box('certify_date', __('Data de emissão', 'congresso-custom'), 'congresso_certify_date_meta_box', 'certify', 'side');
}
add_action('add_meta_boxes', 'congresso_certify_add_meta_boxes');

function congresso_certify_user_meta_box($post) {
    wp_nonce_field('certify_meta_save', 'certify_meta_nonce');
    $selected = (int) get_post_meta($post->ID, CERTIFY_META_USER, true);
    $users = get_users(['fields' => ['ID', 'display_name']]);
    echo '<select name="' . CERTIFY_META_USER . '" class="widefat">';
    echo '<option value="">— Selecione —</option>';
    foreach ($users as $u) {
        printf('<option value="%d" %s>%s</option>', $u->ID, selected($selected, $u->ID, false), esc_html($u->display_name));
    }
    echo '</select>';
}

function congresso_certify_pdf_meta_box($post) {
    $attachment_id = (int) get_post_meta($post->ID, CERTIFY_META_PDF, true);
    $url = $attachment_id ? wp_get_attachment_url($attachment_id) : '';
    echo '<input type="hidden" id="certify_pdf_id" name="' . CERTIFY_META_PDF . '" value="' . esc_attr($attachment_id) . '" />';
    echo '<div id="certify_pdf_preview">' . ($url ? '<a href="' . esc_url($url) . '" target="_blank">PDF atual</a>' : 'Nenhum PDF selecionado') . '</div>';
    echo '<p><button type="button" class="button" id="certify_pdf_select">Selecionar PDF</button> ';
    echo '<button type="button" class="button" id="certify_pdf_remove">Remover</button></p>';
    echo '<p class="description">Envie ou selecione um arquivo PDF.</p>';
    // Media uploader script (inline for simplicity)
    echo <<<JS
<script>
jQuery(function($){
    let frame;
    $("#certify_pdf_select").on("click", function(e){
        e.preventDefault();
        if(frame){ frame.open(); return; }
        frame = wp.media({ title: "Selecionar PDF", button: { text: "Usar este PDF" }, library: { type: "application" }, multiple: false });
        frame.on("select", function(){
            const attachment = frame.state().get("selection").first().toJSON();
            $("#certify_pdf_id").val(attachment.id);
            $("#certify_pdf_preview").html('<a target="_blank" href="'+attachment.url+'">PDF atual</a>');
        });
        frame.open();
    });
    $("#certify_pdf_remove").on("click", function(){
        $("#certify_pdf_id").val("");
        $("#certify_pdf_preview").text("Nenhum PDF selecionado");
    });
});
</script>
JS;
}

function congresso_certify_date_meta_box($post) {
    $date = get_post_meta($post->ID, CERTIFY_META_DATE, true);
    echo '<input type="date" name="' . CERTIFY_META_DATE . '" class="widefat" value="' . esc_attr($date) . '" />';
}

// Save meta
function congresso_certify_save_post($post_id) {
    if (!isset($_POST['certify_meta_nonce']) || !wp_verify_nonce($_POST['certify_meta_nonce'], 'certify_meta_save')) return;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $post_id)) return;
    if (get_post_type($post_id) !== 'certify') return;

    $user_id = isset($_POST[CERTIFY_META_USER]) ? (int) $_POST[CERTIFY_META_USER] : 0;
    $pdf_id = isset($_POST[CERTIFY_META_PDF]) ? (int) $_POST[CERTIFY_META_PDF] : 0;
    $date = isset($_POST[CERTIFY_META_DATE]) ? sanitize_text_field($_POST[CERTIFY_META_DATE]) : '';

    update_post_meta($post_id, CERTIFY_META_USER, $user_id);
    update_post_meta($post_id, CERTIFY_META_PDF, $pdf_id);
    update_post_meta($post_id, CERTIFY_META_DATE, $date);
}
add_action('save_post', 'congresso_certify_save_post');

// Ensure media uploader available in admin
function congresso_certify_admin_scripts($hook) {
    if ($hook === 'post.php' || $hook === 'post-new.php') {
        wp_enqueue_media();
    }
}
add_action('admin_enqueue_scripts', 'congresso_certify_admin_scripts');

// Flush rewrite rules on theme activation to ensure permalinks work
function congresso_flush_rewrite_on_activation() {
    flush_rewrite_rules();
}
add_action('after_switch_theme', 'congresso_flush_rewrite_on_activation');

// Create a custom Login page template programmatically if not present
function congresso_register_login_page_template($templates){
    $templates['page-login.php'] = 'Página de Login';
    return $templates;
}
add_filter('theme_page_templates', 'congresso_register_login_page_template');

// Register Certificados page template name
function congresso_register_certificados_page_template($templates){
    $templates['page-certificados.php'] = 'Página de Certificados';
    return $templates;
}
add_filter('theme_page_templates', 'congresso_register_certificados_page_template');

// Redirect menu Login to custom page: create helper to get/login page URL
function congresso_get_login_page_url(){
    $page = get_page_by_path('login');
    if($page){ return get_permalink($page->ID); }
    // Fallback to wp-login.php
    return wp_login_url();
}

// Ensure a Login page exists and uses the custom template
function congresso_ensure_login_page(){
    if (get_option('congresso_login_page_created')) { return; }
    $page = get_page_by_path('login');
    if (!$page) {
        $page_id = wp_insert_post([
            'post_title' => 'Login',
            'post_name' => 'login',
            'post_status' => 'publish',
            'post_type' => 'page',
        ]);
        if (!is_wp_error($page_id)) {
            update_post_meta($page_id, '_wp_page_template', 'page-login.php');
            update_option('congresso_login_page_created', 1);
        }
    }
}
add_action('init', 'congresso_ensure_login_page');

// Update Primary Menu 'Login' item to point to the custom login page
function congresso_menu_login_link($atts, $item, $args){
    if (isset($args->theme_location) && $args->theme_location === 'primary') {
        $title = strtolower(trim($item->title));
        if (in_array($title, ['login','entrar'])) {
            $atts['href'] = esc_url(congresso_get_login_page_url());
        }
    }
    return $atts;
}
add_filter('nav_menu_link_attributes', 'congresso_menu_login_link', 10, 3);

// Fallback for primary menu: list pages if no menu assigned
function congresso_menu_fallback() {
    echo '<ul class="navbar-nav flex-column flex-xl-row">';
    wp_list_pages([
        'title_li' => '',
    ]);
    echo '</ul>';
}

// Helper and creator for Certificados page
function congresso_get_certificados_page_url(){
    $page = get_page_by_path('certificados');
    return $page ? get_permalink($page->ID) : home_url('/certificados/');
}

function congresso_ensure_certificados_page(){
    if (get_option('congresso_certificados_page_created')) { return; }
    $page = get_page_by_path('certificados');
    if (!$page) {
        $page_id = wp_insert_post([
            'post_title' => 'Certificados',
            'post_name' => 'certificados',
            'post_status' => 'publish',
            'post_type' => 'page',
        ]);
        if (!is_wp_error($page_id)) {
            // Assign the custom template to the page
            update_post_meta($page_id, '_wp_page_template', 'page-certificados.php');
            update_option('congresso_certificados_page_created', 1);
        }
    } else {
        // Ensure the existing page uses the correct template
        $current_tpl = get_post_meta($page->ID, '_wp_page_template', true);
        if ($current_tpl !== 'page-certificados.php') {
            update_post_meta($page->ID, '_wp_page_template', 'page-certificados.php');
        }
    }
}
add_action('init', 'congresso_ensure_certificados_page');

// After login, force redirect to Certificados
function congresso_login_redirect($redirect_to, $request, $user){
    if (is_wp_error($user) || !$user) { return $redirect_to; }
    return congresso_get_certificados_page_url();
}
add_filter('login_redirect', 'congresso_login_redirect', 10, 3);

// Force the certificados page to use our template, in case of cache or meta not applied
function congresso_force_certificados_template($template){
    // Ensure by slug or by template meta
    if (is_page('certificados')) {
        $custom = get_template_directory() . '/page-certificados.php';
        if (file_exists($custom)) {
            return $custom;
        }
    }
    // Fallback: if current page has our template meta, use it explicitly
    if (is_page()) {
        global $post;
        $tpl = get_post_meta($post->ID, '_wp_page_template', true);
        if ($tpl === 'page-certificados.php') {
            $custom = get_template_directory() . '/page-certificados.php';
            if (file_exists($custom)) {
                return $custom;
            }
        }
    }
    return $template;
}
add_filter('template_include', 'congresso_force_certificados_template', 99);
