$(function () {
    $.ajax({
        url: "Ajax/getTeaser",
        context: document.body
    }).success(function (data) {
        $('.trips-teaser-container').html(data);
        displayTeaser();
    });

    function displayTeaser() {
        var items = [];

        $('.teaser-element').each(function (i, e) {
            items.push($(e));
        });

        (function recurse(counter) {
            var item = items[counter];
            $(item).fadeIn('slow');
            delete items[counter];
            items.push(item);
            setTimeout(function () {
                $('.teaser-element').fadeOut('slow');
                recurse(counter + 1);
            }, 6000);
        })(0);
    }
});
