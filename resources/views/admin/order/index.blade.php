@extends('layouts.admin')

@section('title', 'Orders')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-header bg-primary">
                        <h4 class="text-white">New Orders
                            <a href="{{ route('admin.orders.history') }}" class="btn btn-warning float-end">Order History</a>
                        </h4>
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
                                        <td class="text-center">{{ \Carbon\Carbon::parse($item->created_at)->format('d/m/Y') }}</td>
                                        <td class="text-center">{{ $item->tracking_number }}</td>
                                        <td class="text-center">{{ $item->total_price }}</td>
                                        <td class="text-center">{{ ($item->status == 0) ? 'Pending' : 'Completed' }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('admin.orders.view', ['id' => $item->id]) }}" class="btn btn-primary"><i class="fa fa-eye"></i></a>
                                        </td>
                                    </tr>
                                @empty
                                    <div class="text-center" colspan="6">
                                        <img src="{{ asset('assets/logging-off.svg') }}" alt="Nothing to see here..."  class="w-40">
                                        <h4>Nothing to see here...</h4>
                                    </div>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
