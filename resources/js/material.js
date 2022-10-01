$(document).ready(function () {
    let item = $("[data-material-qtd]").data('materialQtd') || 0;

    $("[data-material]").on("click", function (e) {
        e.preventDefault();
        let action = $(e.target).data("material");
        if (action === "open") {
            item++;
            let html = `<div class="col-12 form-group px-0" id="container_material_${item}">
                            <label for="material_${item}">Material</label>
                                <input type="text" class="form-control" id="material_${item}" placeholder="Descrição do Material" name="material_${item}" value="" maxlength="191">
                        </div>`;
            $("#material").append(html);
        }
        if (action === "close" && item >= 0) {
            $(`#container_material_${item}`).remove();
            $(`#material_${item}`).remove();
            item--;
        }
    });
});
