$(document).ready(function() {
    $('#form').on('submit', function (e) {
        e.preventDefault();
        var formdata = (window.FormData) ? new FormData($(this)[0]) : null;
        var data = (formdata !== null) ? formdata : $(this).serialize();
        $.ajax({
            type: 'post',
            url: $("#form").attr('action'),
            data: data,
            datatype: 'json',
            processData: false,
            contentType: false,
            beforeSend: function () {
                $('#sendBtn').prop('disabled',true);
                $('#textSendBtn').text('Patientez...');
                $('#loadSendBtn').show();
                $('#alert').get(0).innerHTML = "";
            },
            success: function (json) {
                if (json.status === 0){
                    $('#category').val('');
                    $('#alert').append(
                        "<span class='alert alert-success'>"+ json.mes +"</span>"
                    );
                    setTimeout(function () {
                        window.location.reload();
                    }, 2000);
                }else{
                    $('#alert').append(
                        "<span class='alert alert-danger'>"+ json.mes +"</span>"
                    );
                }
            },
            complete: function () {
                $('#sendBtn').prop('disabled',false);
                $('#loadSendBtn').hide();
                $('#textSendBtn').text('Enregistrer');
            },
            error: function(jqXHR, textStatus, errorThrown){}
        });
    });

    $('#newModal').on('click', function () {
        $('#form').get(0).reset();
        $('#alert').get(0).innerHTML = "";
        $('#form').attr('action', $(this).data('url'));
    });

    $('.editModal').on('click', function () {
        $('#title').val($(this).data('title'));
        $('#description').val($(this).data('description'));
        $('#price').val($(this).data('price'));
        $('#category').val($(this).data('category'));
        $('#form').attr('action', $(this).data('url'));
    });

    $('.deleteElt').on('click', function (e) {
        e.preventDefault();
        var url = $(this).data('url');
        swal({
                title: "Warning",
                text: "Êtes vous sûr de vouloir supprimer ce cours?",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Oui",
                cancelButtonText: "Annuler",
                closeOnConfirm: true
            },
            function(isConfirm){
                if (isConfirm) {
                    $.ajax({
                        type: 'post',
                        url : url,
                        datatype: 'json',
                        success: function (json) {
                            if (json.status === 0) {
                                window.location.reload();
                            } else {
                                // toastr.error(json.mes,'Oups!');
                            }
                        },
                        error: function(jqXHR, textStatus, errorThrown){}
                    });
                }
            });
    });

    $('.videoLink').on('click', function (e) {
        e.preventDefault();
        $("#videoPlayer").attr('src', $(this).attr('chref'));
    });
});