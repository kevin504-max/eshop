<script>
    $(document).ready(function () {
        $("#modalUpdateCategory").on("show.bs.modal", function (event) {
            var category = $(event.relatedTarget).data("category");
            var modal = $(this);

            modal.find("#id").val(category.id);
            modal.find("#name_update").val(category.name);
            modal.find("#slug_update").val(category.slug);
            modal.find("#description_update").val(category.description);

            (category.status) ?
            modal.find("#status_update").attr("checked", "checked") :
            modal.find("#status_update").removeAttr("checked");

            (category.popular) ?
            modal.find("#popular_update").attr("checked", "checked") :
            modal.find("#popular_update").removeAttr("checked");

            modal.find("#meta_title_update").val(category.meta_title);
            modal.find("#meta_keywords_update").val(category.meta_keywords);
            modal.find("#meta_description_update").val(category.meta_description);
        });

        $("#modalDeleteCategory").on("show.bs.modal", function (event) {
            $(this).find("#id").val($(event.relatedTarget).data("id"));
        });
    });

    $(".custom-file-label").on("change", function () {
        var fileName = $(this).val().split("\\").pop();
        $(this).siblings(".custom-file-label").html(fileName);
    });
</script>
