<?php
/**
 * Block: Shortcode Block
 */

$defaults = [
    'shortcode' => get_sub_field('shortcode'),
];

$args = wp_parse_args($args ?? [], $defaults);
$shortcode = $args['shortcode'];
?>

<?php if ( !empty($shortcode) ) : ?>
    <div class="shortcode-block">
        <?php echo do_shortcode( $shortcode ); ?>
    </div>
<?php endif; ?>
