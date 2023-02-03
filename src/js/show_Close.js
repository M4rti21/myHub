let toRemove = [];

$('#addForm').hide();
$('#showEdit').show();
$('#showConfirm').hide();
$('#showClose').hide();
$('#showAdd').hide();
$('.close_ico').hide();

$('#showEdit').on('click', function () {
    $(this).hide();
    $('#showConfirm').show();
    $('#showClose').show();
    $('#showAdd').show();
    $('.close_ico').show();
    $('#addForm').show();
});

$('#showConfirm').on('click', function () {
    $(this).hide();
    $('#showEdit').show();
    $('#showClose').hide();
    $('#showAdd').hide();
    $('.close_ico').hide();
    $('#addForm').hide();
});


$(document).ready(function() {
    if ( $.cookie("scroll") !== null ) {
        $(document).scrollTop( $.cookie("scroll") );
    }
    $('#soc_submit').on("click", function() {
        $.cookie("scroll", $(document).scrollTop() );
    });

});
