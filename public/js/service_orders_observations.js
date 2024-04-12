$(document).ready(function () {
    let item = $("[data-observation-qtd]").data("observationQtd") || 0;
    $("[data-observation]").on("click", function (e) {
        e.preventDefault();
        let action = $(e.target).data("observation");
        if (action === "open") {
            item++;
            let html = `
                <div class="col-12 form-group px-0 d-flex flex-wrap justify-content-start" id="container_observation_${item}">
                    <div class="col-12 col-md-9 px-0 pr-md-2">
                        <textarea class="form-control" id="observation_${item}" placeholder="Observação sobre a execução" name="observation_${item}" rows="2"></textarea>
                    </div>
                    <div class="col-12 col-md-3 px-0 pl-md-2 mt-2 mt-md-0">
                        <input class="form-control" type="date" id="observation_${item}_date" name="observation_${item}_date" required>
                    </div>
                </div>`;
            $("#observation").append(html);
        }
        if (action === "close" && item >= 0) {
            $(`#container_observation_${item}`).remove();
            $(`#observation_${item}`).remove();
            $(`#observation_${item}_date`).remove();
            item--;
        }
    });
});
