<?php if ( current_user_can( 'administrator' ) ) : ?>
    <div class="d-block w-100 position-relatve bg-danger">
        <div class="container">
            <div class="row">
                <div class="col col-12">
                    <p class="my-3 bg-light text-body py-2 px-3" style="border-left: 5px solid #000">
                        Block template: <span class="fw-bold">/template-parts/acf/blocks/block-<?php echo $args['block_template'] ?>.php</span> not found
                    </p>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>