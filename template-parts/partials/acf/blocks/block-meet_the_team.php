<?php

$default = array(
    "title"        => get_sub_field( 'title' ) ?: false,
    "content"      => get_sub_field( 'content' ) ?: false,
    "team_members" => get_sub_field( 'team_members' ),
    "alignment"    => get_sub_field( 'alignment' ) ?: "start",
);

$args = wp_parse_args( $args, $default );

?>

<div class="meet-the-team padding-normal to-fade" data-delay="0.1">
    <div class="container">
        <div class="row to-fade" data-delay="0.2">
            <div class="col col-12">
                <div class="text-md-<?php echo $args['alignment'] ?>">
                    <?php if ($args['title']) { ?>
                        <h2 class="h2 text-<?php echo $args['alignment'] ?>"><?php echo $args['title']; ?></h2>
                    <?php } ?>
                    <?php if ($args['content']) { ?>
                        <p class="h4"><?php echo $args['content']; ?></p>
                    <?php } ?>
                </div>
            </div>
        </div>

        <?php if ($args['team_members']) { ?>
        <div class="team-members mt-5 row to-fade" data-delay="0.3">
            <?php foreach ($args['team_members'] as $team_member) :
                $team_member = $team_member['team_member'];
                $team_member_photo = get_the_post_thumbnail_url($team_member->ID);
            ?>
            <div class="team-member col-12 col-lg-4 mb-5 mb-lg-0">
                <div>
                    <div class="team-member-photo mb-4" style="background-image: url(<?php echo $team_member_photo; ?>);"></div>
                    <h3 class="h3 mb-3"><?php echo $team_member->post_title; ?></h3>
                    <p class="mb-4"><?php echo get_field('position', $team_member->ID); ?></p>
                    <div class="team-info d-flex justify-content-between pb-4 mb-4">
                        <div>
                            <?php if (get_field('contact_number', $team_member->ID)) { ?>
                            <a class="contact-number fw-bold d-flex mb-3" href="tel:<?php echo get_field('contact_number', $team_member->ID); ?>">
                                <span class="icon icon-Phone me-3 align-middle"></span>
                                <span class="align-middle"><?php echo get_field('contact_number', $team_member->ID); ?></span>
                            </a>
                            <?php } ?>
                            
                            <?php if (get_field('email_address', $team_member->ID)) { ?>
                            <a class="email-address fw-bold d-flex" href="mailto:<?php echo get_field('email_address', $team_member->ID); ?>">
                                <span class="icon icon-Email me-3 align-middle"></span>
                                <span class="align-middle"><?php echo get_field('email_address', $team_member->ID); ?></span>
                            </a>
                            <?php } ?>
                        </div>

                        <?php if (get_field('linkedin', $team_member->ID)) { ?>
                        <a class="linkedin fw-bold d-inline-block" href="<?php echo get_field('linkedin', $team_member->ID); ?>" target="_blank"><span class="icon icon-Linked-In"></span></a>
                        <?php } ?>
                    </div>
                    
                    <?php if (get_field('about_me', $team_member->ID)) { ?>
                    <div>
                        <?php echo get_field('about_me', $team_member->ID); ?>
                    </div>
                    <?php } ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php } ?>
    </div>
</div>