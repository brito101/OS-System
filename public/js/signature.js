let sig = $("#costumer_sig").signature({
    syncField: "#costumer_signature",
    syncFormat: "PNG",
});
$("#costumer_signature_clear").click(function (e) {
    e.preventDefault();
    sig.signature("clear");
    $("#signature64").val("");
});
