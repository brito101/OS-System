const changeTradeStatusComplement = () => {
    if ($("#trade_status option:selected").val() === "Venda Realizada") {
        $("#status_sale_container").show();
    } else {
        $("#status_sale_container").hide();
    }
    if ($("#trade_status option:selected").val() === "Recusado") {
        $("#reason_refusal_container").show();
    } else {
        $("#reason_refusal_container").hide();
    }
};

changeTradeStatusComplement();
$("#trade_status").on("change", function (e) {
    changeTradeStatusComplement();
});
