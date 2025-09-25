<?php
    $default = array(
        "alignment"      => get_sub_field( 'alignment' ),
        "title"          => get_sub_field( 'title' ) ? : "Please enter title",
        "text"           => get_sub_field( 'text' ), // array of image URLs
        "usps"           => get_sub_field( 'usps' )
    );
    
    $args = wp_parse_args( $args, $default );

    $text_alignment = 'text-' . $args['alignment'];

    $swiper_options = array(
        "loop"          => true,
        "slidesPerView" => 1,
        "spaceBetween"  => 30,
        "autoplay"      => array(
            "delay"     => 2500
        ),
        "breakpoints"   => array(
            769 => array(
                "slidesPerView" => 3,
            ),
            1280 => array(
                "slidesPerView" => 4,
            ),
            1340 => array(
                "slidesPerView" => 6,
                "loop"          => false,
            )
            ),
            'navigation'    => array(
                'nextEl'    => '.swiper-button-next.usp-block-nav-' . $args['block_index'],
                'prevEl'    => '.swiper-button-prev.usp-block-nav-' . $args['block_index'],
            )
    );
?>

<div class="usp-block padding-normal position-relative overflow-hidden to-fade" data-delay="0.1">
    <img data-src="<?php echo get_template_directory_uri() ?>/assets/leaf-branch.svg" width="176.492" height="174.415" alt="leaf branch" class="echo-lazy usp-block-leaf usp-block-leaf-a position-absolute">
    <img data-src="<?php echo get_template_directory_uri() ?>/assets/leaf-branch.svg" width="176.492" height="174.415" alt="leaf branch" class="echo-lazy usp-block-leaf usp-block-leaf-b position-absolute d-none d-md-block">
    <div class="container position-relative to-fade" data-delay="0.2">
        <div class="<?php echo $text_alignment; ?>">
            <?php if ($args['title']) { ?>
                <h2 class="h2 <?php echo $text_alignment; ?>"><?php echo $args['title']; ?></h2>
            <?php } ?>
            <?php if ($args['text']) { ?>
               <p class="h4 mx-auto  col-lg-8 mx-auto d-block"><?php echo $args['text']; ?></p>
            <?php } ?>
            <?php if ($args['usps']) { ?>
            <div class="row mt-3 mt-md-5 position-relative to-fade" data-delay="0.3">
                <div class="position-relative">
                    <div class="usp-block-swiper swiper auto-init" data-options='<?php echo json_encode( $swiper_options ) ?>'>
                        <div class="swiper-wrapper">
                            <?php foreach ($args['usps'] as $usp) : ?>
                                <div class="swiper-slide">
                                    <div class="ratio-70 bg bg-contain echo-lazy" data-src="<?php echo $usp['image'] ?>" data-bg="true"></div>
                                    <p class="h4 text-primary px-5 px-md-0"><?php echo $usp['label'] ?></p>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <div class="swiper-button-prev swiper-nav-outside usp-block-nav-<?php echo $args['block_index'] ?>"></div>
                    <div class="swiper-button-next swiper-nav-outside usp-block-nav-<?php echo $args['block_index'] ?>"></div>
                </div>
				
				<div class="text-center pt-4">
					<a href="https://www.josephflach.co.uk/how-we-work-with-you/" class="btn btn-primary">How we work</a>
				</div>

            </div>
            <?php } ?>
        </div>
    </div>
</div>