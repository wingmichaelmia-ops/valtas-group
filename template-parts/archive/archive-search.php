<?php

    $args = array(
        "title" => get_the_archive_title()
    );
    get_template_part( 'template-parts/partials/header/header-archive', 'page', $args );

?>
<div class="container">
    <div class="row">
        <?php
            /* Start the Loop */
            while ( have_posts() ):
                the_post();
                echo '<div class="col">';
                get_template_part( 'template-parts/partials/cards/card', 'search' );
                echo '</div>';
            endwhile;
        ?>
    </div>
    <?php if ( have_posts() ) : ?>
        <div class="row">
            <div class="col">
                <?php understrap_pagination() ?>
            </div>
        </div>
    <?php endif; ?>
</div>
