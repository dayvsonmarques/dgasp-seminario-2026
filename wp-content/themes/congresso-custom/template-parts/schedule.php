<?php
$home_id = get_the_ID();
$schedule_link1 = get_post_meta($home_id, '_home_schedule_link1', true) ?: '#';
$schedule_link2 = get_post_meta($home_id, '_home_schedule_link2', true) ?: '#';
?>
<section class="section-schedule">
    <div class="container-fluid">
        <div class="row my-5">
            <div class="col-12 col-xl-5 d-flex align-items-center">
                <h2 class="section-title text-white">PROGRAMAÇÃO<br>E APRESENTAÇÕES</h2>
            </div>
            <div class="col-12 col-xl-7">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="card event-card h-100 p-4 text-center">
                            <h3 class="card-title pb-3">PROGRAMAÇÃO COMPLETA</h3>
                            <a href="<?php echo esc_url($schedule_link1); ?>" class="btn-main">SAIBA MAIS</a>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="card event-card h-100 p-4 text-center">
                            <h3 class="card-title pb-3">APRESENTAÇÕES ORAIS</h3>
                            <a href="<?php echo esc_url($schedule_link2); ?>" class="btn-main">SAIBA MAIS</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
