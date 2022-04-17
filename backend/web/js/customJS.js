$(function() {

    $('.modalButton').click(function (e) {
        e.preventDefault();
        $('#modal').modal('show')
            .find('#modalContent')
            .load($(this).attr('href'));
    });

    $('.modalButtonView').click(function (e) {
        e.preventDefault();
        $('#modalview').modal('show')
            .find('#modalContentView')
            .load($(this).attr('href'));
    });

    $('.modalButtonCreate').click(function (e) {
        e.preventDefault();
        $('#modalcreate').modal('show')
            .find('#modalContentCreate')
            .load($(this).attr('href'));
    });

    $('.modalButtonUpdate').click(function (e) {
        e.preventDefault();
        $('#modalupdate').modal('show')
            .find('#modalContentUpdate')
            .load($(this).attr('href'));
    });

    $('.copy_btn').click(function (e) {
        e.preventDefault();
        var temp = $("<input>");
        $("body").append(temp);
        temp.val($(this).attr('value')).select();
        document.execCommand("copy");
        temp.remove();
        var label_copied = $(this).attr('data-copied-title');
        $(this).attr('data-original-title',label_copied).tooltip('show');
    });

    $('.modalImage').click(function (e) {
        e.preventDefault();
        var img = '<div class="text-center img-bordered"><img style="width: 85%;" src="'+$(this).attr('src')+'"></div>';
        $('#modal').modal('show').find('#modalContent').html(img);
    });

});