<?php

$default = array(

    "title"         => get_sub_field( 'title' ),
    "content"       => get_sub_field( 'content' ),
    
    "title_2"       => get_sub_field( 'title_2' ),
    "content_2"     => get_sub_field( 'content_2' ),

    "taxonomy"      => get_sub_field( 'select_taxonomy' ) ?: 'category',

    "taxonomy_ids"  => get_sub_field( 'taxonomy_ids' ) ?: array(),

    'link_1'        => get_sub_field( 'link_1' ) ?: array(),
    'link_2'        => get_sub_field( 'link_2' ) ?: array(),
    'link_3'        => get_sub_field( 'link_3' ) ?: array()

);

$args = wp_parse_args( $args, $default );

?>

<div class="block-featured_categories position-relative overflow-hidden padding-normal">

    <div class="container">
        <div class="row">
            <div class="col col-12 to-fade" data-delay="0.1">

                <h3 class="h2 text-center"><?php echo $args['title'] ?></h3>
                <p class="h4 text-center"><?php echo $args['content'] ?></p>

                <div class="d-block position-relative pt-3 pt-md-5 to-fade" data-delay="0.2">
                    <?php
                        $terms = get_terms( array(
                            'taxonomy'      => $args['taxonomy'],
                            'include'       => $args['taxonomy_ids'],
                            'hide_empty'    => false
                        ));

                        $placeholder_thumb = get_template_directory_uri() . '/assets/logo-circle-icon.svg';

                        if ( $terms ) {
                            ?>
                            <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5 row-cols-xxl-6">
                                <?php foreach( $terms as $term ) : $image = get_field( 'thumbnail', $args['taxonomy'] . '_' . $term->term_id ) ?: $placeholder_thumb ?>
                                    <div class="col mb-4">
                                        <a href="<?php echo get_term_link( $term, $args['taxonomy'] ) ?>" class="loop-tax-box position-relative ratio-100 d-block bg echo-lazy bg-light" data-bg="true" data-src="<?php echo $image ?>">
                                            <span class="loop-tax-name d-block position-absolute bottom-0 start-0 w-100"><?php echo $term->name ?></span>
                                        </a>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <?php
                        }
                    ?>
                </div>
				<?php if ( $args['title_2'] ) : ?>
	                <h3 class="h2 text-center pt-3 pt-md-5"><?php echo $args['title_2'] ?></h3>
				<?php endif; ?>
				<?php if ( $args['content_2'] ) : ?>
                	<p class="h4 text-center"><?php echo $args['content_2'] ?></p>
				<?php endif; ?>
                <div class="text-center to-fade" data-delay="0.3">
                    <?php if ( $link = $args['link_1'] ) : ?>
                        <a href="<?php echo $link['url'] ?>" target="<?php echo $link['target'] ?>" class="mt-3 btn btn-primary"><?php echo $link['title'] ?></a>
                    <?php endif; ?>

                    <?php if ( $link = $args['link_2'] ) : ?>
                        <a href="<?php echo $link['url'] ?>" target="<?php echo $link['target'] ?>" class="mt-3 btn btn-light text-primary mx-md-4"><?php echo $link['title'] ?></a>
                    <?php endif; ?>
                    
                    <?php if ( $link = $args['link_3'] ) : ?>
                        <a href="<?php echo $link['url'] ?>" target="<?php echo $link['target'] ?>" class="mt-3 ms-0 btn btn-secondary"><?php echo $link['title'] ?></a>
                    <?php endif; ?>
                </div>

            </div>
        </div>
    </div>

</div>