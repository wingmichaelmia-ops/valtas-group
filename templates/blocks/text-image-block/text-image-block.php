<?php
/**********************************************************
 *
 * File:         Page Header
 * Description:  Page Header
 * Version:      v0.1
 * Modified:     10/06/24
 *
 **********************************************************/
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

$heading_size = get_field( 'heading_size_image' );
$subheading_size = get_field('subheading_size_image');
$heading_center = get_field( 'heading_center_image' );

$acf_heading = get_field( 'heading_text_image' );
$heading = $acf_heading ? sprintf( '<%1$s class="text-block__heading">%2$s</%1$s>', $heading_size, $acf_heading) : '';

$acf_subheading = get_field('subheading_text_image');
$subheading = $acf_subheading ? sprintf('<%1$s class="text-block__subheading">%2$s</%1$s>', $subheading_size, $acf_subheading) : '';

$lead_paragraph = get_field( 'lead_paragraph_text_image' );
$content  = get_field( 'content_text_image' );

$acf_image = get_field( 'image_text_image' );
$position_image = get_field( 'position_image_text_image' );

$auxClass = "flex-wrap";
$auxCenter = '';
$auxaMargin = 'mb-0';

if($position_image == "left"){
    $auxClass = "flex-row-reverse";
}

if( $heading_center == 'yes' ) {
	$auxCenter = 'text-center';
}

if( $content ) {
	$auxaMargin = '';
}

?>

<div class="text-block text-image-block block block--margin">
	<div class="container-fluid">
		<div class="row justify-content-center align-items-center <?php echo $auxClass ?>">
			<div class="col-12 col-xl-6 order-2 order-xl-0 mt-5 mt-xl-0">
				<?php if( $heading ) { ?>
					<div class="text-block__header <?php echo $auxCenter . ' ' . $auxaMargin; ?>">
						<?php echo $heading; ?>
						<?php if( $subheading ) { ?>
							<?php echo $subheading; ?>
						<?php } ?>
					</div>
				<?php } ?>
				<?php if( $content ) { ?>
					<?php if( $lead_paragraph ) { ?>
						<p class="lead"><?php echo $lead_paragraph; ?></p>
					<?php } ?>
					<?php echo $content; ?>
					<?php if ( have_rows('buttons_text_image') ) : ?>
						<div class="block-buttons">
							<?php while ( have_rows('buttons_text_image') ) : the_row(); ?>
								<?php
									$link   = get_sub_field('link');
									$theme  = get_sub_field('theme');
									if ( empty($link) ) { break; }

									echo sprintf('<a class="btn btn--%1$s" href="%2$s" target="%3$s">%4$s</a>', $theme, $link['url'], $link['target'], $link['title']);

								?>
								<?php endwhile; ?>
						</div>
					<?php endif; ?>
				<?php } ?>
			</div>
			<div class="col-12 col-xl-6 order-1 order-xl-0">
				<?php echo wp_get_attachment_image( $acf_image, 'full', false, array('class'=>'text-block__img img-fluid', 'loading' => 'lazy') ) ?>
			</div>
		</div>
	</div>
</div>
