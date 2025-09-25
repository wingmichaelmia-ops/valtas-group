<?php

$defaults = array(
    "data" => array()
);

$args = wp_parse_args( $args, $defaults );

$data = $args['data'];

?>
<div class="position-relative echo-mega-menu padding w-100">
    
    <img class="gfx gfx-end position-absolute end-0 bottom-0 w-auto" src="<?php echo get_template_directory_uri() ?>/assets/leaves-arc-gray.svg" alt="Leaves arc" width="334" height="97.282" />
	<img class="gfx gfx-start position-absolute start-0 top-0 w-auto" src="<?php echo get_template_directory_uri() ?>/assets/leaves-arc-gray.svg" alt="Leaves arc" width="334" height="97.282" />

    <div class="container">
        <?php
            $title = $data['title'];
            $style = $data['style'] ?: 'one-col';
            $links = $data['links'] ?: array();
        ?>
        <div class="row">
            <div class="col col-12 col-xl-<?php echo ( $style == 'one-col-compact' ) ? "4 d-xl-flex justify-content-center" : "4" ?>">
				<?php if ( $data['main_link'] ) : ?>
                	<a href="<?php echo $data['main_link'] ?>" class="h2 d-none text-decoration-none d-lg-block mega-menu-title-<?php echo $style ?>"><?php echo $title ?></a>
				<?php else : ?>
                	<p href="<?php echo $data['main_link'] ?>" class="h2 d-none text-decoration-none mb-0 d-lg-block mega-menu-title-<?php echo $style ?>"><?php echo $title ?></p>
				<?php endif; ?>
            </div>
            <div class="col col-12 col-xl-8">
                <div class="row row-cols-1 row-cols-xl-<?php echo ($style == 'one-col') ? '1 one-col-menu' : '2 two-col-menu' ?> col-menu">
                    <?php if ( ! empty( $links ) ) : foreach( $links as $link ) : ?>
                        <div class="col">
                            <?php if ( $link['title'] ) : ?>
                                <div class="h2"><span class="h4 text-primary"><?php echo $link['title'] ?></span></div>
                            <?php endif; ?>
                            <div class="link-items d-flex flex-wrap w-100">
                                <?php foreach( $link['link'] as $link_item ) : ?>
                                    <a href="<?php echo $link_item['link']['url'] ?>" target="<?php echo $link_item['link']['target'] ?>" class="text-decoration-none">
                                        <?php echo $link_item['link']['title'] ?>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endforeach; endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>