<?php
/**
 * Template Name: Privacy Policy
 */

global $post;

get_header();
?>
<style>
    .pp-header-title {
        min-height: 60dvh;
        display: flex;
        align-items: center;
        background: url(<?php echo esc_url(get_template_directory_uri() . '/img/login-bg.jpg') ?>);
        background-size: cover;
        background-position: bottom center;
    }
    h3 {
        font-size: clamp(1.875rem, 1.7188rem + 0.5vw, 2rem);
        color: #009FED;
        margin-bottom: 1rem;
    }
    h4 {
        font-size: 27px;
        color: #012F6B;
        margin-bottom: 1rem;
    }
    .pp-body {
        p, li {
            font-size: clamp(1.3125rem, 1.1563rem + 0.5vw, 1.4375rem);
        }
    }
</style>
<section class="pp-header-title py-5">
    <div class="container text-center" style="max-width:820px;">
        <h1>Privacy <span class="highlight">Policy</span></h1>
        <p>Nullam eget augue et mauris aliquam ornare ut sit amet diam. Sed ac dui varius, lacinia diam vitae, suscipit sapien. Curabitur eu ante vel ante elementum porta. </p>
    </div>
</section>
<section class="pp-body">
    <div class="container">
        <?php the_content() ?>
    </div>
</section>

<?php get_footer(); ?>