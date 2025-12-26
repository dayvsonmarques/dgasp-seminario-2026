<footer id="footer" class="site-footer bg-dark-blue text-white p-5 pb-3 footer-bar-top">
    <div class="container-fluid pt-5">
        <div class="row ">
            <div class="col-12 col-lg-4">
                <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/logo-footer.png'); ?>" alt="Logo do Seminário" class="img-fluid footer-logo" />
            </div>
            <div class="col-12 col-lg-1"></div>
            <div class="col-12 col-lg-3">
                <nav class="footer-menu mt-2">
                    <div class="row pt-5 pb-5">
                        <div class="col-6 col-lg-4 d-flex flex-column footer-menu__col footer-menu__col--left">
                            <a href="#" class="footer-link text-white text-decoration-none mb-2">INÍCIO</a>
                            <a href="#" class="footer-link text-white text-decoration-none">SOBRE</a>
                        </div>
                        <div class="col-6 col-lg-8 d-flex flex-column footer-menu__col footer-menu__col--right">
                            <a href="#" class="footer-link text-white text-decoration-none mb-2">COMISSÕES</a>
                            <a href="#" class="footer-link text-white text-decoration-none">EDITAL</a>
                        </div>
                    </div>
                </nav>
            </div>
            <div class="col-12 col-lg-4 pt-4">
                <div class="footer-contact fs-6">
                    <div class="border-start border-start-blue">
                        <div class="fw-bold h1 pb-3 ff-heading">CONTATO</div>
                        <p class="h5 light text-nowrap pb-2">Email: loremipsum@gmail.com</p>
                        <p class="h5 light text-nowrap">Telefone: (81) xxxxx - xxxx
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-5 pt-5">
        <div class="col text-center">
            <span class="text-light-blue"><span class="bold">DGASP</span> &copy; <?php echo date('Y'); ?> </span>
        </div>
    </div>
    </div>
    <?php wp_footer(); ?>
</footer>
</body>

</html>