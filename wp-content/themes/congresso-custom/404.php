<?php
/**
 * Template: 404 — Página não encontrada
 */
get_header();
?>

<section class="section-404 d-flex align-items-center justify-content-center text-center py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-6">
                <p class="error-404__code color-dark-blue ff-heading" style="font-size:10em;line-height:1;margin:0;">404</p>
                <p class="error-404__message mt-3 mb-4">
                    Parece que a página que tentou acessar não foi encontrada.
                </p>
                <a href="<?php echo esc_url(home_url('/')); ?>" class="btn btn-primary px-4 py-2">
                    Seguir para página inicial
                </a>
            </div>
        </div>
    </div>
</section>

<?php get_footer(); ?>
