<?php get_header(); ?>

<?php
$image_url = get_the_post_thumbnail_url(get_the_ID(), 'large');
$position  = get_field('position');
$linkedin  = get_field('linkedin');
$email     = get_field('email');
$bio       = get_field('bio'); // or the_content() if bio is editor field
$resume    = get_field('resume');

$photo     = get_field('team_photo');
$position  = get_field('team_position');
$linkedin  = get_field('team_linkedin');
$email     = get_field('team_email');
$bio     = get_field('team_bio');
$image_url = $photo ? $photo['url'] : get_the_post_thumbnail_url(get_the_ID(), 'medium');
$resume    = get_field('team_resume');
$popid = strtolower( preg_replace( '/[^a-z0-9_-]/', '', str_replace( ' ', '', get_the_title() ) ) );
?>
<div class="team-profile-popup">
    <div class="bg-primary pt-5">
        <div class="container py-5">
            <div class="row g-5 team-profile pt-5">
                <div class="col-md-4">
                    <div class="tp-image">
                        <?php if ( $image_url ) : ?>
                            <img src="<?php echo esc_url($image_url); ?>" alt="<?php the_title(); ?>" class="card-img-top">
                        <?php endif; ?>
                    </div>           
                </div>
                <div class="col-md-8">
                    <div class="row align-items-center">
                        <div class="col-md-9">
                            <?php if ( $position ) : ?>
                                <p class="tp-position"><?php echo esc_html( $position ); ?></p>
                            <?php endif; ?>
                            <h2 class="tp-name"><?php the_title(); ?></h2>
                        </div>
                        <div class="col-md-3">
                            <div class="col-lg-2">
                                <div class="d-flex gap-2">
                                    <?php if ( $linkedin ) : ?>
                                        <a href="<?php echo esc_url($linkedin); ?>" target="_blank" rel="noopener" class="socials"><img src="<?php echo get_template_directory_uri() . '/img/linkedin.svg'?>"></a>
                                    <?php endif; ?>
                                    <?php if ( $email ) : ?>
                                        <a href="mailto:<?php echo antispambot($email); ?>" class="socials"><img src="<?php echo get_template_directory_uri() . '/img/email.svg'?>"></a>
                                    <?php endif; ?>
                                </div>
                            </div>   
                        </div>
                        <div class="col-md-12">
                            <div class="tp-bio text-white">
                                <?php echo $bio; ?>
                            </div>
                            <?php if ( $resume ) : ?>   
                                <div class="btn-valtas mt-5">
                                    <a href="<?php echo $resume ?>" target="_blank" class="btn btn-primary">
                                        <?php echo esc_html( strtok( get_the_title(), ' ' ) ); ?>'s Resume
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php get_footer(); ?>
