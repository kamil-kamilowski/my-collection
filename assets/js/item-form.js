var $ = require('jquery');

var $category = $('#item_category');
// When sport gets selected ...
$category.change(function () {
    // ... retrieve the corresponding form.
    var $form = $(this).closest('form');
    // Simulate form data, but only include the selected sport value.
    var data = {};
    data[$category.attr('name')] = $category.val();
    // Submit data via AJAX to the form's action path.
    $.ajax({
        url: $form.attr('action'),
        type: $form.attr('method'),
        data: data,
        success: function (html) {
            // Replace current position field ...
            $('#item_genre').replaceWith(
                // ... with the returned one from the AJAX response.
                $(html).find('#item_genre')
            );
            // Position field now displays the appropriate positions.
        }
    });
});