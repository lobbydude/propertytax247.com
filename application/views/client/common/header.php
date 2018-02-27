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
        <style type="text/css">
            #result
            {
                position:absolute;
                width:40.3%;
                padding:10px;
                display:none;
                margin-top:-3px;
                border-top:0px;
                overflow:hidden;
                border:1px #CCC solid;
                background-color: white;
                left:388px;
                overflow-y:auto;
                min-height: 0px;
                max-height: 300px;
            }
            .show
            {
                /*padding:10px;*/ 
                border-bottom:1px #999 dashed;
                font-size:15px; 
                height:30px;
            }
            .show:hover
            {
                background:#4c66a4;
                color:#FFF;
                cursor:pointer;
            }
            .show_heading
            {
                border-bottom:1px #999 dashed;
                font-size:15px;
                height:30px;
                font-weight: bold;
            }
            #searchdiv{
                float:left;
            }
            .name{
                margin-top: 3px;
                position: absolute;
                width: 100%;
            }
            #remove{
                border-radius: 2px 2px 2px 2px;
            }
            .select{ 
                background-color: #3598dc; 
                color:#fff;
            }
        </style>          
        <script type="text/javascript">
            $(function () {
                $('.search').bind('keyup', function (e) {
                    if (e.keyCode == '38' || e.keyCode == '40') {
                        e.preventDefault();
                    } else {
                        var searchid = $(this).val();
                        var dataString = 'search=' + searchid;
                        if (searchid !== '' && (searchid.length > 2))
                        {
                            $.ajax({
                                type: "POST",
                                url: "<?php echo site_url('Cart/search') ?>",
                                data: dataString,
                                cache: false,
                                success: function (html)
                                {
                                    $("#result").html(html).show();
                                }
                            });
                        } else {
                            return false;
                        }
                    }
                });
                jQuery("#result .show").live("click", function (e) {
                    var decoded = $(this).find('.name').html();
                    var countywise_id = $(this).find('.countywise_id').val();
                    $('#searchid').val(decoded);
                    $('#search_countywiseid').val(countywise_id);
                });
                jQuery(document).live("click", function (e) {
                    var $clicked = $(e.target);
                    if (!$clicked.hasClass("search")) {
                        jQuery("#result").fadeOut();
                    }
                });
            });
        </script>
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
                $('body').click(function (e) {
                    if (!$(e.target).closest('#showcartdiv').length) {
                        $("#showcartdiv").hide();
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
                        $("#showcartdiv").show();
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
                        <div class="input-cont alert alert-success alert-borderless" id="searchdiv">
                            
							<input type="text" name="search_order" class="form-control placeholder-no-fix" style="border:1px solid #333; font-size:17px;" placeholder="Search Order Number..."/>
							
                            <input type="hidden" id="search_countywiseid" name="search_countywiseid">
                        </div>                        

                        <span class="input-group-btn">
                            <button type="submit" id="remove" class="btn green-haze" style="margin-left:386px; margin-top:-40px; height:37px; font-family: "Helvetica Neue",Helvetica,Arial,sans-serif">
                                    <i class="fa fa-search"></i>&nbsp; Search
                            </button>
                        </span>
                        <div id="result"></div>
                    </form>
					
					
					
                    <div class="top-menu">
                        <ul class="nav navbar-nav pull-right">
                            <li class="separator hide"></li>
                            <li class="separator hide"></li>
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
                                <?php
                            }
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
                        <!--                        <li <?php
                        if ($this->uri->segment(1) == "Client" && $this->uri->segment(2) == "newplan") {
                            echo "class=active";
                        }
                        ?>>
                                                    <a href="<?php echo site_url('Client/newplan') ?>">
                                                        <i class="icon-folder-alt"></i>
                                                        <span class="title">New Plan</span>
                                                    </a>
                                                </li>-->
                        <li <?php
                        if ($this->uri->segment(1) == "Client" && $this->uri->segment(2) == "placeorder") {
                            echo "class=active";
                        }
                        ?>>
                            <a href="<?php echo site_url('Client/placeorder') ?>">
                                <i class="icon-bag"></i>
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
                        /* if ($this->uri->segment(1) == "Client" && $this->uri->segment(2) == "invoice") {
                          echo "class='active'";
                          } */
                        ?>>
                            <a href="<?php //echo site_url('Client/invoice');                               ?>">
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


                function autocomplete(textBoxId, containerDivId) {
                    var ac = this;
                    this.textbox = document.getElementById(textBoxId);
                    this.div = document.getElementById(containerDivId);
                    this.list = this.div.getElementsByTagName('span');
                    this.input = this.div.getElementsByTagName('input');
                    this.pointer = null;
                    this.textbox.onkeydown = function (e) {
                        e = e || window.event;
                        switch (e.keyCode) {
                            case 38: //up
                                ac.selectDiv(-1);
                                $('.show:not(:first-child).select').removeClass('select').prev().addClass('select');
                                $("#result").scrollTop(0); //set to top
                                $("#result").scrollTop($('.select:first').offset().top - $("#result").height());
                                break;
                            case 40: //down
                                ac.selectDiv(1);
                                $('.show:not(:last-child).select').removeClass('select').next().addClass('select');
                                $("#result").scrollTop(0); //set to top
                                $("#result").scrollTop($('.select:first').offset().top - $("#result").height());
                                break;
                        }
                    };

                    this.selectDiv = function (inc) {
                        if (this.pointer !== null && this.pointer + inc >= 0 && this.pointer + inc < this.list.length) {
                            this.list[this.pointer].className = 'name';
                            this.pointer += inc;
                            this.list[this.pointer].className = 'name select';
                            this.textbox.value = this.list[this.pointer].innerHTML;
                            var countywise_id = this.input[this.pointer].value;
                            $('#search_countywiseid').val(countywise_id);
                            $("#result").show();
                        }
                        if (this.pointer === null) {
                            this.pointer = 0;
                            this.list[this.pointer].className = 'name select';
                            this.textbox.value = this.list[this.pointer].innerHTML;
                            var countywise_id = this.input[this.pointer].value;
                            $('#search_countywiseid').val(countywise_id);
                            $("#result").show();
                        }
                    };
                }
                new autocomplete('searchid', 'result');
            </script>
