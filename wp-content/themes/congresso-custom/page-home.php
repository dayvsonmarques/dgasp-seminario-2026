<?php /* Template Name: Home */
get_header(); ?>

<main class="home">
    <section class="banner-home position-relative overflow-hidden">
        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/homepage/banner.jpg" alt="Banner Hero Seminário" class="img-fluid banner-img">
        <div class="banner__container position-absolute top-0 start-0 w-100 h-100 d-flex">
            <div class="banner__col banner__col--image"></div>
            <div class="banner__col banner__col--text d-flex flex-column justify-content-center align-items-start">
                <h1 class="banner__title">
                    III SEMINÁRIO ESTADUAL<br>
                    DE ATENÇÃO À SAÚDE<br>
                    PRISIONAL DE PERNAMBUCO
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
    <section class="sobre-evento py-5 bg-blue">
        <div class="container">
            <div class="row mb-4">
                <div class="col-lg-3 d-flex align-items-center">
                    <h2 class="section-title text-white">SOBRE O EVENTO</h2>
                </div>
                <div class="col-lg-9">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/homepage/about-bg.jpg" alt="Sobre o Evento" class="img-fluid about-img mb-4">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="card evento-card h-100">
                                <h3 class="card-title">III SEMINÁRIO ESTADUAL DE ATENÇÃO À SAÚDE PRISIONAL DE PERNAMBUCO</h3>
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.</p>
                                <a href="#" class="btn btn-primary btn-saiba">SAIBA MAIS</a>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card evento-card h-100">
                                <h3 class="card-title">III MOSTRA ESTADUAL DE EXPERIÊNCIAS NA SAÚDE PRISIONAL</h3>
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.</p>
                                <a href="#" class="btn btn-primary btn-saiba">EIXOS TEMÁTICOS</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="programacao py-5 bg-dark-blue">
        <div class="container">
            <div class="row mb-4">
                <div class="col-lg-3 d-flex align-items-center">
                    <h2 class="section-title text-white">PROGRAMAÇÃO<br>E APRESENTAÇÕES</h2>
                </div>
                <div class="col-lg-9">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/homepage/schedule.jpg" alt="Programação e Apresentações" class="img-fluid schedule-img mb-4">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="card evento-card h-100">
                                <h3 class="card-title">PROGRAMAÇÃO COMPLETA</h3>
                                <a href="#" class="btn btn-primary btn-saiba">SAIBA MAIS</a>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card evento-card h-100">
                                <h3 class="card-title">APRESENTAÇÕES ORAIS</h3>
                                <a href="#" class="btn btn-primary btn-saiba">SAIBA MAIS</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="participacao py-5 bg-white">
        <div class="container text-center">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/homepage/footer.jpg" alt="Participe do Seminário" class="img-fluid footer-img mb-4">
            <h2 class="section-title text-blue">PARTICIPE DO SEMINÁRIO</h2>
            <p class="text-dark-blue">Inscreva-se e venha fazer parte dessa jornada de saúde, integração e cuidado.</p>
            <a href="#" class="btn btn-primary btn-cadastro">CADASTRE-SE AQUI</a>
        </div>
    </section>
</main>
<?php get_footer(); ?>
