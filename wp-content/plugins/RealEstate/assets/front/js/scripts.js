jQuery(document).ready(function($) {

    $('.real-estate-filter-btn').on('click', function () {
        data = {
            action: 'real_estate_filter_results',
            name: $('#real-estate-name').val(),
            coordinates: $('#real-estate-coordinates').val(),
            floors: $('#real-estate-floors').val(),
            building_type: $('[name="real-estate-building-type"]:checked').val(),
            ecology: $('#real-estate-ecology').val(),
        }

        send_ajax_real_estate(data);

    });

    $(document).on('click', '.real-estate-pagination a', function (event) {
        event.preventDefault();
        event.stopPropagation();
        console.log($(this).attr('href'));
        var paginationOptions = ('.real-estate-pagination');

        data = {
            action: 'real_estate_filter_results',
            name: $(paginationOptions).data('name'),
            coordinates: $(paginationOptions).data('coordinates'),
            floors: $(paginationOptions).data('floors'),
            building_type: $(paginationOptions).data('buldingType'),
            ecology: $(paginationOptions).data('ecology'),
            page: $(this).attr('href'),
        };

        send_ajax_real_estate(data);
    });

    function send_ajax_real_estate(data) {

        $('.real-estate-filter-btn').addClass('disabled');

        $.ajax({
            url: refilter_ajax_object.ajax_url, // this is the object instantiated in wp_localize_script function
            data: data,
            type: 'POST',
            success: function( success_data ) {
                console.log( success_data );
                $('.real-estate-filter-results').html( success_data );
                $('.real-estate-filter-btn').removeClass('disabled');
            },
        });
    }

});
