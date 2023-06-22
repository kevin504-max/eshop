@extends('layouts.front')

@section('title', $product->title)

@section('content')
<div class="py-3 mb-4 shadow-sm bg-warning border-top">
    <div class="container">
        <h6 class="mb-0">
            <a href="{{ url('category') }}"> Collections </a> /
            <a href="{{ url('category/' . $product->category->slug) }}"> {{ $category->name }} </a> /
            <a href="{{ url('category/' . $product->category->slug . '/' . $product->slug) }}"> {{ $product->title }} </a>
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
                    @php
                        $rate_number = number_format($ratings_value);
                    @endphp
                    <div class="rating">
                        @for ($i = 1; $i <= $rate_number; $i++)
                            <i class="fa fa-star checked"></i>
                        @endfor
                        @for ($i = 5; $i > $rate_number; $i--)
                            <i class="fa fa-star" style="color: #ccc;"></i>
                        @endfor
                        <span>@if ($ratings->count() > 0) {{ $ratings->count() }} Ratings @else No Ratings @endif</span>
                    </div>
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
                            @if ($product->stock > 0)
                                <button type="button" class="btn btn-primary me-3 float-start addCartBtn">Add to Cart <i class="fa fa-shopping-cart"></i></button>
                            @endif
                            <button type="button" class="btn btn-success me-3 addToWishlistBtn float-start">Add to Whilist <i class="fa fa-heart"></i></button>
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
                <div class="col-lg-12 hr-line"></div>
                <div class="row">
                    <div class="col-md-4">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalRateProduct"><i class="fa fa-star"></i> Rate this product</button>
                        <a href="{{ url('create-review/' . $product->slug . '/userreview') }}" class="btn btn-primary"><i class="fa fa-comment"></i> Write a review</a>
                    </div>
                    <div class="col-md-8">
                        @forelse ($reviews as $review)
                            <div class="user-review">
                                <label for="" class="font-bold" style="font-size: 1.2em;">{{ $review->user->name }}</label>
                                @if ($review->user_id == Auth::id())
                                    <a href="{{ url('edit-review/' . $product->slug . '/userreview' ) }}">edit</a>
                                @endif
                                <br>
                                @if ($review->rating)
                                    @php
                                        $user_rated = $review->rating->rating;
                                    @endphp
                                    @for ($i = 1; $i <= $user_rated; $i++)
                                        <i class="fa fa-star checked"></i>
                                    @endfor
                                    @for ($i = ($user_rated + 1); $i <= 5; $i++)
                                        <i class="fa fa-star"></i>
                                    @endfor
                                @endif
                                <small>Reviewed on {{ $review->created_at->format('d/m/Y') }}</small>
                                <p>{{ $review->review }}</p>
                            </div>
                        @empty

                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('modals')
{{-- MODAL RATE PRODUCT --}}
<div id="modalRateProduct" class="modal inmodal fade" tabindex="-1" role="dialog" aria-modal="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" type="button" data-bs-dismiss="modal" aria-label="Fechar"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Rate {{ $product->title }}</h4>
            </div>
            <form action="{{ url('add-rating') }}" method="POST">
                @csrf
                <input type="hidden" name="product_id" id="product_id" value="{{ $product->id }}">
                <div class="modal-body">
                    <div class="rating-css">
                        <div class="star-icon">
                            @if ($user_rating)
                                @for ($i = 1; $i <= $user_rating->rating; $i++)
                                    <input type="radio" value="{{ $i }}" name="product_rating" id="rating_{{ $i }}">
                                    <label for="rating_{{ $i }}" class="fa fa-star" style="color: #ffbb33;"></label>
                                @endfor
                                @for ($i = ($user_rating->rating + 1); $i <= 5 ; $i++)
                                    <input type="radio" value="{{ $i }}" name="product_rating" id="rating_{{ $i }}">
                                    <label for="rating_{{ $i }}" class="fa fa-star" style="color: #ccc;"></label>
                                @endfor
                            @else
                                @for ($i = 1; $i <= 5; $i++)
                                    <input type="radio" value="{{ $i }}" name="product_rating" id="rating_{{ $i }}" @if($i == 1) checked @endif>
                                    <label for="rating_{{ $i }}" class="fa fa-star" @if ($i == 1) style="color: #ffbb33;" @endif></label>
                                @endfor
                            @endif
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-outline-primary" type="button" data-bs-dismiss="modal">Cancel</button>
                    <button class="btn btn-primary" type="submit">Rate</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function () {
        $("#modalRateProduct").on("show.bs.modal", function () {
            var modal = $(this);
            modal.find(".star-icon").on("change", function (event) {
                var rating = $(this).find("input:checked").val();

                for (let i = 1; i <= rating; i++) {
                    modal.find('label[for="rating_' + i + '"]').css("color", "#ffbb33");
                }

                for (let i = 5; i > rating; i--) {
                    modal.find('label[for="rating_' + i + '"]').css("color", "#ccc");
                }
            });
        });
    });
</script>
@endsection
