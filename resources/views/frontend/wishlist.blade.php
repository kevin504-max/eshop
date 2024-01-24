@extends('layouts.front')

@section('title', 'My Wishlist')

@section('content')
<div class="py-3 mb-4 shadow-sm bg-warning border-top">
    <div class="container">
        <h6 class="mb-0">
            <a href="{{ url('/') }}"> Home </a> /
            <a href="{{ url('wishlist') }}"> Wishlist </a>
        </h6>
    </div>
</div>
<div class="container my-5">
    <div class="card shadow wishlist-items">
        <div class="card-body">
            @if (count($wishlist) > 0)
                <div class="card-body">
                    @php
                        $total = 0;
                    @endphp
                    @foreach ($wishlist as $item)
                        <div class="row mb-3 product_data">
                            <div class="col-md-2 height-img">
                                @if (file_exists(public_path('assets/uploads/product/' . $product->thumbnail)))
                                    <img src="{{ asset('assets/uploads/product/' . $item->product->thumbnail) }}" alt="Product image" class="w-100 border-radius-xl p-2" style="height: 120px;">
                                @else
                                    <img src="{{ $item->product->thumbnail }}" alt="Product image" class="w-100 border-radius-xl p-2" style="height: 120px;">
                                @endif
                            </div>
                            <div class="col-md-4 mt-5">
                                <h4>{{ $item->product->title }}</h4>
                                <h4>${{ ($item->product->price - $item->product->discountPercentage) }}</h4>
                            </div>
                            <div class="col-md-2 mt-5">
                                <input type="hidden" class="product_id" value="{{ $item->product_id }}">
                                @if ($item->product->stock >= 1)
                                    <h6>In Stock</h6>
                                @else
                                    <h6>Out of Stock</h6>
                                @endif
                            </div>
                            <div class="col-md-2 mt-5">
                                <button class="btn btn-success addCartBtn" type="button"><i class="fa fa-shopping-cart"></i> Add to Cart</button>
                            </div>
                            <div class="col-md-2 mt-5">
                                <button class="btn btn-danger delete-wishlist-item" type="button"><i class="fa fa-trash"></i> Remove</button>
                            </div>
                        </div>
                        @php
                            $total += ($item->product->price - $item->product->discountPercentage);
                        @endphp
                    @endforeach
                </div>
                <div class="col-lg-12 hr-line"></div>
                <div class="card-footer">
                    <h6>Total Price: ${{ $total }}
                        <a href="{{ url('checkout') }}" type="button" class="btn btn-outline-success float-end">Proceed to Checkout</a>
                    </h6>
                </div>
            @else
                <div class="card-body text-center">
                    <img src="{{ asset('assets/logging-off.svg') }}" alt="Nothing to see here..."  class="w-40">
                    <h4>Your wishlist is empty</h4>
                    <a href="{{ url('category') }}" type="button" class="btn btn-outline-primary"><i class="fa fa-shopping-cart fa-2x"></i> Continue Shopping</a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
