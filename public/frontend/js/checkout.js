$(document).ready(function() {
    $(".razorpay_btn").on("click", function(event) {
        event.preventDefault();

        let validation = true;

        const displayError = (field, message) => {
            $(`#${field}_error`).html(message);
        };

        const clearError = (field) => {
            $(`#${field}_error`).html("");
        };

        const validateField = (field, errorMessage) => {
            const value = $(`.${field}`).val();
            if (!value) {
                displayError(field, errorMessage);
                validation = false;
            } else {
                clearError(field);
            }
        };

        validateField("phone", "Phone is required");
        validateField("cpf_cnpj", "CPF/CNPJ is required");
        validateField("state", "State is required");
        validateField("city", "City is required");

        if (validation) {
            var data = {
                "username": $(".username").val(),
                "email": $(".email").val(),
                "phone": $(".phone").val(),
                "cpf_cnpj": $(".cpf_cnpj").val(),
                "state": $(".state").val(),
                "city": $(".city").val(),
            };

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                method: "POST",
                url: '/proceed-to-pay',
                data: data,
                success: function (response) {
                    var options = {
                        "key": "rzp_test_JdnkEvYGOrGMFd", // Enter the Key ID generated from the Dashboard
                        "amount": parseFloat(response.total_price).toFixed(2) * 100, // Amount is in currency subunits. Default currency is INR. Hence, 50000 refers to 50000 paise
                        "currency": "INR",
                        "name": response.username, //your business name
                        "description": "Thank you for choosing us!",
                        "image": "https://example.com/your_logo",
                        // "order_id": "order_9A33XWu170gUtm", //This is a sample Order ID. Pass the `id` obtained in the response of Step 1
                        "handler": function (responsea) {
                            // alert(responsea.razorpay_payment_id);
                            $.ajax({
                                method: "POST",
                                url: "/place-order",
                                data: {
                                    "username": response.username,
                                    "email": response.email,
                                    "phone": response.phone,
                                    "cpf_cnpj": response.cpf_cnpj,
                                    "state": response.state,
                                    "city": response.city,
                                    "payment_mode": "Paid by Razorpay",
                                    "payment_id": responsea.razorpay_payment_id
                                },
                                success: function (responseb) {
                                    Swal.fire({
                                        icon: responseb.status,
                                        title: responseb.message,
                                        showConfirmButton: false,
                                        timer: 1500
                                    });

                                    window.location.href = "/my-orders";
                                }
                            });
                        },
                        "prefill": { //We recommend using the prefill parameter to auto-fill customer's contact information especially their phone number
                            "name": response.name, //your customer's name
                            "email": response.email,
                            "contact": response.phone //Provide the customer's phone number for better conversion rates
                        },
                        "theme": {
                            "color": "#e91e63"
                        }
                    };
                    var rzp1 = new Razorpay(options);
                    rzp1.open();
                }
            });
        }
    });
});
