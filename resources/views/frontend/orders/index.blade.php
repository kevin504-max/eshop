@extends('layouts.front')

@section('title', 'My Orders')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>My Orders</h4>
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th class="text-center align-middle">Order Date</th>
                                <th class="text-center align-middle">Tracking Number</th>
                                <th class="text-center align-middle">Total Price</th>
                                <th class="text-center align-middle">Status</th>
                                <th class="text-center align-middle">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($orders as $item)
                                <tr>
                                    <td class="text-center">{{ $item->created_at->format('d/m/Y') }}</td>
                                    <td class="text-center">{{ $item->tracking_number }}</td>
                                    <td class="text-center">${{ $item->total_price }}</td>
                                    <td class="text-center">{{ ($item->status == 0) ? 'Pending' : 'Completed' }}</td>
                                    <td class="text-center">
                                        <a href="{{ url('view-order/' . $item->id) }}" class="btn btn-primary"><i class="fa fa-eye"></i></a>
                                    </td>
                                </tr>
                            @empty
                                <div class="text-center" colspan="6">
                                    <img src="{{ asset('assets/logging-off.svg', true) }}" alt="You don't have any order registered yet..."  class="w-40">
                                    <h4>You don't have any order registered yet...</h4>
                                    <a href="{{ url('category') }}" type="button" class="btn btn-outline-primary"><i class="fa fa-shopping-cart fa-2x"></i> Continue Shopping</a>
                                </div>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
