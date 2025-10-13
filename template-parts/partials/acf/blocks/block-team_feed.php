<?php
/**
 * Block: Team Feed
 */

$defaults = [
    'title_tag'       => get_sub_field('title_tag'),
    'header_title'    => get_sub_field('header_title'),
    'intro_text'      => get_sub_field('intro_text'),
    'image_text'      => get_sub_field('image_text') ?: [],
    'header_position' => get_sub_field('header_position') ?: 'header-title-center',
    'team_division' => get_sub_field('team_division'),
];

$args = wp_parse_args($args ?? [], $defaults);
?>

<?php if ( !empty($args['header_title']) ) : ?>
    <div class="container pt-5 <?php echo esc_attr($args['header_position']); ?>">
        <?php if ( $args['header_title'] ) : ?>
            <<?php echo esc_html( $args['title_tag'] ); ?> class="valtas-cta-block__title">
                <?php echo  $args['header_title']; ?>
            </<?php echo esc_html( $args['title_tag'] ); ?>>
        <?php endif; ?>

        <?php if ( $args['intro_text'] ) : ?>
            <div class="valtas-cta-block__intro-text">
                <?php echo wp_kses_post( wpautop( $args['intro_text'] ) ); ?>
            </div>
        <?php endif; ?>
    </div>
<?php endif; ?>
<div class="team-feed container py-5">

    <div class="row g-4">
        <?php
        $division = $args['team_division'];
        $args = array(
            'post_type'      => 'team-member',
            'posts_per_page' => -1,
            'orderby'        => 'menu_order',
            'order'          => 'ASC',
                'tax_query' => array(
                    array(
                        'taxonomy' => 'division',
                        'field'    => 'slug', 
                        'terms'    => $division, 
                    ),
                ),
        );
        $team_query = new WP_Query($args);

        if ( $team_query->have_posts() ) :
            while ( $team_query->have_posts() ) : $team_query->the_post();

                $photo     = get_field('team_photo');
                $position  = get_field('team_position');
                $linkedin  = get_field('team_linkedin');
                $email     = get_field('team_email');
                $image_url = $photo ? $photo['url'] : get_the_post_thumbnail_url(get_the_ID(), 'medium');
                ?>
                
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <div class="card team-member-card border-0">
                        <div class="team-member-image">
                            <?php if ( $image_url ) : ?>
                                <img src="<?php echo esc_url($image_url); ?>" alt="<?php the_title(); ?>" class="card-img-top">
                            <?php endif; ?>
                        </div>
                        <div class="team-member-info">
                            <h5 class="card-title"><?php the_title(); ?></h5>
                             <?php if ( $position ) : ?>
                                <p class="mb-2"><?php echo esc_html( $position ); ?></p>
                            <?php endif; ?>
                            <div class="team-buttons row">
                                <div class="col-8">
                                        <div class="btn-valtas">
                                            <a href="#" target="_self" class="btn btn-primary">Learn More</a>
                                        </div>    
                                    </div>
                                    <div class="col-4 d-flex gap-2 align-items-center">
                                        <?php if ( $linkedin ) : ?>
                                            <a href="<?php echo esc_url($linkedin); ?>" target="_blank" rel="noopener" class="socials"><img src="<?php echo get_template_directory_uri() . '/img/linkedin.svg'?>"></a>
                                        <?php endif; ?>
                                        <?php if ( $email ) : ?>
                                            <a href="mailto:<?php echo antispambot($email); ?>" class="socials"><img src="<?php echo get_template_directory_uri() . '/img/email.svg'?>"></a>
                                        <?php endif; ?>
                                    </div>        
                                </div>
                            </div>        
                        </div>
                </div>

            <?php endwhile;
            wp_reset_postdata();
        else :
            echo '<p>No team members found.</p>';
        endif;
        ?>
    </div>
</div>
