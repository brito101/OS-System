$(document).ready((function(){let o=$("[data-observation-qtd]").data("observationQtd")||0;$("[data-observation]").on("click",(function(e){e.preventDefault();let t=$(e.target).data("observation");if("open"===t){o++;let e=`\n                <div class="col-12 form-group px-0 d-flex flex-wrap justify-content-start" id="container_observation_${o}">\n                    <div class="col-12 col-md-9 px-0 pr-md-2">\n                        <textarea class="form-control" id="observation_${o}" placeholder="Observação sobre a execução" name="observation_${o}" rows="2"></textarea>\n                    </div>\n                     <div class="col-12 col-md-3 px-0 pl-md-2">\n                        <input class="form-control" type="date" id="observation_${o}_date" name="observation_${o}_date" required>\n                    </div>\n                </div>`;$("#observation").append(e)}"close"===t&&o>=0&&($(`#container_observation_${o}`).remove(),$(`#observation_${o}`).remove(),$(`#observation_${o}_date`).remove(),o--)}))}));
