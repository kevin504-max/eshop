@extends('layouts.admin')

@section('title', 'Products')

@section('content')
    <div class="card">
        <div class="card-header">
            <h1>Products Manager</h1>
            <button class="btn btn-primary mr-0" data-bs-toggle="modal" data-bs-target="#modalCreateProducts"><i class="fa fa-plus"></i> Register Product</button>
        </div>
        <div class="card-body">
            <table class="table table-stripped table-hover">
                <thead>
                    <tr>
                        <th class="text-center">ID</th>
                        <th class="text-center">Category</th>
                        <th class="text-center">Name</th>
                        <th class="text-center">Price</th>
                        <th class="text-center">Discount</th>
                        <th class="text-center">Rate</th>
                        <th class="text-center">Stock</th>
                        <th class="text-center">Image</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($products as $product)
                        <tr>
                            <td class="text-center align-middle">{{ $product['id'] }}</td>
                            <td class="text-center align-middle">{{ $product['category']->name ?? "-" }}</td>
                            <td class="text-center align-middle">{{ $product['title'] }}</td>
                            <td class="text-center align-middle">{{ $product['price'] }}</td>
                            <td class="text-center align-middle">{{ $product['discountPercentage'] }}</td>
                            <td class="text-center align-middle">{{ $product['rating'] }}</td>
                            <td class="text-center align-middle">{{ $product['stock'] }}</td>
                            <td class="text-center align-middle height-img">
                                <img src="{{ $product['thumbnail'] }}" alt="image" class="img-circle" style="height: 80px;">
                            </td>
                            <td class="text-center align-middle">
                                <button class="btn btn-primary" type="button" data-bs-target="#modalUpdateProducts" data-bs-toggle="modal" data-product="{{ json_encode($product) }}"><i class="fa fa-pen"></i></button>
                                <button class="btn btn-danger" type="button" data-bs-target="#modalDeleteProducts" data-bs-toggle="modal" data-id="{{ $product['id'] }}"><i class="fa fa-trash"></i></button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <div class="text-center" colspan="5">
                                <img src="{{ asset('assets/logging-off.svg') }}" alt="Nothing to see here..." width="200px">
                                <h2 class="text-center">Nothing to see here...</h2>
                            </div>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('modals')
@include('admin.product._modals')
@endsection

@section('scripts')
@include('admin.product._scripts')
@endsection
