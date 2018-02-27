<div class="modal-body">    <div class="row">        <div class="col-md-10">            <div id="admin_delete_card_success" class="alert alert-success" style="display:none;">Card deleted successfully.</div>            <div id="admin_delete_card_error" class="alert alert-danger" style="display:none;">Failed to delete card details.</div>        </div>    </div>    <div class="row">        <div class="col-md-10">            <input type="hidden" id="delete_card_id" name="delete_card_id" value="<?php echo $card_id ?>">            <p>Are you sure want to delete this card? </p>        </div>    </div></div><div class="modal-footer">    <button type="submit" class="btn blue">Yes</button>    <button type="button" data-dismiss="modal" class="btn default">No</button></div><script>    $(document).ready(function () {        $('#delete_admin_card_form').submit(function (e) {            e.preventDefault();            var formdata = {                delete_card_id: $('#delete_card_id').val()            };            $.ajax({                url: "<?php echo site_url('Admin/delete_carddetails') ?>",                type: 'post',                data: formdata,                success: function (msg) {                    if (msg == 'fail') {                        $('#admin_delete_card_error').show();                    }                    if (msg == 'success') {                        $('#admin_delete_card_success').show();                        window.location.reload();                    }                }            });        });    });</script>