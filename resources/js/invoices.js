const repetition = $('select[name="repetition"]');
if (repetition.val() == "única") {
    $("#quota_field").val("").hide();
    $("#entrance_field").val("").hide();
}
repetition.on("change", function () {
    if (repetition.val() == "única") {
        $("#quota_field").val("").hide();
        $("#entrance_field").val("").hide();
    } else {
        $("#quota_field").show();
        $("#entrance_field").show();
    }
});
