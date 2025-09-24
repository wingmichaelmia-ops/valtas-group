<?php

$defaults = array(
    "image"                 => get_field( 'banner_page_image' ) ?: get_the_post_thumbnail_url( null, 'full' ),
    "title"                 => get_field( 'banner_page_title' ) ?: get_the_title(),
    "hide_breadcrumbs"      => get_field( 'banner_page_breadcrumb' ),
    "disabled"              => get_field( 'banner_page_heading' ),
	"button"				=> get_field( 'banner_page_button' ) ?: [],
);

$args = wp_parse_args( $args, $defaults );

if ( $args["disabled"] ) { return; }

?>

<section id="banner" class="position-relative d-block w-100 overflow-hidden bg bg-orange" style="background-image: url(<?php echo $args['image'] ?>);">

    <?php if ( $args['image'] ) : ?>
        <div class="overlay w-100 h-100 top-0 start-0 position-absolute bg-dark opacity-25"></div>
    <?php endif; ?>
    
    <img src="<?php echo get_template_directory_uri() ?>/assets/images/triangle.svg" class="h-100 position-absolute start-0 bottom-0 w-auto banner-triangle" alt="triangle">
    <img src="<?php echo get_template_directory_uri() ?>/assets/images/circle.svg" class="h-100 position-absolute end-0 bottom-0 w-auto banner-circle" alt="circle">
    
    <div class="container position-relative">
        <div class="row justify-content-center">
            <div class="text-center col-12 col-md-8 text-white">
                <h1 class="large-heading"><?php echo $args['title'] ?></h1>
				<?php if ( $args['button'] ) : ?>
					<a href="<?php echo $args['button']['url'] ?>" class="button" target="<?php echo $args['button']['target'] ?>"><?php echo $args['button']['title'] ?></a>
    			<?php endif; ?>
            </div>
        </div>
    </div>
    
</section>

<?php if ( ! $args[ 'hide_breadcrumbs'] ) : ?>
    <?php get_template_part( 'template-parts/partials/header/breadcrumbs' ); ?>
<?php endif; ?>