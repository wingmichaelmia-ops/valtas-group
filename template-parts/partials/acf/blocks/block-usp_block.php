<div class="valtas-usp-block py-5">
    <div class="container">
        <?php if( have_rows('usp_list', 'option') ): ?>
            <ul class="usp-list">
                <?php while( have_rows('usp_list', 'option') ): the_row(); 
                    $icon  = get_sub_field('usp_icon');   // image
                    $title = get_sub_field('usp_title');  // text
                    $blurb = get_sub_field('usp_blurb');  // text
                ?>
                    <li class="usp-item">
                        <?php if( $icon ): ?>
                            <div class="usp-icon">
                                <?php echo wp_get_attachment_image( $icon, 'thumbnail' ); ?>
                            </div>
                        <?php endif; ?>

                        <div class="usp-content">
                            <?php if( $title ): ?>
                                <h4 class="usp-title"><?php echo esc_html( $title ); ?></h4>
                            <?php endif; ?>

                            <?php if( $blurb ): ?>
                                <p class="usp-blurb"><?php echo esc_html( $blurb ); ?></p>
                            <?php endif; ?>
                        </div>
                    </li>
                <?php endwhile; ?>
            </ul>
        <?php endif; ?>

    </div>
</div>