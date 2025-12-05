<?php
/*
Template Name: Página de Login
*/

// Redirect early before any output if user is logged in
if (is_user_logged_in()) {
  if (function_exists('congresso_get_certificados_page_url')) {
    wp_safe_redirect(congresso_get_certificados_page_url());
  } else {
    wp_safe_redirect(home_url('/certificados/'));
  }
  exit;
}

get_header();
?>

<section class="section-login py-5">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-6 col-lg-5">
        <h1 class="text-center mb-4">Entrar</h1>
        <?php
          if (!is_user_logged_in()) {
            $redirect_url = home_url('/certificados/');
            $args = [
              'echo' => true,
              'redirect' => $redirect_url,
              'form_id' => 'congresso-loginform',
              'label_username' => __('Usuário ou e-mail'),
              'label_password' => __('Senha'),
              'label_remember' => __('Manter conectado'),
              'label_log_in' => __('Entrar'),
              'remember' => true,
            ];
            wp_login_form($args);
            echo '<p class="mt-3 text-center"><a href="' . esc_url(wp_lostpassword_url()) . '">Esqueceu a senha?</a></p>';
          }
        ?>
      </div>
    </div>
  </div>
</section>

<?php
get_footer();
