<div class="page-content-wrapper">
    <div class="page-content">
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="portlet box blue" id="form_wizard_1">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="icon-credit-card"></i> Pay as you go
                        </div>
                        <div class="tools">
                            <a href="javascript:;" class="reload"></a>
                        </div>
                    </div>

                    <div class="portlet-body form">
                        <form class="form-horizontal validate plan_submit_form" id="plan_submit_form" method="POST">
                            <div class="form-wizard">
                                <div class="form-body">
                                    <ul class="nav nav-pills nav-justified steps">
                                        <li>
                                            <a href="#taborder1" data-toggle="tab" class="step">
                                                <span class="number">
                                                    1 </span>
                                                <span class="desc">
                                                    <i class="fa fa-check"></i> Order Information </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#taborder2" data-toggle="tab" class="step">
                                                <span class="number">
                                                    2 </span>
                                                <span class="desc">
                                                    <i class="fa fa-check"></i> Billing Information </span>
                                            </a>
                                        </li>
                                    </ul>
                                    <div id="bar" class="progress progress-striped" role="progressbar">
                                        <div class="progress-bar progress-bar-success">
                                        </div>
                                    </div>
                                    <div class="tab-content">
                                        <div class="tab-pane" id="taborder1">                                                                             
                                            <div class="form-group">
                                                <label class="col-md-2 control-label">Ticket No <span class="required"> *</span></label>
                                                <div class="col-md-4">
                                                    <div class="form-group form-md-line-input has-info">
                                                        <input type="text" class="form-control input-sm" name="ticket_no" id="ticket_no" autocomplete="off">
                                                    </div>
                                                </div>
                                                <label class="control-label col-md-2">
                                                    <input type="button" class="btn blue" value="Submit">
                                                </label>
                                            </div>
                                            <table class="sample_2 table table-hover" id="sample_2">
                                                <thead>
                                                    <tr class="odd gradeX">
                                                        <th style="width:35px">Order No</th>                                  
                                                        <th>Order Date</th>
                                                        <th>Property Address</th>
                                                        <th>Product Type </th>
                                                        <th>State</th>
                                                        <th>County</th>
                                                        <th>Plan</th>
                                                        <th>Status</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                        <div class="tab-pane" id="taborder21">                                                                             
                                            <div class="form-group">
                                                <label class="col-md-2 control-label">Street & Address </label>
                                                <div class="col-md-4">
                                                    <div class="form-group form-md-line-input has-info">
                                                        <input type="text" class="form-control input-sm" name="street<?php //echo $k . $l;      ?>" autocomplete="off">
                                                    </div>
                                                </div>

                                                <label class="col-md-2 control-label">Order Number <span class="required"> *</span></label>
                                                <div class="col-md-4">
                                                    <div class="form-group form-md-line-input has-info">
                                                        <input type="text" class="form-control input-sm" name="order_number<?php //echo $k . $l;      ?>" data-validate="required" data-message-required="Please enter order number." autocomplete="off">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-2 control-label">State <span class="required"> *</span></label>
                                                <div class="col-md-4">
                                                    <select class="form-control select2me" data-validate="required" autocomplete="off">                                                   
                                                        <option value=""> Select State </option>                                                        
                                                    </select>
                                                </div>

                                                <label class="col-md-2 control-label">County <span class="required"> *</span></label>
                                                <div class="col-md-4">
                                                    <select class="form-control select2me"  data-validate="required" autocomplete="off">                                                   
                                                        <option value=""> Select County </option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-2 control-label">City </label>
                                                <div class="col-md-4">
                                                    <div class="form-group form-md-line-input has-info">
                                                        <input type="text" class="form-control input-sm" name="city" autocomplete="off">
                                                    </div>
                                                </div>

                                                <label class="col-md-2 control-label">Zip code <span class="required"> *</span></label>
                                                <div class="col-md-4">
                                                    <div class="form-group form-md-line-input has-info">
                                                        <input type="text" class="form-control input-sm" data-validate="required" name="zipcode" autocomplete="off">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-2 control-label">Borrower Name <span class="required"> *</span></label>
                                                <div class="col-md-4">
                                                    <div class="form-group form-md-line-input has-info">
                                                        <input type="text" class="form-control input-sm" data-validate="required" name="borrowername<?php //echo $k . $l      ?>" autocomplete="off">
                                                    </div>
                                                </div>

                                                <label class="col-md-2 control-label">APN </label>
                                                <div class="col-md-4">
                                                    <div class="form-group form-md-line-input has-info">
                                                        <input type="text" class="form-control input-sm" name="apn<?php //echo $k . $l      ?>" autocomplete="off">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-2 control-label">Notes </label>
                                                <div class="col-md-4">
                                                    <div class="form-group form-md-line-input has-info">
                                                        <input type="text" class="form-control input-sm" data-validate="required" name="borrowername" autocomplete="off">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="taborder2">                                    
                                            <div class="form-group">
                                                <label class="control-label col-md-2">Enter Amount <span class="required">
                                                        * </span>
                                                </label>                                       
                                                <div class="col-md-4">
                                                    <div class="form-group form-md-line-input has-info">
                                                        <input type="text" class="form-control input-sm" placeholder="Amount" name="card_name" autocomplete="off">
                                                        <span class="help-block"></span>
                                                    </div>
                                                </div>                                                                             



                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-md-2">Payment Options <span class="required">
                                                        * </span>
                                                </label>
                                                <div class="col-md-4">
                                                    <label>
                                                        <input type="radio" name="payment_option" value="order" checked>
                                                        <img src="<?php echo site_url('assets/global/img/master.png') ?>" border="0" style="width:160px"/>
                                                    </label>
                                                </div>
                                                <div class="col-md-4">
                                                    <label>
                                                        <input type="radio" name="payment_option" value="order_pp">
                                                        <img src="https://www.paypal.com/en_US/i/btn/btn_xpressCheckout.gif" style="cursor:pointer">
                                                    </label>
                                                </div>
                                            </div>    
                                            <div id="billing_order">
                                                <div class="form-group">
                                                    <label class="control-label col-md-2">Card Holder Name <span class="required">
                                                            * </span>
                                                    </label>                                       
                                                    <div class="col-md-4">
                                                        <div class="form-group form-md-line-input has-info">
                                                            <input type="text" class="form-control input-sm" placeholder="Card Holder Name" name="card_name" autocomplete="off">
                                                            <span class="help-block"></span>
                                                        </div>
                                                    </div>

                                                    <label class="control-label col-md-2">Card Number <span class="required">
                                                            * </span>
                                                    </label>
                                                    <div class="col-md-4">                                           
                                                        <div class="form-group form-md-line-input has-info">
                                                            <input type="text" class="form-control input-sm" placeholder="Card Number" name="card_number" autocomplete="off">
                                                            <span class="help-block"></span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-md-2 control-label">Expiration(MM/YYYY) <span class="required"> *</span></label>
                                                    <div class="col-md-4">
                                                        <div class="col-md-6">
                                                            <select class="form-control select2me" autocomplete="off">
                                                                <?php
                                                                for ($m = 1; $m <= 12; $m++) {
                                                                    $current_month = date('m');
                                                                    $month = date('F', mktime(0, 0, 0, $m, 1, date('Y')));
                                                                    ?>
                                                                    <option value="<?php echo $m; ?>" <?php
                                                                    if ($current_month == $m) {
                                                                        echo "selected=selected";
                                                                    }
                                                                    ?>><?php echo $month . " (" . $m . ")"; ?></option>
                                                                            <?php
                                                                        }
                                                                        ?>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <select class="form-control select2me" autocomplete="off">
                                                                <?php
                                                                $current_year = date('Y');
                                                                for ($y = 0; $y < 10; $y++) {
                                                                    $year = $current_year + $y;
                                                                    ?>
                                                                    <option value="<?php echo $year; ?>"><?php echo $year; ?></option>
                                                                    <?php
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>  
                                                    <label class="col-md-2 control-label">Card Security Code <span class="required"> *</span></label>
                                                    <div class="col-md-4">
                                                        <div class="form-group form-md-line-input has-info">
                                                            <input type="text" class="form-control input-sm" placeholder="Security Code" name="securitycode" autocomplete="off">
                                                            <span class="help-block"></span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-md-2 control-label">Billing Zip Code <span class="required"> *</span></label>
                                                    <div class="col-md-4">
                                                        <div class="form-group form-md-line-input has-info">
                                                            <input type="text" class="form-control input-sm" placeholder="Zip Code" name="zipcode" autocomplete="off">
                                                            <span class="help-block"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="form-actions">
                                    <div class="row">
                                        <div class="col-md-offset-9 col-md-2">
                                            <div class="col-md-offset-2 col-md-2">
                                                <a href="javascript:;" class="btn default button-previous">
                                                    <i class="m-icon-swapleft"></i> Back </a>
                                            </div>
                                            <div class="col-md-offset-5 col-md-2">
                                                <a href="javascript:;" class="btn blue button-next">
                                                    Continue <i class="m-icon-swapright m-icon-white"></i>
                                                </a>
                                            </div>
                                            <div class="col-md-offset-5 col-md-2">
                                           <!-- <input type="submit" value="submit" class="btn blue button-submit"> -->
                                                <a class="btn blue button-submit" onclick="plan_submit_form()">
                                                    Submit <i class="m-icon-swapright m-icon-white"></i>
                                                </a>
                                            </div>
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