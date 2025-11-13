<?php
$default = array(
    "title" => get_sub_field('title'),
    "text"  => get_sub_field('text'),
    "logos" => get_sub_field('logos'),
);

$args = wp_parse_args($args ?? [], $default);
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.css" integrity="sha512-wR4oNhLBHf7smjy0K4oqzdWumd+r5/+6QO/vDda76MW5iug4PT7v86FoEkySIJft3XA0Ae6axhIvHrqwm793Nw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick-theme.css" integrity="sha512-6lLUdeQ5uheMFbWm3CP271l14RsX1xtx+J5x2yeIDkkiBpeVTNhTqijME7GgRKKi6hCqovwCoBTlRBEC20M8Mg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<div class="logo-carousel to-fade py-4" data-delay="0.1">
    <div class="container">
        <div class="logo-center">
            <?php foreach ($args['logos'] as $logo) : ?>
                
                    <img
                        src="<?php echo esc_url($logo['url']); ?>"
                        class="logo-carousel-image"
                        alt="<?php echo esc_attr($logo['alt'] ?: 'Logo'); ?>">
                
            <?php endforeach; ?>
        </div>
    </div>
</div>


<script type="text/javascript" src="https://code.jquery.com/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="https://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.js"></script>
<script>
    $('.logo-center').slick({
        centerMode: true,
        centerPadding: '60px',
        slidesToShow: 4,
        autoplay: true,
        responsive: [
            {
            breakpoint: 768,
            settings: {
                arrows: false,
                centerMode: true,
                centerPadding: '40px',
                slidesToShow: 2
            }
            },
            {
            breakpoint: 480,
            settings: {
                arrows: false,
                centerMode: true,
                centerPadding: '40px',
                slidesToShow: 2
            }
            }
        ]
        });
</script>   

<style>
    .slick-track{
        display: flex !important;
        align-items: center;
    }
    .slick-slide {
        height: inherit !important;
    }
    .slick-slide div {
        padding: 1em;
        display: flex;
    }
    .slick-slide img {
        max-height: 77px;
        width: auto !important;
        margin: auto;
        filter: grayscale(1);
    }
    @media(max-width: 768px) {
        .slick-slide img {
            max-height: 45px;
        }
        .slick-slide div {
            padding: 0.5em;
        }
    }
</style>