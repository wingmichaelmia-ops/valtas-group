<?php
/**
 * Block: Our Values
 */

$tag     = get_sub_field('title_tag') ?: 'h2';
$title   = get_sub_field('title');
$intro   = get_sub_field('blurb');
$values  = get_sub_field('our_values');
?>

<?php if ( $title || $intro || $values ) : ?>
    <div class="our-values container py-5">

        <?php if ( $title ) : ?>
            <<?php echo esc_attr($tag); ?> class="section-title text-center mb-4">
                <?php echo $title; ?>
            </<?php echo esc_attr($tag); ?>>
        <?php endif; ?>

        <?php if ( $intro ) : ?>
            <div class="section-intro text-center mb-5">
                <?php echo wp_kses_post($intro); ?>
            </div>
        <?php endif; ?>

        <?php if ( $values ) : ?>

            <!-- ✅ Straight Order (1 → 7) for LG and below -->
            <div class="row g-4 justify-content-center d-flex d-xl-none">
                <?php foreach ( $values as $index => $value ) : 
                    $num    = $index + 1;
                    $vtitle = $value['our_values_title'] ?? '';
                    $blurb  = $value['our_values_blurb'] ?? '';
                ?>
                    <div class="col-12 value-item text-center">
                        <div class="value-item_inner">
                            <div class="value-number"><span><?php echo $num; ?></span></div>
                            <div class="value-content">
                                <?php if ( $vtitle ) : ?>
                                    <h4 class="value-title mb-2"><?php echo esc_html($vtitle); ?></h4>
                                <?php endif; ?>
                                <?php if ( $blurb ) : ?>
                                    <div class="value-blurb"><?php echo wp_kses_post($blurb); ?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- ✅ Zigzag Layout for XL and up -->
            <div class="d-none d-xl-block">
                <!-- Top Row (2,4,6) -->
                <div class="row g-4 value-top justify-content-center mt-5">
                    <?php foreach ( $values as $index => $value ) : 
                        $num = $index + 1;
                        if ( in_array( $num, [2,4,6] ) ) :
                            $vtitle = $value['our_values_title'] ?? '';
                            $blurb  = $value['our_values_blurb'] ?? '';
                    ?>
                        <div class="col-xl-3 value-item text-center">
                            <div class="value-item_inner">    
                                <?php if ( $vtitle ) : ?>
                                    <h4 class="value-title mb-2"><?php echo esc_html($vtitle); ?></h4>
                                <?php endif; ?>
                                <?php if ( $blurb ) : ?>
                                    <div class="value-blurb"><?php echo wp_kses_post($blurb); ?></div>
                                <?php endif; ?>
                                <div class="value-number"><span><?php echo $num; ?></span></div>
                            </div>
                        </div>
                    <?php endif; endforeach; ?>
                </div>

                <!-- Bottom Row (1,3,5,7) -->
                <div class="row g-4 value-bottom">
                    <?php foreach ( $values as $index => $value ) : 
                        $num = $index + 1;
                        if ( in_array( $num, [1,3,5,7] ) ) :
                            $vtitle = $value['our_values_title'] ?? '';
                            $blurb  = $value['our_values_blurb'] ?? '';
                    ?>
                        <div class="col-xl-3 value-item text-center">
                            <div class="value-item_inner">
                                <div class="value-number"><span><?php echo $num; ?></span></div>
                                <?php if ( $vtitle ) : ?>
                                    <h4 class="value-title mb-2"><?php echo esc_html($vtitle); ?></h4>
                                <?php endif; ?>
                                <?php if ( $blurb ) : ?>
                                    <div class="value-blurb"><?php echo wp_kses_post($blurb); ?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endif; endforeach; ?>
                </div>
            </div>

        <?php endif; ?>
    </div>
<?php endif; ?>
