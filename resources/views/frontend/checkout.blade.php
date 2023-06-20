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
            <div class="col-md-7">
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
                                <span id="phone_error" class="text-danger"></span>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="cpf_cnpj">Document (CPF/CNPJ)</label>
                                <input id="cpf_cnpj" name="cpf_cnpj" type="text" name="cpf_cnpj" class="form-control cpf_cnpj mask-cpf" placeholder="000.000.000-00">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="state">State</label>
                                <input type="text" class="form-control state" name="state" placeholder="Enter with your state">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="city">City</label>
                                <input type="text" class="form-control city" name="city" placeholder="Enter with your city">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="card">
                    <div class="card-body">
                        <h6>Order Details</h6>
                        <div class="col-lg-12 hr-line"></div>
                        <table class="table table-striped">
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
                                @endforeach
                            </tbody>
                        </table>
                        <div class="col-lg-12 hr-line"></div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-success w-80">Place Order | COD</button>
                            <button type="button" class="btn btn-primary w-80 mt-3 razorpay_btn">Pay with Razorpay</button>
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
<script>
    var options = {
        onKeyPress: function (cpf, ev, el, op) {
            var masks = ['000.000.000-000', '00.000.000/0000-00'];
            $('#cpf_cnpj').mask((cpf.length > 14) ? masks[1] : masks[0], op);
        }
    }

    $('#cpf_cnpj').length > 11 ? $('#cpf_cnpj').mask('00.000.000/0000-00', options) : $('#cpf_cnpj').mask('000.000.000-00#', options);
</script>
@endsection
