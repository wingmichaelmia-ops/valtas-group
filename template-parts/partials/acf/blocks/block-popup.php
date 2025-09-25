<?php

    $default = array(
        "header"        => get_sub_field( 'header' ),
        "body"          => get_sub_field( 'body' ),
        "trigger"       => get_sub_field( 'trigger' )
    );

    $args = wp_parse_args( $args, $default );

?>

<div class="modal modal-xl fade" data-trigger="<?php echo $args['trigger'] ?>" tabindex="-1" id="modal-<?php echo $args['block_id'] ?>">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <?php if ( $args['header'] ) : ?>
                <div class="modal-header">
                    <h5 class="modal-title">Modal title</h5>
                </div>
            <?php endif; ?>
            <div class="modal-body">
                <?php echo $args['body'] ?>
            </div>
            
            <button type="button" data-bs-dismiss="modal" aria-label="Close" class="p-4 border-0 bg-transparent text-decoration-none text-body opacity-75 position-absolute text-primary d-inline-flex align-items-center top-0 end-0">
                <i class="icon-Cross"></i> <small class="text-uppercase ms-2">Close</small>
            </button>
        </div>
    </div>
</div>