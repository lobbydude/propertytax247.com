<?php
$admin_username = $this->session->userdata('admin_username');
?>
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
    </head>
    <body class="page-header-fixed page-sidebar-closed-hide-logo">
        <div class="page-header navbar navbar-fixed-top">
            <div id="topbar">
                <div class="container">
                    <div class="row">
                        <div class="col-md-8">          
                        </div>
                        <div class="col-md-4">
                            <p class="social-icons pull-right" style="margin-right: -75px;">           
                                <i class="fa fa-phone-square"></i>Toll Free : 1-844-50TITLE
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="page-header-inner">
                <div class="page-logo">
                    <a href="#">
                        <img src="<?php echo site_url('assets/admin/layout4/img/logo-light.png') ?>" alt="logo" class="logo-default"/>
                    </a>
                    <div class="menu-toggler sidebar-toggler">
                    </div>
                </div>
                <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse">
                </a>
                <div class="page-top">
                    <form class="search-form open" method="post" action="<?php echo site_url('Admin/searchorder') ?>" id="admin_search_form">
                        <!--<div class="input-group">
                            <input type="text" style="border-style: solid; border:1.55px solid #002040; width:320px; height: 34px; border-radius: 8px; padding: 6px; font-weight:500;" placeholder="Search Order Number.." name="search_order" id="search_order" >                            
                        </div>-->
                        <div class="input-icon">
                            <i class="icon-magnifier" style="color:#333;"></i>
                            <input type="text" name="search_order" id="search_order" class="form-control placeholder-no-fix" style="border:1px solid #333;" placeholder="Search Order Number..."/>
                        </div>
                    </form>
                    <div class="top-menu">
                        <ul class="nav navbar-nav pull-right">
                            <li class="separator hide">
                            </li>
                            <li class="dropdown dropdown-extended dropdown-notification dropdown-dark" id="header_notification_bar">
                            </li>
                            <li class="separator hide"></li>
                            <li class="dropdown dropdown-user dropdown-dark">
                                <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                    <span class="username username-hide-on-mobile">
                                        <i class="glyphicon glyphicon-user" style="font-weight: bold;"></i> <?php echo $admin_username; ?> 
                                    </span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-default">
                                    <li>
                                        <a href="<?php echo site_url('Admin/profile') ?>">
                                            <i class="icon-user"></i> My Profile </a>
                                    </li>
                                    <li class="divider"></li>
                                    <li>
                                        <a href="<?php echo site_url('Admin/account') ?>">
                                            <i class="icon-map"></i> Account History </a>
                                    </li>
                                    <li class="divider"></li>
                                    <li>
                                        <a href="<?php echo site_url('Admin/reset') ?>">
                                            <i class="icon-lock"></i> Change Password </a>
                                    </li>
                                    <li class="divider"></li>
                                    <li>
                                        <a href="<?php echo site_url('Admin/logout') ?>">
                                            <i class="icon-key"></i> Log Out 
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="clearfix">
        </div>
        <div class="page-container">
            <div class="page-sidebar-wrapper">
                <div class="page-sidebar navbar-collapse collapse">
                    <ul class="page-sidebar-menu " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
                        <li id="tab1" onclick="admin_tabopen('#tabs', $(this).index(),'tab_1_1')" <?php                       
                        
                        if ($this->uri->segment(1) == "admin" && $this->uri->segment(2) == "") {
                            echo "class='start active'";
                        }
                        ?>>
                            <a href="<?php echo site_url('Admin') ?>" <?php                            
                            if ($this->uri->segment(1) == "Admin" && $this->uri->segment(2) == "") {
                                echo "data-toggle='tab'";
                            }
                            ?>>
                                <i class="icon-home"></i>
                                <span class="title">Dashboard</span>
                            </a>
                        </li>
                        <li id="tab2" onclick="admin_tabopen('#tabs', $(this).index(), 'tab_1_2')" <?php                        
                        if (($this->uri->segment(1) == "Otuser_admin" && $this->uri->segment(2) == "Signup") || ($this->uri->segment(1) == "Otuser_admin" && $this->uri->segment(2) == "signup_placingorder") || ($this->uri->segment(1) == "admin" && $this->uri->segment(2) == "editorder")) {
                            echo "class='active'";
                        }
                        ?>>
                            <a href="<?php echo site_url('Admin') ?>"  <?php
                            if ($this->uri->segment(1) == "Admin" && $this->uri->segment(2) == "") {
                                echo "data-toggle='tab'";
                            }
                            ?>>
                                <i class="icon-layers"></i>
                                <span class="title">Orders Queue</span>
                            </a>
                        </li>
                        <li <?php
                        if (($this->uri->segment(1) == "Plan" && $this->uri->segment(2) == "") || ($this->uri->segment(1) == "Planwise" && $this->uri->segment(2) == "") || ($this->uri->segment(1) == "Price" && $this->uri->segment(2) == "") || ($this->uri->segment(1) == "priority" && $this->uri->segment(2) == "")) {
                            echo "class='active open'";
                        }
                        ?>>
                            <a href="javascript:;">
                                <i class="icon-grid"></i>
                                <span class="title">Masters</span>
                                <span class="arrow "></span>
                            </a>
                            <ul class="sub-menu">
                                <li <?php
                                if ($this->uri->segment(1) == "Plan" && $this->uri->segment(2) == "") {
                                    echo "class='active'";
                                }
                                ?>>
                                    <a href="<?php echo site_url('Plan') ?>">
                                        <i class="icon-wallet"></i>
                                        Plans
                                    </a>
                                </li>
                                <li <?php
                                if ($this->uri->segment(1) == "Planwise" && $this->uri->segment(2) == "") {
                                    echo "class='active'";
                                }
                                ?>>
                                    <a href="<?php echo site_url('Planwise') ?>">
                                        <i class="icon-globe"></i>
                                        State and County</a>
                                </li>
                                <li <?php
                                if ($this->uri->segment(1) == "Price" && $this->uri->segment(2) == "") {
                                    echo "class='active'";
                                }
                                ?>>
                                    <a href="<?php echo site_url('Price') ?>">
                                        <i class="fa fa-dollar"></i>
                                        Price</a>
                                </li>
                                <li <?php
                                if ($this->uri->segment(1) == "Priority" && $this->uri->segment(2) == "") {
                                    echo "class='active'";
                                }
                                ?>>
                                    <a href="<?php echo site_url('Priority') ?>">
                                        <i class="icon-map"></i>
                                        Priority</a>
                                </li>
                            </ul>
                        </li>
                        <!--<li <?php
                        /*if (($this->uri->segment(1) == "Otuser_admin" && $this->uri->segment(2) == "signup") || ($this->uri->segment(1) == "Otuser_admin" && $this->uri->segment(2) == "signup_placeorder") || ($this->uri->segment(1) == "Otuser_admin" && $this->uri->segment(2) == "place_order")) {
                            echo "class='active open'";
                        }*/
                        ?>>
                            <a href="javascript:;">
                                <i class="icon-users"></i>
                                <span class="title">One time Users</span>
                                <span class="arrow "></span>
                            </a>
                            <ul class="sub-menu">
                                <li <?php
                                /*if ($this->uri->segment(1) == "Otuser_admin" && $this->uri->segment(2) == "signup_placeorder") {
                                    echo "class='active'";
                                }*/
                                ?>>
                                    <a href="<?php //echo site_url('Otuser_admin/signup_placeorder') ?>">
                                        <i class="icon-wallet"></i>
                                        Signup & Place Orders</a>
                                </li>
                            </ul>
                        </li>-->
                        <li <?php
                        if ($this->uri->segment(1) == "Admin" && $this->uri->segment(2) == "account") {
                            echo "class='active'";
                        }
                        ?>>
                            <a href="<?php echo site_url('Admin/account'); ?>">
                                <i class="icon-screen-tablet"></i>
                                <span class="title">Account History</span>
                            </a>
                        </li>
                        <li <?php
                        if ($this->uri->segment(1) == "Admin" && $this->uri->segment(2) == "payment") {
                            echo "class='active'";
                        }
                        ?>>
                            <a href="<?php echo site_url('Admin/payment'); ?>">
                                <i class="icon-credit-card"></i>
                                <span class="title">Payment History</span>
                            </a>
                        </li>
                        <li <?php
                        if (($this->uri->segment(1) == "Admin" && $this->uri->segment(2) == "refund") || ($this->uri->segment(1) == "admin" && $this->uri->segment(2) == "ViewRefund")) {
                            echo "class='active'";
                        }
                        ?>>
                            <a href="<?php echo site_url('Admin/refund'); ?>">
                                <i class="icon-briefcase"></i>
                                <span class="title">Refund History</span>
                            </a>
                        </li>
						<li <?php
                        if ($this->uri->segment(1) == "Admin" && $this->uri->segment(2) == "cancel") {
                            echo "class='active'";
                        }
                        ?>>
                            <a href="<?php echo site_url('Admin/cancel'); ?>">
                                <i class="icon-dislike"></i>
                                <span class="title">Cancel History</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <script>
                function admin_tabopen(div, li_no1, list) {
                    var li_no = li_no1 + 1;
                    $(div + " li").removeClass();
                    $(div + " li:nth-child(" + li_no + ")").addClass('active');
                    if (list == "tab_1_1") {
                        $('#tab_1_2.active').removeClass('active');
                        $("#tab2").removeClass();
                        $("#tab1").addClass('active');
                        $("#tab_1_1").addClass('active');
                    }
                    if (list == "tab_1_2") {
                        $('#tab_1_1.active').removeClass('active');
                        $("#tab1").removeClass();
                        $("#tab2").addClass('active');
                        $("#tab_1_2").addClass('active');
                    }
                }
            </script>