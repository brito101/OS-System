$(document).ready((function(){$("#zipcode").inputmask("99.999-999"),$("#state").inputmask("AA"),$("#zipcode").blur((function(){function a(){$("#street").val(""),$("#neighborhood").val(""),$("#city").val(""),$("#state").val("")}var t=$(this).val().replace(/\D/g,"");""!=t&&/^[0-9]{8}$/.test(t)?($("#street").val(""),$("#neighborhood").val(""),$("#city").val(""),$("#state").val(""),$.getJSON("https://viacep.com.br/ws/"+t+"/json/?callback=?",(function(t){if("erro"in t)a(),alert("CEP não encontrado.");else{$("#street").val(t.logradouro),$("#neighborhood").val(t.bairro),$("#city").val(t.localidade),$("#state").val(t.uf),Array.from($("#subsidiary_id")[0].options).forEach((a=>{a.dataset.state==t.uf&&$("#subsidiary_id").val(a.value).select2()}))}}))):(a(),alert("Formato de CEP inválido."))}))}));