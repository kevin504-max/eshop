@extends('layouts.front')

@section('title', $category->name)

@section('content')
<div class="py-3 mb-4 shadow-sm bg-warning border-top">
    <div class="container">
        <h6 class="mb-0">
            <a href="{{ url('category') }}"> Collections </a> /
            <a href="{{ url('category/' . $category->slug) }}"> {{ $category->name }} </a>
        </h6>
    </div>
</div>
<div class="py-5">
    <div class="container">
        <div class="row">
            <h2>{{ $category->name }}</h2>
            @forelse($products as $product)
                <div class="col-md-3 mb-3">
                    <a href="{{ url('category/' . $category->slug . '/' . $product->slug) }}">
                        <div class="card height-img">
                            <img src="{{ asset('assets/uploads/product/' . $product->thumbnail, true) }}" alt="Product image" class="d-block w-100" style="height: 200px;">
                            <div class="card-body">
                                <h5>{{ $product->title }}</h5>
                                <small class="float-start">{{ "$" . ($product->price - $product->discountPercentage) }}</small>
                                <small class="float-end"> <s> {{ "$" . $product->price }}</s></small>
                            </div>
                        </div>
                    </a>
                </div>
            @empty
                <div class="text-center" colspan="6">
                    <img src="{{ asset('assets/logging-off.svg', true) }}" alt="No products in this category yet..."  class="w-40">
                    <h4>No products in this category yet...</h4>
                    <a href="{{ url('category') }}" type="button" class="btn btn-outline-primary"><i class="fa fa-shopping-cart fa-2x"></i> Continue Shopping</a>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
