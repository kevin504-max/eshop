<script>
    $(document).ready(function () {
        $("#modalUpdateCategoria").on("show.bs.modal", function (event) {
            var categoria = $(event.relatedTarget).data("dados");
            var modal = $(this);

            modal.find("#id").val(categoria.id);
            modal.find("#nome_update").val(categoria.nome);
            modal.find("#slug_update").val(categoria.slug);
            modal.find("#descricao_update").val(categoria.descricao);

            (categoria.status) ?
            modal.find("#status_update").attr("checked", "checked") :
            modal.find("#status_update").removeAttr("checked");

            (categoria.popular) ?
            modal.find("#popular_update").attr("checked", "checked") :
            modal.find("#popular_update").removeAttr("checked");

            modal.find("#meta_titulo_update").val(categoria.meta_titulo);
            modal.find("#meta_keywords_update").val(categoria.meta_keywords);
            modal.find("#meta_descricao_update").val(categoria.meta_descricao);
        });

        $("#modalDeleteCategoria").on("show.bs.modal", function (event) {
            $(this).find("#id").val($(event.relatedTarget).data("id"));
        });
    });

    $(".custom-file-label").on("change", function () {
        var fileName = $(this).val().split("\\").pop();
        $(this).siblings(".custom-file-label").html(fileName);
    });
</script>
