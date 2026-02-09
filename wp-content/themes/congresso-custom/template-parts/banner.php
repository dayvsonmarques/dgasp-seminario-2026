<?php
$home_id = get_the_ID();
$banner_id = (int) get_post_meta($home_id, '_home_banner_image', true);
$banner_mobile_id = (int) get_post_meta($home_id, '_home_banner_image_mobile', true);
$banner_url = $banner_id ? wp_get_attachment_image_url($banner_id, 'full') : get_template_directory_uri() . '/assets/img/banner.jpg';
$banner_mobile_url = $banner_mobile_id ? wp_get_attachment_image_url($banner_mobile_id, 'large') : get_template_directory_uri() . '/assets/img/banner-mobile.jpg';
?>
<section class="banner-home position-relative overflow-hidden">
    <picture>
        <source srcset="<?php echo esc_url($banner_mobile_url); ?>" media="(max-width: 991.98px)">
        <img src="<?php echo esc_url($banner_url); ?>" alt="Banner Hero Seminário" class="img-fluid banner-img">
    </picture>
    <div class="banner__container position-absolute top-0 start-0 w-100 h-100 d-flex">
        <div class="banner__col banner__col--image"></div>
        <div class="banner__col banner__col--text d-flex flex-column justify-content-center align-items-start d-none">
            <h1 class="banner__title">
                <span class="bold">III SEMINÁRIO</span> ESTADUAL<br>
                DE <span class="bold">ATENÇÃO</span> À <span class="bold">SAÚDE</span><br>
                <span class="bold">PRISIONAL</span> DE <span class="bold">PERNAMBUCO</span>
            </h1>
            <p class="banner__subtitle">
                <strong>10 ANOS</strong> DA <strong>PNAISP</strong> EM PERNAMBUCO:<br>MEMÓRIA, CUIDADO E COMPROMISSO
            </p>
            <span class="banner__date">
                <span class="bold">27</span>, <span class="bold">28</span> E <span class="bold">29</span> DE <span class="bold">JANEIRO</span> DE 2026
            </span>
        </div>
    </div>
</section>
