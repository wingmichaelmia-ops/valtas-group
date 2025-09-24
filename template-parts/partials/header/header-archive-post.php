<div class="padding-normal news-header pb-4">
    <div class="container pb-4">
        <div class="row align-items-end">
            <div class="col col-12 col-md-8">
                <?php
                    $title = "Our latest news and articles, including advice for making a claim and our recent legal case outcomes";
                    if ( is_category() || is_tag() ) {
                        $title = get_the_archive_title();
                    }
                ?>
                <h1 class="h3"><?php echo $title ?></h1>
            </div>
            <div class="col col-12 col-md-4 text-center text-md-end">
                <select class="mt-4 mt-md-0 w-100 w-md-auto ms-md-auto cat-filter select-redirect form-control">
                    <option value="">Choose topic</option>
                    <?php
                        $categories = get_categories();
                        foreach($categories as $category) {
                            echo '<option value="' . get_category_link($category->term_id) . '">' . $category->name . '</option>';
                        }
                        echo '<option value="'.esc_url(get_permalink(get_option('page_for_posts'))).'">Show all</option>'
                    ?>
                </select>
            </div>
        </div>
    </div>
</div>