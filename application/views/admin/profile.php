<?php
$admin_id = $this->session->userdata('admin_id');
$this->db->where('Admin_Id', $admin_id);
$q_admin = $this->db->get('tbl_admin');
foreach ($q_admin->result() as $row_admin) {
    $admin_email = $row_admin->Admin_Email;
    $admin_username = $row_admin->Admin_Username;
}
?>
<script src="<?php echo site_url('assets/global/validation/main-gsap.js') ?>"></script>
<script src="<?php echo site_url('assets/global/validation/resizeable.js') ?>"></script>
<script src="<?php echo site_url('assets/global/validation/jquery.validate.min.js') ?>"></script>
<script src="<?php echo site_url('assets/global/validation/custom.js') ?>"></script>
<script>
    $(document).ready(function () {
        $('#admin_profile_form').submit(function (e) {
            e.preventDefault();
            var formdata = {
                admin_id: $('#admin_id').val(),
                username: $("#admin_username").val(),
                email: $("#admin_email").val()
            };
            $.ajax({
                url: "<?php echo site_url('Admin/edit_profile') ?>",
                type: 'post',
                data: formdata,
                success: function (msg) {
                    if (msg.trim() == "success") {
                        $('#adminprofile_error').hide();
                        $('#adminprofile_success').show();
                    }
                    if (msg.trim() == "fail") {
                        $('#adminprofile_success').hide();
                        $('#adminprofile_error').show();
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
                            <i class="icon-user"></i> Profile
                        </div>
                    </div>
                    <div class="portlet-body">
                        <form class="form-horizontal validate admin-profile-form" id="admin_profile_form" method="POST">
                            <div class="col-md-10">
                                <div id="adminprofile_success" class="alert alert-success" style="display:none;">Your account has been updated successfully.</div>
                                <div id="adminprofile_error" class="alert alert-danger" style="display:none;">Failed to update the account details.</div>
                            </div>
                            <input type="hidden" id="admin_id" name="admin_id" value="<?php echo $admin_id ?>">
                            <div class="form-group">
                                <label class="control-label col-md-2">Username <span class="required">*</span></label>
                                <div class="col-md-2">
                                    <div class="form-group form-md-line-input has-info">
                                        <input type="text" class="form-control input-sm" name="admin_username" id="admin_username" autocomplete="off" value="<?php echo $admin_username; ?>" data-validate="required" data-message-required="Please enter username">
                                    </div>
                                </div>
                                <label class="control-label col-md-2">Email Address <span class="required">*</span></label>
                                <div class="col-md-2">
                                    <div class="form-group form-md-line-input has-info">
                                        <input type="text" class="form-control input-sm" name="admin_email" id="admin_email" autocomplete="off" value="<?php echo $admin_email; ?>" data-validate="email,required" data-message-required="Please enter email id">
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