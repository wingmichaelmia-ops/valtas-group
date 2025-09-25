<div class="padding-normal">
    <div class="container content-row-inner">
        <?php
            $content = get_sub_field( 'content' );
            get_template_part( 'template-parts/partials/acf/renderer', '', array( 'flexible_content_key' => 'content', 'depth' => 'inner' ) );
        ?>
    </div>
</div>