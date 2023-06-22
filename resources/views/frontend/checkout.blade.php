@extends('layouts.front')

@section('title', 'Checkout')

@section('content')
<div class="py-3 mb-4 shadow-sm bg-warning border-top">
    <div class="container">
        <h6 class="mb-0">
            <a href="{{ url('/') }}"> Home </a> /
            <a href="{{ url('checkout') }}"> Checkout </a>
        </h6>
    </div>
</div>
<div class="container mt-5">
    <form action="{{ url('place-order') }}" method="POST">
        {{ csrf_field() }}
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h6>Basic Details</h6>
                        <div class="col-lg-12 hr-line"></div>
                        <div class="row checkout-form">
                            <div class="col-md-6 mb-3">
                                <label for="name">Full Name</label>
                                <input type="text" class="form-control username" name="username" value="{{ Auth::user()->name }}" readonly>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="email">Email</label>
                                <input type="text" class="form-control email" name="email" value="{{ Auth::user()->email }}" readonly>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="phone">Phone Number</label>
                                <input type="text" class="form-control phone" name="phone" placeholder="Enter with your phone">
                                <span id="phone_error" class="text-danger" style="font-size: 0.8em;"></span>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="cpf_cnpj">Document (CPF/CNPJ)</label>
                                <input id="cpf_cnpj" name="cpf_cnpj" type="text" name="cpf_cnpj" class="form-control cpf_cnpj mask-cpf" placeholder="000.000.000-00">
                                <span id="cpf_cnpj_error" class="text-danger" style="font-size: 0.8em;"></span>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="state">State</label>
                                <input type="text" class="form-control state" name="state" placeholder="Enter with your state">
                                <span id="state_error" class="text-danger" style="font-size: 0.8em;"></span>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="city">City</label>
                                <input type="text" class="form-control city" name="city" placeholder="Enter with your city">
                                <span id="city_error" class="text-danger" style="font-size: 0.8em;"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        @php
                            $total = 0;
                        @endphp
                        <h6>Order Details</h6>
                        <div class="col-lg-12 hr-line"></div>
                        <table class="table table-striped table-responsive">
                            <thead>
                                <tr>
                                    <th >Product</th>
                                    <th >Quantity</th>
                                    <th >Price ($)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($cartItems as $item)
                                    <tr>
                                        <td class="text-center align-middle">{{ $item->product->title }}</td>
                                        <td class="text-center align-middle">{{ $item->items }}</td>
                                        <td class="text-center align-middle">{{ ($item->product->price - $item->product->discountPercentage) }}</td>
                                    </tr>
                                    @php
                                        $total += (($item->product->price - $item->product->discountPercentage) * $item->items);
                                    @endphp
                                @endforeach
                            </tbody>
                        </table>
                        <h4 class="px-2">Grand Total: <span class="float-end">${{ $total }}</span></h4>
                        <div class="col-lg-12 hr-line"></div>
                        <input type="hidden" name="payment_mode" id="payment_mode" value="COD">
                        <div class="text-center">
                            <button type="submit" class="btn btn-success w-100" style="height: 55px;">Place Order | COD</button>
                            <button type="button" class="btn btn-primary w-100 mt-1 mb-1 razorpay_btn" style="height: 55px;">Pay with Razorpay</button>
                            <div id="paypal-button-container"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.js"></script>
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script src="https://www.paypal.com/sdk/js?client-id=AV42ollXW_kGfDJjZam4tzCFzH4O803b601M4zH9Bnvodio4d8ZE_4OLioViLxK40rHGH9k3Jj26f9mk&currency=BRL"></script>
<script>
    var options = {
        onKeyPress: function (cpf, ev, el, op) {
            var masks = ['000.000.000-000', '00.000.000/0000-00'];
            $('#cpf_cnpj').mask((cpf.length > 14) ? masks[1] : masks[0], op);
        }
    }

    $('#cpf_cnpj').length > 11 ? $('#cpf_cnpj').mask('00.000.000/0000-00', options) : $('#cpf_cnpj').mask('000.000.000-00#', options);

    paypal.Buttons({
        // Order is created on the server and the order id is returned
        createOrder: function(data, actions) {
          return actions.order.create({
            purchase_units: [{
              amount: {
                value: '{{ $total }}'
              }
            }]
          });
        },
        // Finalize the transaction on the server after payer approval
        onApprove: function(data, actions) {
          return actions.order.capture().then(function (details) {
            // alert ('Transaction completed by ' + details.payer.name.given_name + '!');

            var username = $('.username').val();
            var email = $('.email').val();
            var phone = $('.phone').val();
            var cpf_cnpj = $('.cpf_cnpj').val();
            var state = $('.state').val();
            var city = $('.city').val();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                method: "POST",
                url: "/place-order",
                data: {
                    "username": username,
                    "email": email,
                    "phone": phone,
                    "cpf_cnpj": cpf_cnpj,
                    "state": state,
                    "city": city,
                    "payment_mode": "Paid by Paypal",
                    "payment_id": details.id
                },
                success: function (response) {
                    Swal.fire({
                        icon: response.status,
                        title: response.message,
                        showConfirmButton: false,
                        timer: 1500
                    }).then((result) => {
                        window.location.href = "/my-orders";
                    });
                }
            });
          });
        }
      }).render('#paypal-button-container');
</script>
@endsection

{{-- rzp_test_JdnkEvYGOrGMFd --}}
{{-- BSV0eHAh9tk7yGn6o0TIvJ9b --}}
