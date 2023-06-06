{{-- MODAL CREATE PRODUTOS --}}
<div id="modalCreateProduto" class="modal inmodal fade" tabindex="-1" role="dialog" aria-modal="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" type="button" data-bs-dismiss="modal" aria-label="Fechar"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Adicionar Produto</h4>
            </div>
            <form action="{{ route('produtos.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="categoria">Categoria</label>
                            <select name="categoria_id" id="categoria_create" class="form-control">
                                <option value=""></option>
                                @foreach ($categorias as $categoria)
                                    <option value="{{ $categoria->id }}">{{ $categoria->nome }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="nome">Nome</label>
                            <input type="text" name="nome" id="nome" class="form-control" placeholder="Nome do produto" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="preco">Preço</label>
                            <input type="text" name="preco" id="preco_create" class="form-control mask-money" placeholder="Preço do produto" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="desconto">Desconto</label>
                            <input type="text" name="desconto" id="desconto_create" class="form-control mask-money" placeholder="Desconto do produto">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="descricao">Descrição</label>
                            <textarea name="descricao" id="descricao" class="form-control" placeholder="Descrição do produto" required></textarea>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="estoque">Estoque</label>
                            <input type="number" name="estoque" id="estoque" class="form-control" placeholder="Estoque do produto" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="marca">Marca</label>
                            <input type="text" name="marca" id="marca_create" class="form-control" placeholder="Marca do produto">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="imagem">Thumbnail</label>
                            <div class="col-md-12 mt-2 mb-2 custom-file">
                                <input type="file" name="thumbnail" id="thumbnail" class="custom-file-input">
                                <label class="custom-file-label" for="thumbnail"></label>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="imagens">Imagens</label>
                            <div class="col-md-12 mt-2 mb-2 custom-file">
                                <input type="file" name="imagens[]" id="imagens" class="custom-file-input" multiple>
                                <label class="custom-file-label" for="imagens"></label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-outline-primary" type="button" data-bs-dismiss="modal">Cancelar</button>
                    <button class="btn btn-primary" type="submit">Salvar</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- MODAL UPDATE PRODUTOS --}}
<div id="modalUpdateProduto" class="modal inmodal fade" tabindex="-1" role="dialog" aria-modal="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" type="button" data-bs-dismiss="modal" aria-label="Fechar"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Atualizar Produto</h4>
            </div>
            <form action="{{ route('produtos.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method("PUT")
                <input type="hidden" name="id" id="id">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="categoria">Categoria</label>
                            <select name="categoria_id" id="categoria_update" class="form-control">
                                <option value=""></option>
                                @foreach ($categorias as $categoria)
                                    <option value="{{ $categoria->id }}">{{ $categoria->nome }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="nome">Nome</label>
                            <input type="text" name="nome" id="nome_update" class="form-control" placeholder="Nome do produto" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="preco">Preço</label>
                            <input type="text" name="preco" id="preco_update" class="form-control mask-money" placeholder="Preço do produto" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="desconto">Desconto</label>
                            <input type="text" name="desconto" id="desconto_update" class="form-control mask-money" placeholder="Desconto do produto">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="descricao">Descrição</label>
                            <textarea name="descricao" id="descricao_update" class="form-control" placeholder="Descrição do produto" required></textarea>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="estoque">Estoque</label>
                            <input type="number" name="estoque" id="estoque_update" class="form-control" placeholder="Estoque do produto" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="marca">Marca</label>
                            <input type="text" name="marca" id="marca_update" class="form-control" placeholder="Marca do produto">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="imagem">Thumbnail</label>
                            <div class="col-md-12 mt-2 mb-2 custom-file">
                                <input type="file" name="thumbnail" id="thumbnail_update" class="custom-file-input">
                                <label class="custom-file-label" for="thumbnail"></label>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="imagens">Imagens</label>
                            <div class="col-md-12 mt-2 mb-2 custom-file">
                                <input type="file" name="imagens[]" id="imagens_update" class="custom-file-input" multiple>
                                <label class="custom-file-label" for="imagens"></label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-outline-primary" data-bs-dismiss="modal" type="button">Cancelar</button>
                    <button class="btn btn-primary" type="submit">Atualizar</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- MODAL DELETE PRODUTOS --}}
<div id="modalDeleteProduto" class="modal inmodal fade" tabindex="-1" role="dialog" aria-modal="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" type="button" data-bs-dismiss="modal" aria-label="Fechar"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Excluir Produto</h4>
            </div>
            <div class="modal-body">
                <h5 class="text-center">Deseja realmente <strong>excluir</strong> este produto?</h5>
                <span class="text-muted">Esta ação não poderá ser desfeita.</span>
            </div>
            <form action="{{ route('produtos.destroy') }}" method="POST">
                @csrf
                @method("DELETE")
                <input type="hidden" name="id" id="id">
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-danger">Excluir</button>
                </div>
            </form>
        </div>
    </div>
</div>
