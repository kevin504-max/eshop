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
                            <input type="hidden" name="product_id" id="product_id" value="{{ $product->id }}">
                            <label for="quantity">Quantity</label>
                            <div class="input-group text-center mb-3">
                                <span class="input-group-prepend bg-white border-0 mt-3">
                                    <button class="btn btn-sm btn-outline-secondary" type="button" id="button-decrement">-</button>
                                </span>
                                <input type="text" class="form-control text-center border-0" id="quantity" name="quantity" value="1">
                                <span class="input-group-append bg-white border-0 mt-3">
                                    <button class="btn btn-sm btn-outline-secondary" type="button" id="button-increment">+</button>
                                </span>
                            </div>
                        </div>
                        <div class="col-md-10 mt-3">
                            <br>
                            <button type="button" class="btn btn-success me-3 float-start">Add to Whilist <i class="fa fa-heart"></i></button>
                            <button id="addCartBtn" type="button" class="btn btn-primary me-3 float-start">Add to Cart <i class="fa fa-shopping-cart"></i></button>
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

@section('scripts')
<script>
    $(document).ready(function () {
        $("#addCartBtn").on("click", function (event) {
            event.preventDefault();

            // var product_id = $("#product_id").val();
            // var quantity = $("#quantity").val();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                method: "POST",
                url: "/add-to-cart",
                data: {
                    'product_id': $("#product_id").val(),
                    'quantity': $("#quantity").val(),
                },
                success: function (response) {
                    Swal.fire({
                        title: response.message,
                        icon: response.status,
                        showConfirmButton: false,
                        timer: 3500
                    });

                }
            })
        });

        $("#button-increment").on("click", function (event) {
            event.preventDefault();

            var inc_value = $("#quantity").val();
            var value = parseInt(inc_value, 10);

            value = isNaN(value) ? 0 : value;

            if (value < 10) {
                value++;
                $("#quantity").val(value);
            }
        });

        $("#button-decrement").on("click", function (event) {
            event.preventDefault();

            var dec_value = $("#quantity").val();
            var value = parseInt(dec_value, 10);

            value = isNaN(value) ? 0 : value;

            if (value > 1) {
                value--;
                $("#quantity").val(value);
            }
        });
    });
</script>
@endsection