// Add your JS customizations here
class Accordion {
	constructor(el) {
		// Store the <details> element
		this.el = el;
		// Store the <summary> element
		this.summary = el.querySelector("summary");
		// Store the <div class="content"> element
		this.content = el.querySelector(".accordion");

		// Store the animation object (so we can cancel it if needed)
		this.animation = null;
		// Store if the element is closing
		this.isClosing = false;
		// Store if the element is expanding
		this.isExpanding = false;
		// Detect user clicks on the summary element
		this.summary.addEventListener("click", (e) => this.onClick(e));
	}

	onClick(e) {
		// Stop default behaviour from the browser
		e.preventDefault();
		// Add an overflow on the <details> to avoid content overflowing
		this.el.style.overflow = "hidden";
		// Check if the element is being closed or is already closed
		if (this.isClosing || !this.el.open) {
			this.open();
			// Check if the element is being openned or is already open
		} else if (this.isExpanding || this.el.open) {
			this.shrink();
		}
	}

	shrink() {
		// Set the element as "being closed"
		this.isClosing = true;

		// Store the current height of the element
		const startHeight = `${this.el.offsetHeight}px`;
		// Calculate the height of the summary
		const endHeight = `${this.summary.offsetHeight}px`;

		// If there is already an animation running
		if (this.animation) {
			// Cancel the current animation
			this.animation.cancel();
		}

		// Start a WAAPI animation
		this.animation = this.el.animate(
			[
				// Set the keyframes from the startHeight to endHeight
				{ height: startHeight },
				{ height: endHeight },
			],
			{
				duration: 500, // Increased duration for smoother transition
				easing: "ease-in-out", // Ease-in-out for smoother animation
			}
		);

		// When the animation is complete, call onAnimationFinish()
		this.animation.onfinish = () => this.onAnimationFinish(false);
		// If the animation is cancelled, isClosing variable is set to false
		this.animation.oncancel = () => (this.isClosing = false);
	}

	open() {
		// Apply a fixed height on the element
		this.el.style.height = `${this.el.offsetHeight}px`;
		// Force the [open] attribute on the details element
		this.el.open = true;
		// Wait for the next frame to call the expand function
		window.requestAnimationFrame(() => this.expand());
	}

	expand() {
		// Set the element as "being expanding"
		this.isExpanding = true;
		// Get the current fixed height of the element
		const startHeight = `${this.el.offsetHeight}px`;
		// Calculate the open height of the element (summary height + content height)
		const endHeight = `${
			this.summary.offsetHeight + this.content.offsetHeight
		}px`;

		// If there is already an animation running
		if (this.animation) {
			// Cancel the current animation
			this.animation.cancel();
		}

		// Start a WAAPI animation
		this.animation = this.el.animate(
			[
				// Set the keyframes from the startHeight to endHeight
				{ height: startHeight },
				{ height: endHeight },
			],
			{
				duration: 500, // Increased duration for smoother transition
				easing: "ease-in-out", // Ease-in-out for smoother animation
			}
		);
		// When the animation is complete, call onAnimationFinish()
		this.animation.onfinish = () => this.onAnimationFinish(true);
		// If the animation is cancelled, isExpanding variable is set to false
		this.animation.oncancel = () => (this.isExpanding = false);
	}

	onAnimationFinish(open) {
		// Set the open attribute based on the parameter
		this.el.open = open;
		// Clear the stored animation
		this.animation = null;
		// Reset isClosing & isExpanding
		this.isClosing = false;
		this.isExpanding = false;
		// Remove the overflow hidden and the fixed height
		this.el.style.height = this.el.style.overflow = "";
	}
}

document.querySelectorAll("details").forEach((el) => {
	new Accordion(el);
});


jQuery(document).ready(function($) {
    function setActiveService() {
        var windowCenter = $(window).scrollTop() + ($(window).height() / 2);

        $('.service-item').each(function() {
            var $this = $(this);
            var itemTop = $this.offset().top;
            var itemBottom = itemTop + $this.outerHeight();

            if (itemTop < windowCenter && itemBottom > windowCenter) {
                $this.addClass('in-center');
            } else {
                $this.removeClass('in-center');
            }
        });
    }

    // Run on scroll + on page load
    $(window).on('scroll resize', setActiveService);
    setActiveService();
});

jQuery(function($) {

    function loadPosts() {
        let selected = [];

        $('.category-checkbox:checked').each(function() {
            selected.push($(this).val());
        });

        // If nothing checked OR "all" selected — use all
        if (selected.length === 0 || selected.includes("all")) {
            selected = ["all"];
        }

        $.ajax({
            url: ajax_params.ajax_url,
            type: "POST",
            data: {
                action: "filter_blog_posts",
                categories: selected
            },
            beforeSend: function() {
                $('.blog-post-wrapper').html('<p>Loading...</p>');
            },
            success: function(res) {
                $('.blog-post-wrapper').html(res);
            }
        });
    }

    // Toggle all
    $('#cat-all').on('change', function(){
        if ($(this).is(':checked')) {
            $('.category-checkbox').not(this).prop('checked', false);
            loadPosts();
        }
    });

    // Toggle individual
    $('.category-checkbox').not('#cat-all').on('change', function(){
        $('#cat-all').prop('checked', false);

        // If user unchecks all, re-check all
        if ($('.category-checkbox:checked').not('#cat-all').length === 0) {
            $('#cat-all').prop('checked', true);
        }

        loadPosts();
    });

});



document.addEventListener('DOMContentLoaded', function () {

  const dropdownLinks = document.querySelectorAll('a.dropdown-toggle');

  dropdownLinks.forEach(function (toggle) {

    let tappedOnce = false;

    toggle.addEventListener('click', function (e) {

      const href = this.getAttribute('href');
      const menu = this.nextElementSibling;
      const isDropdown = menu && menu.classList.contains('dropdown-menu');
      if (!isDropdown) return;

      const isHoverDevice = window.matchMedia('(hover: hover)').matches;

      // --- Desktop behavior ---
      if (isHoverDevice) {
        if (href && href !== '#') {
          window.location.href = href;
        } else {
          // desktop: # only toggles
          e.preventDefault();
          this.classList.toggle('show');
          menu.classList.toggle('show');
        }
        return;
      }

      // --- Mobile behavior ---

      // CASE 1 — href="#"
      if (href === '#') {
        e.preventDefault();

        if (!tappedOnce) {
          // First tap → open
          tappedOnce = true;
          this.classList.add('show');
          menu.classList.add('show');
        } else {
          // Second tap → close
          tappedOnce = false;
          this.classList.remove('show');
          menu.classList.remove('show');
        }

        return;
      }

      // CASE 2 — real URL on mobile
      if (!tappedOnce) {
        // First tap → open dropdown
        e.preventDefault();
        tappedOnce = true;
        this.classList.add('show');
        menu.classList.add('show');
      } else {
        // Second tap → follow link
        window.location.href = href;
      }

    });

  });

});

jQuery(function($){

    $('#project-load-more').on('click', function(e){
        e.preventDefault(); // stop page from jumping to top

        let button = $(this);
        let wrapper = $('#project-feed-wrapper');

        let offset     = parseInt(button.data('offset'));
        let categories = wrapper.data('categories');
        let layout     = wrapper.data('layout');

        $.ajax({
            url: ajaxurl,
            type: 'POST',
            data: {
                action: 'load_more_case_studies',
                offset: offset,
                categories: categories,
                layout: layout
            },
            beforeSend: function(){
                button.text('Loading...');
            },
            success: function(response){
                if (response) {

                    let newItems = $(response);

                    $('#project-feed-posts').append(newItems);

                    // Smooth scroll to new items
                    $('html, body').animate({
                        scrollTop: newItems.first().offset().top - 100
                    }, 600);

                    button.data('offset', offset + 4);
                    button.text('Load More');

                } else {
                    button.text('No more posts');
                    button.addClass('disabled').attr('aria-disabled', 'true');
                }
            }
        });

    });

});
