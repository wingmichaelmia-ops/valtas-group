jQuery(document).ready(function($) {
    function fetchFilteredPosts() {
        let selectedYears = [];

        $('#year-filter-form .year-checkbox:checked').each(function() {
            const value = $(this).val();
            if (value !== 'all') {
                selectedYears.push(value);
            }
        });

        // Handle "All" behavior — if none selected or "all" checked
        if (selectedYears.length === 0 || $('#year-all').is(':checked')) {
            selectedYears = ['all'];
        }

        $.ajax({
            url: valtas_ajax.ajax_url,
            type: 'POST',
            data: {
                action: 'filter_posts_by_year',
                years: selectedYears,
            },
            beforeSend: function() {
                $('.blog-items').addClass('loading').css('opacity', '0.5');
            },
            success: function(response) {
                $('.blog-items').html(response).removeClass('loading').css('opacity', '1');
            }
        });
    }

    // Checkbox behavior
    $('#year-filter-form').on('change', '.year-checkbox', function() {
        // If "All" checked → uncheck others
        if ($(this).val() === 'all') {
            $('#year-filter-form .year-checkbox').not(this).prop('checked', false);
        } else {
            $('#year-all').prop('checked', false);
        }

        fetchFilteredPosts();
    });
});
