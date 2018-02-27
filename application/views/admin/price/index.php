<?php
$this->db->order_by('Plan_Id', 'desc');
$this->db->where('Status', 1);
$q_plan = $this->db->get('tbl_plan');

$this->db->where('Status', 1);
$q_ordertype = $this->db->get('tbl_ordertype');

$this->db->order_by('Price_Id', 'desc');
$this->db->where('Status', 1);
$q = $this->db->get('tbl_price');
?>

<script>
    function edit_Price(id) {
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('Price/Editprice') ?>",
            data: "price_id=" + id,
            cache: false,
            success: function (html) {
                $("#editprice_form").html(html);
            }
        });
    }

    function delete_Price(id) {
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('Price/Deleteprice') ?>",
            data: "price_id=" + id,
            cache: false,
            success: function (html) {
                $("#deleteprice_form").html(html);

            }
        });
    }
    
    // No Space bar query
    $('#add_price_amt').live('keydown', function (e) {
            var keyCode = e.keyCode || e.which;
            if (keyCode == 32) {
                e.preventDefault();
            }
        }); 

</script>
<div class="page-content-wrapper">
    <div class="page-content">
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="portlet box blue">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-dollar"></i>Price
                        </div>
						<div class="tools hidden-xs" style="width:15%">
                              <button id="btnExport" class="btn-default">Export to excel</button>
                        </div>
                        <div class="tools">
                            <a href="javascript:;" class="reload"></a>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <table class="sample_2 table table-hover" id="Export_Excel">
                            <thead>
                                <tr>
                                    <th>Plan Name</th>
                                    <th>Product Type</th>
                                    <th>Order Type</th>
                                    <th style="width:70px">Price ($)</th>
                                    <th style="width:70px;background: none">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($q->result() as $row) {
                                    $price_id = $row->Price_Id;
                                    $plan_id = $row->Plan_Id;
                                    $product_type = $row->Product_Type;
                                    $order_type_id=$row->Order_Type;
                                    $this->db->where('Order_Type_ID', $order_type_id);
                                    $q_ordertype_select = $this->db->get('tbl_ordertype');
                                    foreach ($q_ordertype_select->result() as $row_ordertype_select) {
                                        $order_Type_select = $row_ordertype_select->Order_Type;
                                    }
                                    $price = $row->Price;
                                    $this->db->where('Plan_Id', $plan_id);
                                    $q_plan_select = $this->db->get('tbl_plan');
                                    foreach ($q_plan_select->result() as $row_plan_select) {
                                        $plan_name_select = $row_plan_select->Plan_Name;
										$plan_type_select = $row_plan_select->Type;
                                    }
                                    ?>
                                    <tr class="odd gradeX">
                                        <td><?php echo $plan_name_select . " - " . $plan_type_select; ?></td>
                                        <td><?php echo $product_type; ?></td>
                                        <td><?php echo $order_Type_select; ?></td>
                                        <td><?php echo $price; ?></td>
                                        <td>                                        
                                            <a class="btn btn-xs black node-buttons" data-toggle="modal" href="#edit_price_model" onclick="edit_Price(<?php echo $price_id; ?>)">
                                                <span class="glyphicon glyphicon-pencil"></span>
                                            </a>
                                            <a class="btn btn-xs node-buttons" data-toggle="modal" href="#delete_price_model" onclick="delete_Price(<?php echo $price_id; ?>)">
                                                <span class="glyphicon glyphicon-trash"></span>
                                            </a>
                                        </td>
                                    </tr>
                                    <?php
                                    $i++;
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- Add Price Popup Start Here --> 
                <div id="add_price_model" class="modal fade" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                <h4 class="modal-title">Add Price</h4>
                            </div>                           
                            <form role="form" id="addprice_form" method="post" class="form-horizontal">
                                <div class="modal-body">                                     
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div id="add_price_exists" class="alert alert-info" style="display:none;">Price details already exists.</div>
                                            <div id="add_price_success" class="alert alert-success" style="display:none;">Price details added successfully.</div>
                                            <div id="add_price_error" class="alert alert-danger" style="display:none;">Failed to add price details.</div>
                                        </div>
                                    </div>                                    

                                    <div class="row">
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Plan <span class="required">
                                                    * </span>
                                            </label>
                                            <div class="col-md-8">
                                                <select class="form-control select2me" name="add_price_plan" id="add_price_plan">                                                   
                                                    <?php
                                                    foreach ($q_plan->result() as $row_plan) {
                                                        $plan_id = $row_plan->Plan_Id;
                                                        $plan_name = $row_plan->Plan_Name;
                                                        $no_of_order = $row_plan->No_Of_Order;
                                                        ?>
                                                        <option value="<?php echo $plan_id ?>"><?php echo $plan_name . " / " . $no_of_order . " orders"; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Plan Type<span class="required">
                                                    * </span>
                                            </label>
                                            <div class="col-md-9">
                                                <div class="radio-list" data-error-container="#form_2_membership_error" >
                                                    <div class="col-md-5">
                                                        <label>
                                                            <input type="radio" name="add_price_type" id="add_price_residential" value="Residential" checked/>
                                                            Residential </label>
                                                    </div>  
                                                    <div class="col-md-54">
                                                        <label>
                                                            <input type="radio" name="add_price_type" id="add_price_commercial" value="Commercial"/>
                                                            Commercial </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Order Type <span class="required">
                                                    * </span>
                                            </label>
                                            <div class="col-md-8">
                                                <select class="form-control select2me" name="add_price_orderype" id="add_price_orderype">                                                   
                                                    <?php
                                                    foreach ($q_ordertype->result() as $row_ordertype) {
                                                        $ordertype_id = $row_ordertype->Order_Type_ID;
                                                        $order_type = $row_ordertype->Order_Type;
                                                        ?>
                                                        <option value="<?php echo $ordertype_id ?>"><?php echo $order_type; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-3"> Price <span class="required"> * </span>
                                            </label>
                                            <div class="col-md-8">
                                                <div class="form-group form-md-line-input has-info">
                                                    <input type="text" class="form-control input-sm" name="add_price_amt" id="add_price_amt" placeholder="Price">
                                                    <label for="form_control_1"></label>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn blue">Save</button>
                                    <button type="button" data-dismiss="modal" class="btn default">Close</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- Add Price Popup End Here -->

                <!-- Edit Price Popup Start Here -->
                <div id="edit_price_model" class="modal fade" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                <h4 class="modal-title">Edit Price</h4>
                            </div>
                            <form role="form" id="editprice_form" method="post" class="form-horizontal">

                            </form>
                        </div>
                    </div>
                </div>
                <!-- Edit Price Popup End Here -->

                <!-- Delete Price Popup Start Here -->
                <div id="delete_price_model" class="modal fade" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                <h4 class="modal-title">Delete Price</h4>
                            </div>
                            <form role="form" id="deleteprice_form" method="post" class="form-horizontal">

                            </form>
                        </div>
                    </div>
                </div>
                <!-- Delete Price Popup End Here -->
            </div>
        </div>
    </div>
    <a class="b-c WpoiA" data-toggle="modal" href="#add_price_model">
        <i class="fa fa-plus"></i>
    </a>
</div>

<!--Priority Data table Export in Excel-->
<script src="<?php echo site_url('assets/global/export/datatables.js') ?>"></script>
<link href="<?php echo site_url('assets/global/export/datatables.css') ?>" rel="stylesheet" type="text/css"/>
<script type="text/javascript">$( document ).ready(function() {
    $('#sample_2').DataTable({
        "processing": true,
        "dom": 'lBfrtip',
        "buttons": [            
            {                
                extend: 'collection',                
                text: 'Export',                
                buttons: [                                        
                    'excel',                                        
                    'pdf'  
                ]            
            }        
        ]       
    })
    ;});
</script>