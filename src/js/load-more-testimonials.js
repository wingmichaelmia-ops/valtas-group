jQuery(document).ready(function ($) {
    const wrapper = $(".testimonials-masonry-wrapper");

    $(document).on("click", ".load-more-testimonials", function () {
        const button = $(this);
        const container = wrapper.find(".masonry-grid");
        const loadMoreContainer = $("#load-more-container");

        let page = parseInt(button.attr("data-page")) + 1;
        const perPage = wrapper.data("per-page");
        const postType = wrapper.data("post-type");
        const terms = wrapper.data("tax-terms");

        $.ajax({
            url: ajaxurl,
            type: "POST",
            data: {
                action: "load_more_testimonials",
                page: page,
                per_page: perPage,
                post_type: postType,
                terms: terms,
            },
            beforeSend: function () {
                button.text("Loading...");
            },
            success: function (res) {
                if (res.trim() !== "") {
                    // Append new posts
                    container.append(res);
                    button.attr("data-page", page).text("Load More");
                } else {
                    // No more posts — hide the container
                    loadMoreContainer.fadeOut(300);
                }
            },
            error: function () {
                button.text("Error");
            },
        });
    });
});
