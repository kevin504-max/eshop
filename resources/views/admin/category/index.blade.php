@extends('layouts.admin')

@section('title', 'Categories')

@section('content')
    <div class="card">
        <div class="card-header">
            <h1>Category Management</h1>
            <button class="btn btn-primary mr-0" data-bs-toggle="modal" data-bs-target="#modalCreateCategory"><i class="fa fa-plus"></i> Register Category</button>
        </div>
        <div class="card-body">
            <table class="table table-stripped table-hover">
                <thead>
                    <tr>
                        <th class="text-center">ID</th>
                        <th class="text-center">Name</th>
                        <th class="text-center">Description</th>
                        <th class="text-center">Image</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($categories as $category)
                        <tr>
                            <td class="text-center align-middle">{{ $category['id'] }}</td>
                            <td class="text-center align-middle">{{ $category['name'] }}</td>
                            <td class="text-center align-middle">{{ $category['description'] }}</td>
                            <td class="text-center align-middle height-img">
                                @if (file_exists(public_path('assets/uploads/category/' . $category['image'])))
                                <img src="{{ asset('assets/uploads/category/' . $category['image']) }}" alt="image" class="img-circle" style="height: 80px;">
                            @else
                                <img src="{{ $category['image'] }}" alt="image" class="img-circle" style="height: 80px;">
                            @endif                            </td>
                            <td class="text-center align-middle">
                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalUpdateCategory" data-category="{{ json_encode($category) }}"><i class="fa fa-pen"></i></button>
                                <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalDeleteCategory" data-id="{{ $category['id'] }}"><i class="fa fa-trash"></i></button>
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
@include('admin.category._modals')
@endsection

@section('scripts')
@include('admin.category._scripts')
@endsection
