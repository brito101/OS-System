$(document).ready((function(){let a=$("[data-material-qtd]").data("materialQtd")||0;$("[data-material]").on("click",(function(e){e.preventDefault();let t=$(e.target).data("material");if("open"===t){a++;let e=`<div class="col-12 form-group px-0" id="container_material_${a}">\n                            <label for="material_${a}">Material</label>\n                                <input type="text" class="form-control" id="material_${a}" placeholder="Descrição do Material" name="material_${a}" value="" maxlength="191">\n                        </div>`;$("#material").append(e)}"close"===t&&a>=0&&($(`#container_material_${a}`).remove(),$(`#material_${a}`).remove(),a--)}))}));