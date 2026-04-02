<?php
$sobre = get_page_by_path( 'sobre' );
if ( ! $sobre ) return;

$thumbnail_id = get_post_thumbnail_id( $sobre->ID );
?>

<?php if ( $thumbnail_id ) : ?>
<div class="sobre-hero">
  <?php echo wp_get_attachment_image( $thumbnail_id, 'full', false, [
    'class' => 'sobre-hero-img',
    'alt'   => esc_attr( get_the_title( $sobre->ID ) ),
  ] ); ?>
</div>
<?php endif; ?>

<section class="section-welcome">
  <div class="container">

    <h2 class="section-title color-blue mb-4">BOAS VINDAS</h2>

    <div class="row">
      <div class="col-12">
        <div class="welcome-content">
          <?php echo apply_filters( 'the_content', $sobre->post_content ); ?>
        </div>
      </div>
    </div>

    <div class="row mt-4 pt-4">
      <div class="col-12">
        <h3 class="section-title color-blue mb-4">AQUI, VOCÊ ENCONTRARÁ:</h3>
        <ul class="ps-4 mb-5 fs-4">
          <li class="mb-2">Programação atualizada</li>
          <li class="mb-2">Informações para submissão de trabalhos e divulgação dos aprovados</li>
          <li class="mb-2">Informações gerais sobre o evento</li>
          <li class="mb-2">Fale conosco e muito mais!</li>
        </ul>
      </div>
      <div class="col-12">
        <p class="fw-bold fs-4 color-dark-blue mb-1">Jonatan Barros</p>
        <p class="fst-italic text-secondary mb-0 fs-4">
          Diretor da DGASP /
          Presidente da Comissão Organizadora
        </p>
      </div>
    </div>

  </div>
</section>
