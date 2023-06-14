@extends('layouts.front')

@section('title', $category->name)

@section('content')
<div class="py-3 mb-4 shadow-sm bg-warning border-top">
    <div class="container">
        <h6 class="mb-0">
            <a href="{{ url('category') }}"> Collections </a> /
            <a href="{{ url('category/' . $category->slug) }}"> {{ $category->name }} </a> /
        </h6>
    </div>
</div>
<div class="py-5">
    <div class="container">
        <div class="row">
            <h2>{{ $category->name }}</h2>
            @foreach($products as $product)
                <div class="col-md-3 mb-3">
                    <a href="{{ url('category/' . $category->slug . '/' . $product->title) }}">
                        <div class="card height-img">
                            <img src="{{ asset('assets/uploads/product/' . $product->thumbnail) }}" alt="Product image" class="d-block w-100" style="height: 200px;">
                            <div class="card-body">
                                <h5>{{ $product->title }}</h5>
                                <small class="float-start">{{ "$" . ($product->price - $product->discountPercentage) }}</small>
                                <small class="float-end"> <s> {{ "$" . $product->price }}</s></small>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
