<?php
/*
Template Name: Comissões
*/

$committees = [
    [
        'title'   => 'COORDENAÇÃO GERAL:',
        'members' => ['Jonatan Barros', 'Maria Júlia Nascimento'],
    ],
    [
        'title'   => 'COMISSÃO CIENTÍFICA E DE PROGRAMAÇÃO:',
        'members' => ['Merielly Bezerra', 'Dayvson Marques', 'Suelen D\'Andrada', 'Ismael Gomes'],
    ],
    [
        'title'   => 'COMISSÃO DE MOBILIZAÇÃO E TRANSPORTE:',
        'members' => ['Maria Eduarda Soares', 'Pedro Ferreira', 'Mikeline Soares', 'Luciana Mello'],
    ],
    [
        'title'   => 'COMISSÃO DE COMUNICAÇÃO, DIVULGAÇÃO E RELATORIA:',
        'members' => ['Fernando Valença', 'Alysson Ramos', 'Rebeca Calado', 'Suenia Olivia'],
    ],
    [
        'title'   => 'COMISSÃO DE LOGÍSTICA E INFRAESTRUTURA:',
        'members' => ['Beatriz D\'Andrade', 'Maria Francisca Santos', 'Andrea Carla', 'Claudiana Rosa', 'Ildemar Rosa'],
    ],
];

get_header();
?>

<section class="section-committees">
  <div class="container py-5">
    <div class="row align-items-start g-4 g-md-5 py-4 py-md-5">

      <div class="col-12 col-lg-5">
        <h1 class="section-title committees-page-title color-blue mb-0">COMISSÕES</h1>
      </div>

      <div class="col-12 col-lg-7">
        <?php foreach ( $committees as $group ) : ?>
        <div class="mb-5">
          <h2 class="committee-group-title fs-3 mb-3"><?php echo esc_html( $group['title'] ); ?></h2>
          <ul class="committee-members list-unstyled mb-0">
            <?php foreach ( $group['members'] as $member ) : ?>
            <li class="fs-4"><?php echo esc_html( $member ); ?></li>
            <?php endforeach; ?>
          </ul>
        </div>
        <?php endforeach; ?>
      </div>

    </div>
  </div>
</section>

<?php get_footer(); ?>
