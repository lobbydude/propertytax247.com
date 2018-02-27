<div class="modal-body">
    <div class="row">
        <div class="col-md-10">
            <div id="delete_price_success" class="alert alert-success" style="display:none;">Price details deleted successfully.</div>
            <div id="delete_price_error" class="alert alert-danger" style="display:none;">Failed to delete Price details.</div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-10">
            <input type="hidden" id="delete_price_id" name="delete_price_id" value="<?php echo $price_id ?>">
            <p>Are you sure want to delete this plan price?</p>
        </div>
        
    </div>
</div>
<div class="modal-footer">
    <button type="submit" class="btn blue">Yes</button>
    <button type="button" data-dismiss="modal" class="btn default">No</button>
</div>