<script>
    $(document).ready(function() {

        // Product data to be used in shop and in cart
        var products = {
            @foreach($prodInfo->where('PROD_IS_APPROVED',1) as $item)
            '{{$item->PROD_NAME}}' : ['{{$item->PROD_NAME}}'
                ,'{{$item->PROD_DESC}}',
                {{ number_format( (($item->PROD_REBATE/100)* $item->PROD_BASE_PRICE)
                                      +(($item->rTaxTableProfile->TAXP_TYPE==0)?($item->rTaxTableProfile->TAXP_RATE/100)* $item->PROD_BASE_PRICE:($item->rTaxTableProfile->TAXP_RATE)+ $item->PROD_BASE_PRICE)
                                      +(($item->PROD_MARKUP/100)* $item->PROD_BASE_PRICE)+$item->PROD_BASE_PRICE,2,'.','' ) }}
                ,'{{($item->PROD_IMG==null||!file_exists($item->PROD_IMG))?asset('uPackage.png'):asset($item->PROD_IMG)}}'
                ,{{$item->PROD_ID}}],
            @endforeach
        };

        // Populates shop with items based on template and data in var products

        var $shop = $('.shop');
        var $cart = $('.cart-items');

        for(var item in products) {
            var itemName = products[item][0],
                itemDescription = products[item][1],
                itemPrice =  products[item][2],
                itemImg = products[item][3],
                itemId = products[item][4],
                $template = $($('#productTemplate').html());

            $template.find('h1').text(itemName);
            $template.find('p').text(itemDescription);
            $template.find('.price').text('₱' + itemPrice);

            $template.find('.direct').html("<div class='directgift' onclick='direct("+parseFloat(products[item][2]).toFixed(2).split('.').join("")+"0"+",&quot "+itemName+"&quot,"+itemId+")' >Direct Gift</div>");

            $template.css('background-image', 'url(' + itemImg + ')');

            $template.data('id', itemId);
            $template.data('name', itemName);
            $template.data('price', itemPrice);
            $template.data('image', itemImg);

            $shop.append($template);
        }

        // Checks quantity of a cart item on input blur and updates total
        // If quantity is zero, item is removed

        $('body').on('blur', '.cart-items input', function() {
            var $this = $(this),
                $item = $this.parents('li');
            if (+$this.val() === 0) {
                $item.remove();
            } else {
                calculateSubtotal($item);
            }
            updateCartQuantity();
            calculateAndUpdate();
        });

        // Add item from the shop to the cart
        // If item is already in the cart, +1 to quantity
        // If not, creates the cart item based on template

        $('body').on('click', '.product .add', function() {
            var items = $cart.children(),
                $item = $(this).parents('.product'),
                $template = $($('#cartItem').html()),
                $matched = null,
                quantity = 0;

            $matched = items.filter(function(index) {
                var $this = $(this);
                return $this.data('id') === $item.data('id');
            });

            if ($matched.length) {
                quantity = +$matched.find('.quantity').val() + 1;
                $matched.find('.quantity').val(quantity);
                calculateSubtotal($matched);
            } else {
                $template.find('.cart-product').css('background-image', 'url(' + $item.data('image') + ')');
                $template.find('h3').text($item.data('name'));
                $template.find('.subtotal').text('₱' + $item.data('price'));

                $template.data('id', $item.data('id'));
                $template.data('price', $item.data('price'));
                $template.data('subtotal', $item.data('price'));

                $cart.append($template);
            }

            updateCartQuantity();
            calculateAndUpdate();
        });

        // Calculates subtotal for an item

        function calculateSubtotal($item) {
            var quantity = $item.find('.quantity').val(),
                price = $item.data('price'),
                subtotal = quantity * price;
            $item.find('.subtotal').text('₱' + subtotal);
            $item.data('subtotal', subtotal);
        }

        // Clicking on the cart link opens up the shopping cart

        var $cartlink = $('.cart-link'), $wrap = $('#wrap');

        $cartlink.on('click', function() {
            $cartlink.toggleClass('active');
            $wrap.toggleClass('active');
            return false;
        });

        // Clicking outside the cart closes the cart, unless target is the "Add to Cart" button

        $wrap.on('click', function(e){
            if (!$(e.target).is('.add')) {
                $wrap.removeClass('active');
                $cartlink.removeClass('active');
            }
        });

        // Calculates and updates totals, taxes, shipping

        function calculateAndUpdate() {
            var subtotal = 0,
                items = $cart.children(),
                // shipping not applied if there are no items
                //shipping = items.length > 0 ? 5 : 0,
                shipping =0
                tax = 0;
            items.each(function(index, item) {
                var $item = $(item),
                    price = $item.data('subtotal');
                subtotal += price;
            });
            //subtotal

            $('.subtotalTotal span').text(formatDollar(subtotal));

             //tax = subtotal * .05;
            tax = 0;
            $('.taxes span').text(formatDollar(0));

            //shipping
            $('.shipping span').text(formatDollar(0));

            var finalTotal = subtotal + tax + shipping;
            $('.finalTotal').html("Total\n" +
                    "<span id=finalTotal vals="+parseFloat(finalTotal).toFixed(2).split('.').join("")+">"+formatDollar(finalTotal)+"</span>");
        }

        //  Update the total quantity of items in notification, hides if zero

        function updateCartQuantity() {
            var quantities = 0,
                $cartQuantity = $('span.cart-quantity'),
                items = $cart.children();
            items.each(function(index, item) {
                var $item = $(item),
                    quantity = +$item.find('.quantity').val();
                quantities += quantity;
            });
            if(quantities > 0){
                $cartQuantity.removeClass('empty');
            } else {
                $cartQuantity.addClass('empty');
            }
            $cartQuantity.text(quantities);
        }


        //  Formats number into dollar format

        function formatDollar(amount) {
            return '₱' + parseFloat(Math.round(amount * 100) / 100).toFixed(2);
        }

        // Restrict the quantity input field to numbers only

        $('body').on('keypress', '.cart-items input', function (ev) {
            var keyCode = window.event ? ev.keyCode : ev.which;
            if (keyCode < 48 || keyCode > 57) {
                if (keyCode != 0 && keyCode != 8 && keyCode != 13 && !ev.ctrlKey) {
                    ev.preventDefault();
                }
            }
        });

        // Trigger animation on Add to Cart button click

        $('.addtocart').on('click', function () {
            $(this).addClass('active');
            setTimeout(function () {
                $('.addtocart').removeClass('active');
            }, 1000);
        });

        // Trigger error animation on Checkout button

        // $('.checkout').on('click', function () {
        //     $(this).addClass('active');
        //     $('.error').css('display', 'block');
        //     setTimeout(function () {
        //         $('.checkout').removeClass('active');
        //         $('.error').css('display', 'none');
        //     }, 1000);
        // });

    });
</script>