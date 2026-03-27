<?php
/*
Template Name: Sobre
*/
get_header();
?>

<!-- Hero Photo -->
<?php if ( has_post_thumbnail() ) : ?>
<div class="sobre-hero">
  <?php the_post_thumbnail( 'full', [ 'class' => 'sobre-hero-img', 'alt' => get_the_title() ] ); ?>
</div>
<?php endif; ?>

<!-- Welcome -->
<section class="section-welcome">
  <div class="container">

    <h2 class="section-title color-blue mb-4">BOAS VINDAS</h2>

    <div class="row">
      <div class="col-12 col-lg-8">
        <div class="welcome-content">
          <?php the_content(); ?>
        </div>
      </div>
    </div>

    <div class="row mt-4 pt-4 border-top">
      <div class="col-12">
        <h3 class="section-title color-blue mb-4">AQUI, VOCÊ ENCONTRARÁ:</h3>
        <ul class="ps-4 mb-5 fs-5">
          <li class="mb-2">Programação atualizada</li>
          <li class="mb-2">Informações para submissão de trabalhos e divulgação dos aprovados</li>
          <li class="mb-2">Informações gerais sobre o evento</li>
          <li class="mb-2">Fale conosco e muito mais!</li>
        </ul>
      </div>
      <div class="col-12">
        <p class="fw-bold fs-5 color-dark-blue mb-1">Jonatan Barros</p>
        <p class="fst-italic text-secondary mb-0 fs-5">
          Diretor da Divisão de Saúde do Sistema Prisional (DASSP) /
          Presidente da Comissão Organizadora
        </p>
      </div>
    </div>

  </div>
</section>

<!-- Full Schedule -->
<section class="section-full-schedule">
  <div class="container">

    <h2 class="section-title mb-0">PROGRAMAÇÃO COMPLETA</h2>
    <hr class="border-white border-2 opacity-50 mt-3 mb-5">

    <!-- 15/04 -->
    <div class="row align-items-start">
      <div class="col-12 col-md-3 day-date-col">
        <p class="schedule-date-number">15/04</p>
        <p class="schedule-day-name">QUARTA-FEIRA</p>
      </div>
      <div class="col-12 col-md-9">
        <ul class="schedule-list">
          <li class="schedule-item">
            <span class="schedule-time">09:00 – 09:30</span>
            <span class="schedule-activity">Credenciamento e boas-vindas</span>
          </li>
          <li class="schedule-item">
            <span class="schedule-time">09:30 – 10:00</span>
            <span class="schedule-activity">Abertura oficial do evento</span>
          </li>
          <li class="schedule-item">
            <span class="schedule-time">10:00 – 11:00</span>
            <span class="schedule-activity">Conferência: Saúde Prisional no Brasil – avanços e desafios</span>
          </li>
          <li class="schedule-item">
            <span class="schedule-time">11:00 – 12:00</span>
            <span class="schedule-activity">Painel: Políticas públicas para a saúde da população privada de liberdade</span>
          </li>
          <li class="schedule-item">
            <span class="schedule-time">12:00 – 14:00</span>
            <span class="schedule-activity">Almoço</span>
          </li>
          <li class="schedule-item">
            <span class="schedule-time">14:00 – 15:30</span>
            <span class="schedule-activity">Grupos de trabalho temáticos</span>
          </li>
          <li class="schedule-item">
            <span class="schedule-time">15:30 – 16:00</span>
            <span class="schedule-activity">Coffee break</span>
          </li>
          <li class="schedule-item">
            <span class="schedule-time">16:00 – 17:30</span>
            <span class="schedule-activity">Apresentação de experiências – III Mostra Estadual</span>
          </li>
        </ul>
      </div>
    </div>

    <hr class="border-white border-1 opacity-25 my-5">

    <!-- 16/04 -->
    <div class="row align-items-start">
      <div class="col-12 col-md-3 day-date-col">
        <p class="schedule-date-number">16/04</p>
        <p class="schedule-day-name">QUINTA-FEIRA</p>
      </div>
      <div class="col-12 col-md-9">
        <ul class="schedule-list">
          <li class="schedule-item">
            <span class="schedule-time">08:30 – 09:30</span>
            <span class="schedule-activity">Mesa redonda: Integração entre saúde e segurança pública</span>
          </li>
          <li class="schedule-item">
            <span class="schedule-time">09:30 – 10:30</span>
            <span class="schedule-activity">Conferência: Atenção à saúde mental no sistema prisional</span>
          </li>
          <li class="schedule-item">
            <span class="schedule-time">10:30 – 11:00</span>
            <span class="schedule-activity">Coffee break</span>
          </li>
          <li class="schedule-item">
            <span class="schedule-time">11:00 – 12:00</span>
            <span class="schedule-activity">Apresentação de trabalhos científicos aprovados</span>
          </li>
          <li class="schedule-item">
            <span class="schedule-time">12:00 – 14:00</span>
            <span class="schedule-activity">Almoço</span>
          </li>
          <li class="schedule-item">
            <span class="schedule-time">14:00 – 15:30</span>
            <span class="schedule-activity">Painel: Equidade e cuidado integral no SUS</span>
          </li>
          <li class="schedule-item">
            <span class="schedule-time">15:30 – 16:00</span>
            <span class="schedule-activity">Coffee break</span>
          </li>
          <li class="schedule-item">
            <span class="schedule-time">16:00 – 17:00</span>
            <span class="schedule-activity">Premiação e encerramento da III Mostra Estadual</span>
          </li>
          <li class="schedule-item">
            <span class="schedule-time">17:00 – 17:30</span>
            <span class="schedule-activity">Encerramento oficial</span>
          </li>
        </ul>
      </div>
    </div>

  </div>
</section>

<?php get_footer(); ?>
