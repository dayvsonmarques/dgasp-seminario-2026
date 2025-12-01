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
<header class="site-header" style="background:#fff;border-bottom:6px solid #5497e8;">
    <div class="container-fluid px-0">
        <div class="row align-items-center g-0" style="min-height:90px;">
            <div class="col-lg-4 d-flex align-items-center gap-3 ps-4">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/logo-header.png" alt="Logo Seminário" class="header-logo header-logo--main">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/logo-gov.br.png" alt="Logo Governo PE" class="header-logo header-logo--gov">
            </div>
            <div class="col-lg-8">
                <nav class="main-menu d-flex justify-content-end gap-2 pe-4" style="font-size:1.1rem;">
                    <a href="#" class="menu-btn" style="background:#0068ff;color:#fff;padding:0.6rem 1.4rem;border-radius:4px;font-weight:600;text-decoration:none;">INÍCIO</a>
                    <a href="#" class="menu-btn" style="background:#0068ff;color:#fff;padding:0.6rem 1.4rem;border-radius:4px;font-weight:600;text-decoration:none;">SOBRE</a>
                    <a href="#" class="menu-btn" style="background:#0068ff;color:#fff;padding:0.6rem 1.4rem;border-radius:4px;font-weight:600;text-decoration:none;">COMISSÕES</a>
                    <a href="#" class="menu-btn" style="background:#0068ff;color:#fff;padding:0.6rem 1.4rem;border-radius:4px;font-weight:600;text-decoration:none;">EDITAL</a>
                    <a href="#" class="menu-btn" style="background:#0068ff;color:#fff;padding:0.6rem 1.4rem;border-radius:4px;font-weight:600;text-decoration:none;">CONTATO</a>
                    <a href="#" class="menu-btn" style="background:#0068ff;color:#fff;padding:0.6rem 1.4rem;border-radius:4px;font-weight:600;text-decoration:none;">LOGIN</a>
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
