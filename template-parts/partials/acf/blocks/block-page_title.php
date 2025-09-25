<?php
    $default = array(
        "title"          => get_sub_field( 'title' ) ? : "Please enter title",
        "alignment"      => get_sub_field( 'alignment' ),
        "image_url"      => get_sub_field( 'image' )['url'] ?? get_template_directory_uri() . '/img/page-title.png'
    );
    
    $args = wp_parse_args( $args, $default );

    $text_alignment = 'text-' . $args['alignment'];
?>

<div class="block-page-title page-title d-flex flex-column position-relative overflow-hidden" data-delay="0.1" style="background-image: url(<?php echo $args['image_url']; ?>)">
    <div class="container position-relative not-to-fade" data-delay="0.1">
        <?php echo get_template_part( 'global-templates/breadcrumbs' ) ?>
    </div>

    <img src="<?php echo $args['image_url']; ?>" alt="banner" width="2000" height="400" class="d-block d-md-none w-100 h-auto">

    <div class="container title-container mt-0 mt-md-auto content-row-inner not-to-fade" data-delay="0.2">
        <?php if ($args['title']) { ?>
        <h1 class="h1 my-3 mb-md-5 mt-md-auto col-md-4 <?php echo $text_alignment; ?> not-to-fade" data-delay="0.3"><?php echo $args['title']; ?></h1>
        <?php } ?>
    </div>
</div>