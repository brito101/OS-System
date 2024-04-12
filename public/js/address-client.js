$(document).ready(function () {
    $("#zipcode").inputmask("99.999-999");
    $("#state").inputmask("AA");

    $("#zipcode").blur(function () {
        function emptyForm() {
            $("#street").val("");
            $("#neighborhood").val("");
            $("#city").val("");
            $("#state").val("");
        }

        var zip_code = $(this).val().replace(/\D/g, "");
        var validate_zip_code = /^[0-9]{8}$/;

        if (zip_code != "" && validate_zip_code.test(zip_code)) {
            $("#street").val("");
            $("#neighborhood").val("");
            $("#city").val("");
            $("#state").val("");

            $.getJSON(
                "https://viacep.com.br/ws/" + zip_code + "/json/?callback=?",
                function (data) {
                    if (!("erro" in data)) {
                        $("#street").val(data.logradouro);
                        $("#neighborhood").val(data.bairro);
                        $("#city").val(data.localidade);
                        $("#state").val(data.uf);
                        let options = Array.from(
                            $("#subsidiary_id")[0].options
                        );
                        options.forEach((element) => {
                            if (element.dataset.state == data.uf) {
                                $("#subsidiary_id")
                                    .val(element.value)
                                    .select2();
                            }
                        });
                    } else {
                        emptyForm();
                        alert("CEP não encontrado.");
                    }
                }
            );
        } else {
            emptyForm();
            alert("Formato de CEP inválido.");
        }
    });
});
