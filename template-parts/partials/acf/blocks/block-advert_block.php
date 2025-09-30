<?php
/**
 * Block: Advert Block
 */

$image     = get_sub_field('advert_image');
$tag       = get_sub_field('advert_title_tag') ?: 'h2';
$title     = get_sub_field('advert_title');
$blurb     = get_sub_field('advert_blurb');
$button    = get_sub_field('advert_button');
$position  = get_sub_field('advert_position') ?: 'left';

// Column classes
$text_col_class = $image ? 'col-md-6' : 'col-md-12';
?>

<?php if ( $title || $blurb || $image ) : ?>
    <div class="advert-block">
        <div class="row gx-5 align-items-center <?php echo $position === 'right' && $image ? 'flex-row-reverse' : ''; ?>">
            
            <?php if ( $image ) : ?>
                <div class="col-md-6 advert-image">
                    <?php echo wp_get_attachment_image( $image, 'large', false, ['class' => ''] ); ?>
                </div>
            <?php endif; ?>
            
            <div class="<?php echo esc_attr($text_col_class); ?>">
                <div class="advert-text p-5">
                    <?php if ( $title ) : ?>
                        <<?php echo esc_attr($tag); ?> class="advert-title text-primary mb-3">
                            <?php echo $title; ?>
                        </<?php echo esc_attr($tag); ?>>
                    <?php endif; ?>
                    
                    <?php if ( $blurb ) : ?>
                        <div class="advert-blurb mb-3">
                            <?php echo wp_kses_post($blurb); ?>
                        </div>
                    <?php endif; ?>
                    
                    <?php if ( $button ) : ?>
                        <a href="<?php echo esc_url($button['url']); ?>" 
                        target="<?php echo esc_attr($button['target'] ?: '_self'); ?>" 
                        class="btn btn-primary">
                            <?php echo esc_html($button['title']); ?>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
