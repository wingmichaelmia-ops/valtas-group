<?php
/**
 * Block: Our Resources
 */

$defaults = [
    'header_title'    => get_sub_field('header_title'),
    'intro_text'      => get_sub_field('intro_text'),
    'resources'       => get_sub_field('resources')
];

$args = wp_parse_args($args ?? [], $defaults);

$title = $args['header_title'];
$intro = $args['intro_text'];
$resources = $args['resources'];
?>

<section class="py-5">
    <div class="container">
        <?php if($title) {?>
            <h3 class="text-primary fw-bold"><?php echo $title; ?></h3>
        <?php } ?>
        <?php if($intro) { ?>
            <?php echo $intro; ?>
        <?php } ?>
        <div class="resources-downloads">
        <?php if ( have_rows('resources') ) : ?>
                <?php while ( have_rows('resources') ) : the_row(); 
                    $title       = get_sub_field('title');
                    $description        = get_sub_field('description');
                    $file = get_sub_field('file_download');
                ?>
                <div class="resources-downloads-list row">
                    <div class="col-md-4">
                        <?php if ( $title ) : ?>
                            <h5 class="fw-bold text-primary resource-title"><img src="<?php echo get_template_directory_uri() ?>/img/folder.png"> &nbsp;<?php echo esc_html( $title ); ?></h5>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-6">
                        <?php if ( $description ) : ?>
                            <?php echo $description ; ?>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-2">
                        <a href="<?php echo esc_url( $file['url'] ); ?>" class="btn btn-outline-primary btn-download" target="_blank" rel="noopener">
                            Download
                        </a>
                    </div>
                </div>
                <?php endwhile; ?>
        <?php else : ?>
            <p>No resources added yet.</p>
        <?php endif; ?>
        </div>
    </div>
</section>