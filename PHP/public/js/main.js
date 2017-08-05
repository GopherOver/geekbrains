function Container(id) {
    this.id = id;
    this.htmlCode = '';
}

Container.prototype.render = function () {
    return this.htmlCode;
};

function Basket() {
    Container.call(this, 'cart');

    this.cartCount = 0;
    this.cartAmount = 0;

    this.cartItems = [];
    this.collectcartItems(); //Загружаем товары, которые уже добавлены (json файле)
}

Basket.prototype = Object.create(Container.prototype);
Basket.prototype.constructor = Basket;

Basket.prototype.render = function(root){
    var basketDiv = $('<div />', {
        id: this.id
        //text: 'Корзина'
    });

    var cartItemsDiv = $('<div />', {
        id: this.id + '_items'
    });

    cartItemsDiv.appendTo(basketDiv);
    basketDiv.appendTo(root);
};

Basket.prototype.add = function(product, quantity){
    var data = {
        "data": {
            "id_product": product,
            "quantity": quantity
        }
    };

     var self = this;

    $.post( "/cart/add", data).done(function( data ) {
        data = $.parseJSON(data);

        if(data.error) {
            console.log( "Error: " + data.errorMessage );
            return false;
        }

        for (var i = 1; i <= quantity; i++)
        {
            self.cartCount++;
        }

        self.cartAmount += data.item.price;
        self.cartItems.push(data.item);
        self.refresh();

    });
};

Basket.prototype.set = function(id_product, cart_id, quantity){

    if (quantity <= 0)
        return;

    var data = {
        "data": {
            "cart_id": cart_id,
            "cartAmount": quantity
        }
    };

    var self = this;

    $.ajax({
        url: "/cart/change",
        method: "POST",
        dataType: "html",
        data: data,
        success: function () {
            self.cartItems.map(function (i, p) {
                if(i.id === id_product) {

                    if (i.amount < quantity) {
                        c = quantity - i.amount;
                        i.amount += c;
                        self.cartCount += c;
                        i.subtotal = i.amount * i.product_price;
                        self.cartAmount += c * i.product_price;
                    }

                    if (i.amount > quantity) {
                        c = i.amount - quantity;
                        i.amount -= c;
                        self.cartCount -= c;
                        i.subtotal = i.amount * i.product_price;
                        self.cartAmount -= c * i.product_price;
                    }
                }
                return true;
            });
            self.refresh();
        },
        error: function (error) {
            console.log('error:', error);
        }
    });
};

Basket.prototype.remove = function(cart_id){


    if (cart_id <= 0)
        return;

    var data = {
        "data": {
            "cart_id": cart_id
        }
    };

    var self = this;

    $.ajax({
        url: "/cart/del",
        method: "POST",
        dataType: "html",
        data: data,
        success: function () {
            self.cartItems.map(function (t, p) {
                if (t.cart_id === cart_id) {
                    self.cartCount -= t.amount;
                    self.cartAmount -= t.subtotal;
                    self.cartItems.splice(p, 1);
                }
            });

            self.refresh();
        },
        error: function (error) {
            console.log('error:', error);
        }
    });
};

Basket.prototype.clearCart = function(){

    var self = this;
    $.ajax({
        url: "/cart/clear",
        method: "POST",
        dataType: "html",
        data: "",
        success: function () {
            self.cartAmount = self.cartCount = self.cartItems = 0;
            self.refresh();
        },
        error: function (error) {
            console.log('error:', error);
        }
    });
};

Basket.prototype.refresh = function () {
    this.makeCartIcon();
    this.makeCartList();
};

Basket.prototype.makeCartIcon = function () {
    var cart = "";

    $('#cart').empty();
    cart += '<div class="cart" amount="'+ this.cartCount +'">';
    cart += '<a href="/user/cart"><i class="fa fa-shopping-basket fa-2x cart" aria-hidden="true"></i></a>';
    cart += '</div>';
    $('#cart').append(cart);
};

Basket.prototype.makeCartList = function (data) {
    var appendId = '#' + this.id + '_items';
    var out = "";
    var cartData = $('#cart_data');

    if (!cartData.length){
        cartData = $('<div />', {
            id: 'cart_data'
        });
    }

    if (!data)
        data = this;

    cartData.empty();

    if (!data.cartItems.length) {
        $('.cart-actions').remove();
        out += '<div class="col-xs-12 text-center"><h3>Cart is empty :\'(</h3><a href="/shop" class="btn btn-lg btn-default">START SHOPPING</a></div>';
    } else {

        if(data !== this)
            this.cartCount = data.cartLength;

        this.cartAmount = data.cartAmount;

        out += '<table class="table table-responsive cart-table"><thead><tr><th>PRODUCT DETAILS</th><th>UNITE PRICE</th><th>QUANTITY</th><th>SHIPPING</th><th>SUBTOTAL</th><th>ACTION</th></tr></thead><tbody>';

        for (var index in data.cartItems){

            out += '<tr><th><a href="/shop?product=' + data.cartItems[index].id + '"><div class="cart-image">';
            out += '<img src="/img/'+ data.cartItems[index].img_src +'" alt="" class="cart-image">';
            out += '</div><div class="cart-details">';
            out += '<h5>'+ data.cartItems[index].name +'</h5>';
            out += '<p>Color: '+ data.cartItems[index].color +'</p>';
            out += '<p>Size: '+ data.cartItems[index].size +'</p>';
            out += '</div></a></th>';
            out += '<th><i class="fa fa-usd" aria-hidden="true"></i>'+ data.cartItems[index].product_price +'</th>';
            out += '<th><div class="form-group col-xs-offset-3 col-xs-6">';
            //out += '<input type="number" class="form-control cart_amount" min="1" value="'+ data.cartItems[index].amount +'" data-content="'+ data.cartItems[index].cart_id +'">';
            out += '<input type="number" class="form-control cart_amount" min="1" value="'+ data.cartItems[index].amount +'" id_product="'+ data.cartItems[index].id +'" cart_id="'+ data.cartItems[index].cart_id +'">';
            out += '</div></th><th>FREE</th>';
            out += '<th>'+ data.cartItems[index].subtotal +'</th>';
            out += '<th><span class="glyphicon glyphicon-remove-circle cart-del" cart_id="'+ data.cartItems[index].cart_id +'" aria-hidden="true"></span></th></tr>';

            if(data !== this)
                this.cartItems.push(data.cartItems[index]);
        }

        $("#subtotal").text(data.cartAmount);
        $("#grandtotal").text(data.cartAmount);

        out += '</tbody></table>';
    }

    cartData.append(out);
    cartData.appendTo(appendId);

};

Basket.prototype.collectcartItems = function () {
    var self = this;

    $.getJSON( "/cart/get", function( data ) {
        self.makeCartList(data);
        self.makeCartIcon();
    });
};

$(document).ready(function () {
    var basket = new Basket();
    basket.render('#cart_wrapper');

    $('.cart-add-click').click( function () {
        var idProduct = parseInt($(this).attr('data-content'));
        var quantity = 1;
        $(this).parent().parent().parent().parent().effect('bounce');

        if (idProduct && quantity)
            basket.add(idProduct, quantity);
    });

    $(".cart-del").live("click",function () {
        var cart_id = parseInt($(this).attr('cart_id'));

        if (cart_id)
            basket.remove(cart_id);
    });

    $('.cart-clear').live("click", function () {
        basket.clearCart();
    });

    $('.cart_amount').live("keyup keydown change", function () {
        var cartAmount = parseInt($(this).val());
        var cart_id = parseInt($(this).attr('cart_id'));
        var id_product = parseInt($(this).attr('id_product'));

        if(id_product, cart_id, cartAmount)
            basket.set(id_product, cart_id, cartAmount);

    });
});

// возвращаем метод .live() (deprecated jQuery 1.7+)
jQuery.fn.extend({
    live: function (event, callback) {
        if (this.selector) {
            jQuery(document).on(event, this.selector, callback);
        }
    }
});
