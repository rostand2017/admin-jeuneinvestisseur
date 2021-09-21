$(document).ready(function() {

    // init ckeditor
    var editor;
    function editCkeditor() {
        return  DecoupledEditor
            .create( document.querySelector( '#editor' ), {
                placeholder: 'Ajoutez un contenu à cette section'
            })
            .then( function (value) {
                editor = value;
                const toolbarContainer = document.querySelector( '#toolbar-container' );
                toolbarContainer.prepend( value.ui.view.toolbar.element );
                value.model.document.on( 'change:data', function(){
                    $("#paragraph").val(editor.getData());
                });
            })
            .catch(function (reason) { console.error(reason); });
    }
    editCkeditor();

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
        editor.setData("");
        $('#alert').get(0).innerHTML = "";
        $("#form").attr('action', $(this).data('url'));
    });

    $('#newModal2').on('click', function () {
        $('#form').get(0).reset();
        editor.setData("");
        $('#alert').get(0).innerHTML = "";
        $("#form").attr('action', $(this).data('url'));
    });

    $('.editModal').on('click', function () {
        editor.setData($(this).data('paragraph'));
        $("#form").attr('action', $(this).data('url'));
    });
});