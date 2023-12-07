window.addEventListener("load", function () {
    var url = window.location.origin;

    function like() {
        $('.btn-like').unbind('click').click(function () {
            console.log('dislike');
            //$(this).replaceWith('<p class="btn btn-dislike"><i class="fal fa-heart fa-2x"></i></p>');
            $(this).removeClass('.btn-like');
            $(this).addClass('btn-dislike');
            $(this).children().replaceWith('<i class="fal fa-heart fa-2x"></i>');

            $.ajax({
                url: url + '/dislike/' + $(this).data('id'),
                type: 'GET',
                success: function (response) {
                    console.log(response);
                }
            });

            dislike();
        })
    }
    like();

    function dislike() {
        $('.btn-dislike').unbind('mousedown').mousedown(function () {
            console.log('like');
            //$(this).replaceWith('<p class="btn btn-like"><i class="fas fa-heart fa-2x"></i></p>');
            $(this).removeClass('.btn-dislike');
            $(this).addClass('btn-like');
            $(this).children().replaceWith('<i class="fas fa-heart fa-2x"></i>');

            $.ajax({
                url: url + '/like/' + $(this).data('id'),
                type: 'GET',
                success: function (response) {
                    console.log(response);
                }
            });

            like();
        })

    }
    dislike();

});