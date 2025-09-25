<?php
    $content   = get_sub_field( 'content' );
    $content_2 = get_sub_field( 'content_2' );
    $content_3 = get_sub_field( 'content_3' );
    $content_3 = get_sub_field( 'content_4' );
?>
<div class="position-relative to-fade" data-delay="0.1">
    <div class="row to-fade" data-delay="0.2">
        <div class="col col-12 col-lg-3 pe-lg-4 wysiwyg to-fade" data-delay="0.3">
            <?php echo $content ?>
        </div>
        <div class="col col-12 col-lg-3  pe-lg-4 wysiwyg to-fade" data-delay="0.3">
            <?php echo $content_2 ?>
        </div>
        <div class="col col-12 col-lg-3  pe-lg-4 wysiwyg to-fade" data-delay="0.3">
            <?php echo $content_3 ?>
        </div>
        <div class="col col-12 col-lg-3  pe-lg-4 wysiwyg to-fade" data-delay="0.3>
            <?php echo $content_3 ?>
        </div>
    </div>
</div>