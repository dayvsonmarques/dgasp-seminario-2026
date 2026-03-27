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

<!-- Boas Vindas -->
<section class="section-boas-vindas">
  <div class="container">

    <h2 class="boas-vindas-title">BOAS VINDAS</h2>

    <div class="row">
      <div class="col-12 col-lg-8">
        <div class="boas-vindas-content">
          <?php the_content(); ?>
        </div>
      </div>
    </div>

    <div class="row boas-vindas-bottom">
      <div class="col-12">
        <h3 class="boas-vindas-encontrara-title">AQUI, VOCÊ ENCONTRARÁ:</h3>
        <ul class="boas-vindas-list">
          <li>Programação atualizada</li>
          <li>Informações para submissão de trabalhos e divulgação dos aprovados</li>
          <li>Informações gerais sobre o evento</li>
          <li>Fale conosco e muito mais!</li>
        </ul>
      </div>
      <div class="col-12">
        <div class="speaker-block">
          <p class="speaker-name">Jonatan Barros</p>
          <p class="speaker-role">
            Diretor da Divisão de Saúde do Sistema Prisional (DASSP) /
            Presidente da Comissão Organizadora
          </p>
        </div>
      </div>
    </div>

  </div>
</section>

<!-- Programação Completa -->
<section class="section-programacao">
  <div class="container">

    <h2 class="programacao-title">PROGRAMAÇÃO COMPLETA</h2>
    <div class="programacao-divider"></div>

    <!-- 15/04 - Quarta-feira -->
    <div class="day-block row">
      <div class="col-12 col-md-3 day-date-col">
        <p class="day-number">15/04</p>
        <p class="day-label">QUARTA-FEIRA</p>
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

    <div class="programacao-day-divider"></div>

    <!-- 16/04 - Quinta-feira -->
    <div class="day-block row">
      <div class="col-12 col-md-3 day-date-col">
        <p class="day-number">16/04</p>
        <p class="day-label">QUINTA-FEIRA</p>
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
