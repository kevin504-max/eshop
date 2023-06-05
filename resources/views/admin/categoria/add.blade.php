@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header">
            <h4>Adicionar Categoria</h4>
        </div>
        <div class="card-body">
            <form action="{{ url('store-categoria') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="nome">Nome</label>
                        <input type="text" class="form-control" name="nome" placeholder="e.g. Jogos">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="nome">Slug</label>
                        <input type="text" class="form-control" name="slug" placeholder="e.g. jogos">
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="nome">Descrição</label>
                        <textarea name="descricao" class="form-control" rows="3" placeholder="Digite aqui...    "></textarea>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="status">Status</label>
                        <input type="checkbox" name="status">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="popular">Popular</label>
                        <input type="checkbox" name="popular">
                    </div>
                    <div class="col-md-12 mb-2">
                        <label for="meta_titulo">Meta Título</label>
                        <input type="text" name="meta_titulo" class="form-control">
                    </div>
                    <div class="col-md-12 mb-2">
                        <label for="meta_keywords">Meta Keywords</label>
                        <textarea name="meta_keywords" rows="3" class="form-control"></textarea>
                    </div>
                    <div class="col-md-12 mb-2">
                        <label for="meta_descricao">Meta Descrição</label>
                        <textarea name="meta_descricao" rows="3" class="form-control"></textarea>
                    </div>
                    <div class="col-md-12 mb-2 custom-file">
                        <input type="file" name="imagem" class="custom-file-input" id="imagem">
                        <label class="custom-file-label" for="imagem">Escolha uma imagem</label>
                    </div>
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary mt-3">Salvar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
