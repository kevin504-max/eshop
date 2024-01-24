@extends('layouts.front')

@section('title', 'Home Page')

@section('content')
@include('layouts.inc.slider')
<div class="py-5">
    <div class="container">
        <div class="row">
            <h2>Better Rated Products</h2>
            <div class="owl-carousel rated-carousel owl-theme">
                @foreach($most_rated as $product)
                    <div class="item mb-3">
                        <div class="card height-img">
                            <img src="{{ $product->thumbnail }}" alt="Product image" class="d-block w-80" style="height: 320px;">
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
</div>
<div class="py-5">
    <div class="container">
        <div class="row">
            <h2>Most Popular Categories</h2>
            <div class="owl-carousel rated-carousel owl-theme">
                @foreach($popular_categories as $category)
                    <a href="{{ url('category/' . $category->slug) }}">
                        <div class="item mb-3">
                            <div class="card height-img">
                                <img src="{{ $category->image }}" alt="Category image" class="d-block w-80" style="height: 320px;">
                                <div class="card-body">
                                    <h5>{{ $category->name }}</h5>
                                    <p>{{ $category->description }}</p>
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $('.rated-carousel').owlCarousel({
        loop:true,
        margin:10,
        nav:true,
        dots:false,
        responsive:{
            0:{
                items:1
            },
            600:{
                items:3
            },
            1000:{
                items:3
            }
        }
    })
</script>
@endsection
