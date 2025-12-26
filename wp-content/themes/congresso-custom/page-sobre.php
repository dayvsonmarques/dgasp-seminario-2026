<?php
/*
Template Name: Sobre
*/
get_header();
?>

<section class="section-about-hero mb-5">
  <div class="container">
    <div class="row">
      <div class="col-12 ">
        <h1 class="page-title color-white text-center">
          <span class="bold">SOBRE</span>
          <span class="">O</span>
          <span class="bold">EVENTO</span>
        </h1>
      </div>
    </div>
  </div>
</section>

<section class="section-about-content py-5">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-12 col-xl-6">
        <h2 class="about-subtitle color-blue">
          <span class="highlight-text bold">III SEMINÁRIO</span> ESTADUAL<br>
          DE <span class="highlight-text bold">ATENÇÃO À SAÚDE<br>
            <span class="bold">PRISIONAL</span></span> DE <span class="highlight-text bold">PERNAMBUCO</span>
        </h2>

      </div>
      <div class="col-12 col-xl-6">
        <p class="about-description fw300 text-left">
          O III Seminário Estadual de Atenção à Saúde Prisional de Pernambuco, reúne profissionais de saúde, gestores, diretores de unidades prisionais, equipes de segurança e representantes do sistema de justiça. O encontro busca fortalecer o debate, promover a troca de experiências e integrar saberes para qualificar a atenção à saúde da população privada de liberdade (PPL) em Pernambuco.
        </p>
      </div>
      <div class="col-12 text-center mt-5 pb-5 mb-5">
        <div class="text-center mt-4">
          <a href="#" class=" btn-default-custom">ACESSE O EDITAL</a>
        </div>
      </div>
    </div>
  </div>

  <div class="container-full bg-blue p-3 mt-5 mb-5"></div>

  <div class="container pt-5">
    <div class="row">
      <div class="col-lg-12">
        <div class="about-block mb-3">
          <h2 class="about-subtitle color-blue text-center">
            <span class="bold">III MOSTRA</span> ESTADUAL DE <span class="bold">EXPERIÊNCIAS</span> NA <span class="bold">SAÚDE PRISIONAL</span>
          </h2>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-12">
        <p class="about-description text-left">
          A III Mostra Estadual de Experiências na Saúde Prisional acontece junto ao seminário, com o objetivo de reconhecer, valorizar e divulgar práticas exitosas das unidades prisionais, municípios e Gerências Regionais. Mais que uma mostra, é um espaço de compartilhamento de práticas inovadoras que inspiram soluções e fortalecem a equidade e o cuidado integral no SUS.
        </p>
      </div>
    </div>

    <div class="row mt-5 mb-5">
      <div class="col-12 text-center">
        <h2 class="display-4 color-blue">EIXOS TEMÁTICOS</h2>
      </div>
    </div>
    
    <div class="about-block">
      <?php
      $eixos = new WP_Query([
        'post_type' => 'eixo_tematico',
        'posts_per_page' => -1,
        'orderby' => 'menu_order title',
        'order' => 'ASC'
      ]);

      if ($eixos->have_posts()) :
        while ($eixos->have_posts()) : $eixos->the_post();
      ?>
        <div class="axis-item">
          <h3 class="axis-title"><?php the_title(); ?></h3>
          <div class="axis-description">
            <?php the_content(); ?>
          </div>
        </div>
      <?php
        endwhile;
        wp_reset_postdata();
      else :
      ?>
        <p class="text-center">Nenhum eixo temático cadastrado.</p>
      <?php endif; ?>
    </div>
  </div>
  </div>
  </div>
</section>

<div class="bg-crosses">
</div>

<?php get_footer(); ?>