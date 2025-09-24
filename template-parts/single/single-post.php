<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-12">
            <?php the_content() ?>
        </div>
        <div class="col-12 col-lg-12">
            <?php
                $post_details = array(
                    "ID"        => get_the_ID(),
                    "image"     => get_the_post_thumbnail_url( null, 'full' ),
                    "tag"       => get_the_terms( get_the_ID(), "category" ),
                    "title"     => get_the_title(),
                    "button"    => array(
                        "title"     => "Read Article",
                        "target"    => "_self",
                        "url"       => get_the_permalink()
                    ),
                    "author"    => array(
                        "name"      => get_the_author_meta( "display_name" ),
                    ),
                    "date"      => get_the_date( "d M Y" )
                );
            ?>
            <div class="bg-light p-3 border d-flex align-items-center justify-content-center py-3 fw-600 mb-4">
                <small class="sep px-2">Posted By:</small>
                <small><?php echo $post_details["author"]["name"] ?></small>
            </div>

            <div class="bg-light p-3 border d-flex align-items-center justify-content-center py-3 fw-600">
                <small class="sep px-2">Posted On:</small>
                <small><?php echo $post_details["date"] ?></small>
            </div>
        </div>
    </div>
</div>
