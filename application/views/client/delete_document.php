<div class="modal-body">    <div class="row">        <div class="col-md-10">            <div id="delete_document_success" class="alert alert-success" style="display:none;">Order upload document delete successfully.</div>            <div id="delete_document_error" class="alert alert-danger" style="display:none;">Failed to upload document details.</div>        </div>    </div>        <div class="row">        <div class="col-md-10">            <input type="hidden" id="delete_document_id" name="delete_document_id" value="<?php echo $doc_id; ?>">            <p>Are you sure want to delete this order user Upload document?<?php echo $doc_id; ?> </p>        </div>    </div></div><div class="modal-footer">    <button type="submit" class="btn blue">Yes</button>    <button type="button" data-dismiss="modal" class="btn default">No</button></div><script>    $(document).ready(function () {        $('#deletedocument_form').submit(function (e) {            e.preventDefault();            var formdata = {                delete_document_id: $('#delete_document_id').val()                            };                        $.ajax({                                url: "<?php echo site_url('Client/delete_document') ?>",   //function name                type: 'post',                data: formdata,                success: function (msg) {                                         if (msg == 'fail') {                        $('#delete_document_error').show();                    }                    if (msg == 'success') {                                                $('#delete_document_success').show();                        window.location.reload();                    }                }            });        });    });</script>