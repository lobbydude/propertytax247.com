<html lang="en">
    <head>
        <meta charset="utf-8"/>
        <title>Property Tax | Admin Login</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
        <meta http-equiv="Content-type" content="text/html; charset=utf-8">
        <meta content="" name="description"/>
        <meta content="" name="author"/>
        <link href="<?php echo site_url('assets/admin/pages/css/login-soft.css') ?>" rel="stylesheet" type="text/css"/>
        <?php $this->load->view('common/head'); ?>
        <link href="<?php echo site_url('assets/global/css/nav.css') ?>" id="style_components" rel="stylesheet" type="text/css"/>
        <script src="<?php echo site_url('assets/admin/pages/scripts/login-soft.js') ?>" type="text/javascript"></script>
        <script>
            jQuery(document).ready(function () {
                Login.init();
            });
        </script>
		<script type="text/javascript">admin_username.focus();</script>
    </head>
    <body class="page-header-fixed page-sidebar-closed-hide-logo login" style="background-image:url('assets/admin/layout4/img/login-bg.png');background-repeat:no-repeat">
          <nav class="navbar yamm navbar-default navbar-static-top">
              <div id="topbar">
                <div class="container">
                    <div class="row">
                        <div class="col-md-8">          
                        </div>
                        <div class="col-md-4">
                            <p class="social-icons pull-right" style="margin:0px -60px;">           
                                <i class="fa fa-phone-square"></i>Toll Free : 1-844-50TITLE
                            </p>
                        </div>
                    </div>
                </div>
            </div>
      <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse"> 
              <span class="sr-only">Toggle navigation</span> 
              <span class="icon-bar"></span> 
              <span class="icon-bar"></span> 
              <span class="icon-bar"></span> 
            </button>
          <a class="navbar-brand" href="https://propertyreport247.com/"><img src="<?php echo site_url('assets/admin/layout4/img/logo-light.png') ?>" alt="logo" style="width: 270px; height:88px; background-color:transparent;" class="logo-default"/></a></div>        <!-- end .navbar-header -->
        
          <div class="navbar-collapse collapse">              
              <ul class="nav navbar-nav">
                  <li><a href="https://propertyreport247.com">Home</a></li>             
                  <li><a href="https://propertyreport247.com/plan.php">Plans</a></li>
                  <li><a href="https://propertyreport247.com/coverage.html">Coverage</a></li>
                  <li><a href="https://propertyreport247.com/samplereport.html">Sample Report</a></li>
                  <li ><a href="http://localhost:82/propertytax247/Signup">Place Order</a></li>			          
                  <li><a href="https://propertyreport247.com/contactus.html">Contact us</a></li>
                  <link href="<?php echo site_url('orders/assets/global/css/nav.css') ?>" id="style_components" rel="stylesheet" type="text/css"/>
                  <li class="active"><a href="http://localhost:82/propertytax247/Client_Login">Login</a></li>			
              </ul>				
          </div>
        <!-- end .navbar-collapse collapse --> 
        
      </div>
      <!-- end .container --> 
    </nav>   
        <div class="clearfix">
        </div>
        <div class="page-container">
            <div class="row" style="margin-top:0px">
                <div class="col-md-12">
                    <div class="content">
                        <!-- BEGIN LOGIN FORM -->
                        <form class="admin-login-form" method="post">
                            <h3 class="form-title" style="color:#00a63f;">Sign in to Propertytax247.com</h3>
                            <div class="row">
                                <div id="adminlogin_error" class="alert alert-danger" style="display:none;">username or password invalid please try again.</div>
                            </div>
                            <div class="form-group">
                                <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
                                <label class="control-label visible-ie8 visible-ie9">Username</label>
                                <div class="input-icon">
                                    <i class="fa fa-user" style="color:#b3b3b3"></i>
                                    <input class="form-control placeholder-no-fix" type="text" autofocus autocomplete="on" placeholder="Username" name="admin_username" id="admin_username"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label visible-ie8 visible-ie9">Password</label>
                                <div class="input-icon">
                                    <i class="fa fa-lock" style="color:#b3b3b3"></i>
                                    <input class="form-control placeholder-no-fix" type="password" autocomplete="off" placeholder="Password" name="admin_password" id="admin_password"/>
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
                            <!--<div class="create-account">
                                <p>
                                    Need an Account? <a href="javascript:;" id="register-btn" class="item-name primary-link">
                                        Sign up! </a>
                                </p>
                            </div>-->
                        </form>
                        <!-- END LOGIN FORM -->
                        <!-- BEGIN FORGOT PASSWORD FORM -->
                        <form class="admin-forget-form" method="post">
                            <h3 class="form-title">Forget Password ?</h3>
                            <div class="row">
                                <div id="adminforget_error" class="alert alert-danger" style="display:none;">Invalid Email Address.</div>
                                <div id="adminforget_success" class="alert alert-success" style="display:none;">Reset password link sent to your email id.</div>
                            </div>
                            <div class="form-group">
                                <div class="input-icon">
                                    <i class="fa fa-envelope" style="color:#b3b3b3"></i>
                                    <input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="Email" name="admin_forget_email" id="admin_forget_email"/>
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
                            <h3 class="form-title">Sign Up in to Propertytax247.com</h3>
                            <p>
                                Enter your account details below:
                            </p>
                            <div class="row">
                                <div id="adminregister_success" class="alert alert-success" style="display:none;">Your account has been created successfully.</div>
                                <div id="adminregister_error" class="alert alert-danger" style="display:none;">Failed to signup the account.</div>
                                <div id="adminregister_exists" class="alert alert-danger" style="display:none;">Username already exists.</div>
                            </div>
                            <div class="form-group">
                                <label class="control-label visible-ie8 visible-ie9">Email Address</label>
                                <div class="input-icon">
                                    <i class="fa fa-envelope" style="color:#b3b3b3"></i>
                                    <input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="Email Address" name="admin_register_email" id="admin_register_email"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label visible-ie8 visible-ie9">Username</label>
                                <div class="input-icon">
                                    <i class="fa fa-user" style="color:#b3b3b3"></i>
                                    <input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="Username" name="admin_register_username" id="admin_register_username"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label visible-ie8 visible-ie9">Password</label>
                                <div class="input-icon">
                                    <i class="fa fa-lock" style="color:#65a0d0"></i>
                                    <input class="form-control placeholder-no-fix" type="password" autocomplete="off" placeholder="Password" name="admin_register_password" id="admin_register_password"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label visible-ie8 visible-ie9">Re-type Your Password</label>
                                <div class="controls">
                                    <div class="input-icon">
                                        <i class="fa fa-check" style="color:#65a0d0"></i>
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