const $ = require('jquery');
const $category = $('#item_category');

//on category change try to get genres for selected category
$category.change(() => {

    // init data
    const $form = $category.closest('form'),
        $item = $('#item_genre'),
        data = {}; // init an empty object

    // disable temporary genre selectbox
    $item.attr('disabled', true);

    // get category value
    data[$category.attr('name')] = $category.val();
    console.log($category.val());
    $.ajax({
        url: $form.attr('action'),
        type: $form.attr('method'),
        data: data,
        success: (html) => $('#item_genre').replaceWith($(html).find('#item_genre')), // replace dom el. with selectbox from response
        error: () => $item.attr('disabled', false) // on error enable genre again
    });
});