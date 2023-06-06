@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header">
            <h1>Gestão de Produtos</h1>
            <button class="btn btn-primary mr-0" data-bs-toggle="modal" data-bs-target="#modalCreateProdutos"><i class="fa fa-plus"></i> Adicionar produto</button>
        </div>
        <div class="card-body">
            <table class="table table-stripped table-hover">
                <thead>
                    <tr>
                        <th class="text-center">ID</th>
                        <th class="text-center">Categoria</th>
                        <th class="text-center">Nome</th>
                        <th class="text-center">Preço</th>
                        <th class="text-center">Desconto</th>
                        <th class="text-center">Avaliações</th>
                        <th class="text-center">Estoque</th>
                        <th class="text-center">Imagem</th>
                        <th class="text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($produtos as $produto)
                        <tr>
                            <td class="text-center align-middle">{{ $produto->id }}</td>
                            <td class="text-center align-middle">{{ $produto->categoria->nome ?? "-" }}</td>
                            <td class="text-center align-middle">{{ $produto->title }}</td>
                            <td class="text-center align-middle">{{ $produto->price }}</td>
                            <td class="text-center align-middle">{{ $produto->discountPercentage }}</td>
                            <td class="text-center align-middle">{{ $produto->rating }}</td>
                            <td class="text-center align-middle">{{ $produto->stock }}</td>
                            <td class="text-center align-middle">
                                <img src="{{ $produto->thumbnail }}" alt="image" class="img-circle img-preview w-25">
                            </td>
                            <td class="text-center align-middle">
                                <button class="btn btn-primary" type="button" data-bs-target="#modalUpdateProduto" data-bs-toggle="modal" data-dados="{{ $produto }}"><i class="fa fa-pen"></i></button>
                                <button class="btn btn-danger" type="button" data-bs-target="#modalDeleteProduto" data-bs-toggle="modal" data-id="{{ $produto->id }}"><i class="fa fa-trash"></i></button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <div class="text-center" colspan="5">
                                <img src="{{ asset('assets/logging-off.svg') }}" alt="Nenhum produto cadastrado..." width="200px">
                                <h2 class="text-center">Nenhum produto cadastrado...</h2>
                            </div>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('modals')
@include('admin.produto._modals')
@endsection

@section('scripts')
@include('admin.produto._scripts')
@endsection
