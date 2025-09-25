<?php

$default = array(
    "title"     => get_sub_field( 'title' ) ?: "Please enter title",
    "tabs"      => get_sub_field( 'tabs' ) ?: false,
);

$args = wp_parse_args( $args, $default );
?>

<div class="block-tabs padding-normal to-fade" data-delay="0.1">
    <div class="container">
        <div class="row">
            <div class="col col-12 to-fade" data-delay="0.2">
                <?php if ($args['title']) { ?>
                    <h2 class="h2"><?php echo $args['title']; ?></h2>
                <?php } ?>

                <?php if ($args['tabs']) { ?>
                <div class="tab to-fade" data-delay="0.3">
                    <ul class="nav mb-4" id="pills-tab" role="tablist">
                        <?php foreach($args['tabs'] as $key => $tab) { ?>
                        <li class="nav-item <?php if ($key == 0) echo 'active'; ?>" role="presentation">
                            <button class="h3 nav-link <?php if ($key == 0) echo 'active'; ?>" data-bs-toggle="pill" data-bs-target="#tab-<?php echo $key ?>" type="button"><?php echo $tab['heading'] ?></button>
                        </li>
                        <?php } ?>
                    </ul>
                    <div class="tab-content" id="pills-tabContent">
                        <?php foreach($args['tabs'] as $key => $tab) { ?>
                        <div class="tab-pane fade <?php if ($key == 0) echo 'show active'; ?>" id="tab-<?php echo $key ?>" role="tabpanel"><?php echo $tab['content']; ?></div>
                        <?php } ?>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>