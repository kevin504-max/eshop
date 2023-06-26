$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    loadCart();
    loadWishlist();

    function loadCart()
    {
        $.ajax({
            method: "GET",
            url: "/load-cart-data",
            success: function (response) {
                $(".cart-count").html('');
                $(".cart-count").html(response.count);
            }
        })
    }

    function loadWishlist()
    {
        $.ajax({
            method: "GET",
            url: "/load-wishlist-data",
            success: function (response) {
                $(".wishlist-count").html('');
                $(".wishlist-count").html(response.count);
            }
        })
    }

    $(".addCartBtn").on("click", function(event) {
        event.preventDefault();

        var product_id = $(this).closest(".product_data").find(".product_id").val();
        var product_qty = $(this).closest(".product_data").find(".qty-input").val();

        $.ajax({
            method: "POST",
            url: "/add-to-cart",
            data: {
                "product_id": product_id,
                "quantity": product_qty ? product_qty : 1
            },
            success: function(response) {
                Swal.fire({
                    title: response.message,
                    icon: response.status,
                    showConfirmButton: false,
                    timer: 2500
                });
                loadCart();
            }
        });
    });

    $(".addToWishlistBtn").on("click", function(event) {
        event.preventDefault();

        var product_id = $(this).closest(".product_data").find(".product_id").val();

        $.ajax({
            method: "POST",
        url: "/add-to-wishlist",
        data: {
                "product_id": product_id,
            },
            success: function(response) {
                Swal.fire({
                    title: response.message,
                    icon: response.status,
                    showConfirmButton: false,
                    timer: 2500
                });
                loadWishlist();
            }
        });
    });

    $(document).on('click', '.increment-btn', function (event) {
        event.preventDefault();

        var inc_value = $(this).closest(".product_data").find(".qty-input").val();
        var value = parseInt(inc_value, 10);

        value = isNaN(value) ? 0 : value;

        if (value < 10) {
            value++;
            $(this).closest(".product_data").find(".qty-input").val(value);
        }
    });

    $(document).on('click', '.decrement-btn', function (event) {
        event.preventDefault();

        var dec_value = $(this).closest(".product_data").find(".qty-input").val();
        var value = parseInt(dec_value, 10);

        value = isNaN(value) ? 0 : value;

        if (value > 1) {
            value--;
            $(this).closest(".product_data").find(".qty-input").val(value);
        }
    });

    $(document).on('click', '.delete-cart-item', function (event) {
        event.preventDefault();

        var product_id = $(this).closest(".product_data").find(".product_id").val();

        $.ajax({
            method: "POST",
            url: "/delete-cart-item",
            data: {
                "product_id": product_id,
            },
            success: function(response) {
                Swal.fire({
                    title: response.message,
                    icon: response.status,
                    showConfirmButton: false,
                    timer: 2500
                });
                loadCart();
                $(".cart-items").load(location.href + " .cart-items");
            }
        });
    });

    $(document).on("click", ".delete-wishlist-item", function (event) {
        event.preventDefault();

        var product_id = $(this).closest(".product_data").find(".product_id").val();

        $.ajax({
            method: "POST",
            url: "/delete-wishlist-item",
            data: {
                "product_id": product_id,
            },
            success: function(response) {
                Swal.fire({
                    title: response.message,
                    icon: response.status,
                    showConfirmButton: false,
                    timer: 2500
                });
                loadWishlist();
                $(".wishlist-items").load(location.href + " .wishlist-items");
            }
        });
    });

    $(document).on("click", ".changeQuantity", function (event) {
        event.preventDefault();

        var product_id = $(this).closest(".product_data").find(".product_id").val();
        var quantity = $(this).closest(".product_data").find(".qty-input").val();

        var data = {
            "product_id": product_id,
            "quantity": quantity
        };

        $.ajax({
            method: "POST",
            url: "/update-cart",
            data: data,
            success: function(response) {
                $(".cart-items").load(location.href + " .cart-items");
            }
        });
    });
});
