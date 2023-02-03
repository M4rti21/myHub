$("#chars_left").html(4000 - $("#descEdit").val().length);
if ($("#descEdit").val().length < 4001) {
    $("#chars_left").removeClass("text-danger");
    $("#chars_left").addClass("text-success");
} else {
    $("#chars_left").removeClass("text-success");
    $("#chars_left").addClass("text-danger");
}
$("#descEdit").on("input selectionchange propertychange", function () {
    $("#chars_left").html(4000 - $(this).val().length);
    if ($(this).val().length < 4001) {
        $("#chars_left").removeClass("text-danger");
        $("#chars_left").addClass("text-success");
    } else {
        $("#chars_left").removeClass("text-success");
        $("#chars_left").addClass("text-danger");
    }
});