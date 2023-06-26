{{-- MODAL CREATE CATEGORY --}}
<div id="modalCreateCategory" class="modal inmodal fade" tabindex="-1" role="dialog" aria-modal="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" type="button" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Register Category</h4>
            </div>
            <form action="{{ route('categories.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" name="name" placeholder="e.g. Eletronics">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="slug">Slug</label>
                            <input type="text" class="form-control" name="slug" placeholder="e.g. eletronics">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="description">Description</label>
                            <textarea name="description" class="form-control" rows="3" placeholder="Type here..."></textarea>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="status">Status</label>
                            <input type="checkbox" name="status" id="status_create">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="popular">Popular</label>
                            <input type="checkbox" name="popular" id="popular_create">
                        </div>
                        <div class="col-md-12 mt-2 mb-2 custom-file">
                            <input type="file" name="image" class="custom-file-input" id="image_create">
                            <label class="custom-file-label" for="image_create"></label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- MODAL UPDATE CATEGORY --}}
<div id="modalUpdateCategory" class="modal inmodal fade" tabindex="-1" role="dialoga" aria-modal=true>
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" type="button" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Update Category</h4>
            </div>
            <form action="{{ route('categories.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method("PUT")
                <input type="hidden" name="id" id="id">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" name="name" id="name_update" placeholder="e.g. Eletronics">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="slug">Slug</label>
                            <input type="text" class="form-control" name="slug" id="slug_update" placeholder="e.g. eletronics">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="description">Description</label>
                            <textarea name="description" id="description_update" class="form-control" rows="3" placeholder="Type here..."></textarea>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="status">Status</label>
                            <input type="checkbox" name="status" id="status_update">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="popular">Popular</label>
                            <input type="checkbox" name="popular" id="popular_update">
                        </div>
                        <div class="col-md-12 mt-2 mb-2 custom-file">
                            <input type="file" name="image" id="image_update" class="custom-file-input">
                            <label class="custom-file-label" for="image_update"></label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- MODAL DELETE CATEGORY --}}
<div id="modalDeleteCategory" class="modal inmodal fade" tabindex="-1" role="dialog" aria-modal="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" type="button" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Delete Category</h4>
            </div>
            <div class="modal-body">
                <h5 class="text-center">Are you sure you want to <strong>delete</strong> this category?</h5>
                <span class="text-muted">This operation cannot be undone.</span>
            </div>
            <form action="{{ route('categories.destroy') }}" method="POST">
                @csrf
                @method("DELETE")
                <input type="hidden" name="id" id="id">
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>
