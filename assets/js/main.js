$(document).ready(function(){
    $('.add-wishlist').on('click', function() {
        $(this).toggleClass('active');

        var accId = $(this).attr('data-acc-id');
        var status = $(this).hasClass('active') ? true : false;
        var data = {
            acc_id: accId,
            status: status
        };

        $.ajax({
            url: '/kawasaki/page/user_wishlist',
            dataType: 'json',
            type: 'POST',
            data: data,
            success: function (response) {
                console.log(response);
            },
            error: function (err) {
                // alert('There is something wrong on server, please contact our adminstrator!');
            }
        });
    });
});