@extends('layouts.front')

@section('title', 'My Orders')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-primary">
                    <h4 class="text-white">Order View
                        <a href="{{ url('my-orders') }}" class="btn btn-warning text-white float-end">Back</a>
                    </h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 order-details">
                            <h4>Shipping Details</h4>
                            <label for="username">User</label>
                            <div class="border mb-3">{{ $order->username }}</div>
                            <label for="email">Email</label>
                            <div class="border mb-3">{{ $order->email }}</div>
                            <label for="cpf_cnpj">CPF/CNPJ</label>
                            <div class="border mb-3">{{ $order->cpf_cnpj }}</div>
                            <label for="address">Address</label>
                            <div class="border mb-3">{{ $order->state . ' - ' . $order->city }}</div>
                            <label for="phone">Phone</label>
                            <div class="border mb-3">{{ $order->phone }}</div>
                            <label for="total_price">Total Price</label>
                            <div class="border mb-3">${{ $order->total_price }}</div>
                            <label for="total_price">Order Date</label>
                            <div class="border mb-3">{{ \Carbon\Carbon::parse($order->created_at)->format('d/m/Y') }}</div>
                        </div>
                        <div class="col-md-6">
                            <h4>Order Details</h4>
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th class="text-center align-middle">Product</th>
                                        <th class="text-center align-middle">Quantity</th>
                                        <th class="text-center align-middle">Price</th>
                                        <th class="text-center align-middle">Image</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($order->orderItems as $item)
                                        <tr>
                                            <td class="text-center">{{ $item->product->title }}</td>
                                            <td class="text-center">{{ $item->quantity }}</td>
                                            <td class="text-center">${{ ($item->product->price - $item->product->discountPercentage) }}</td>
                                            <td class="text-center">
                                                @if (file_exists(public_path('assets/uploads/product/' . $item->product->thumbnail)))
                                                    <img src="{{ asset('assets/uploads/product/' . $item->product->thumbnail) }}" alt="{{ $item->product->title }}" class="img-circle w-30">
                                                @else
                                                    <img src="{{ $item->product->thumbnail }}" alt="{{ $item->product->title }}" class="img-circle w-30">
                                                @endif                                            </td>
                                        </tr>
                                    @empty
                                        <div class="text-center" colspan="6">
                                            <img src="{{ asset('assets/logging-off.svg') }}" alt="You don't have any order registered yet..."  class="w-40">
                                            <h4>You don't have any order registered yet...</h4>
                                            <a href="{{ url('category') }}" type="button" class="btn btn-outline-primary"><i class="fa fa-shopping-cart fa-2x"></i> Continue Shopping</a>
                                        </div>
                                    @endforelse
                                </tbody>
                            </table>
                            <h4 class="px-2">Grand Total: <span class="float-end">${{ $order->total_price }}</span></h4>
                            <h6 class="px-2 mt-5">Payment Mode: <span class="float-end">{{ $order->payment_mode }}</span></h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
