<?php 
$admin_id=$this->uri->segment(3);
$active_code=$this->uri->segment(4);
?>
<html lang="en">
    <head>
        <meta charset="utf-8"/>
        <title>Property | Admin Login</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
        <meta http-equiv="Content-type" content="text/html; charset=utf-8">
        <meta content="" name="description"/>
        <meta content="" name="author"/>
        <link href="<?php echo site_url('assets/admin/pages/css/login-soft.css') ?>" rel="stylesheet" type="text/css"/>
        <?php $this->load->view('common/head'); ?>
        <script src="<?php echo site_url('assets/admin/pages/scripts/login-soft.js') ?>" type="text/javascript"></script>
        <script>
            jQuery(document).ready(function () {
                Login.init();
            });
        </script>
    </head>
    <body class="page-header-fixed page-sidebar-closed-hide-logo login">
        <div class="page-header navbar navbar-fixed-top">
            <div class="page-header-inner">
                <div class="page-logo">
                    <a href="#">
                        <img src="<?php echo site_url('assets/admin/layout4/img/logo-light.png') ?>" alt="logo" class="logo-default"/>
                    </a>
                </div>
                <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse">
                </a>
                <div class="page-top">

                    <div class="top-menu">

                    </div>
                </div>
            </div>
        </div>
        <div class="clearfix">
        </div>
        <div class="page-container">
            <div class="row">
                <div class="col-md-12">
                    <div class="content">
                        <!-- BEGIN RESET PASSWORD FORM -->
                        <form class="admin-reset-form" method="post" id="admin-reset-form">
                            <h3 class="form-title">Reset Password ?</h3>
                            <div class="row">
                                <div id="adminreset_error" class="alert alert-danger" style="display:none;">Failed to reset password.</div>
                                <div id="adminreset_success" class="alert alert-success" style="display:none;">Your password reset successfully.</div>
                            </div>
                            <input type="hidden" id="admin_reset_user_id" value="<?php echo $admin_id;?>">
                            <input type="hidden" id="admin_reset_active_code" value="<?php echo $active_code;?>">
                            <div class="form-group">
                                <div class="input-icon">
                                    <i class="fa fa-lock"></i>
                                    <input class="form-control placeholder-no-fix" type="password" autocomplete="off" placeholder="New Password" name="admin_reset_pwd" id="admin_reset_pwd"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-icon">
                                    <i class="fa fa-lock"></i>
                                    <input class="form-control placeholder-no-fix" type="password" autocomplete="off" placeholder="Retype New Password" name="admin_reset_retypepwd" id="admin_reset_retypepwd"/>
                                </div>
                            </div>
                            <div class="form-actions">
                                <button id="reset-back-btn" class="btn">
                                    <i class="m-icon-swapleft"></i> Back </button>
                                <button type="submit" class="btn blue pull-right">
                                    Submit <i class="m-icon-swapright m-icon-white"></i>
                                </button>
                            </div>
                        </form>
                        <!-- END RESET PASSWORD FORM -->
                    </div>
                    <!-- END LOGIN -->
                </div>
            </div>
        </div>
        <?php $this->load->view('common/footer'); ?>