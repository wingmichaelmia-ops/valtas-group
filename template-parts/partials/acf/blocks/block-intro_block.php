<?php

$default = array(
    "title_tag"      => get_sub_field( 'title_tag' ),
    "title"         => get_sub_field( 'title' ),
    "content"       => get_sub_field( 'blurb' ),
    "featured_image" => get_sub_field( 'featured_image' ),
    "blurb_second"  => get_sub_field( 'blurb_second'),
    "small_image" => get_sub_field( 'small_image'),
);

$args = wp_parse_args( $args, $default );

?>

<div class="valtas-intro-block py-5">
    <div class="container">
       <div class="row">
            <div class="col-lg-5">
                <?php if ( $args['title'] ) : ?>
                    <<?php echo esc_html( $args['title_tag'] ); ?>><?php echo $args['title']; ?></<?php echo esc_html( $args['title_tag'] ); ?>>
                <?php endif; ?>
                <div class="d-none d-md-block">  
                    <?php 
                        $link = get_sub_field('button');
                        if( $link ): 
                            $url = $link['url'];
                            $title = $link['title'];
                            $target = $link['target'] ? $link['target'] : '_self';
                            ?>
                            <div class="btn-valtas my-4">
                                <a href="<?php echo esc_url($url); ?>" target="<?php echo esc_attr($target); ?>" class="btn btn-primary">
                                    <?php echo esc_html($title); ?>
                                </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-lg-7">
                <div class="row px-0">
                    <div class="col-lg-6">
                        <?php if ( $args['content'] ) : ?>
                            <?php echo $args['content']; ?>
                        <?php endif; ?>
                    </div>
                    <div class="col-lg-6">
                        <?php if ( $args['small_image'] ) : ?>
                            <img class="my-4 d-block d-lg-none" src="<?php echo esc_url( $args['small_image']['url'] ); ?>" alt="<?php echo esc_attr( $args['small_image']['alt'] ); ?>" />
                        <?php endif; ?>  
                        <?php if ( $args['blurb_second'] ) : ?>
                            <?php echo $args['blurb_second']; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div> 
        </div>
        <div class="row align-items-center mt-4 ">
            <div class="d-none d-lg-block col-lg-4">
                <?php if ( $args['small_image'] ) : ?>
                    <img class="mt-4" src="<?php echo esc_url( $args['small_image']['url'] ); ?>" alt="<?php echo esc_attr( $args['small_image']['alt'] ); ?>" />
                <?php endif; ?>              
            </div>
            <div class="col-lg-8">
                <?php if ( $args['featured_image'] ) : ?>
                    <img src="<?php echo esc_url( $args['featured_image']['url'] ); ?>" alt="<?php echo esc_attr( $args['featured_image']['alt'] ); ?>" />    
                <?php endif; ?>         
            </div>
        </div>
        <div class="d-md-none d-block">
            <?php 
                $link = get_sub_field('button');
                if( $link ): 
                    $url = $link['url'];
                    $title = $link['title'];
                    $target = $link['target'] ? $link['target'] : '_self';
                ?>
                <div class="btn-valtas my-4">
                    <a href="<?php echo esc_url($url); ?>" target="<?php echo esc_attr($target); ?>" class="btn btn-primary">
                        <?php echo esc_html($title); ?>
                    </a>
                </div>
            <?php endif; ?>           
        </div>
    </div>
</div>