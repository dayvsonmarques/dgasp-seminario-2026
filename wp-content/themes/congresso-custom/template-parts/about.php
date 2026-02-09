<?php
$home_id = get_the_ID();
$block1_title   = get_post_meta($home_id, '_home_block1_title', true) ?: 'III SEMINÁRIO ESTADUAL DE ATENÇÃO À SAÚDE PRISIONAL DE PERNAMBUCO';
$block1_summary = get_post_meta($home_id, '_home_block1_summary', true) ?: '';
$block1_btn     = get_post_meta($home_id, '_home_block1_btn_text', true) ?: 'SAIBA MAIS';
$block1_link    = get_post_meta($home_id, '_home_block1_btn_link', true) ?: '#';
$block2_title   = get_post_meta($home_id, '_home_block2_title', true) ?: 'III MOSTRA ESTADUAL DE EXPERIÊNCIAS NA SAÚDE PRISIONAL';
$block2_summary = get_post_meta($home_id, '_home_block2_summary', true) ?: '';
$block2_btn     = get_post_meta($home_id, '_home_block2_btn_text', true) ?: 'EIXOS TEMÁTICOS';
$block2_link    = get_post_meta($home_id, '_home_block2_btn_link', true) ?: '#';
?>
<section class="section-about py-5">
    <div class="container-fluid">
        <div class="row my-5">
            <div class="col-lg-3 ">
                <h2 class="section-title text-white">
                    <span class="bold">SOBRE</span> 
                    <span class="">O</span>
                    <span class="bold">EVENTO</span>
                </h2>
            </div>
            <div class="col-lg-9">
                <div class="row">
                    <div class="col-md-6 mb-4">
                        <div class="card event-card px-5 py-5">
                            <h3 class="card-title color-blue"><?php echo esc_html($block1_title); ?></h3>
                            <p><?php echo esc_html($block1_summary); ?></p>
                            <a href="<?php echo esc_url($block1_link); ?>" target="_blank" class="btn-main"><?php echo esc_html($block1_btn); ?></a>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card event-card px-5 py-5">
                            <h3 class="card-title color-blue"><?php echo esc_html($block2_title); ?></h3>
                            <p><?php echo esc_html($block2_summary); ?></p>
                            <a href="<?php echo esc_url($block2_link); ?>" target="_blank" class="btn-main"><?php echo esc_html($block2_btn); ?></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
