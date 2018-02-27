<?php
$client_id = $this->session->userdata('client_id');
$this->db->where('User_Id', $client_id);
$q_user = $this->db->get('tbl_user');
foreach ($q_user->result() as $row_user) {
    $client_firstname = $row_user->First_Name;
    $client_business = $row_user->Business_Name;
    $client_username = $row_user->Username;
    $client_email = $row_user->Email_Address;
    $client_phone = $row_user->Phone_Number;
}
?>
<script src="<?php echo site_url('assets/global/validation/main-gsap.js') ?>"></script>
<script src="<?php echo site_url('assets/global/validation/resizeable.js') ?>"></script>
<script src="<?php echo site_url('assets/global/validation/jquery.validate.min.js') ?>"></script>
<script src="<?php echo site_url('assets/global/validation/custom.js') ?>"></script>
<script>
    $(document).ready(function () {
        $('#client_profile_form').submit(function (e) {
            e.preventDefault();
            var formdata = {
                client_id: $('#client_id').val(),
                fullname: $("#client_fullname").val(),
                businessname: $("#client_businessname").val(),
                username: $("#client_username").val(),
                email: $("#client_email").val(),
                phone: $("#client_phone").val()
            };
            $.ajax({
                url: "<?php echo site_url('Client/edit_profile') ?>",
                type: 'post',
                data: formdata,
                success: function (msg) {
                    if (msg.trim() == "success") {
                        $('#clientprofile_error').hide();
                        $('#clientprofile_success').show();
                    }
                    else if (msg.trim() == "fail") {
                        $('#clientprofile_success').hide();
                        $('#clientprofile_error').show();
                    } else {
                        $('#clientprofile_success').hide();
                        $('#clientprofile_error').hide();
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
                        <form class="form-horizontal validate client-profile-form" id="client_profile_form" method="POST">
                            <div class="col-md-10">
                                <div id="clientprofile_success" class="alert alert-success" style="display:none;">Your account has been updated successfully.</div>
                                <div id="clientprofile_error" class="alert alert-danger" style="display:none;">Failed to update the account details.</div>
                            </div>
                            <input type="hidden" id="client_id" name="client_id" value="<?php echo $client_id ?>">
                            <div class="form-group">
                                <label class="control-label col-md-2">First & Last Name <span class="required">*</span></label>
                                <div class="col-md-3">
                                    <div class="form-group form-md-line-input has-info">
                                        <input type="text" class="form-control input-sm" name="client_fullname" id="client_fullname" autocomplete="off" value="<?php echo $client_firstname; ?>" data-validate="required" data-message-required="Please enter firstname">
                                    </div>
                                </div>
                                <label class="control-label col-md-2">Business Name<span class="required">*</span></label>
                                <div class="col-md-3">
                                    <div class="form-group form-md-line-input has-info">
                                        <input type="text" class="form-control input-sm" name="client_businessname" id="client_businessname" autocomplete="off" value="<?php echo $client_business; ?>" data-validate="required" data-message-required="Please enter business name">
                                    </div>
                                </div>
                            </div> 
                            <div class="form-group">
                                <label class="control-label col-md-2">Username <span class="required">*</span></label>
                                <div class="col-md-3">
                                    <div class="form-group form-md-line-input has-info">
                                        <input type="text" class="form-control input-sm" name="client_username" id="client_username" autocomplete="off" value="<?php echo $client_username; ?>" data-validate="required" data-message-required="Please enter username">
                                    </div>
                                </div>
                                <label class="control-label col-md-2">Email Address <span class="required">*</span></label>
                                <div class="col-md-3">
                                    <div class="form-group form-md-line-input has-info">
                                        <input type="text" class="form-control input-sm" name="client_email" id="client_email" autocomplete="off" value="<?php echo $client_email; ?>" data-validate="email,required" data-message-required="Please enter email id">
                                    </div>
                                </div>
                            </div> 
                            <div class="form-group">
                                <label class="control-label col-md-2">Phone Number <span class="required">*</span></label>
                                <div class="col-md-3">
                                    <div class="form-group form-md-line-input has-info">
                                        <input type="text" class="form-control input-sm" name="client_phone" id="client_phone" autocomplete="off" value="<?php echo $client_phone; ?>" data-validate="required,number" data-message-required="Please enter phone number">
                                    </div>
                                </div>
                                <div class="col-md-3">
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