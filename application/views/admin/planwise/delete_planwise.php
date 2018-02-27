<div class="modal-body">
    <div class="row">
        <div class="col-md-10">
            <div id="delete_planwise_success" class="alert alert-success" style="display:none;">Plan details deleted successfully.</div>
            <div id="delete_planwise_error" class="alert alert-danger" style="display:none;">Failed to delete plan details.</div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-10">
            <input type="hidden" id="delete_planwise_id" name="delete_planwise_id" value="<?php echo $s_id ?>">
            <p>Are you sure want to delete this plan details?</p>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="submit" class="btn blue">Yes</button>
    <button type="button" data-dismiss="modal" class="btn default">No</button>
</div>