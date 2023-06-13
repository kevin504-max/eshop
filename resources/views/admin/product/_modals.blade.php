{{-- MODAL CREATE PRODUCTS --}}
<div id="modalCreateProducts" class="modal inmodal fade" tabindex="-1" role="dialog" aria-modal="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Register Product</h4>
            </div>
            <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="category">Category</label>
                            <select name="category_id" id="category_create" class="form-control">
                                <option value=""></option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="name">Name</label>
                            <input type="text" name="name" id="name_create" class="form-control" placeholder="Product name" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="price">Price</label>
                            <input type="text" name="price" id="price_create" class="form-control mask-money" placeholder="Product price" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="discount">Discount</label>
                            <input type="text" name="discount" id="discount_create" class="form-control mask-money" placeholder="Product discount">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="description">Description</label>
                            <textarea name="description" id="description_create" class="form-control" placeholder="Product description" required></textarea>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="stock">Stock</label>
                            <input type="number" name="stock" id="stock_create" class="form-control" placeholder="Product stock" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="brand">Brand</label>
                            <input type="text" name="brand" id="brand_create" class="form-control" placeholder="Product brand">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="thumbnail">Thumbnail</label>
                            <div class="col-md-12 mt-2 mb-2 custom-file">
                                <input type="file" name="thumbnail" id="thumbnail_create" class="custom-file-input">
                                <label class="custom-file-label" for="thumbnail_create"></label>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="images">Images</label>
                            <div class="col-md-12 mt-2 mb-2 custom-file">
                                <input type="file" name="images[]" id="images" class="custom-file-input" multiple>
                                <label class="custom-file-label" for="images"></label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-outline-primary" type="button" data-bs-dismiss="modal">Cancel</button>
                    <button class="btn btn-primary" type="submit">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- MODAL UPDATE PRODUCTS --}}
<div id="modalUpdateProducts" class="modal inmodal fade" tabindex="-1" role="dialog" aria-modal="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" type="button" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Update Product</h4>
            </div>
            <form action="{{ route('products.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method("PUT")
                <input type="hidden" name="id" id="id">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="category">Category</label>
                            <select name="category_id" id="category_update" class="form-control">
                                <option value=""></option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="name">Name</label>
                            <input type="text" name="name" id="name_update" class="form-control" placeholder="Product name" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="price">Price</label>
                            <input type="text" name="price" id="price_update" class="form-control mask-money" placeholder="Product price" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="discount">Discount Percentage</label>
                            <input type="text" name="discount" id="discount_update" class="form-control mask-money" placeholder="Product discount">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="description">Description</label>
                            <textarea name="description" id="description_update" class="form-control" placeholder="Product description" required></textarea>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="stock">Stock</label>
                            <input type="number" name="stock" id="stock_update" class="form-control" placeholder="Product stock" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="brand">Brand</label>
                            <input type="text" name="brand" id="brand_update" class="form-control" placeholder="Product brand">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="thumbnail">Thumbnail</label>
                            <div class="col-md-12 mt-2 mb-2 custom-file">
                                <input type="file" name="thumbnail" id="thumbnail_update" class="custom-file-input">
                                <label class="custom-file-label" for="thumbnail_update"></label>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="images">Images</label>
                            <div class="col-md-12 mt-2 mb-2 custom-file">
                                <input type="file" name="images[]" id="images_update" class="custom-file-input" multiple>
                                <label class="custom-file-label" for="images_update"></label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-outline-primary" data-bs-dismiss="modal" type="button">Cancel</button>
                    <button class="btn btn-primary" type="submit">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- MODAL DELETE PRODUCTS --}}
<div id="modalDeleteProducts" class="modal inmodal fade" tabindex="-1" role="dialog" aria-modal="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" type="button" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Delete Product</h4>
            </div>
            <div class="modal-body">
                <h5 class="text-center">Are you sure you want to <strong>delete</strong> this product?</h5>
                <span class="text-muted">This operation cannot be undone.</span>
            </div>
            <form action="{{ route('products.destroy') }}" method="POST">
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
