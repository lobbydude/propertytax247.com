<?php
//session_start();
$client_username = $this->session->userdata('client_username');
?>
<!DOCTYPE html>
<html lang="en">
    <!--<![endif]-->
    <!-- BEGIN HEAD -->
    <head>
        <meta charset="utf-8"/>
        <title>Property | <?php echo $title; ?></title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
        <meta http-equiv="Content-type" content="text/html; charset=utf-8">
        <meta content="" name="description"/>
        <meta content="" name="author"/>
        <?php $this->load->view('common/head'); ?>
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
        <div class="page-header navbar navbar-fixed-top">
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

            <div class="page-header-inner">
                <div class="page-logo">
                    <a href="#">
                        <img src="<?php echo site_url('assets/admin/layout4/img/logo-light.png') ?>" title="Propertyreport247.com" class="logo-default"/>
                    </a>
                    <div class="menu-toggler sidebar-toggler">
                    </div>
                </div>
                <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse">
                </a>
                <div class="page-top">
                    <form class="search-form open" action="<?php echo site_url('Client/searchorder') ?>" method="post">
                        <!--<div class="input-group">
                            <input type="text" style="border-style: solid; border:1.55px solid #002040; width:320px; height: 34px; border-radius: 8px; padding: 6px; font-weight:500;" placeholder="Search Order Number.." name="search_order">
                        </div>-->
                        <div class="input-icon">
                            <i class="icon-magnifier" style="color:#333;"></i>
                            <input type="text" name="search_order" class="form-control placeholder-no-fix" style="border:1px solid #333;" placeholder="Search Order Number..."/>
                        </div>
                    </form>
                    <div class="top-menu">
                        <ul class="nav navbar-nav pull-right">
                            <li class="separator hide">
                            </li>
                            <li class="separator hide">
                            </li>
                            <li class="dropdown dropdown-user dropdown-dark">
                                <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                    <span class="username username-hide-on-mobile">
                                        <i class="glyphicon glyphicon-user" style="font-weight: bold;"></i> <?php echo $client_username; ?> </span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-default">
                                    <li>
                                        <a href="<?php echo site_url('Client/profile') ?>">
                                            <i class="icon-user"></i> My Profile </a>
                                    </li>
                                    <li class="divider"></li>
                                    <li>
                                        <a href="<?php echo site_url('Client/account') ?>">
                                            <i class="icon-map"></i>Account History </a>
                                    </li>
                                    <li class="divider"></li>
                                    <li>
                                        <a href="<?php echo site_url('Client/reset') ?>">
                                            <i class="icon-lock"></i> Change Password </a>
                                    </li>
                                    <li class="divider"></li>
                                    <li>
                                        <a href="<?php echo site_url('Client/logout') ?>">
                                            <i class="icon-key"></i> Log Out 
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="dropdown dropdown-user dropdown-dark">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="padding:0" onclick="show_cart()">
                                    <span class="label label-warning cart-inside" id="total_items">0</span>
                                    <div class="cart-image"></div>
                                </a>
                                <div class="dropdown-menu arrow_box" id="showcartdiv" style="width:250px">
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
                                    <a href="<?php echo site_url('Cart') ?>" class="delete pull-right" id="checkout_btn" style="float:right; margin-top: -24px; padding:6px;">CHECKOUT</a>
                                </div>
                            <?php }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="clearfix">
        </div>
        <div class="page-container">
            <div class="page-sidebar-wrapper">
                <div class="page-sidebar navbar-collapse collapse">
                    <ul class="page-sidebar-menu " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200" id="navs">
                        <li id="tablisthead1" <?php
                        if ($this->uri->segment(1) == "Client" && $this->uri->segment(2) == "") {
                            echo "class='start active'";
                        }
                        ?> onclick="client_tabopen('#tabs', $(this).index(), 'tab_1_1')">
                            <a href="<?php echo site_url('Client') ?>" <?php
                            if ($this->uri->segment(1) == "client" && $this->uri->segment(2) == "") {
                                echo "data-toggle='tab'";
                            }
                            ?>>
                                <i class="icon-home"></i>
                                <span class="title">Dashboard</span>
                            </a>
                        </li>
                        <li id="tablisthead2" onclick="client_tabopen('#tabs', $(this).index(), 'tab_1_2')" <?php
                        if ($this->uri->segment(2) == "editorder") {
                            echo "class=active";
                        }
                        ?>>
                            <a href="<?php echo site_url('Client') ?>"  <?php
                            if ($this->uri->segment(1) == "Client" && $this->uri->segment(2) == "") {
                                echo "data-toggle='tab'";
                            }
                            ?>>
                                <i class="icon-layers"></i>
                                <span class="title">Orders Queue</span>
                            </a>
                        </li>
                        <li <?php
                        if ($this->uri->segment(1) == "Client" && $this->uri->segment(2) == "newplan") {
                            echo "class=active";
                        }
                        ?>>
                            <a href="<?php echo site_url('Client/newplan') ?>">
                                <i class="icon-folder-alt"></i>
                                <span class="title">New Plan</span>
                            </a>
                        </li>

                        <li <?php
                        if ($this->uri->segment(1) == "Client" && $this->uri->segment(2) == "placeorder") {
                            echo "class=active";
                        }
                        ?>>
                            <a href="<?php echo site_url('Client/placeorder') ?>">
                                <i class="icon-folder-alt"></i>
                                <span class="title">Place Order</span>
                            </a>
                        </li>
                        <li <?php
                        if (($this->uri->segment(1) == "Client" && $this->uri->segment(2) == "account") || ($this->uri->segment(1) == "Client" && $this->uri->segment(2) == "viewaccount")) {
                            echo "class='active'";
                        }
                        ?>>
                            <a href="<?php echo site_url('Client/account'); ?>">
                                <i class="icon-screen-tablet"></i>
                                <span class="title">Account History</span>
                            </a>
                        </li>
                        <li <?php
                        if ($this->uri->segment(1) == "Client" && $this->uri->segment(2) == "payment") {
                            echo "class='active'";
                        }
                        ?>>
                            <a href="<?php echo site_url('Client/payment'); ?>">
                                <i class="icon-credit-card"></i>
                                <span class="title">Payment History</span>
                            </a>
                        </li>
                        <!--<li <?php
                        /*if ($this->uri->segment(1) == "Client" && $this->uri->segment(2) == "invoice") {
                            echo "class='active'";
                        }*/
                        ?>>
                            <a href="<?php //echo site_url('Client/invoice'); ?>">
                                <i class="icon-credit-card"></i>
                                <span class="title">Invoice History</span>
                            </a>
                        </li>-->
                        <li <?php
                        if ($this->uri->segment(1) == "Client" && $this->uri->segment(2) == "refund") {
                            echo "class='active'";
                        }
                        ?>>
                            <a href="<?php echo site_url('Client/refund'); ?>">
                                <i class="icon-briefcase"></i>
                                <span class="title">Refund History</span>
                            </a>
                        </li>
                        <li <?php
                        if ($this->uri->segment(1) == "Client" && $this->uri->segment(2) == "cancel") {
                            echo "class='active'";
                        }
                        ?>>
                            <a href="<?php echo site_url('Client/cancel'); ?>">
                                <i class="icon-dislike"></i>
                                <span class="title">Cancel History</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <script>
                function client_tabopen(div, li_no1, list) {
                    var li_no = li_no1 + 1;
                    $(div + " li").removeClass();
                    $(div + " li:nth-child(" + li_no + ")").addClass('active');
                    if (list == "tab_1_1") {
                        $('#tab_1_2.active').removeClass('active');
                        $("#tablisthead2").removeClass();
                        $("#tablisthead1").addClass('active');
                        $("#tab_1_1").addClass('active');
                    }
                    if (list == "tab_1_2") {
                        $('#tab_1_1.active').removeClass('active');
                        $("#tablisthead1").removeClass();
                        $("#tablisthead2").addClass('active');
                        $("#tab_1_2").addClass('active');
                    }
                }
            </script>