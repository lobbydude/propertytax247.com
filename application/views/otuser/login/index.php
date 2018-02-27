<html lang="en">
    <head>
        <meta charset="utf-8"/>
        <title>Property | Onetime User Login</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
        <meta http-equiv="Content-type" content="text/html; charset=utf-8">
        <meta content="" name="description"/>
        <meta content="" name="author"/>
        <link href="<?php echo site_url('assets/admin/pages/css/login-soft.css') ?>" rel="stylesheet" type="text/css"/>
        <?php $this->load->view('common/head'); ?>
        <script src="<?php //echo site_url('assets/admin/pages/scripts/login-soft.js')   ?>" type="text/javascript"></script>
        <script src="<?php //echo site_url('assets/admin/pages/scripts/client-login-validation.js') ?>" type="text/javascript"></script>
        <script src="<?php echo site_url('assets/admin/pages/scripts/otuser-login-validation.js') ?>" type="text/javascript"></script>

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
                        <form class="otuser-login-form" method="post">
                            <h3 class="form-title">Sign in to Propertyreport247.com</h3>
                            <div class="row">
                                <div id="otuserlogin_error" class="alert alert-danger" style="display:none;">username or password invalid please try again.</div>
                            </div>
                            <div class="form-group">
                                <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
                                <label class="control-label visible-ie8 visible-ie9">Username</label>
                                <div class="input-icon">
                                    <i class="fa fa-user"></i>
                                    <input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="Username" name="otuser_username" id="otuser_username"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label visible-ie8 visible-ie9">Password</label>
                                <div class="input-icon">
                                    <i class="fa fa-lock"></i>
                                    <input class="form-control placeholder-no-fix" type="password" autocomplete="off" placeholder="Password" name="otuser_password" id="otuser_password"/>
                                </div>
                            </div>
                            <div class="form-actions">
                                <button type="submit" class="btn btn-circle btn-primary pull-right">
                                    Login <i class="m-icon-swapright m-icon-white"></i>
                                </button>
                            </div>

                            <div class="forget-password">
                                <h4><a href="#" class="primary-link" id="forget-password">Forgot your password ?</a></h4>
                            </div>                            
                        </form>
                        <!-- END LOGIN FORM -->
                        <!-- BEGIN FORGOT PASSWORD FORM -->
                        <form class="otuser-forget-form" method="post">
                            <h3 class="form-title">Forget Password ?</h3>
                            <div class="row">
                                <div id="otuserforget_error" class="alert alert-danger" style="display:none;">Invalid Email Address.</div>
                                 <div id="otuserforget_success" class="alert alert-success" style="display:none;">Reset password link sent to your email id.</div>
                            </div>
                            <p>
                                Enter your e-mail address below to reset your password.
                            </p>
                            <div class="form-group">
                                <div class="input-icon">
                                    <i class="fa fa-envelope"></i>
                                    <input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="Email" name="otuser_forget_email" id="otuser_forget_email"/>
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
                        
                        <!--</div>-->
                        <!--<div class="registercontent">-->
                        
                    </div>
                    <!-- END LOGIN -->
                </div>
            </div>
        </div>
        <?php $this->load->view('common/footer'); ?>