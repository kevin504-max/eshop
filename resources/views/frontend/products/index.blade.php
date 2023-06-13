@extends('layouts.front')

@section('title', $category->name)

@section('content')
<div class="py-5">
    <div class="container">
        <div class="row">
            <h2>{{ $category->name }}</h2>
            @foreach($products as $product)
                <div class="col-md-3 mb-3">
                    <div class="card height-img">
                        <img src="{{ asset('assets/uploads/product/' . $product->thumbnail) }}" alt="Product image" class="d-block w-100" style="height: 200px;">
                        <div class="card-body">
                            <h5>{{ $product->title }}</h5>
                            <small class="float-start">{{ "$" . ($product->price - $product->discountPercentage) }}</small>
                            <small class="float-end"> <s> {{ "$" . $product->price }}</s></small>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
