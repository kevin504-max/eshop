@extends('layouts.front')

@section('title', $product->title)

@section('content')
<div class="py-3 mb-4 shadow-sm bg-warning border-top">
    <div class="container">
        <h6 class="mb-0">
            <a href="{{ url('category') }}"> Collections </a> /
            <a href="{{ url('category/' . $product->hasCategory->slug) }}"> {{ $category->name }} </a> /
            <a href="{{ url('category/' . $product->hasCategory->slug . '/' . $product->title) }}"> {{ $product->title }} </a>
        </h6>
    </div>
</div>
<div class="container">
    <div class="card shadow product_data">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4 border-right">
                    <img src="{{ asset('assets/uploads/product/' . $product->thumbnail) }}" alt="Product image" class="w-100 border-radius-xl p-2">
                </div>
                <div class="col-md-8">
                    <h2 class="mb-0">{{ $product->title }} <label class="float-end badge bg-danger m-2" style="font-size: 0.8rem">Trending</label></h2>
                    <div class="hr-line col-lg-12"></div>
                    <label class="me-3">Original Price: <s>${{ $product->price }}</s></label>
                    <label class="fw-bold">Selling Price: ${{ ($product->price - $product->discountPercentage) }}</label>
                    <p class="mt-3">{!! $product->description !!}</p>
                    <div class="hr-line col-lg-12"></div>
                    @if ($product->stock > 0)
                        <label class="badge bg-success">In stock</label>
                    @else
                        <label class="badge bg-danger">Out of stock</label>
                    @endif
                    <div class="row mt-2">
                        <div class="col-md-2">
                            <input type="hidden" class="product_id" value="{{ $product->id }}">
                            <label for="quantity">Quantity</label>
                            <div class="input-group text-center mb-3">
                                <span class="input-group-prepend bg-white border-0 mt-3">
                                    <button class="btn btn-sm btn-outline-secondary decrement-btn" type="button">-</button>
                                </span>
                                <input type="text" class="form-control text-center border-0 qty-input" id="quantity" name="quantity" value="1">
                                <span class="input-group-append bg-white border-0 mt-3">
                                    <button class="btn btn-sm btn-outline-secondary increment-btn" type="button">+</button>
                                </span>
                            </div>
                        </div>
                        <div class="col-md-10 mt-3">
                            <br>
                            <button type="button" class="btn btn-success me-3 float-start">Add to Whilist <i class="fa fa-heart"></i></button>
                            <button type="button" class="btn btn-primary me-3 float-start addCartBtn">Add to Cart <i class="fa fa-shopping-cart"></i></button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-5">
                <div class="col-md-12">
                    <h3 class="mb-0">Description</h3>
                    <div class="hr-line col-lg-12"></div>
                    <p class="mt-3">{!! $product->description !!}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
