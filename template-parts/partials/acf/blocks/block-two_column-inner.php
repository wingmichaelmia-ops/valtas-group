<?php
    $content   = get_sub_field( 'content' );
    $content_2 = get_sub_field( 'content_2' );
?>
<div class="padding-normal pt-0 to-fade" data-delay="0.1">
    <div class="row to-fade" data-delay="0.2">
        <div class="col col-12 col-lg-6 pe-lg-4 wysiwyg">
            <?php echo $content ?>
        </div>
        <div class="col col-12 col-lg-6  ps-lg-4 wysiwyg to-fade" data-delay="0.3">
            <?php echo $content_2 ?>
        </div>
    </div>
</div>