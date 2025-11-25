<?php
/* Template Name: Lost Password */

if ( isset($_POST['user_login']) ) {
    $user_login = sanitize_text_field($_POST['user_login']);

    $result = retrieve_password($user_login);

    if ( $result === true ) {
        wp_redirect(add_query_arg('status', 'sent', home_url('/login/lost-password/')));
        exit;
    } else {
        wp_redirect(add_query_arg('status', 'error', home_url('/login/lost-password/')));
        exit;
    }
}

get_header();
?>

<div class="custom-login-wrapper">
    <div class="custom-login-wrapper-inner">
    <h2 class="h4 mb-2 fw-bold text-primary">Reset Your Password</h2>

    <?php if ( isset($_GET['status']) && $_GET['status'] === 'sent' ) : ?>
        <div style="color:green;margin-bottom:15px;">
            Check your email for the password reset link.
        </div>
    <?php endif; ?>

    <?php if ( isset($_GET['status']) && $_GET['status'] === 'error' ) : ?>
        <div style="color:red;margin-bottom:15px;">
            We couldn’t find a user with that email or username.
        </div>
    <?php endif; ?>

    <form method="post" action="" id="custom-login-form">
        <input type="text" name="user_login" id="user_login" placeholder="Username or Email" class="form-control" required>

        <button type="submit" class="btn btn-primary w-100">
            Send Reset Link
        </button>
    </form>

    <p style="margin-top:20px;">
        <a href="<?php echo home_url('/login/'); ?>">← Back to Login</a>
    </p>
    </div>
</div>

<?php get_footer(); ?>
