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
                $('#sendBtn').text('Patientez...').prop('disabled',true);
                $('#alert').get(0).innerHTML = "";
            },
            success: function (json) {
                if (json.status === 0){
                    $('#category').val('');
                    $('#description').val('');
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
                $('#sendBtn').text('Enregistrer').prop('disabled',false);
            },
            error: function(jqXHR, textStatus, errorThrown){}
        });
    });

    $('#newModal').on('click', function () {
        $('#form').get(0).reset();
        $('#alert').get(0).innerHTML = "";
        $('#id').val('');
    });

    $('.editModal').on('click', function () {
        $('#category').val($(this).data('category'));
        $('#description').val($(this).data('description'));
        $('#id').val($(this).data('id'));
    });

    $('.deleteElt').on('click', function (e) {
        e.preventDefault();
        var url = $(this).data('url');
        swal({
                title: "Warning",
                text: "Êtes vous sûr de vouloir supprimer cette catégorie?",
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
});