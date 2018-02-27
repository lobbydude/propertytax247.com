<?php
$this->db->order_by('State_ID', 'desc');
$q_state = $this->db->get('tbl_state');

$this->db->order_by('County_ID', 'desc');
$q_county = $this->db->get('tbl_county');
?>
<script src="<?php echo site_url('assets/global/validation/main-gsap.js') ?>"></script>
<script src="<?php echo site_url('assets/global/validation/resizeable.js') ?>"></script>
<script src="<?php echo site_url('assets/global/validation/jquery.validate.min.js') ?>"></script>
<script src="<?php echo site_url('assets/global/validation/custom.js') ?>"></script>
<script>
    $(document).ready(function () {
        $('#username').live('keydown', function (e) {
            var keyCode = e.keyCode || e.which;
            if (keyCode == 32) {
                e.preventDefault();
            }
        });
        $('#email').live('keydown', function (e) {
            var keyCode = e.keyCode || e.which;
            if (keyCode == 32) {
                e.preventDefault();
            }
        });
    });

    function showCounty(sel) {
        var state_id = sel.options[sel.selectedIndex].value;
        if (state_id.length > 0) {
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('Admin/fetch_county') ?>",
                data: "state_id=" + state_id,
                cache: false,
                success: function (msg) {
                    $("#otuser_signupplace_county").html(msg);
                }
            });
        }
    }

    function otuser_signupplace_submit_form() {
        var form = $('#otuser_signupplace_submit_form');
        if (!form.valid())
            return false;
    }
</script>

<!-- BEGIN FORM-->
<div class="page-content-wrapper">
    <div class="page-content">
        <div class="row">
            <div class="col-md-12">
                <div class="portlet box blue" id="form_wizard_1">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="icon-folder-alt"></i>Sign up & Place Order
                        </div>
                    </div>
                    <div class="portlet-body form">
                        <form class="form-horizontal validate plan_submit_form" id="otuser_signupplace_submit_form" method="POST">
                            <div class="form-wizard">
                                <div class="form-body">
                                    <ul class="nav nav-pills nav-justified steps">
                                        <li>
                                            <a href="#taborder1" data-toggle="tab" class="step">
                                                <span class="number">
                                                    1 </span>
                                                <span class="desc">
                                                    <i class="fa fa-check"></i> Sign up </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#taborder2" data-toggle="tab" class="step">
                                                <span class="number">
                                                    2 </span>
                                                <span class="desc">
                                                    <i class="fa fa-check"></i> Place Order </span>
                                            </a>
                                        </li>
                                    </ul>
                                    <div id="bar" class="progress progress-striped" role="progressbar">
                                        <div class="progress-bar progress-bar-success">
                                        </div>
                                    </div>
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="taborder1">
                                            <h3 class="block">Provide your account details</h3>
                                            <div class="form-group">
                                                <label class="control-label col-md-2">First & Last Name <span class="required">
                                                        * </span>
                                                </label>
                                                <div class="col-md-4">
                                                    <div class="form-group form-md-line-input has-info">
                                                        <input type="text" class="form-control input-sm" name="fullname" data-validate="required" data-validate="Please Enter Your Name" autocomplete="off">
                                                    </div>
                                                </div>

                                                <label class="control-label col-md-2">Business Name<span class="required">
                                                        * </span>
                                                </label>
                                                <div class="col-md-4">
                                                    <div class="form-group form-md-line-input has-info">
                                                        <input type="text" class="form-control input-sm" name="businessname"  data-validate="required" data-validate="Please Enter Business Name" autocomplete="off">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-2">Username<span class="required">
                                                        * </span>
                                                </label>
                                                <div class="col-md-4">
                                                    <div class="form-group form-md-line-input has-info">
                                                        <input type="text" class="form-control input-sm" name="username" data-validate="required" autocomplete="off" tabindex="0" id="username">
                                                    </div>
                                                </div>

                                                <label class="control-label col-md-2"> Password <span class="required">
                                                        * </span>
                                                </label>
                                                <div class="col-md-4">														
                                                    <div class="form-group form-md-line-input has-info">
                                                        <input type="password" class="form-control input-sm" name="password" id="password" data-validate="required" autocomplete="off">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-2">Email Address <span class="required">
                                                        * </span>
                                                </label>
                                                <div class="col-md-4">
                                                    <div class="form-group form-md-line-input has-info">
                                                        <input type="text" class="form-control input-sm"  name="email" data-validate="required,email" autocomplete="off" id="email">
                                                    </div>
                                                </div>
                                                <label class="control-label col-md-2">Phone No <span class="required">
                                                        * </span>
                                                </label>
                                                <div class="col-md-4">
                                                    <div class="form-group form-md-line-input has-info">
                                                        <input type="text" class="form-control input-sm" name="phone" data-validate="required,number" maxlength="15" autocomplete="off">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-md-4">
                                                    <div class="checkbox-list">
                                                        <input type="checkbox" name="tc" value="yes" data-validate="required" autocomplete="off"/> I have read and agree to the terms of service <span class="required">  * </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="taborder2">

                                            <div class="portlet-body form">
                                                <div class="form-body">
                                                    <div class="form-group">
                                                        <label class="col-md-2 control-label">Street & Address </label>
                                                        <div class="col-md-4">
                                                            <div class="form-group form-md-line-input has-info">
                                                                <input type="text" class="form-control input-sm" name="otuser_signupplace_street" id="otuser_signupplace_street" autocomplete="off">
                                                            </div>
                                                        </div>

                                                        <label class="col-md-2 control-label">Order Number <span class="required"> *</span></label>
                                                        <div class="col-md-4">
                                                            <div class="form-group form-md-line-input has-info">
                                                                <input type="text" class="form-control input-sm" name="otuser_signupplace_order_no" id="otuser_signupplace_order_no" data-validate="required" autocomplete="off">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-2 control-label">State <span class="required"> *</span></label>
                                                        <div class="col-md-4">
                                                            <select class="form-control select2me" onChange="showCounty(this);" data-validate="required" autocomplete="off" name="otuser_signupplace_state" id="otuser_signupplace_state">                                                   
                                                                <option value="0"> Select State </option>
                                                                <?php
                                                                foreach ($q_state->result() as $row_state) {
                                                                    $state_id = $row_state->State_ID;
                                                                    $state = $row_state->State;
                                                                    ?>
                                                                    <option value="<?php echo $state_id ?>"><?php echo $state; ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>

                                                        <label class="col-md-2 control-label">County <span class="required"> *</span></label>
                                                        <div class="col-md-4" id="add_signup_county_div">
                                                            <select name="otuser_signupplace_county[]" id="otuser_signupplace_county" class="form-control select2me">
                                                                <option value="0"> Select County </option>
                                                            </select>
                                                        </div>                                               
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-2 control-label">City </label>
                                                        <div class="col-md-4">
                                                            <div class="form-group form-md-line-input has-info">
                                                                <input type="text" class="form-control input-sm" name="otuser_signupplace_city" id="otuser_signupplace_city" autocomplete="off">
                                                            </div>
                                                        </div>

                                                        <label class="col-md-2 control-label">Zip code <span class="required"> *</span></label>
                                                        <div class="col-md-4">
                                                            <div class="form-group form-md-line-input has-info">
                                                                <input type="text" class="form-control input-sm" data-validate="required,number" name="otuser_signupplace_zipcode" id="otuser_signupplace_zipcode" autocomplete="off">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-2 control-label">Borrower Name <span class="required"> *</span></label>
                                                        <div class="col-md-4">
                                                            <div class="form-group form-md-line-input has-info">
                                                                <input type="text" class="form-control input-sm" data-validate="required" name="otuser_signupplace_borrowername" id="otuser_signupplace_borrowername" autocomplete="off">
                                                            </div>
                                                        </div>

                                                        <label class="col-md-2 control-label">APN </label>
                                                        <div class="col-md-4">
                                                            <div class="form-group form-md-line-input has-info">
                                                                <input type="text" class="form-control input-sm" name="otuser_signupplace_apn" id="otuser_signupplace_apn" autocomplete="off">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-2 control-label">Notes </label>
                                                        <div class="col-md-4">
                                                            <div class="form-group form-md-line-input has-info">
                                                                <input type="text" class="form-control input-sm" data-validate="required" name="otuser_signupplace_notes" id="otuser_signupplace_notes" autocomplete="off">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div style="display:none" id="tabcontent" class="form-body">
                                                    <div class="tabbable-custom nav-justified">
                                                        <ul class="nav nav-tabs nav-justified">
                                                            <li><a data-toggle="tab"></a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>    
                                        </div>
                                    </div>
                                </div>
                                <div class="form-actions">
                                    <div class="row">
                                        <div class="col-md-offset-10 col-md-2">
                                            <a href="javascript:;" class="btn default button-previous">
                                                <i class="m-icon-swapleft"></i> Back 
                                            </a>
                                            <a href="javascript:;" class="btn blue button-next">
                                                Continue <i class="m-icon-swapright m-icon-white"></i>
                                            </a>
                                            <a class="btn blue button-submit" onclick="otuser_signupplace_submit_form()">
                                                Submit <i class="m-icon-swapright m-icon-white"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END FORM-->
