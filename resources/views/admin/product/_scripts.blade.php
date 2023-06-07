<script>
    $(document).ready(function () {
        $("#category_create").select2({
            placeholder: "Select a category",
            width: "100%",
            dropdownParent: $("#modalCreateProducts .modal-body")
        });

        $("#category_update").select2({
            placeholder: "Select a category",
            width: "100%",
            dropdownParent: $("#modalUpdateProducts .modal-body")
        });

        $(".mask-money").unmask().mask("#.##0,00", {
            reverse: true,
            placeholder: "0,00"
        });
    });

    $("#modalUpdateProducts").on("show.bs.modal", function (event) {
        var product = $(event.relatedTarget).data("product");
        var modal = $(this);

        modal.find("#id").val(product.id);
        modal.find("#category_update option[value='" + product.category_id + "']").prop("selected", true).trigger("change");
        modal.find("#name_update").val(product.title);
        modal.find("#price_update").val(product.price);
        modal.find("#discount_update").val(product.discountPercentage);
        modal.find("#description_update").val(product.description);
        modal.find("#stock_update").val(product.stock);
        modal.find("#brand_update").val(product.brand);
    });

    $("#modalDeleteProducts").on("show.bs.modal", function (event) {
        $(this).find("#id").val($(event.relatedTarget).data("id"));
    });

    $(".custom-file-label").on("change", function () {
        var fileName = $(this).val().split("\\").pop();
        $(this).siblings(".custom-file-label").html(fileName);
    });
</script>
