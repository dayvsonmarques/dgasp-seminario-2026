<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

<div class="header-bar header-bar--top w-100">
    <span></span>
    <span></span>
    <span></span>
</div>
<header class="site-header py-5">
    <div class="container-fluid px-0">
        <div class="row align-items-center g-0">
            <div class="col-12 col-xl-4 d-flex align-items-center justify-content-between gap-3 ps-4 pe-4 py-3 py-xl-0">
                <div class="d-flex align-items-center gap-3">
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="text-decoration-none">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/logo-header.png" alt="Logo Seminário" class="header-logo header-logo--main">
                    </a>
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/logo-gov.br.png" alt="Logo Governo PE" class="header-logo header-logo--gov">
                </div>
                <button class="navbar-toggler d-xl-none" type="button" aria-controls="mainMenu" aria-expanded="false" aria-label="Toggle navigation" id="menuToggle">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
            <div class="col-12 col-xl-8">
                <nav class="main-menu collapse d-none" id="mainMenu">
                    <div class="d-flex flex-column flex-xl-row justify-content-xl-end gap-2 pe-xl-4 pb-3 pb-xl-0">
                        <?php
                        wp_nav_menu([
                            'theme_location' => 'primary',
                            'container'      => false,
                            'menu_class'     => 'navbar-nav flex-column flex-xl-row',
                            'fallback_cb'    => 'congresso_menu_fallback',
                            'add_li_class'   => 'nav-item',
                            'link_before'    => '<span class="menu-btn">',
                            'link_after'     => '</span>',
                        ]);
                        ?>
                    </div>
                </nav>
            </div>
        </div>
    </div>
</header>
<div class="header-bar header-bar--bottom w-100">
    <span></span>
    <span></span>
    <span></span>
</div>

<script src="<?php echo get_template_directory_uri(); ?>/assets/js/header-menu.js" defer></script>
