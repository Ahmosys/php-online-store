/////// Modal home
$(document).ready(function () {
if ($.cookie('modal_shown') == null) {
        $.cookie('modal_shown', 'yes', { expires: 1, path: '/' });
        $("#myModal").modal('show');
    }
    
/////// Modal delete account

$("#btnDeleteAccount").click(function () {
        $("#myModalDelete").modal('show');
    });
    
    
});


