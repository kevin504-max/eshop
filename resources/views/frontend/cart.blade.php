@extends('layouts.front')

@section('title', 'My Cart')

@section('content')
<div class="py-3 mb-4 shadow-sm bg-warning border-top">
    <div class="container">
        <h6 class="mb-0">
            <a href="{{ url('/') }}"> Home </a> /
            <a href="{{ url('cart') }}"> Cart </a>
        </h6>
    </div>
</div>
<div class="container my-5">
    <div class="card shadow">
        <div class="card-body">
            @php
                $total = 0;
            @endphp
            @foreach ($cartItems as $item)
                <div class="row mb-3 product_data">
                    <div class="col-md-2 height-img">
                        <img src="{{ asset('assets/uploads/product/' . $item->product->thumbnail) }}" alt="Product image" class="w-100 border-radius-xl p-2" style="height: 120px;">
                    </div>
                    <div class="col-md-5 mt-5">
                        <h4>{{ $item->product->title }}</h4>
                        <h4>${{ ($item->product->price - $item->product->discountPercentage) }}</h4>
                    </div>
                    <div class="col-md-3">
                        <input type="hidden" class="product_id" value="{{ $item->product_id }}">
                        <label for="quantity">Quantity</label>
                        <div class="input-group text-center justify-content-center mb-3" style="width: 120px;">
                            <span class="input-group-prepend bg-white border-0 mt-3">
                                <button class="btn btn-sm btn-outline-secondary changeQuantity decrement-btn" type="button">-</button>
                            </span>
                            <input type="text" class="form-control text-center border-0 qty-input" id="quantity" name="quantity" value="{{ $item->items }}">
                            <span class="input-group-append bg-white border-0 mt-3">
                                <button class="btn btn-sm btn-outline-secondary changeQuantity increment-btn" type="button">+</button>
                            </span>
                        </div>
                    </div>
                    <div class="col-md-2 mt-5">
                        <button class="btn btn-danger delete-cart-item" type="button"><i class="fa fa-trash"></i> Remove</button>
                    </div>
                </div>
                @php
                    $total += (($item->product->price - $item->product->discountPercentage) * $item->items);
                @endphp
            @endforeach
        </div>
        <div class="col-lg-12 hr-line"></div>
        <div class="card-footer">
            <h6>Total Price: ${{ $total }}
                <a href="{{ url('checkout') }}" type="button" class="btn btn-outline-success float-end">Proceed to Checkout</a>
            </h6>
        </div>
    </div>
</div>
@endsection
