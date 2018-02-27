<?php
$admin_id = $this->session->userdata('admin_id');
?>
<script src="<?php echo site_url('assets/global/validation/main-gsap.js') ?>"></script>
<script src="<?php echo site_url('assets/global/validation/resizeable.js') ?>"></script>
<script src="<?php echo site_url('assets/global/validation/jquery.validate.min.js') ?>"></script>
<script src="<?php echo site_url('assets/global/validation/custom.js') ?>"></script>
<script>
    $(document).ready(function () {
        $('#admin_reset_form').submit(function (e) {
            e.preventDefault();
            var formdata = {
                admin_id: $('#admin_id').val(),
                current_pwd: $("#admin_current_pwd").val(),
                new_pwd: $("#admin_new_pwd").val()
            };
            $.ajax({
                url: "<?php echo site_url('Admin/reset_pwd') ?>",
                type: 'post',
                data: formdata,
                success: function (msg) {
                    if (msg.trim() == "success") {
                        $('#adminreset_error').hide();
                        $('#adminreset_invalid').hide();
                        $('#adminreset_success').show();
                    }
                    if (msg.trim() == "fail") {
                        $('#adminreset_success').hide();
                        $('#adminreset_invalid').hide();
                        $('#adminreset_error').show();
                    }
                    if (msg.trim() == "invalid") {
                        $('#adminreset_success').hide();
                        $('#adminreset_error').hide();
                        $('#adminreset_invalid').show();
                    }
                }
            });
        });
    });
</script>
<!-- BEGIN FORM-->
<div class="page-content-wrapper">
    <div class="page-content">
        <div class="row">
            <div class="col-md-12">
                <div class="portlet box blue">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="icon-user"></i> Reset Password
                        </div>
                    </div>
                    <div class="portlet-body">
                        <form class="form-horizontal validate admin-reset-form" id="admin_reset_form" method="POST">
                            <div class="col-md-10">
                                <div id="adminreset_success" class="alert alert-success" style="display:none;">Your password changed successfully.</div>
                                <div id="adminreset_error" class="alert alert-danger" style="display:none;">Failed to update the password.</div>
                                <div id="adminreset_invalid" class="alert alert-danger" style="display:none;">Current password is invalid.</div>
                            </div>
                            <input type="hidden" id="admin_id" name="admin_id" value="<?php echo $admin_id ?>">
                            <div class="form-group">
                                <label class="control-label col-md-2">Current Password <span class="required">*</span></label>
                                <div class="col-md-3">
                                    <div class="form-group form-md-line-input has-info">
                                        <input type="password" class="form-control input-sm" name="admin_current_pwd" id="admin_current_pwd" autocomplete="off" data-validate="required" data-message-required="Please enter your current password">
                                    </div>
                                </div>
                                <label class="control-label col-md-2">New Password <span class="required">*</span></label>
                                <div class="col-md-3">
                                    <div class="form-group form-md-line-input has-info">
                                        <input type="password" class="form-control input-sm" name="admin_new_pwd" id="admin_new_pwd" autocomplete="off" data-validate="required" data-message-required="Please enter new password">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <button class="btn blue" type="submit">Update</button>
                                </div>
                            </div> 
                        </form>
                    </div>
                </div>            
            </div>
        </div>
        <!-- END PAGE CONTENT-->
    </div>
</div>