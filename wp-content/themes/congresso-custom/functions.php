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

function congresso_register_eixos_tematicos_cpt() {
    $labels = [
        'name'               => __('Eixos Temáticos', 'congresso-custom'),
        'singular_name'      => __('Eixo Temático', 'congresso-custom'),
        'menu_name'          => __('Eixos Temáticos', 'congresso-custom'),
        'name_admin_bar'     => __('Eixo Temático', 'congresso-custom'),
        'add_new'            => __('Adicionar novo', 'congresso-custom'),
        'add_new_item'       => __('Adicionar novo Eixo Temático', 'congresso-custom'),
        'new_item'           => __('Novo Eixo Temático', 'congresso-custom'),
        'edit_item'          => __('Editar Eixo Temático', 'congresso-custom'),
        'view_item'          => __('Ver Eixo Temático', 'congresso-custom'),
        'all_items'          => __('Todos os Eixos', 'congresso-custom'),
        'search_items'       => __('Buscar Eixos', 'congresso-custom'),
        'not_found'          => __('Nenhum Eixo encontrado', 'congresso-custom'),
        'not_found_in_trash' => __('Nenhum Eixo na lixeira', 'congresso-custom'),
    ];

    $args = [
        'labels'             => $labels,
        'public'             => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'menu_position'      => 21,
        'menu_icon'          => 'dashicons-editor-ul',
        'show_in_rest'       => true,
        'supports'           => ['title', 'editor', 'page-attributes'],
        'has_archive'        => false,
        'publicly_queryable' => false,
        'capability_type'    => 'post',
        'hierarchical'       => false,
    ];

    register_post_type('eixo_tematico', $args);
}
add_action('init', 'congresso_register_eixos_tematicos_cpt');

function congresso_certify_flush_once(){
    if (!get_option('congresso_certify_rewrite_flushed')) {
        flush_rewrite_rules();
        update_option('congresso_certify_rewrite_flushed', 1);
    }
}
add_action('init', 'congresso_certify_flush_once', 15);

function congresso_eixos_flush_once(){
    if (!get_option('congresso_eixos_rewrite_flushed')) {
        flush_rewrite_rules();
        update_option('congresso_eixos_rewrite_flushed', 1);
    }
}
add_action('init', 'congresso_eixos_flush_once', 15);

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
    if (is_wp_error($user) || !$user) { 
        return $redirect_to; 
    }

    // Verifica se o usuário é Admin ou Editor
    $is_admin_or_editor = user_can($user, 'administrator') || user_can($user, 'editor');
    
    if ($is_admin_or_editor) {
        // Admin/Editor sempre vai para o painel administrativo
        return admin_url();
    }
    
    // Todos os outros usuários vão para a página de Certificados
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

/**
 * Meta Boxes: Campos da Página Inicial (Home)
 */
function congresso_home_add_meta_boxes() {
    $home_page = get_page_by_path('inicio');
    if (!$home_page) {
        $home_page = get_page_by_path('home');
    }
    $screen_id = 'page';

    add_meta_box(
        'congresso_home_banner',
        __('Banner Principal', 'congresso-custom'),
        'congresso_home_banner_meta_box',
        $screen_id,
        'normal',
        'high'
    );
    add_meta_box(
        'congresso_home_about',
        __('Sobre o Evento — Blocos de Texto', 'congresso-custom'),
        'congresso_home_about_meta_box',
        $screen_id,
        'normal',
        'high'
    );
    add_meta_box(
        'congresso_home_schedule',
        __('Programação e Apresentações', 'congresso-custom'),
        'congresso_home_schedule_meta_box',
        $screen_id,
        'normal',
        'default'
    );
    add_meta_box(
        'congresso_home_participation',
        __('Participe do Seminário', 'congresso-custom'),
        'congresso_home_participation_meta_box',
        $screen_id,
        'normal',
        'default'
    );
}
add_action('add_meta_boxes', 'congresso_home_add_meta_boxes');

/** Exibir meta boxes somente na página Home */
function congresso_home_is_home_page() {
    global $post;
    if (!$post) return false;
    $template = get_post_meta($post->ID, '_wp_page_template', true);
    return $template === 'page-home.php';
}

/** Banner Meta Box */
function congresso_home_banner_meta_box($post) {
    if (!congresso_home_is_home_page()) {
        echo '<p><em>' . __('Estes campos são exclusivos para a página Home.', 'congresso-custom') . '</em></p>';
        return;
    }
    wp_nonce_field('congresso_home_meta_save', 'congresso_home_meta_nonce');
    $banner_id = (int) get_post_meta($post->ID, '_home_banner_image', true);
    $banner_url = $banner_id ? wp_get_attachment_image_url($banner_id, 'large') : '';
    $banner_mobile_id = (int) get_post_meta($post->ID, '_home_banner_image_mobile', true);
    $banner_mobile_url = $banner_mobile_id ? wp_get_attachment_image_url($banner_mobile_id, 'medium') : '';
    ?>
    <table class="form-table">
        <tr>
            <th><label><?php _e('Imagem do Banner (Desktop)', 'congresso-custom'); ?></label></th>
            <td>
                <input type="hidden" id="home_banner_image" name="_home_banner_image" value="<?php echo esc_attr($banner_id); ?>" />
                <div id="home_banner_preview"><?php if ($banner_url): ?><img src="<?php echo esc_url($banner_url); ?>" style="max-width:400px;height:auto;"><?php else: ?>Nenhuma imagem selecionada<?php endif; ?></div>
                <p><button type="button" class="button" id="home_banner_select"><?php _e('Selecionar Imagem', 'congresso-custom'); ?></button>
                <button type="button" class="button" id="home_banner_remove"><?php _e('Remover', 'congresso-custom'); ?></button></p>
            </td>
        </tr>
        <tr>
            <th><label><?php _e('Imagem do Banner (Mobile)', 'congresso-custom'); ?></label></th>
            <td>
                <input type="hidden" id="home_banner_image_mobile" name="_home_banner_image_mobile" value="<?php echo esc_attr($banner_mobile_id); ?>" />
                <div id="home_banner_mobile_preview"><?php if ($banner_mobile_url): ?><img src="<?php echo esc_url($banner_mobile_url); ?>" style="max-width:300px;height:auto;"><?php else: ?>Nenhuma imagem selecionada<?php endif; ?></div>
                <p><button type="button" class="button" id="home_banner_mobile_select"><?php _e('Selecionar Imagem Mobile', 'congresso-custom'); ?></button>
                <button type="button" class="button" id="home_banner_mobile_remove"><?php _e('Remover', 'congresso-custom'); ?></button></p>
            </td>
        </tr>
    </table>
    <?php
}

/** About / Blocos Meta Box */
function congresso_home_about_meta_box($post) {
    if (!congresso_home_is_home_page()) {
        echo '<p><em>' . __('Estes campos são exclusivos para a página Home.', 'congresso-custom') . '</em></p>';
        return;
    }
    $fields = [
        1 => [
            'title'       => get_post_meta($post->ID, '_home_block1_title', true),
            'summary'     => get_post_meta($post->ID, '_home_block1_summary', true),
            'btn_text'    => get_post_meta($post->ID, '_home_block1_btn_text', true),
            'btn_link'    => get_post_meta($post->ID, '_home_block1_btn_link', true),
        ],
        2 => [
            'title'       => get_post_meta($post->ID, '_home_block2_title', true),
            'summary'     => get_post_meta($post->ID, '_home_block2_summary', true),
            'btn_text'    => get_post_meta($post->ID, '_home_block2_btn_text', true),
            'btn_link'    => get_post_meta($post->ID, '_home_block2_btn_link', true),
        ],
    ];
    ?>
    <table class="form-table">
    <?php foreach ($fields as $num => $f): ?>
        <tr><td colspan="2"><h3><?php printf(__('Bloco de Texto %d', 'congresso-custom'), $num); ?></h3></td></tr>
        <tr>
            <th><label><?php _e('Título', 'congresso-custom'); ?></label></th>
            <td><input type="text" name="_home_block<?php echo $num; ?>_title" class="widefat" value="<?php echo esc_attr($f['title']); ?>" /></td>
        </tr>
        <tr>
            <th><label><?php _e('Resumo', 'congresso-custom'); ?></label></th>
            <td><textarea name="_home_block<?php echo $num; ?>_summary" class="widefat" rows="4"><?php echo esc_textarea($f['summary']); ?></textarea></td>
        </tr>
        <tr>
            <th><label><?php _e('Texto do Botão', 'congresso-custom'); ?></label></th>
            <td><input type="text" name="_home_block<?php echo $num; ?>_btn_text" class="widefat" value="<?php echo esc_attr($f['btn_text']); ?>" /></td>
        </tr>
        <tr>
            <th><label><?php _e('Link do Botão', 'congresso-custom'); ?></label></th>
            <td><input type="url" name="_home_block<?php echo $num; ?>_btn_link" class="widefat" value="<?php echo esc_attr($f['btn_link']); ?>" /></td>
        </tr>
    <?php endforeach; ?>
    </table>
    <?php
}

/** Schedule Meta Box */
function congresso_home_schedule_meta_box($post) {
    if (!congresso_home_is_home_page()) {
        echo '<p><em>' . __('Estes campos são exclusivos para a página Home.', 'congresso-custom') . '</em></p>';
        return;
    }
    $link1 = get_post_meta($post->ID, '_home_schedule_link1', true);
    $link2 = get_post_meta($post->ID, '_home_schedule_link2', true);
    ?>
    <table class="form-table">
        <tr>
            <th><label><?php _e('Link — Programação Completa', 'congresso-custom'); ?></label></th>
            <td><input type="url" name="_home_schedule_link1" class="widefat" value="<?php echo esc_attr($link1); ?>" /></td>
        </tr>
        <tr>
            <th><label><?php _e('Link — Apresentações Orais', 'congresso-custom'); ?></label></th>
            <td><input type="url" name="_home_schedule_link2" class="widefat" value="<?php echo esc_attr($link2); ?>" /></td>
        </tr>
    </table>
    <?php
}

/** Participation Meta Box */
function congresso_home_participation_meta_box($post) {
    if (!congresso_home_is_home_page()) {
        echo '<p><em>' . __('Estes campos são exclusivos para a página Home.', 'congresso-custom') . '</em></p>';
        return;
    }
    $subtitle = get_post_meta($post->ID, '_home_participation_subtitle', true);
    $btn_text = get_post_meta($post->ID, '_home_participation_btn_text', true);
    $btn_link = get_post_meta($post->ID, '_home_participation_btn_link', true);
    ?>
    <table class="form-table">
        <tr>
            <th><label><?php _e('Subtítulo', 'congresso-custom'); ?></label></th>
            <td><input type="text" name="_home_participation_subtitle" class="widefat" value="<?php echo esc_attr($subtitle); ?>" /></td>
        </tr>
        <tr>
            <th><label><?php _e('Texto do Botão', 'congresso-custom'); ?></label></th>
            <td><input type="text" name="_home_participation_btn_text" class="widefat" value="<?php echo esc_attr($btn_text); ?>" /></td>
        </tr>
        <tr>
            <th><label><?php _e('Link do Cadastro', 'congresso-custom'); ?></label></th>
            <td><input type="url" name="_home_participation_btn_link" class="widefat" value="<?php echo esc_attr($btn_link); ?>" /></td>
        </tr>
    </table>
    <?php
}

/** Save Home Meta Fields */
function congresso_home_save_meta($post_id) {
    if (!isset($_POST['congresso_home_meta_nonce']) || !wp_verify_nonce($_POST['congresso_home_meta_nonce'], 'congresso_home_meta_save')) return;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $post_id)) return;

    $template = get_post_meta($post_id, '_wp_page_template', true);
    if ($template !== 'page-home.php') return;

    // Banner
    $banner_fields = ['_home_banner_image', '_home_banner_image_mobile'];
    foreach ($banner_fields as $key) {
        if (isset($_POST[$key])) {
            update_post_meta($post_id, $key, (int) $_POST[$key]);
        }
    }

    // Blocks 1 & 2
    foreach ([1, 2] as $num) {
        $text_keys = ["_home_block{$num}_title", "_home_block{$num}_summary", "_home_block{$num}_btn_text"];
        foreach ($text_keys as $key) {
            if (isset($_POST[$key])) {
                update_post_meta($post_id, $key, sanitize_text_field($_POST[$key]));
            }
        }
        $url_key = "_home_block{$num}_btn_link";
        if (isset($_POST[$url_key])) {
            update_post_meta($post_id, $url_key, esc_url_raw($_POST[$url_key]));
        }
    }

    // Schedule
    foreach (['_home_schedule_link1', '_home_schedule_link2'] as $key) {
        if (isset($_POST[$key])) {
            update_post_meta($post_id, $key, esc_url_raw($_POST[$key]));
        }
    }

    // Participation
    $part_text = ['_home_participation_subtitle', '_home_participation_btn_text'];
    foreach ($part_text as $key) {
        if (isset($_POST[$key])) {
            update_post_meta($post_id, $key, sanitize_text_field($_POST[$key]));
        }
    }
    if (isset($_POST['_home_participation_btn_link'])) {
        update_post_meta($post_id, '_home_participation_btn_link', esc_url_raw($_POST['_home_participation_btn_link']));
    }
}
add_action('save_post', 'congresso_home_save_meta');

/** Enqueue media for Home page editor */
function congresso_home_admin_scripts($hook) {
    global $post;
    if (!$post || ($hook !== 'post.php' && $hook !== 'post-new.php')) return;
    $template = get_post_meta($post->ID, '_wp_page_template', true);
    if ($template !== 'page-home.php') return;

    wp_enqueue_media();
    wp_add_inline_script('jquery-core', "
        jQuery(function($){
            function setupMediaPicker(btnSelect, btnRemove, inputId, previewId, isImage) {
                var frame;
                $(btnSelect).on('click', function(e){
                    e.preventDefault();
                    if(frame){ frame.open(); return; }
                    frame = wp.media({ title: 'Selecionar Imagem', button: { text: 'Usar esta imagem' }, library: { type: 'image' }, multiple: false });
                    frame.on('select', function(){
                        var att = frame.state().get('selection').first().toJSON();
                        $(inputId).val(att.id);
                        $(previewId).html('<img src=\"'+att.url+'\" style=\"max-width:400px;height:auto;\">');
                    });
                    frame.open();
                });
                $(btnRemove).on('click', function(){
                    $(inputId).val('');
                    $(previewId).text('Nenhuma imagem selecionada');
                });
            }
            setupMediaPicker('#home_banner_select','#home_banner_remove','#home_banner_image','#home_banner_preview',true);
            setupMediaPicker('#home_banner_mobile_select','#home_banner_mobile_remove','#home_banner_image_mobile','#home_banner_mobile_preview',true);
        });
    ");
}
add_action('admin_enqueue_scripts', 'congresso_home_admin_scripts');

/**
 * Customizer: Informações de Contato do Footer
 */
function congresso_customizer_footer_contact($wp_customize) {
    // Seção
    $wp_customize->add_section('congresso_footer_contact', [
        'title'    => __('Contato do Footer', 'congresso-custom'),
        'priority' => 160,
    ]);

    // Campo: E-mail
    $wp_customize->add_setting('congresso_footer_email', [
        'default'           => 'loremipsum@gmail.com',
        'sanitize_callback' => 'sanitize_email',
        'transport'         => 'refresh',
    ]);
    $wp_customize->add_control('congresso_footer_email', [
        'label'   => __('E-mail de contato', 'congresso-custom'),
        'section' => 'congresso_footer_contact',
        'type'    => 'email',
    ]);

    // Campo: Telefone
    $wp_customize->add_setting('congresso_footer_phone', [
        'default'           => '(81) xxxxx - xxxx',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ]);
    $wp_customize->add_control('congresso_footer_phone', [
        'label'   => __('Telefone de contato', 'congresso-custom'),
        'section' => 'congresso_footer_contact',
        'type'    => 'text',
    ]);
}
add_action('customize_register', 'congresso_customizer_footer_contact');
