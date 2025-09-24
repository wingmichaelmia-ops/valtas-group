<?php

$defaults = array(
    "ID"        => get_the_ID(),
    "image"     => get_the_post_thumbnail_url( null, 'full' ),
    "tag"       => get_primary_term( get_the_ID(), "category" ),
    "title"     => get_the_title(),
    "button"    => array(
        "title"     => "View Item",
        "target"    => "_self",
        "url"       => get_the_permalink()
    ),
    "author"    => array(
        "name"      => get_the_author_meta( "display_name" ),
        "avatar"    => get_site_url() . '/wp-content/uploads/2023/07/capital-lawyers-fav.png'
    ),
    "date"      => get_the_date( "d M Y" )
);

$args = wp_parse_args( $args, $defaults );

?>

<article id="post-<?php echo $args["ID"] ?>" class="card bg-white h-100 card-case-study">
    <div class="d-flex flex-wrap align-items-center justify-content-between h-100 card-content text-center py-4">
        <div class="text-orange fw-600 pb-4 text-uppercase"><small><?php echo $args["tag"] ?></small></div>
        <h5 class="normal-heading px-5"><?php echo $args["title"] ?></h5>
        <div class="d-flex align-items-center justify-content-center py-3 fw-600">
            <div class="rounded-circle card-author bg echo-lazy me-2" data-bg="true" data-src="<?php echo $args["author"]["avatar"] ?>" ></div>
            <small><?php echo $args["author"]["name"] ?></small>
        </div>
    </div>
    <a href="<?php echo $args['button']['url'] ?>" target="<?php echo $args['button']['target'] ?>" title="<?php echo $args['button']['title'] ?>" class="w-100 h-100 position-absolute d-block"></a>
    <div class="d-block text-center card-action position-relative">
        <a href="<?php echo $args['button']['url'] ?>" target="<?php echo $args['button']['target'] ?>" class="button"><?php echo $args['button']['title'] ?></a>
    </div>
</article>