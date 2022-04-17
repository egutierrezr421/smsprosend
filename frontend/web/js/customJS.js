$(function() {

    $('.modalButton').click(function (e) {
        e.preventDefault();
        $('#myModal').modal('show')
            .find('#modalContent')
            .load($(this).attr('href'));
    });

});