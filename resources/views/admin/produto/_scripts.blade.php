<script>
    $(document).ready(function () {
        $("#categoria_create").select2({
            placeholder: "Selecione uma categoria",
            width: "100%",
            dropdownParent: $("#modalCreateProduto .modal-body")
        });

        $("#categoria_update").select2({
            placeholder: "Selecione uma categoria",
            width: "100%",
            dropdownParent: $("#modalUpdateProduto .modal-body")
        });

        $(".mask-money").unmask().mask("#.##0,00", {
            reverse: true,
            placeholder: "0,00"
        });
    });

    $("#modalUpdateProduto").on("show.bs.modal", function (event) {
        var produto = $(event.relatedTarget).data("dados");
        var modal = $(this);

        modal.find("#id").val(produto.id);
        modal.find("#categoria_update option[value='" + produto.category_id + "']").prop("selected", true).trigger("change");
        modal.find("#nome_update").val(produto.title);
        modal.find("#preco_update").val(produto.price);
        modal.find("#desconto_update").val(produto.discountPercentage);
        modal.find("#descricao_update").val(produto.description);
        modal.find("#estoque_update").val(produto.stock);
        modal.find("#marca_update").val(produto.brand);
    });

    $("#modalDeleteProduto").on("show.bs.modal", function (event) {
        $(this).find("#id").val($(event.relatedTarget).data("id"));
    });

    $(".custom-file-label").on("change", function () {
        var fileName = $(this).val().split("\\").pop();
        $(this).siblings(".custom-file-label").html(fileName);
    });
</script>
