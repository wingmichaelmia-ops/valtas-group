<?php
/**********************************************************
 *
 * File:         Page Header
 * Description:  Page Header
 * Version:      v0.1
 * Modified:     10/06/24
 *
 **********************************************************/
defined('ABSPATH') or die('No script kiddies please!');

$heading_size = get_field('heading_size_faq');
$subheading_size = get_field('subheading_size_faq');
$heading_center = get_field('heading_center_faq');

$acf_heading = get_field('heading_text_faq');
$heading = $acf_heading ? sprintf('<%1$s class="text-block__heading">%2$s</%1$s>', $heading_size, $acf_heading) : '';

$acf_subheading = get_field('subheading_text_faq');
$subheading = $acf_subheading ? sprintf('<%1$s class="text-block__subheading">%2$s</%1$s>', $subheading_size, $acf_subheading) : '';

$auxCenter = '';

if ($heading_center == 'yes') {
	$auxCenter = 'text-center';
}

$link = get_field('link_all_faqs');
?>

<?php if (have_rows('questions')): ?>
	<div class="accordion-block block block--margin">
		<div class="container-fluid">
			<div class="row justify-content-center">
				<div class="col-12">
					<?php if ($heading) { ?>
						<div class="text-block__header <?php echo $auxCenter ?>">
							<?php echo $heading; ?>
							<?php if ($subheading) { ?>
								<?php echo $subheading; ?>
							<?php } ?>
						</div>
					<?php } ?>
					<div class="accordion-items">
						<?php while (have_rows('questions')):
							the_row('questions');
							$i = 0; ?>
							<details id="accordion-item-id-<?php echo $i ?>" class="accordion-items__item">
								<summary class="accordion accordion-items__item__question">
									<span><?php echo get_sub_field('q'); ?></span>
								</summary>
								<div class="accordion__answer">
									<?php echo wpautop(get_sub_field('a')); ?>
								</div>
							</details>
							<?php $i++; endwhile; ?>
					</div>

					<?php if ($link) { ?>
						<div class="text-center block--margin-md">
							<a href="<?php echo $link['url'] ?>" target="<?php echo $link['target'] ?>"
								class="btn btn--transparent btn-arrow-right">
								<?php echo $link['title'] ?>
							</a>
						</div>
					<?php } ?>
				</div>
			</div>
		</div>

		<?php if (have_rows('questions')): ?>
			<?php $count = get_field('questions');
			$i = 1; ?>
			<script type="application/ld+json">
							{
								"@context": "https://schema.org",
								"@type": "FAQPage",
								"mainEntity": [
									<?php while (have_rows('questions')):
										the_row('questions'); ?>
												{
													"@type": "Question",
													"name": "<?php echo get_sub_field('q'); ?>",
														"acceptedAnswer": {
														"@type": "Answer",
														"text": "<?php echo esc_attr(wp_strip_all_tags(get_sub_field('a'))); ?>"
													}
												}
												<?php if ($i < count($count)) {
													echo ',';
													$i++;
												} ?>

									<?php endwhile; ?>
								]
							}
							</script>
		<?php endif; ?>
	</div>
<?php endif; ?>