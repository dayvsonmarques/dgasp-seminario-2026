<?php
$home_id      = get_the_ID();
$pdf_id       = (int) get_post_meta($home_id, '_home_approved_pdf_id', true);
$pdf_url      = $pdf_id ? wp_get_attachment_url($pdf_id) : '';
$btn_href     = $pdf_url ?: '#';
$btn_attrs    = $pdf_url ? ' target="_blank" rel="noopener"' : '';
?>
<section class="section-participation bg-white">
    <div class="container text-center">
        <h2 class="section-title text-blue mb-1">
            <span class="bold">TRABALHOS APROVADOS</span>
        </h2>
        <a href="<?php echo esc_url($btn_href); ?>"<?php echo $btn_attrs; ?> class="btn btn-primary btn-register mt-3">CONFIRA</a>
    </div>
</section>