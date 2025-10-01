<?php
/**
 * Block: Our Process
 */

$tag         = get_sub_field('title_tag') ?: 'h2';
$title       = get_sub_field('title');
$intro       = get_sub_field('blurb');
$our_process = get_sub_field('our_process');
?>

<?php if ( $title || $intro || $our_process ) : ?>
    <div class="our-process container py-5">
        <?php if ( $title ) : ?>
            <<?php echo esc_html( $tag ); ?> class="process-title text-center mb-3">
                <?php echo  $title; ?>
            </<?php echo esc_html( $tag ); ?>>
        <?php endif; ?>

        <?php if ( $intro ) : ?>
            <div class="process-intro text-center mb-4">
                <?php echo wp_kses_post( $intro ); ?>
            </div>
        <?php endif; ?>

        <?php if ( $our_process ) : ?>
            <div class="row g-4 process-steps">
                <?php foreach ( $our_process as $index => $step ) : 
                    $step_title = $step['our_process_title'] ?? '';
                    $step_text  = $step['our_process_blurb'] ?? '';
                    $step_icon  = $step['our_process_icon'] ?? ''; // optional icon/image
                    $step_num   = $index + 1; // step number
                ?>
                    <div class="col-lg-3 col-md-12 process-step text-center">
                        
                        <div class="step-header mb-3 d-flex flex-column align-items-center justify-content-center">
                            <div class="arrow-icon"></div>
                            <?php if ( $step_icon ) : ?>
                                <div class="step-icon">
                                    <?php echo wp_get_attachment_image( $step_icon, 'medium', false, ['class' => 'img-fluid'] ); ?>
                                    <span class="step-number">0<?php echo $step_num; ?></span>
                                </div>
                            <?php endif; ?>
                        </div>

                        <?php if ( $step_title ) : ?>
                            <h3 class="step-title h5 mb-2">
                                <?php echo esc_html( $step_title ); ?>
                            </h3>
                        <?php endif; ?>

                        <?php if ( $step_text ) : ?>
                            <div class="step-text">
                                <?php echo wp_kses_post( $step_text ); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
<?php endif; ?>
