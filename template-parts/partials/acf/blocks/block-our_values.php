<?php
/**
 * Block: Our Values
 */

$tag             = get_sub_field('title_tag') ?: 'h2';
$title           = get_sub_field('title');
$intro           = get_sub_field('blurb');
$values          = get_sub_field('our_values');
$connector_style = get_sub_field('connector_style');

$total_items     = is_array($values) ? count($values) : 0;
$col_class       = ($total_items === 6) ? 'col-xl-2' : 'col-xl-3';
$wrapper_class   = ($total_items === 6) ? 'values-6' : (($total_items === 7) ? 'values-7' : '');
?>

<?php if ( $title || $intro || $values ) : ?>
    <div class="our-values container py-5 <?php echo esc_attr( $connector_style . ' ' . $wrapper_class ); ?>">

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

            <!-- ✅ Straight Order (1 → N) for LG and below -->
            <div class="row g-4 justify-content-center value-mobile d-flex d-xl-none">
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
                <!-- Top Row (even numbers) -->
                <div class="row g-4 value-top justify-content-center mt-5">
                    <?php 
                    $first_top_added = false;
                    foreach ( $values as $index => $value ) : 
                        $num = $index + 1;
                        if ( $num % 2 === 0 ) : // Even numbers
                            $vtitle = $value['our_values_title'] ?? '';
                            $blurb  = $value['our_values_blurb'] ?? '';

                            // 👉 Add empty col BEFORE the first top-row value-item
                            if ( $connector_style === 'connector_style_2' && ! $first_top_added ) {
                                echo '<div class="' . esc_attr($col_class) . ' value-item"></div>';
                                $first_top_added = true;
                            }
                    ?>
                        <div class="<?php echo esc_attr($col_class); ?> value-item text-center">
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

                        <?php if ( $connector_style === 'connector_style_2' ) : ?>
                            <div class="<?php echo esc_attr($col_class); ?> value-item"></div>
                        <?php endif; ?>

                    <?php endif; endforeach; ?>
                </div>

                <!-- Bottom Row (odd numbers) -->
                <div class="row g-4 value-bottom">
                    <?php foreach ( $values as $index => $value ) : 
                        $num = $index + 1;
                        if ( $num % 2 !== 0 ) : // Odd numbers
                            $vtitle = $value['our_values_title'] ?? '';
                            $blurb  = $value['our_values_blurb'] ?? '';
                    ?>
                        <div class="<?php echo esc_attr($col_class); ?> value-item text-center">
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

                        <?php if ( $connector_style === 'connector_style_2' ) : ?>
                            <div class="<?php echo esc_attr($col_class); ?> value-item"></div>
                        <?php endif; ?>

                    <?php endif; endforeach; ?>
                </div>
            </div>

        <?php endif; ?>
    </div>

    <!-- ✅ Dynamic CSS for max-width -->
    <style>
        @media(min-width:1200px) {
            .our-values.values-7 .value-item_inner {
                max-width: 290px;
                margin: 0 auto;
            }
            .our-values.values-6 .value-item_inner {
                max-width: 220px;
                margin: 0 auto;
            }
        }
    </style>
<?php endif; ?>
