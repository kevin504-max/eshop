@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header">
            <h1>Página de categoria</h1>
            <button class="btn btn-primary mr-0" data-bs-toggle="modal" data-bs-target="#modalCreateCategoria"><i class="fa fa-plus"></i> Adicionar categoria</button>
        </div>
        <div class="card-body">
            <table class="table table-stripped table-hover">
                <thead>
                    <tr>
                        <th class="text-center">ID</th>
                        <th class="text-center">Nome</th>
                        <th class="text-center">Descrição</th>
                        <th class="text-center">Imagem</th>
                        <th class="text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($categorias as $categoria)
                        <tr>
                            <td class="text-center align-middle">{{ $categoria->id }}</td>
                            <td class="text-center align-middle">{{ $categoria->nome }}</td>
                            <td class="text-center align-middle">{{ $categoria->descricao }}</td>
                            <td class="text-center align-middle">
                                <img src="{{ asset('assets/uploads/categoria/' . $categoria->imagem) }}" alt="foto" class="w-25">
                            </td>
                            <td class="text-center align-middle">
                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalUpdateCategoria" data-dados="{{ $categoria }}">Atualizar</button>
                                <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalDeleteCategoria" data-id="{{ $categoria->id }}">Excluir</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <div class="text-center" colspan="5">
                                <img src="{{ asset('assets/logging-off.svg') }}" alt="Nenhuma categoria cadastrada..." width="200px">
                                <h2 class="text-center">Nenhuma categoria cadastrada...</h2>
                            </div>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('modals')
@include('admin.categoria._modals')
@endsection

@section('scripts')
@include('admin.categoria._scripts')
@endsection
