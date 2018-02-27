<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8"/>
        <title>Property Tax | <?php echo $title; ?></title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
        <meta http-equiv="Content-type" content="text/html; charset=utf-8">
        <meta content="" name="description"/>
        <meta content="" name="author"/>
        <?php $this->load->view('common/head'); ?>
        <link href="<?php echo site_url('assets/global/css/nav.css') ?>" id="style_components" rel="stylesheet" type="text/css"/>
        <script>
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
                        $('[class="dropdown dropdown-user dropdown-dark"]').parent().removeClass('open');
                        $("#total_items").html(msg);
                    }
                });
            }
        </script>
    </head>
    <body class="page-header-fixed page-sidebar-closed-hide-logo">
        <div id="topbar">
                <div class="container">
                    <div class="row">
                        <div class="col-md-8">          
                        </div>
                        <div class="col-md-4">
                            <p class="social-icons pull-right" style="margin:0px -82px;">         
                                <i class="fa fa-phone-square"></i>Toll Free : 1-844-50TITLE
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        
        <nav class="navbar yamm navbar-default navbar-static-top" style="padding-bottom:6px; height: 95px;" >            
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
                    <a class="navbar-brand" href="http://localhost/propertytax247"><img src="<?php echo site_url('assets/admin/layout4/img/logo-light.png') ?>" style="width: 270px; height:88px;" class="logo-default"/></a>
                </div>        <!-- end .navbar-header -->
                <div class="navbar-collapse collapse">
                    <ul class="nav navbar-nav">
                        <li><a href="http://localhost/">Home</a></li>             
                        <li><a href="http://localhost/plan.php">Plans</a></li>
                        <li><a href="http://localhost/coverage.html">Coverage</a></li>
                        <li><a href="http://localhost/samplereport.html">Sample Report</a></li>
                        <li ><a href="http://localhost:82/propertytax247/Signup" target="_blank">Place Order</a></li>			          
                        <li><a href="http://localhost/contactus.html">Contact us</a></li>
                        <link href="<?php echo site_url('orders/assets/global/css/nav.css') ?>" id="style_components" rel="stylesheet" type="text/css"/>
                        <li class="active"><a href="http://localhost:82/propertytax247/Client_Login">Login</a></li>			
                        <li class="dropdown yamm-fw cart-dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="padding:0" onclick="show_cart()">
                                <span class="label label-warning cart-inside" id="total_items" style="bottom:-7px;">0</span>
                                <div class="cart-image" style="margin-top:-15px;"></div>
                            </a>
                            <div class="dropdown-menu arrow_box" 
                                 style="background-color: #528FCC;color:#fff;width:270px;padding:10px;
                                        margin:27px 0px 0px -85px; background-image:url('assets/global/img/slash-bg.png'); ">
                                <ul>
                                    <li>
                                        <div class="yamm-content" id="show_cart"></div>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                    
                    
                    
                </div>
                <?php
                        if (isset($_SESSION["cart_item"])) {
                            if (count($_SESSION["cart_item"]) > 0) {
                                ?>
                                <div class="col-md-12">
                                    <a href="<?php echo site_url('Cart') ?>" class="delete pull-right" id="checkout_btn" style="float:right; margin-top: -24px; padding:6px;">CHECKOUT</a>
                                </div>
                            <?php }
                        }
                        ?>
                <!-- end .navbar-collapse collapse --> 
            </div>
            <!-- end .container --> 
        </nav>   
        <div class="clearfix">
        </div>
        <div class="page-container">
            