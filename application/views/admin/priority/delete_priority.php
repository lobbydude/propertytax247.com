<div class="modal-body">
    <div class="row">
        <div class="col-md-10">
            <div id="delete_priority_success" class="alert alert-success" style="display:none;">Priority details deleted successfully.</div>
            <div id="delete_priority_error" class="alert alert-danger" style="display:none;">Failed to delete priority details.</div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-10">
            <input type="hidden" id="delete_priority_id" name="delete_priority_id" value="<?php echo $priority_id ?>">
            <p>Are you sure want to delete this priority?</p>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="submit" class="btn blue">Yes</button>
    <button type="button" data-dismiss="modal" class="btn default">No</button>
</div>