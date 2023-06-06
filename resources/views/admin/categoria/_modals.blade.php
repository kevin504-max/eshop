{{-- MODAL CREATE CATEGORIA --}}
<div id="modalCreateCategoria" class="modal inmodal fade" tabindex="-1" role="dialog" aria-modal="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" type="button" data-bs-dismiss="modal" aria-label="Fechar"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Adicionar Categoria</h4>
            </div>
            <form action="{{ route('categorias.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
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
                            <input type="text" name="meta_titulo" class="form-control" placeholder="Digite aqui...">
                        </div>
                        <div class="col-md-12 mb-2">
                            <label for="meta_keywords">Meta Keywords</label>
                            <textarea name="meta_keywords" rows="3" class="form-control" placeholder="Digite aqui..."></textarea>
                        </div>
                        <div class="col-md-12 mb-2">
                            <label for="meta_descricao">Meta Descrição</label>
                            <textarea name="meta_descricao" rows="3" class="form-control" placeholder="Digite aqui..."></textarea>
                        </div>
                        <div class="col-md-12 mt-2 mb-2 custom-file">
                            <input type="file" name="imagem" class="custom-file-input" id="imagem">
                            <label class="custom-file-label" for="imagem">Escolha uma imagem</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Salvar</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- MODAL UPDATE CATEGORIA --}}
<div id="modalUpdateCategoria" class="modal inmodal fade" tabindex="-1" role="dialoga" aria-modal=true>
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" type="button" data-bs-dismiss="modal" aria-label="Fechar"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Atualizar Categoria</h4>
            </div>
            <form action="{{ route('categorias.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method("PUT")
                <input type="hidden" name="id" id="id">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nome">Nome</label>
                            <input type="text" class="form-control" name="nome" id="nome_update" placeholder="e.g. Jogos">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="nome">Slug</label>
                            <input type="text" class="form-control" name="slug" id="slug_update" placeholder="e.g. jogos">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="nome">Descrição</label>
                            <textarea name="descricao" id="descricao_update" class="form-control" rows="3" placeholder="Digite aqui...    "></textarea>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="status">Status</label>
                            <input type="checkbox" name="status" id="status_update">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="popular">Popular</label>
                            <input type="checkbox" name="popular" id="popular_update">
                        </div>
                        <div class="col-md-12 mb-2">
                            <label for="meta_titulo">Meta Título</label>
                            <input type="text" name="meta_titulo" id="meta_titulo_update" class="form-control" placeholder="Digite aqui...">
                        </div>
                        <div class="col-md-12 mb-2">
                            <label for="meta_keywords">Meta Keywords</label>
                            <textarea name="meta_keywords" id="meta_keywords_update" rows="3" class="form-control" placeholder="Digite aqui..."></textarea>
                        </div>
                        <div class="col-md-12 mb-2">
                            <label for="meta_descricao">Meta Descrição</label>
                            <textarea name="meta_descricao" id="meta_descricao_update" rows="3" class="form-control" placeholder="Digite aqui..."></textarea>
                        </div>
                        <div class="col-md-12 mt-2 mb-2 custom-file">
                            <input type="file" name="imagem" id="imagem_update" class="custom-file-input" id="imagem">
                            <label class="custom-file-label" for="imagem">Escolha uma imagem</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Atualizar</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- MODAL DELETE CATEGORIA --}}
<div id="modalDeleteCategoria" class="modal inmodal fade" tabindex="-1" role="dialog" aria-modal="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" type="button" data-bs-dismiss="modal" aria-label="Fechar"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Excluir Categoria</h4>
            </div>
            <div class="modal-body">
                <h5 class="text-center">Deseja realmente <strong>excluir</strong> esta categoria?</h5>
                <span class="text-muted">Esta ação não poderá ser desfeita.</span>
            </div>
            <form action="{{ route('categorias.destroy') }}" method="POST">
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
