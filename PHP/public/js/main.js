$('.cart-add').on('click', function () {
    var product_id = $(this).data('content');

    var dataString = {
        id: product_id
    };

    $.ajax({
        url: "/cart/add",
        method: "POST",
        dataType: "html",
        data: { data: JSON.stringify(dataString) },
        success: function (response) {
            console.log('success:', response);
        },
        error: function (error) {
            console.log('error:', error);
        }
    });
});

$('.cart-clear').on('click', function () {

    $.ajax({
        url: "/cart/clear",
        method: "POST",
        dataType: "html",
        data: '',
        success: function (response) {
            location.reload();
        },
        error: function (error) {
            console.log('error:', error);
        }
    });
});

$('.cart-del').on('click', function () {
    var product_id = $(this).data('content');

    var dataString = {
        id: product_id
    };

    $.ajax({
        url: "/cart/del",
        method: "POST",
        dataType: "html",
        data: { data: JSON.stringify(dataString) },
        success: function () {
            location.reload();
        },
        error: function (error) {
            console.log('error:', error);
        }
    });
});

var timer;

$('.cart_amount').on('change', function () {
    clearTimeout(timer);
    var amount = $(this).val();
    var cart_id = $(this).data('content');

    var dataString = {
        cart_id: cart_id,
        amount: amount
    };


    timer = setTimeout(function() {
        $.ajax({
            url: "/cart/change",
            method: "POST",
            dataType: "html",
            data: { data: JSON.stringify(dataString) },
            success: function () {
                location.reload();
            },
            error: function (error) {
                console.log('error:', error);
            }
        });
    }, 3000);

   console.log(amount);
});