$(document).ready(function() {
    $(".addCartBtn").on("click", function(event) {
        event.preventDefault();

        var product_id = $(this).closest(".product_data").find(".product_id").val();
        var product_qty = $(this).closest(".product_data").find(".qty-input").val();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            method: "POST",
            url: "/add-to-cart",
            data: {
                "product_id": product_id,
                "quantity": product_qty,
            },
            success: function(response) {
                Swal.fire({
                    title: response.message,
                    icon: response.status,
                    showConfirmButton: false,
                    timer: 3500
                });
            }
        });
    });

    $(".increment-btn").on("click", function(event) {
        event.preventDefault();

        var inc_value = $(this).closest(".product_data").find(".qty-input").val();
        var value = parseInt(inc_value, 10);

        value = isNaN(value) ? 0 : value;

        if (value < 10) {
            value++;
            $(this).closest(".product_data").find(".qty-input").val(value);
        }
    });

    $(".decrement-btn").on("click", function(event) {
        event.preventDefault();

        var dec_value = $(this).closest(".product_data").find(".qty-input").val();
        var value = parseInt(dec_value, 10);

        value = isNaN(value) ? 0 : value;

        if (value > 1) {
            value--;
            $(this).closest(".product_data").find(".qty-input").val(value);
        }
    });

    $(".delete-cart-item").on("click", function (event) {
        event.preventDefault();

        var product_id = $(this).closest(".product_data").find(".product_id").val();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

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
                    timer: 3500
                });
                window.location.reload();
            }
        });
    });

    $(".changeQuantity").on("click", function (event) {
        event.preventDefault();

        var product_id = $(this).closest(".product_data").find(".product_id").val();
        var quantity = $(this).closest(".product_data").find(".qty-input").val();

        var data = {
            "product_id": product_id,
            "quantity": quantity
        };

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            method: "POST",
            url: "/update-cart",
            data: data,
            success: function(response) {
                window.location.reload();
            }
        });
    });
});
