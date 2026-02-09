<?php
$home_id = get_the_ID();
$part_subtitle = get_post_meta($home_id, '_home_participation_subtitle', true) ?: 'Inscreva-se e faça parte dessa jornada de saúde, integração e cuidado.';
$part_btn_text = get_post_meta($home_id, '_home_participation_btn_text', true) ?: 'CADASTRE-SE AQUI';
$part_btn_link = get_post_meta($home_id, '_home_participation_btn_link', true) ?: '#';
?>
<section class="section-participation bg-white">
    <div class="container text-center">
        <h2 class="section-title text-blue mb-1">
            <span class="bold">PARTICIPE</span>
            <span class="">DO</span>
            <span class="bold">SEMINÁRIO</span>
        </h2>
        <p class="text-dark-blue h4"><?php echo esc_html($part_subtitle); ?></p>
        <a href="<?php echo esc_url($part_btn_link); ?>" class="btn btn-primary btn-register"><?php echo esc_html($part_btn_text); ?></a>
    </div>
</section>