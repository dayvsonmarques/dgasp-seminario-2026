<?php
$speakers = new WP_Query([
    'post_type'      => 'palestrante',
    'posts_per_page' => -1,
    'orderby'        => 'menu_order',
    'order'          => 'ASC',
    'post_status'    => 'publish',
]);
$has_speakers = $speakers->have_posts();
?>

<section class="section-speakers" id="palestrantes">
  <div id="speakersCarousel" class="carousel slide carousel-fade" data-bs-ride="false">
    <div class="carousel-inner">

      <div class="carousel-item carousel-item--banner active">
        <div class="speaker-slide speaker-slide--banner">
          <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/palestrantes-banner.png' ); ?>"
               alt="Palestrantes" class="speaker-slide__banner-img">
        </div>
      </div>

      <?php if ( $has_speakers ) : $speaker_index = 0; while ( $speakers->have_posts() ) : $speakers->the_post();
        $speaker_index++;
        $prefix    = get_post_meta( get_the_ID(), '_speaker_prefix', true );
        $bg_class  = ( $speaker_index % 2 !== 0 ) ? 'speaker-slide--odd' : 'speaker-slide--even';
        $thumb_id  = get_post_thumbnail_id();
        $thumb_url = $thumb_id ? wp_get_attachment_image_url( $thumb_id, 'large' ) : '';
      ?>
      <div class="carousel-item">
        <div class="speaker-slide <?php echo $bg_class; ?>">

          <div class="speaker-slide__inner container-fluid h-100">
            <div class="row h-100 align-items-center justify-content-center">

              <?php if ( $thumb_url ) : ?>
              <div class="col-12 col-lg-5 d-flex justify-content-center pe-md-5">
                <div class="speaker-slide__photo">
                  <img src="<?php echo esc_url( $thumb_url ); ?>" alt="<?php the_title_attribute(); ?>">
                </div>
              </div>
              <?php endif; ?>

              <div class="col-12 col-lg-6 ps-md-4">
                <h2 class="speaker-slide__name">
                  <?php if ( $prefix ) : ?>
                    <span class="speaker-slide__prefix"><?php echo esc_html( $prefix ); ?> </span>
                  <?php endif; ?>
                  <?php the_title(); ?>
                </h2>
                <div class="speaker-slide__bio">
                  <?php the_content(); ?>
                </div>
              </div>

            </div>
          </div>

        </div>
      </div>
      <?php endwhile; wp_reset_postdata(); endif; ?>

    </div>

    <!-- Controles -->
    <button class="carousel-control-prev" type="button" data-bs-target="#speakersCarousel" data-bs-slide="prev">
      <span class="carousel-control-prev-icon"></span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#speakersCarousel" data-bs-slide="next">
      <span class="carousel-control-next-icon"></span>
    </button>

    <!-- Indicadores -->
    <div class="carousel-indicators speakers-indicators">
      <?php
        $total = 1 + ( $has_speakers ? $speakers->found_posts : 0 );
        for ( $i = 0; $i < $total; $i++ ) :
      ?>
        <button type="button" data-bs-target="#speakersCarousel"
                data-bs-slide-to="<?php echo $i; ?>"
                <?php echo $i === 0 ? 'class="active" aria-current="true"' : ''; ?>
                aria-label="Slide <?php echo $i + 1; ?>">
        </button>
      <?php endfor; ?>
    </div>

  </div>
</section>
