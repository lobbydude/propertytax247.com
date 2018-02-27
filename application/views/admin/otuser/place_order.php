<?php
$this->db->order_by('State_ID', 'desc');
$q_state = $this->db->get('tbl_state');

$this->db->order_by('County_ID', 'desc');
$q_county = $this->db->get('tbl_county');
?>
<script>
    $(document).ready(function () {
        $('#username').live('keydown', function (e) {
            var keyCode = e.keyCode || e.which;
            if (keyCode == 32) {
                e.preventDefault();
            }
        });
        $('#email').live('keydown', function (e) {
            var keyCode = e.keyCode || e.which;
            if (keyCode == 32) {
                e.preventDefault();
            }
        });
    });

    function showCounty(sel) {
        var state_id = sel.options[sel.selectedIndex].value;
        if (state_id.length > 0) {
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('Admin/fetch_county') ?>",
                data: "state_id=" + state_id,
                cache: false,
                success: function (msg) {
                    $("#add_exituser_county_div").show(10);
                    $("#add_exituser_county_from").html(msg);
                }
            });
        }
    }

</script>


<div class="page-content-wrapper">
    <div class="page-content">
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="portlet box blue" id="form_wizard_1">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="icon-layers"></i> Place Order
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
                                                    <i class="fa fa-check"></i> User details </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#taborder2" data-toggle="tab" class="step">
                                                <span class="number">
                                                    2 </span>
                                                <span class="desc">
                                                    <i class="fa fa-check"></i> Place Orders </span>
                                            </a>
                                        </li>                                
                                    </ul>
                                    <div id="bar" class="progress progress-striped" role="progressbar">
                                        <div class="progress-bar progress-bar-success">
                                        </div>
                                    </div>
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="taborder1">                                            
                                            <div class="form-group">


                                                <div class="form-group">
                                                    <label class="control-label col-md-2">Username<span class="required">
                                                            * </span>
                                                    </label>
                                                    <div class="col-md-6">
                                                        <div class="form-group form-md-line-input has-info">
                                                            <input type="text" class="form-control input-sm" name="username" id="username" placeholder="Username" data-validate="required" autocomplete="off" tabindex="0" >
                                                        </div>
                                                    </div>


                                                </div>
                                            </div>


                                        </div>
                                        <div class="tab-pane" id="taborder2">                                                                             
                                            <div class="form-group">
                                                <label class="col-md-2 control-label">Street & Address </label>
                                                <div class="col-md-4">
                                                    <div class="form-group form-md-line-input has-info">
                                                        <input type="text" class="form-control input-sm" name="street<?php //echo $k . $l;    ?>" autocomplete="off">
                                                    </div>
                                                </div>

                                                <label class="col-md-2 control-label">Order Number <span class="required"> *</span></label>
                                                <div class="col-md-4">
                                                    <div class="form-group form-md-line-input has-info">
                                                        <input type="text" class="form-control input-sm" name="order_number<?php //echo $k . $l;    ?>" data-validate="required" data-message-required="Please enter order number." autocomplete="off">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-2 control-label">State <span class="required"> *</span></label>
                                                <div class="col-md-4">
                                                    <select class="form-control select2me" onChange="showCounty(this);" data-validate="required" autocomplete="off">                                                   
                                                        <option value="0"> Select State </option>
                                                        <?php
                                                        foreach ($q_state->result() as $row_state) {
                                                            $state_id = $row_state->State_ID;
                                                            $state = $row_state->State;
                                                            ?>
                                                            <option value="<?php echo $state_id ?>"><?php echo $state; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>

                                                <label class="col-md-2 control-label">County <span class="required"> *</span></label>
                                                <div class="col-md-4" id="add_exituser_county_div">
                                                    <select name="add_exituser_county_from[]" id="add_exituser_county_from" class="form-control select2me">
                                                        <option value="0"> Select County </option>
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
                                                        <input type="text" class="form-control input-sm" data-validate="required" name="borrowername<?php //echo $k . $l    ?>" autocomplete="off">
                                                    </div>
                                                </div>

                                                <label class="col-md-2 control-label">APN </label>
                                                <div class="col-md-4">
                                                    <div class="form-group form-md-line-input has-info">
                                                        <input type="text" class="form-control input-sm" name="apn<?php //echo $k . $l    ?>" autocomplete="off">
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

                                                <!--<label class="col-md-2 control-label">Upload <span class="required"> *</span> </label>
                                                <div class="col-md-4">
                                                    <div class="row fileupload-buttonbar">
                                                        <div class="col-lg-4">                                                            
                                                            <span class="btn green fileinput-button">
                                                                <i class="fa fa-plus"></i>
                                                                <span>
                                                                    Browse</span> 
                                                                <input type="file" name="files[]" multiple="">
                                                            </span>																										
                                                        </div>                                                                                                              
                                                    </div>
                                                </div>-->
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