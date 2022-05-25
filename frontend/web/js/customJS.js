$(function() {

    $('.btn-delete').click(function (e) {
        e.preventDefault();
        var url = $(this).attr('value');
        krajeeDialog.confirm('Are you sure', function(out){
            if(out) {
                alert('Yes'); // or do something on confirmation
            }
        });
    });

});