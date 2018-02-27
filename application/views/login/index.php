<html lang="en">
    <head>
        <meta charset="utf-8"/>
        <title>Property | Login</title>
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
                        <!-- BEGIN LOGIN FORM -->
                        <form class="admin-login-form" method="post">
                            <h3 class="form-title">Login to your account</h3>
                            <div class="row">
                                <div id="adminlogin_error" class="alert alert-danger" style="display:none;">Failed to login.</div>
                            </div>
                            <div class="form-group">
                                <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
                                <label class="control-label visible-ie8 visible-ie9">Username</label>
                                <div class="input-icon">
                                    <i class="fa fa-user"></i>
                                    <input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="Username" name="admin_username" id="admin_username"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label visible-ie8 visible-ie9">Password</label>
                                <div class="input-icon">
                                    <i class="fa fa-lock"></i>
                                    <input class="form-control placeholder-no-fix" type="password" autocomplete="off" placeholder="Password" name="admin_password" id="admin_password"/>
                                </div>
                            </div>
                            <div class="form-actions">
                                <button type="submit" class="btn btn-circle btn-primary pull-right">
                                    Login <i class="m-icon-swapright m-icon-white"></i>
                                </button>
                            </div>

                            <div class="forget-password">
                                <h4><a href="#" class="primary-link">Forgot your password ?</a></h4>
                                <p>
                                    no worries, click <a href="javascript:;" id="forget-password" class="item-name primary-link">
                                        here </a>
                                    to reset your password.
                                </p>
                            </div>
                            <div class="create-account">
                                <p>
                                    Don't have an account yet ?&nbsp; <a href="javascript:;" id="register-btn" class="item-name primary-link">
                                        Create an account </a>
                                </p>
                            </div>
                        </form>
                        <!-- END LOGIN FORM -->
                        <!-- BEGIN FORGOT PASSWORD FORM -->
                        <form class="forget-form" method="post">
                            <h3 class="form-title">Forget Password ?</h3>
                            <p>
                                Enter your e-mail address below to reset your password.
                            </p>
                            <div class="form-group">
                                <div class="input-icon">
                                    <i class="fa fa-envelope"></i>
                                    <input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="Email" name="email"/>
                                </div>
                            </div>
                            <div class="form-actions">
                                <button type="button" id="back-btn" class="btn">
                                    <i class="m-icon-swapleft"></i> Back </button>
                                <button type="submit" class="btn blue pull-right">
                                    Submit <i class="m-icon-swapright m-icon-white"></i>
                                </button>
                            </div>
                        </form>
                        <!-- END FORGOT PASSWORD FORM -->

                        <!-- BEGIN REGISTRATION FORM -->
                        <form class="admin-register-form" method="post">
                            <h3 class="form-title">Sign Up</h3>
                            <p>
                                Enter your account details below:
                            </p>
                            <div class="row">
                                <div id="adminregister_success" class="alert alert-success" style="display:none;">Your account has been created successfully.</div>
                                <div id="adminregister_error" class="alert alert-danger" style="display:none;">Failed to signup the account.</div>
                            </div>
                            <div class="form-group">
                                <label class="control-label visible-ie8 visible-ie9">Email Address</label>
                                <div class="input-icon">
                                    <i class="fa fa-envelope"></i>
                                    <input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="Email Address" name="admin_register_email" id="admin_register_email"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label visible-ie8 visible-ie9">Username</label>
                                <div class="input-icon">
                                    <i class="fa fa-user"></i>
                                    <input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="Username" name="admin_register_username" id="admin_register_username"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label visible-ie8 visible-ie9">Password</label>
                                <div class="input-icon">
                                    <i class="fa fa-lock"></i>
                                    <input class="form-control placeholder-no-fix" type="password" autocomplete="off" placeholder="Password" name="admin_register_password" id="admin_register_password"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label visible-ie8 visible-ie9">Re-type Your Password</label>
                                <div class="controls">
                                    <div class="input-icon">
                                        <i class="fa fa-check"></i>
                                        <input class="form-control placeholder-no-fix" type="password" autocomplete="off" placeholder="Re-type Your Password" name="admin_register_rpassword" id="admin_register_rpassword"/>
                                    </div>
                                </div>
                            </div>
                            <div class="form-actions">
                                <button id="register-back-btn" type="button" class="btn">
                                    <i class="m-icon-swapleft"></i> Back
                                </button>
                                <button type="submit" id="register-submit-btn" class="btn blue pull-right">
                                    Sign Up <i class="m-icon-swapright m-icon-white"></i>
                                </button>
                            </div>
                        </form>
                        <!-- END REGISTRATION FORM -->
                    </div>
                    <!-- END LOGIN -->
                </div>
            </div>
        </div>
        <?php $this->load->view('common/footer'); ?>