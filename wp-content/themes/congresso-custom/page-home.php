<?php /* Template Name: Home */
get_header(); ?>

<main class="home">
    <section class="banner-home position-relative overflow-hidden">
        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/banner.jpg" alt="Banner Hero Seminário" class="img-fluid banner-img">
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
    <section class="section-about about-event py-5 bg-blue">
        <div class="container">
            <div class="row mb-4">
                <div class="col-lg-3 d-flex align-items-center">
                    <h2 class="section-title text-white">ABOUT THE EVENT</h2>
                </div>
                <div class="col-lg-9">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/homepage/about-bg.jpg" alt="About the Event" class="img-fluid about-img mb-4">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="card event-card h-100">
                                <h3 class="card-title">III STATE SEMINAR ON PRISON HEALTH CARE OF PERNAMBUCO</h3>
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.</p>
                                <a href="#" class="btn btn-primary btn-learn">LEARN MORE</a>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card event-card h-100">
                                <h3 class="card-title">III STATE SHOWCASE OF PRISON HEALTH EXPERIENCES</h3>
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.</p>
                                <a href="#" class="btn btn-primary btn-topics">THEMATIC AXES</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="schedule py-5 bg-dark-blue">
        <div class="container">
            <div class="row mb-4">
                <div class="col-lg-3 d-flex align-items-center">
                    <h2 class="section-title text-white">SCHEDULE<br>AND PRESENTATIONS</h2>
                </div>
                <div class="col-lg-9">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/homepage/schedule.jpg" alt="Schedule and Presentations" class="img-fluid schedule-img mb-4">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="card event-card h-100">
                                <h3 class="card-title">FULL SCHEDULE</h3>
                                <a href="#" class="btn btn-primary btn-learn">LEARN MORE</a>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card event-card h-100">
                                <h3 class="card-title">ORAL PRESENTATIONS</h3>
                                <a href="#" class="btn btn-primary btn-learn">LEARN MORE</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="participation py-5 bg-white">
        <div class="container text-center">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/homepage/footer.jpg" alt="Join the Seminar" class="img-fluid footer-img mb-4">
            <h2 class="section-title text-blue">JOIN THE SEMINAR</h2>
            <p class="text-dark-blue">Sign up and be part of this journey of health, integration and care.</p>
            <a href="#" class="btn btn-primary btn-register">REGISTER HERE</a>
        </div>
    </section>
</main>
<?php get_footer(); ?>
