<?php
function congresso_custom_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('custom-logo');
    register_nav_menus([
        'primary' => __('Primary Menu', 'congresso-custom'),
    ]);
}
add_action('after_setup_theme', 'congresso_custom_setup');

function congresso_custom_enqueue_scripts() {
    wp_enqueue_style('bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css');
    wp_enqueue_style('congresso-custom-style', get_stylesheet_uri(), [], filemtime(get_template_directory() . '/style.css'));
    wp_enqueue_script('bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js', [], null, true);
}
add_action('wp_enqueue_scripts', 'congresso_custom_enqueue_scripts');

// Fix Firefox caching issues
function congresso_custom_headers() {
    if (!is_admin()) {
        header('Cache-Control: no-cache, no-store, must-revalidate');
        header('Pragma: no-cache');
        header('Expires: 0');
    }
}
add_action('send_headers', 'congresso_custom_headers');

add_filter('show_admin_bar', '__return_false');

function congresso_register_certificados_cpt() {
    $labels = [
        'name'               => __('Certificados', 'congresso-custom'),
        'singular_name'      => __('Certificado', 'congresso-custom'),
        'menu_name'          => __('Certificados', 'congresso-custom'),
        'name_admin_bar'     => __('Certificado', 'congresso-custom'),
        'add_new'            => __('Adicionar novo', 'congresso-custom'),
        'add_new_item'       => __('Adicionar novo Certificado', 'congresso-custom'),
        'new_item'           => __('Novo Certificado', 'congresso-custom'),
        'edit_item'          => __('Editar Certificado', 'congresso-custom'),
        'view_item'          => __('Ver Certificado', 'congresso-custom'),
        'all_items'          => __('Todos os Certificados', 'congresso-custom'),
        'search_items'       => __('Buscar Certificados', 'congresso-custom'),
        'not_found'          => __('Nenhum Certificado encontrado', 'congresso-custom'),
        'not_found_in_trash' => __('Nenhum Certificado na lixeira', 'congresso-custom'),
    ];

    $args = [
        'labels'             => $labels,
        'public'             => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'menu_position'      => 20,
        'menu_icon'          => 'dashicons-media-document',
        'show_in_rest'       => true,
        'supports'           => ['title'],
        'has_archive'        => 'certificados-registros',
        'rewrite'            => ['slug' => 'certificados-registros'],
        'map_meta_cap'       => true,
        'capability_type'    => 'post',
    ];

    register_post_type('certify', $args);
}
add_action('init', 'congresso_register_certificados_cpt');

function congresso_certify_flush_once(){
    if (!get_option('congresso_certify_rewrite_flushed')) {
        flush_rewrite_rules();
        update_option('congresso_certify_rewrite_flushed', 1);
    }
}
add_action('init', 'congresso_certify_flush_once', 15);

if (!defined('CERTIFY_META_USER')) define('CERTIFY_META_USER', 'certify_user_id');
if (!defined('CERTIFY_META_PDF'))  define('CERTIFY_META_PDF',  'certify_pdf_id');
if (!defined('CERTIFY_META_DATE')) define('CERTIFY_META_DATE', 'certify_issue_date');

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
        echo '<select name="' . esc_attr(CERTIFY_META_USER) . '" class="widefat">';
        echo '<option value="">— ' . esc_html__('Selecione', 'congresso-custom') . ' —</option>';
        foreach ($users as $u) {
                printf('<option value="%d" %s>%s</option>', (int) $u->ID, selected($selected, $u->ID, false), esc_html($u->display_name));
        }
        echo '</select>';
}

function congresso_certify_pdf_meta_box($post) {
        $attachment_id = (int) get_post_meta($post->ID, CERTIFY_META_PDF, true);
        $url = $attachment_id ? wp_get_attachment_url($attachment_id) : '';
        echo '<input type="hidden" id="certify_pdf_id" name="' . esc_attr(CERTIFY_META_PDF) . '" value="' . esc_attr($attachment_id) . '" />';
        echo '<div id="certify_pdf_preview">' . ($url ? '<a href="' . esc_url($url) . '" target="_blank">PDF atual</a>' : 'Nenhum PDF selecionado') . '</div>';
        echo '<p><button type="button" class="button" id="certify_pdf_select">' . esc_html__('Selecionar PDF', 'congresso-custom') . '</button> ';
        echo '<button type="button" class="button" id="certify_pdf_remove">' . esc_html__('Remover', 'congresso-custom') . '</button></p>';
        echo '<p class="description">' . esc_html__('Envie ou selecione um arquivo PDF.', 'congresso-custom') . '</p>';
        echo <<<JS
<script>
jQuery(function($){
    let frame;
    $('#certify_pdf_select').on('click', function(e){
        e.preventDefault();
        if(frame){ frame.open(); return; }
        frame = wp.media({ title: 'Selecionar PDF', button: { text: 'Usar este PDF' }, library: { type: 'application/pdf' }, multiple: false });
        frame.on('select', function(){
            const attachment = frame.state().get('selection').first().toJSON();
            $('#certify_pdf_id').val(attachment.id);
            $('#certify_pdf_preview').html('<a target="_blank" href="'+attachment.url+'">PDF atual</a>');
        });
        frame.open();
    });
    $('#certify_pdf_remove').on('click', function(){
        $('#certify_pdf_id').val('');
        $('#certify_pdf_preview').text('Nenhum PDF selecionado');
    });
});
</script>
JS;
}

function congresso_certify_date_meta_box($post) {
        $date = get_post_meta($post->ID, CERTIFY_META_DATE, true);
        echo '<input type="date" name="' . esc_attr(CERTIFY_META_DATE) . '" class="widefat" value="' . esc_attr($date) . '" />';
}

function congresso_certify_save_post($post_id) {
        if (!isset($_POST['certify_meta_nonce']) || !wp_verify_nonce($_POST['certify_meta_nonce'], 'certify_meta_save')) return;
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
        if (!current_user_can('edit_post', $post_id)) return;
        if (get_post_type($post_id) !== 'certify') return;

        $user_id = isset($_POST[CERTIFY_META_USER]) ? (int) $_POST[CERTIFY_META_USER] : 0;
        $pdf_id  = isset($_POST[CERTIFY_META_PDF])  ? (int) $_POST[CERTIFY_META_PDF]  : 0;
        $date    = isset($_POST[CERTIFY_META_DATE]) ? sanitize_text_field($_POST[CERTIFY_META_DATE]) : '';

        update_post_meta($post_id, CERTIFY_META_USER, $user_id);
        update_post_meta($post_id, CERTIFY_META_PDF,  $pdf_id);
        update_post_meta($post_id, CERTIFY_META_DATE, $date);
}
add_action('save_post', 'congresso_certify_save_post');

function congresso_certify_admin_scripts($hook) {
        global $post_type;
        if (($hook === 'post.php' || $hook === 'post-new.php') && $post_type === 'certify') {
                wp_enqueue_media();
        }
}
add_action('admin_enqueue_scripts', 'congresso_certify_admin_scripts');

function congresso_get_login_page_url(){
    return home_url('/gerenciamento/');
}

function congresso_get_certificados_page_url(){
    $page = get_page_by_path('certificados');
    return $page ? get_permalink($page->ID) : home_url('/certificados/');
}

function congresso_menu_login_link($atts, $item, $args){
    if (isset($args->theme_location) && $args->theme_location === 'primary') {
        $title = strtolower(trim($item->title));
        if (in_array($title, ['login','entrar'])) {
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

function congresso_login_redirect($redirect_to, $request, $user){
    if (is_wp_error($user) || !$user) { return $redirect_to; }

    if (user_can($user, 'administrator') || user_can($user, 'editor')) {
        return !empty($redirect_to) ? $redirect_to : admin_url();
    }
    return congresso_get_certificados_page_url();
}
add_filter('login_redirect', 'congresso_login_redirect', 10, 3);

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
        if (is_user_logged_in()) {
            $user = wp_get_current_user();
            if (user_can($user, 'administrator') || user_can($user, 'editor')) {
                wp_safe_redirect(admin_url());
            } else {
                wp_safe_redirect(congresso_get_certificados_page_url());
            }
            exit;
        }
        require_once ABSPATH . 'wp-login.php';
        exit;
    }
}
add_action('template_redirect', 'congresso_handle_gerenciamento_route');

function congresso_filter_login_url($login_url, $redirect, $force_reauth){
    return home_url('/gerenciamento/');
}
add_filter('login_url', 'congresso_filter_login_url', 10, 3);

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

function congresso_menu_contact_scroll($atts, $item, $args){
    if (isset($args->theme_location) && $args->theme_location === 'primary') {
        $title = strtolower(trim($item->title));
        if (in_array($title, ['contato','contact'])) {
            $atts['href'] = '#footer';
            $atts['class'] = isset($atts['class']) ? $atts['class'] . ' js-scroll' : 'js-scroll';
        }
    }
    return $atts;
}
add_filter('nav_menu_link_attributes', 'congresso_menu_contact_scroll', 10, 3);

function congresso_flush_rewrite_for_gerenciamento_once(){
    if (!get_option('congresso_gerenciamento_rewrite_flushed')) {
        flush_rewrite_rules();
        update_option('congresso_gerenciamento_rewrite_flushed', 1);
    }
}
add_action('init', 'congresso_flush_rewrite_for_gerenciamento_once', 20);

function congresso_block_admin_access_for_public(){
    if (is_admin()) {
        if (defined('DOING_AJAX') && DOING_AJAX) { return; }
        if (!current_user_can('administrator') && !current_user_can('editor')) {
            wp_safe_redirect(home_url('/'));
            exit;
        }
    }
}
add_action('admin_init', 'congresso_block_admin_access_for_public');

function congresso_block_wp_login_for_logged_in(){
    $action = isset($_REQUEST['action']) ? strtolower(sanitize_text_field($_REQUEST['action'])) : '';
    if ($action === 'logout') {
        return;
    }
    if (is_user_logged_in()) {
        $user = wp_get_current_user();
        if (!user_can($user, 'administrator') && !user_can($user, 'editor')) {
            wp_safe_redirect(home_url('/'));
            exit;
        }
    }
}
add_action('login_init', 'congresso_block_wp_login_for_logged_in');
