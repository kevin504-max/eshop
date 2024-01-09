@extends('layouts.front')

@section('title', "Write a Review")

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    @if (count($verifiedPurchase) > 0)
                        <h5>You are writing a review for {{ $product->title }}</h5>
                        <form action="{{ url('/store-review') }}" method="POST">
                            @csrf
                            <input type="hidden" name="product_id" id="product_id" value="{{ $product->id }}">
                            <textarea class="form-control" name="user_review" id="user_review" rows="5" placeholder="Type here..."></textarea>
                            <button class="btn btn-primary mt-3" type="submit">Submit Review</button>
                        </form>
                    @else
                        <div class="alert alert-danger">
                            <h5>You are not eligible to review this product</h5>
                            <p>For the trusthworthiness of the reviews, only customers who purchased the product can write a review about the product.</p>
                            <a href="{{ url('/') }}" class="btn btn-primary mt-3">Go to home page</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
