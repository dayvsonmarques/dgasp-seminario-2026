<?php
/*
Template Name: Página de Certificados
*/
if (!is_user_logged_in()) {
  wp_safe_redirect(home_url('/login/'));
  exit;
}

get_header();
?>

<section class="section-certificados py-5">
  <div class="container">
    <?php  ?>
      <div class="row">
        <div class="col-12">
          <h1 class="mb-4 text-center">Certificados</h1>
        </div>
      </div>
      <?php
        $current_user = wp_get_current_user();
        $meta_user = defined('CERTIFY_META_USER') ? CERTIFY_META_USER : 'certify_user_id';
        $meta_pdf  = defined('CERTIFY_META_PDF') ? CERTIFY_META_PDF  : 'certify_pdf_id';
        $meta_date = defined('CERTIFY_META_DATE') ? CERTIFY_META_DATE : 'certify_issue_date';

        $query = new WP_Query([
          'post_type'      => 'certify',
          'post_status'    => 'publish',
          'posts_per_page' => -1,
          'no_found_rows'  => true,
          'meta_query'     => [
            'relation' => 'OR',
            [
              'key'     => $meta_user, // expected key: certify_user_id
              'value'   => (int) $current_user->ID,
              'compare' => '=',
              'type'    => 'NUMERIC',
            ],
            [
              'key'     => 'certify_user', // fallback if some posts used a different key
              'value'   => (int) $current_user->ID,
              'compare' => '=',
              'type'    => 'NUMERIC',
            ],
          ],
        ]);
      ?>

      <?php if ($query->have_posts()): ?>
        <div class="row g-4 justify-content-center">
          <?php while ($query->have_posts()): $query->the_post();
            $pdf_id = (int) get_post_meta(get_the_ID(), $meta_pdf, true);
            $pdf_url = $pdf_id ? wp_get_attachment_url($pdf_id) : '';
            $issue_date = get_post_meta(get_the_ID(), $meta_date, true);
          ?>
            <div class="col-md-6 col-lg-5">
              <div class="card h-100 p-4">
                <h3 class="card-title"><?php the_title(); ?></h3>
                <?php if ($issue_date): ?>
                  <p class="mb-2"><strong>Data de emissão:</strong> <?php echo esc_html($issue_date); ?></p>
                <?php endif; ?>
                <?php if ($pdf_url): ?>
                  <a class="btn btn-primary" href="<?php echo esc_url($pdf_url); ?>" target="_blank" rel="noopener">Baixar PDF</a>
                <?php else: ?>
                  <p class="text-muted">PDF não disponível.</p>
                <?php endif; ?>
              </div>
            </div>
          <?php endwhile; wp_reset_postdata(); ?>
        </div>
      <?php else: ?>
        <div class="row justify-content-center">
          <div class="col-md-8">
            <div class="alert alert-info text-center">
              Nenhum certificado encontrado para sua conta.
            </div>
          </div>
        </div>
      <?php endif; ?>
  </div>
</section>

<?php
get_footer();
