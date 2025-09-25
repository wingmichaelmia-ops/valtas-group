<?php

$default = array(
    "title"     => get_sub_field( 'title' ) ?: "Please enter title",
    "content"   => get_sub_field( 'content' ) ?: false,
    "alignment" => get_sub_field( 'alignment' ) ?: "center",
    "items"     => get_sub_field( 'items' ) ?: array(
        array(
            "title" => "Sample title",
            "content" => "Sample Content"
        ),
        array(
            "title" => "Sample title",
            "content" => "Sample Content"
        )
    ),
    "schema"    => get_sub_field( 'generate_faq_schema' ),
    "hide_cta"  => get_sub_field( 'hide_cta' )
);

$args = wp_parse_args( $args, $default );

$block_id = $args['block_id'];

if( $args['items'] ) {
    
    $faq = array();

    foreach( $args['items'] as $item ) {
        $question   = $item['title'];
        $answer     = $item['content'];
        $faq[]      = array(
            "@type" => "Question",
            "name"  => $question,
            "acceptedAnswer" => array(
                "@type"      => "Answer",
                "text"       => $answer
            ),
        );
    }
    $arr = array(
        "@context" => "https://schema.org",
        "@type" => "FAQPage",
        "mainEntity" => $faq
    );
    echo '<script type="application/ld+json">'.json_encode($arr, JSON_UNESCAPED_SLASHES).'</script>';
}
?>

<div class="block-accordion padding-normal to-fade" data-delay="0.1">
    <div class="container">
        <div class="row">
            <div class="col col-12">
                <div class="text-md-<?php echo $args['alignment'] ?> to-fade" data-delay="0.2">
                    <?php if ($args['title']) { ?>
                        <h2 class="h2 text-<?php echo $args['alignment'] ?>"><?php echo $args['title']; ?></h2>
                    <?php } ?>
                    <?php if ($args['content']) { ?>
                        <p class="h4 col-lg-9 mx-lg-auto"><?php echo $args['content']; ?></p>
                    <?php } ?>
                </div>

                <div id="block-accordion-<?php echo $block_id ?>" class="accordion mt-4 to-fade" data-delay="0.3">
                    <?php if ( $args['items'] ) : foreach( $args['items'] as $key => $item ) : ?>
                        <div class="accordion-item to-fade" data-delay="0.3">
                            <div class="accordion-header" id="<?php echo "accordion-heading-" . $block_id . '-' . $key ?>">
                                <button class="accordion-button collapsed border-0" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-<?php echo $block_id . '-' . $key ?>" aria-expanded="true" aria-controls="collapse-<?php echo $block_id . '-' . $key ?>">
                                    <span class="h4 text-primary"><?php echo $item['title'] ?></span>
                                </button>
                            </div>
                            
                            <div id="collapse-<?php echo $block_id . '-' . $key ?>" class="accordion-collapse collapse" aria-labelledby="<?php echo "accordion-heading-" . $block_id . '-' . $key ?>" data-bs-parent="#block-accordion-<?php echo $block_id ?>">
                                <div class="accordion-body">
                                    <?php echo $item['content'] ?>
                                </div>
                            </div>

                        </div>
                    <?php endforeach; endif; ?>
                </div>
            </div>
            <?php if ( ! $args['hide_cta'] ) : ?>
                <div class="col col-12 text-center to-fade" data-delay="0.3">
                    <a href="/faqs/" class="btn btn-primary mt-5">View all FAQs</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>