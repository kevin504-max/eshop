$(document).ready(function() {
    $(".razorpay_btn").on("click", function(event) {
        event.preventDefault();

        var phone = $(".phone").val();
        var cpf_cnpj = $(".cpf_cnpj").val();
        var state = $(".state").val();
        var city = $(".city").val();

        if (!phone) {
            phone_error = "Phone is required";
            $("#phone_error").html('');
            $("#phone_error").html(phone_error);
        } else {
            phone_error = "";
            $("#phone_error").html('');
        }
    });
});
