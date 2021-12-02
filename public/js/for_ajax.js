$(document).ready(function () {
    deleteBtn41 = () => {
        $.ajax({
            url: $('.pir').data('url'),
            type: 'post',
            data: {
                "_method": 'DELETE',
                '_token': $('meta[name="csrf-token"]').attr('content'),
                "keys": window.sessionStorage.getItem($('.pir').data('storage'))
            },
            success: function (result) {
                deleted();
                location.reload()
            }
        });
    }
});
