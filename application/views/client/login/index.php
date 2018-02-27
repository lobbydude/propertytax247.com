<html lang="en">
    <head>
        <meta charset="utf-8"/>
        <title>Property Tax | Client Login</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
        <meta http-equiv="Content-type" content="text/html; charset=utf-8">
        <meta content="" name="description"/>
        <meta content="" name="author"/>
        <link href="<?php echo site_url('assets/admin/pages/css/login-soft.css') ?>" rel="stylesheet" type="text/css"/>
        <?php $this->load->view('common/head'); ?>
        <script src="<?php echo site_url('assets/admin/pages/scripts/client-login-validation.js') ?>" type="text/javascript"></script>
        <link href="<?php echo site_url('assets/global/css/nav.css') ?>" id="style_components" rel="stylesheet" type="text/css"/>
        <script>
            jQuery(document).ready(function () {
                Login.init();
            });

            $(document).ready(function () {
                $.ajax({
                    type: 'post',
                    url: "<?php echo site_url('Cart/Storeitems') ?>",
                    data: {
                        total_cart_items: "totalitems"
                    },
                    success: function (response) {
                        $('#total_items').html(response);
                    }
                });
            });
            function show_cart()
            {
                $.ajax({
                    type: 'post',
                    url: "<?php echo site_url('Cart/Storeitems') ?>",
                    data: {
                        showcart: "cart"
                    },
                    success: function (response) {
                        document.getElementById("show_cart").innerHTML = response;
                    }
                });
            }
             function removepopupcart(code) {
                $.ajax({
                    url: "<?php echo site_url('Cart/removefromcart') ?>",
                    type: 'post',
                    data: {
                        order_code: code
                    },
                    method: 'POST',
                    success: function (msg)
                    {
                        $('[data-toggle="dropdown"]').parent().removeClass('open');
                        $("#total_items").html(msg);
                    }
                });
            }
            //$("#client_username").focus();
        </script>
        <script type="text/javascript">client_username.focus();</script>
    </head>
    <body class="page-header-fixed page-sidebar-closed-hide-logo login" style="background-image: url('assets/admin/layout4/img/login-bg.png');
          background-repeat: no-repeat;">
        <nav class="navbar yamm navbar-default navbar-static-top" style="min-height:128px;">
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
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
                    <a class="navbar-brand" href="https://propertyreport247.com"><img src="<?php echo site_url('assets/admin/layout4/img/logo-light.png') ?>" style="width: 270px; height:88px; background-color:transparent;" class="logo-default"/></a>
                </div>        <!-- end .navbar-header -->

                <div class="navbar-collapse collapse">
                    <ul class="nav navbar-nav">
                        <li><a href="https://propertyreport247.com">Home</a></li>             
                        <li><a href="https://propertyreport247.com/plan.php">Plans</a></li>
                        <li><a href="https://propertyreport247.com/coverage.html">Coverage</a></li>
                        <li><a href="https://propertyreport247.com/samplereport.html">Sample Report</a></li>
                        <li ><a href="http://localhost:82/propertytax247/Signup" target="_blank">Place Order</a></li>			          
                        <li><a href="https://propertyreport247.com/contactus.html">Contact us</a></li>
                        <li class="active"><a href="http://localhost:82/propertytax247/Client_Login">Login</a></li>			
                        <li class="dropdown yamm-fw cart-dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="padding:0" onclick="show_cart()">
                                <span class="label label-warning cart-inside" id="total_items">0</span>
                                <div class="cart-image"></div>
                            </a>
                            <div class="dropdown-menu arrow_box" 
                                 style="background-color:#528FCC; color:#fff; width:270px; padding:10px; margin:27px 0px 0px -85px; 
                                 background-image:url('assets/global/img/slash-bg.png'); ">
                                <ul>
                                    <li>
                                        <div class="yamm-content" id="show_cart"></div>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                    <?php
                    if (isset($_SESSION["cart_item"])) {
                        if (count($_SESSION["cart_item"]) > 0) {
                            ?>
                            <div class="col-md-12">
                                <a href="https://propertyreport247.com/checkout.php" class="delete pull-right" id="checkout_btn" style="float: right; margin-top: -16px; margin-right: -35px; padding:6px 20px 6px 20px;">CHECKOUT</a>
                            </div>
                        <?php }
                    } ?>
                </div>
                <!-- end .navbar-collapse collapse --> 

            </div>
            <!-- end .container --> 
        </nav>   
        <div class="clearfix">
        </div>
        <div class="page-container" style="margin-top:95px">
            <div class="row">
                <div class="col-md-12">
                    <div class="content">
                        <!-- BEGIN LOGIN FORM -->
                        <form class="client-login-form" method="post">
                            <h3 class="form-title" style="color:#00a63f;">Sign in to Propertytax247.com</h3>
                            <div class="row">
                                <div id="clientlogin_error" class="alert alert-danger" style="display:none;">username or password invalid please try again.</div>
                            </div>
                            <div class="form-group">
                                <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
                                <label class="control-label visible-ie8 visible-ie9">Username</label>
                                <div class="input-icon">
                                    <i class="fa fa-user" style="color:#b3b3b3"></i>
                                    <input class="form-control placeholder-no-fix" type="text" autofocus autocomplete="on" placeholder="Username" name="client_username" id="client_username"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label visible-ie8 visible-ie9">Password</label>
                                <div class="input-icon">
                                    <i class="fa fa-lock" style="color:#b3b3b3"></i>
                                    <input class="form-control placeholder-no-fix" type="password" autocomplete="off" placeholder="Password" name="client_password" id="client_password"/>
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
                            <div class="create-account">
                                <p>
                                    Need an account?
                                    <!--<a href="javascript:;" id="register-btn" class="item-name primary-link"> Signup Free! 
                                    </a>-->
                                    <a href="<?php echo site_url('Signup') ?>" >
                                        Sign up! 
                                    </a>
                                </p>
                            </div>
                        </form>
                        <!-- END LOGIN FORM -->
                        <!-- BEGIN FORGOT PASSWORD FORM -->
                        <form class="client-forget-form" method="post">
                            <h3 class="form-title">Forget Password ?</h3>
                            <div class="row">
                                <div id="clientforget_error" class="alert alert-danger" style="display:none;">Invalid Email Address.</div>
                                <div id="clientforget_success" class="alert alert-success" style="display:none;">Reset password link sent to your email id.</div>
                            </div>
                            <p>
                                Enter your e-mail address below to reset your password.
                            </p>
                            <div class="form-group">
                                <div class="input-icon">
                                    <i class="fa fa-envelope" style="color:#b3b3b3;"></i>
                                    <input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="Email" name="client_forget_email" id="client_forget_email"/>
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
                        <!-- BEGIN REGISTRATION FORM -->                      
                        <form class="client-register-form" method="post">
                            <h3 class="form-title">Signup in to Property Report 247 </h3>
                            <div class="row" >
                                <div id="clientregister_success" class="alert alert-success" style="display:none;">Your account has been created successfully.</div>
                                <div id="clientregister_error" class="alert alert-danger" style="display:none;">Failed to signup the account.</div>
                                <div id="clientregister_exists" class="alert alert-danger" style="display:none;">Username already exists.</div>
                            </div>
                            <div class="row">
                                <div class="form-group">
                                    <div class="col-md-6">
                                        <label class="control-label visible-lg-inline-block">Fast & Last Name</label>
                                        <div class="input-icon">
                                            <i class="fa fa-check-circle"></i>
                                            <input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="Your Fullname" name="client_full_name" id="client_full_name"/>
                                        </div>
                                    </div>    
                                    <div class="col-md-6">
                                        <label class="control-label visible-lg-inline-block">Business Name</label>
                                        <div class="input-icon">
                                            <i class="fa fa-check-circle"></i>
                                            <input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="Business Name" name="client_business_name" id="client_business_name"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group">
                                    <div class="col-md-6">
                                        <label class="control-label visible-lg-inline-block">Username</label>
                                        <div class="input-icon">
                                            <i class="fa fa-user"></i>
                                            <input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="Username" name="client_register_username" id="client_register_username"/>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="control-label visible-lg-inline-block">Password</label>
                                        <div class="input-icon">
                                            <i class="fa fa-lock"></i>
                                            <input class="form-control placeholder-no-fix" type="password" autocomplete="off" placeholder="Password" name="client_register_password" id="client_register_password"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group">
                                    <div class="col-md-6">
                                        <label class="control-label visible-lg-inline-block">Email Address</label>
                                        <div class="input-icon">
                                            <i class="fa fa-envelope"></i>
                                            <input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="Email Address" name="client_register_email" id="client_register_email"/>
                                        </div>
                                    </div>    
                                    <div class="col-md-6">
                                        <label class="control-label visible-lg-inline-block">Phone No</label>
                                        <div class="input-icon">
                                            <i class="fa fa-phone"></i>
                                            <input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="Phone No" name="client_register_phone" id="client_register_phone" maxlength="15"/>
                                        </div>
                                    </div>
                                </div>     
                            </div>
                            <div class="row">
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label class="control-label visible-lg-inline-block"></label>
                                        <div class="input-icon">                                        
                                            <input type="checkbox" name="client_tc" id="client_tc" value="yes"/> I agree to the <a href="javascript:;">
                                                Terms of Service </a> and <a href="javascript:;"> Privacy Policy </a>
                                        </div>
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
    </div>
    <!-- END CONTAINER -->
    <!-- BEGIN FOOTER -->
    <div class="page-footer">
        <div class="copyright">
            Copyright © 2016 <a target="_blank" href="#" style="color:#fff">Abstract Shop, LLC</a> All Rights Reserved. 
        </div>
        <div class="scroll-to-top">
            <i class="icon-arrow-up"></i>
        </div>
    </div>
    <!-- END FOOTER -->
</body>
<!-- END BODY -->
</html>