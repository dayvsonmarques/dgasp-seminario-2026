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
<header class="site-header">
    <div class="container-fluid px-0">
        <div class="row align-items-center g-0">
            <div class="col-12 col-lg-4 d-flex align-items-center justify-content-between gap-3 ps-4 pe-4 py-3 py-lg-0">
                <div class="d-flex align-items-center gap-3">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/logo-header.png" alt="Logo Seminário" class="header-logo header-logo--main">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/logo-gov.br.png" alt="Logo Governo PE" class="header-logo header-logo--gov">
                </div>
                <button class="navbar-toggler d-lg-none" type="button" data-bs-toggle="collapse" data-bs-target="#mainMenu" aria-controls="mainMenu" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
            <div class="col-12 col-lg-8">
                <nav class="main-menu collapse navbar-collapse" id="mainMenu">
                    <div class="d-flex flex-column flex-lg-row justify-content-lg-end gap-2 pe-lg-4 pb-3 pb-lg-0">
                        <a href="#" class="menu-btn">INÍCIO</a>
                        <a href="#" class="menu-btn">SOBRE</a>
                        <a href="#" class="menu-btn">COMISSÕES</a>
                        <a href="#" class="menu-btn">EDITAL</a>
                        <a href="#" class="menu-btn">CONTATO</a>
                        <a href="#" class="menu-btn">LOGIN</a>
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
