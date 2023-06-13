@extends('layouts.front')

@section('title', $product->title)

@section('content')
<div class="py-3 mb-4 shadow-sm bg-warning border-top">
    <div class="container">
        <h6 class="mb-0"> Collections / {{ $category->name }} / {{ $product->title }}</h6>
    </div>
</div>
<div class="container">
    <div class="card shadow">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4 border-right">
                    <img src="{{ asset('assets/uploads/product/' . $product->thumbnail) }}" alt="Product image" class="w-100 border-radius-xl p-2">
                </div>
                <div class="col-md-8">
                    <h2 class="mb-0">{{ $product->title }} <label class="float-end badge bg-danger m-2" style="font-size: 0.8rem">Trending</label></h2>
                    <div class="hr-line col-lg-12"></div>
                    <label class="me-3">Original Price: <s>${{ $product->price }}</s></label>
                    <label class="fw-bold">Selling Price: <s>${{ ($product->price - $product->discountPercentage) }}</s></label>
                    <p class="mt-3">{!! $product->description !!}</p>
                    <div class="hr-line col-lg-12"></div>
                    @if ($product->stock > 0)
                        <label class="badge bg-success">In stock</label>
                    @else
                        <label class="badge bg-danger">Out of stock</label>
                    @endif
                    <div class="row mt-2">
                        <div class="col-md-2">
                            <label for="quantity">Quantity</label>
                            <div class="input-group text-center mb-3">
                                <span class="input-group-prepend bg-white border-0 mt-3">
                                    <button class="btn btn-sm btn-outline-secondary" type="button" id="button-addon1">-</button>
                                </span>
                                <input type="text" class="form-control text-center border-0" id="quantity" name="quantity" value="1" aria-label="Example text with button addon" aria-describedby="button-addon1" readonly>
                                <span class="input-group-append bg-white border-0 mt-3">
                                    <button class="btn btn-sm btn-outline-secondary" type="button" id="button-addon1">+</button>
                                </span>
                            </div>
                        </div>
                        <div class="col-md-10 mt-3">
                            <br>
                            <button type="button" class="btn btn-success me-3 float-start">Add to Whilist</button>
                            <button type="button" class="btn btn-primary me-3 float-start">Add to Cart</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
