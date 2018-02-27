<?php
$user_id = $this->session->userdata('client_id');
$this->db->order_by('Order_Date', 'desc');
$get_proecessing_data = array(
    'User_Id' => $user_id,
    'Order_Status' => 'Processing',
    'Status' => 1
);
$this->db->where($get_proecessing_data);
$q_processing = $this->db->get('tbl_order');
$count_processing = $q_processing->num_rows();
$this->db->order_by('Order_Date', 'desc');
$get_pending_data = array(
    'User_Id' => $user_id,
    'Order_Status' => 'Pending',
    'Status' => 1
);
$this->db->where($get_pending_data);
$q_pending = $this->db->get('tbl_order');
$count_pending = $q_pending->num_rows();
$this->db->order_by('Order_Date', 'desc');
$get_completed_data = array(
    'User_Id' => $user_id,
    'Order_Status' => 'Completed',
    'Status' => 1
);
$this->db->where($get_completed_data);
$q_completed = $this->db->get('tbl_order');
$count_completed = $q_completed->num_rows();
$this->db->order_by('Order_Date', 'desc');
$get_hold_data = array(
    'User_Id' => $user_id,
    'Order_Status' => 'Hold',
    'Status' => 1
);
$this->db->where($get_hold_data);
$q_hold = $this->db->get('tbl_order');
$count_hold = $q_hold->num_rows();
$this->db->order_by('Order_Date', 'desc');
$get_cancel_data = array(
    'User_Id' => $user_id,
    'Order_Status' => 'Canceled',
    'Status' => 1
);
$this->db->where($get_cancel_data);
$q_cancel = $this->db->get('tbl_order');
$count_cancel = $q_cancel->num_rows();
?>
<script type="text/javascript" src="<?php echo site_url('assets/global/scripts/jquery.countdownTimer.js') ?>"></script>
<script>
    function edit_client_orderinfo(id) {
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('Client/edit_orderinfo') ?>",
            data: "order_id=" + id,
            cache: false,
            success: function (html) {
                $("#edit_client_orderinfo_div").html(html);
            }
        });
    }
    function edit_client_orderupload(id) {
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('Client/edit_orderinfo') ?>",
            data: "order_id=" + id,
            cache: false,
            success: function (html) {
                $("#edit_client_orderinfo_div").html(html);
                $('#edit_client_orderinfo_form').hide();
            }
        });
    }
    function delete_client_orderinfo(id, order_no) {
        var formdata = {
            order_id: id,
            order_no: order_no
        };
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('Client/delete_orderinfo') ?>",
            data: formdata,
            cache: false,
            success: function (html) {
                $("#delete_client_orderinfo_form").html(html);
            }
        });
    }
</script>
<div class="page-content-wrapper">
    <div class="page-content">
        <!-- Tabs Menu Start Here-->
        <div class="row">
            <div class="col-md-12">
                <div class="tabbable tabbable-custom tabbable-noborder">
                    <ul class="nav nav-tabs" id="tabs">
                        <li class="active" onclick="client_tabopen('#navs', $(this).index())">
                            <a href="#tab_1_1" data-toggle="tab">
                                DASHBOARD </a>
                        </li>
                        <li onclick="client_tabopen('#navs', $(this).index())">
                            <a href="#tab_1_2" data-toggle="tab">
                                ORDERS QUEUE </a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active fontawesome-demo" id="tab_1_1">
                            <div class="note note-success">
                                <div class="row">
                                    <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                        <a data-toggle="modal" href="#view_client_orderprocessing_model">
                                            <div class="dashboard-stat2">
                                                <div class="display">
                                                    <div class="number">
                                                        <h3 class="font-green-sharp"><small class="font-green-sharp"></small><?php echo $count_processing; ?></h3>
                                                        <small>Processing</small>														
                                                    </div>
                                                    <div class="icon">
                                                        <i class="icon-refresh"></i>
                                                    </div>

                                                </div>

                                            </div>

                                        </a>

                                    </div>

                                    <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">

                                        <a data-toggle="modal" href="#view_client_orderpending_model">

                                            <div class="dashboard-stat2">

                                                <div class="display">

                                                    <div class="number">

                                                        <h3 class="font-red-haze"><?php echo $count_pending; ?></h3>

                                                        <small>Pending</small>

                                                    </div>

                                                    <div class="icon">

                                                        <i class="icon-info"></i>

                                                    </div>

                                                </div>

                                            </div>

                                        </a>

                                    </div>

                                    <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">

                                        <a data-toggle="modal" href="#view_client_ordercompleted_model">

                                            <div class="dashboard-stat2">

                                                <div class="display">

                                                    <div class="number">

                                                        <h3 class="font-green-sharp"><?php echo $count_completed; ?></h3>

                                                        <small>Completed</small>

                                                    </div>

                                                    <div class="icon">

                                                        <i class="icon-drawer"></i>

                                                    </div>

                                                </div>

                                            </div>

                                        </a>

                                    </div>

                                    <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">

                                        <a data-toggle="modal" href="#view_client_orderhold_model">

                                            <div class="dashboard-stat2">

                                                <div class="display">

                                                    <div class="number">

                                                        <h3 class="font-green-sharp"><?php echo $count_hold; ?></h3>

                                                        <small>Hold</small>

                                                    </div>

                                                    <div class="icon">

                                                        <i class="icon-lock-open"></i>

                                                    </div>

                                                </div>

                                            </div>

                                        </a>

                                    </div>



                                    <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">

                                        <a data-toggle="modal" href="#view_client_ordercancel_model">

                                            <div class="dashboard-stat2">

                                                <div class="display">

                                                    <div class="number">

                                                        <h3 class="font-green-sharp"><?php echo $count_cancel; ?></h3>

                                                        <small>Canceled</small>

                                                    </div>

                                                    <div class="icon">

                                                        <i class="icon-dislike"></i>

                                                    </div>

                                                </div>

                                            </div>

                                        </a>

                                    </div> 

                                </div>

                            </div>

                        </div>                       



                        <div class="tab-pane" id="tab_1_2">

                            <div class="row">

                                <div class="col-md-12 col-sm-12">

                                    <div class="portlet box blue">

                                        <div class="portlet-title">

                                            <div class="caption">

                                                <i class="icon-layers"></i>Orders Queue

                                            </div>
											<div class="tools hidden-xs" style="width:15%">
                                                <button id="btnExport" class="btn-default">Export to excel</button>
                                            </div>

                                        </div>

                                        <div class="portlet-body">

                                            <table class="sample_2 table table-hover" id="Export_Excel">

                                                <thead>

                                                    <tr>

                                                        <th style="width:100px">Order No</th>                               														
                                                        <th style="width:100px;">Order Date</th>
                                                        <th style="width:100px;">Property Address</th>
                                                        <th style="width:100px;">Product Type </th>
                                                        <th style="width:100px;">State & County</th>
                                                        <th style="width:100px;">Plan Name</th>                                                        
                                                        <th style="width:100px;">Status</th>
                                                        <th style="width:100px;">Timing</th>
                                                        <th style="width:100px;">Priority</th>
                                                        <th style="background: none">Action</th>                                                      

                                                    </tr>

                                                </thead>

                                                <tbody>

                                                    <?php
                                                    $i = 1;

                                                    foreach ($q_processing->result() as $row) {
                                                        $Order_Id = $row->Order_Id;
                                                        $Order_Number = $row->Order_Number;
                                                        $Order_Date1 = $row->Order_Date;
                                                        $Order_Date = date("d-M-Y", strtotime($Order_Date1));
                                                        $Street = $row->Street;
                                                        $Product_Type = $row->Product_Type;
                                                        $State_County = $row->State_County;
                                                        $Plan_Id = $row->Plan_Id;
                                                        $Order_Status = $row->Order_Status;
                                                        $Set_Date = $row->Set_Date;
                                                        date_default_timezone_set("Asia/Kolkata");
                                                        $current_date = date('Y-m-d H:i:s');

                                                        $timeFirst = strtotime($current_date);

                                                        $timeSecond = strtotime($Set_Date);

                                                        $init = $timeSecond - $timeFirst;

                                                        $hours = floor($init / 3600);

                                                        $minutes = floor(($init / 60) % 60);

                                                        $seconds = $init % 60;

                                                        $Inserted_Date = $row->Inserted_Date;

                                                        $add2h_time = date('Y-m-d H:i:s', strtotime($Inserted_Date . ' + 2 hours'));

                                                        $this->db->where('Plan_Id', $Plan_Id);

                                                        $q_plan_name = $this->db->get('tbl_plan');

                                                        foreach ($q_plan_name->result() as $row_plan) {
                                                            $Plan_Name = $row_plan->Plan_Name;
                                                            $Plan_Type = $row_plan->Type;
                                                        }
                                                        $Priority1 = $row->Priority;
                                                        $Priority = number_format((float) $Priority1, 2, '.', '');
                                                        ?>

                                                        <tr class="odd gradeX">
                                                            <td>
                                                                <a href="<?php echo site_url('Client/editorder/' . $Order_Id); ?>">
                                                                    <?php echo $Order_Number; ?>
                                                                </a>
                                                            </td>
                                                            <td><?php echo $Order_Date; ?></td>
                                                            <td><?php echo $Street; ?></td>
                                                            <td><?php echo $Product_Type; ?></td>
                                                            <td><?php echo $State_County; ?></td>
                                                            <td><?php echo $Plan_Name . ' ' . $Plan_Type ?></td>                                                            
                                                            <td><?php echo $Order_Status; ?></td>
                                                            <td>  <?php if ($init > 0) { ?><p id="hm_timer<?php echo $i; ?>"></p><?php
                                                                } else {
                                                                    echo "Timeout";
                                                                }
                                                                ?></td>
                                                            <td style="color:red;"><?php
                                                                if ($Priority != 0) {
                                                                    echo "Rush Order";
                                                                } else {
                                                                    echo "";
                                                                }
                                                                ?></td>

                                                            <td>
                                                                <a class="btn btn-xs black node-buttons" href="<?php echo site_url('Client/editorder/' . $Order_Id . '/upload'); ?>">
                                                                    <span class="glyphicon glyphicon-upload fa fa-exclamation-triangle tooltips" data-original-title="Order Upload"></span>
                                                                </a>
                                                                <?php
                                                                if ((strtotime($current_date)) < (strtotime($add2h_time))) {
                                                                    ?>

                                                                    <a class="btn btn-xs black node-buttons" href="#client_delete_order_model" data-toggle="modal" onclick="delete_client_orderinfo(<?php echo $Order_Id; ?>, '<?php echo $Order_Number; ?>')">

                                                                        <span class="glyphicon glyphicon-remove-circle tooltips" data-original-title="Cancel Order"></span>

                                                                    </a>
																<?php } ?>

                                                            </td>

                                                        </tr>

                                                    <script>

                                                        $(function () {

                                                            $('#hm_timer<?php echo $i; ?>').countdowntimer({
                                                                hours: <?php echo $hours; ?>,
                                                                minutes: <?php echo $minutes; ?>,
                                                                seconds:<?php echo $seconds; ?>,
                                                                size: "lg"

                                                            });

                                                        });

                                                    </script>

                                                    <?php
                                                    $i++;
                                                }
                                                ?>

                                                </tbody>

                                            </table>

                                        </div>

                                    </div>            

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <!-- Tabs Menu End Here-->



        <!-- View Client Order Processing Popup Start Here -->

        <div id="view_client_orderprocessing_model" class="modal fade" tabindex="-1" aria-hidden="true">

            <div class="modal-dialog modal-lg">

                <div class="modal-content">

                    <div class="modal-header">

                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>

                        <h4 class="modal-title">Processing Orders</h4>
						<div class="tools hidden-xs" style="width:15%; margin:-3% 80% 0%;">
                            <button id="btnExport_Processing1" class="btn-default">Export to excel</button>
                        </div>

                    </div>

                    <form role="form" class="form-horizontal popuptable">

                        <table class="sample_2 table table-hover" id="Export_Excel_processing1">

                            <thead>

                                <tr>
                                    <th style="width:35px;">S.No</th>                                  
                                    <th style="width:100px;">Order No</th>                                  

                                    <th style="width:100px;">Order Date</th>

                                    <th style="width:100px;">Property Address</th>

                                    <th style="width:100px;">Product Type </th>

                                    <th style="width:100px;">State County</th>

                                    <th style="width:100px;">Plan Name</th>

                                </tr>

                            </thead>

                            <tbody>

                                <?php
                                $i1 = 1;
                                foreach ($q_processing->result() as $row_processing) {

                                    $Order_Id_Processing = $row_processing->Order_Id;

                                    $Order_Number_Processing = $row_processing->Order_Number;

                                    $Order_Date1_Processing = $row_processing->Order_Date;

                                    $Order_Date_Processing = date("d-M-Y", strtotime($Order_Date1_Processing));

                                    $Street_Processing = $row_processing->Street;

                                    $Product_Type_Processing = $row_processing->Product_Type;

                                    $State_Processing = $row_processing->State_County;

                                    $Plan_Id_Processing = $row_processing->Plan_Id;

                                    $Order_Status_Processing = $row_processing->Order_Status;



                                    $this->db->where('Plan_Id', $Plan_Id_Processing);

                                    $q_plan_processing = $this->db->get('tbl_plan');

                                    foreach ($q_plan_processing->result() as $row_plan_processing) {
                                        $Plan_Name_Processing = $row_plan_processing->Plan_Name;
                                        $Plan_type_Processing = $row_plan_processing->Type;
                                    }
                                    ?>



                                    <tr class="odd gradeX">
                                        <td><?php echo $i1; ?></td>

                                        <td>

                                            <a href="<?php echo site_url('Client/editorder/' . $Order_Id_Processing); ?>">

                                             <?php echo $Order_Number_Processing; ?>

                                            </a>

                                        </td>

                                        <td><?php echo $Order_Date_Processing; ?></td>

                                        <td><?php echo $Street_Processing; ?></td>

                                        <td><?php echo $Product_Type_Processing; ?></td>

                                        <td><?php echo $State_Processing; ?></td>

                                        <td><?php echo $Plan_Name_Processing . ' ' . $Plan_type_Processing; ?></td>                                       

                                    </tr>

                                    <?php
                                    $i1++;
                                }
                                ?>

                            </tbody>

                        </table>

                    </form>

                </div>

            </div>

        </div>

        <!--  View Client Order Processing Popup End Here -->



        <!--  View Client Order Pending Popup Start Here -->

        <div id="view_client_orderpending_model" class="modal fade" tabindex="-1" aria-hidden="true">

            <div class="modal-dialog modal-lg">

                <div class="modal-content">

                    <div class="modal-header">

                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>

                        <h4 class="modal-title">Pending Orders</h4>
						<div class="tools hidden-xs" style="width:15%; margin:-3% 80% 0%;">
                            <button id="btnExport_Pending" class="btn-default">Export to excel</button>
                        </div>

                    </div>

                    <form role="form" class="form-horizontal popuptable">

                        <table class="sample_2 table table-hover" id="Export_Excel_Pending">

                            <thead>

                                <tr class="odd gradeX">
                                    <th style="width:35px;">S.No</th> 
                                    <th style="width:100px;">Order No</th>                                 

                                    <th style="width:100px;">Order Date</th>

                                    <th style="width:100px;">Property Address</th>

                                    <th style="width:100px;">Product Type </th>

                                    <th style="width:100px;">State County</th>

                                    <th style="width:100px;">Plan Name</th>

                                </tr>

                            </thead>

                            <tbody>

                                <?php
                                $i2 = 1;
                                foreach ($q_pending->result() as $row_pending) {

                                    $Order_Id_Pending = $row_pending->Order_Id;

                                    $Order_Number_Pending = $row_pending->Order_Number;

                                    $Order_Date1_Pending = $row_pending->Order_Date;

                                    $Order_Date_Pending = date("d-M-Y", strtotime($Order_Date1_Pending));

                                    $Street_Pending = $row_pending->Street;

                                    $Product_Type_Pending = $row_pending->Product_Type;

                                    $State_Pending = $row_pending->State_County;

                                    $Plan_Id_Pending = $row_pending->Plan_Id;

                                    $Order_Status_Pending = $row_pending->Order_Status;



                                    $this->db->where('Plan_Id', $Plan_Id_Pending);

                                    $q_plan_pending = $this->db->get('tbl_plan');

                                    foreach ($q_plan_pending->result() as $row_plan_pending) {
                                        $Plan_Name_Pending = $row_plan_pending->Plan_Name;
                                        $Plan_Type_Pending = $row_plan_pending->Type;
                                    }
                                    ?>

                                    <tr>

                                                                               
                                        <td><?php echo $i2; ?></td>    
                                       <td>                                
                                         <a href="<?php echo site_url('Client/editorder/' . $Order_Id_Pending); ?>">
                                       <?php echo $Order_Number_Pending; ?>

                                </a>

                                </td>

                                <td><?php echo $Order_Date_Pending; ?></td>

                                <td><?php echo $Street_Pending; ?></td>

                                <td><?php echo $Product_Type_Pending; ?></td>

                                <td><?php echo $State_Pending; ?></td>

                                <td><?php echo $Plan_Name_Pending . ' ' . $Plan_Type_Pending; ?></td>                                       

                                </tr>

                                <?php
                                $i2++;                        }
                            ?>

                            </tbody>

                        </table>

                    </form>

                </div>

            </div>

        </div>

        <!--  View Client Order Pending Popup End Here -->

        <!--  View Client Order Completed Popup Start Here -->

        <div id="view_client_ordercompleted_model" class="modal fade" tabindex="-1" aria-hidden="true">

            <div class="modal-dialog modal-lg">

                <div class="modal-content">

                    <div class="modal-header">

                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>

                        <h4 class="modal-title">Completed Orders</h4>
						<div class="tools hidden-xs" style="width:15%; margin:-3% 80% 0%;">
                            <button id="btnExport_Completed" class="btn-default">Export to excel</button>
                        </div>

                    </div>

                    <form role="form" class="form-horizontal popuptable">
                        <table class="sample_2 table table-hover" id="Export_Excel_Completed">
                            <thead>
                                <tr class="odd gradeX">
                                    <th style="width:35px;">S.No</th> 

                                    <th style="width:100px;">Order No</th>                                  

                                    <th style="width:100px;">Order Date</th>

                                    <th style="width:100px;">Property Address</th>

                                    <th style="width:100px;">Product Type </th>

                                    <th style="width:100px;">State County</th>

                                    <th style="width:100px;">Plan</th>

                                </tr>

                            </thead>

                            <tbody>

                                <?php
                                $i3 = 1;
                                foreach ($q_completed->result() as $row_completed) {

                                    $Order_Id_Completed = $row_completed->Order_Id;

                                    $Order_Number_Completed = $row_completed->Order_Number;

                                    $Order_Date1_Completed = $row_completed->Order_Date;

                                    $Order_Date_Completed = date("d-M-Y", strtotime($Order_Date1_Completed));

                                    $Street_Completed = $row_completed->Street;

                                    $Product_Type_Completed = $row_completed->Product_Type;

                                    $State_Completed = $row_completed->State_County;

                                    $Plan_Id_Completed = $row_completed->Plan_Id;

                                    $Order_Status_Completed = $row_completed->Order_Status;



                                    $this->db->where('Plan_Id', $Plan_Id_Completed);

                                    $q_plan_completed = $this->db->get('tbl_plan');

                                    foreach ($q_plan_completed->result() as $row_plan_completed) {

                                        $Plan_Name_Completed = $row_plan_completed->Plan_Name;
                                    }
                                    ?>



                                    <tr class="odd gradeX">
                                        <td><?php echo $i3; ?></td>
                                        <td>
                                            <a href="<?php echo site_url('Client/editorder/' . $Order_Id_Completed); ?>">
										    <?php echo $Order_Number_Completed; ?>
                                            </a>
                                        </td>
                                        <td><?php echo $Order_Date_Completed; ?></td>

                                        <td><?php echo $Street_Completed; ?></td>

                                        <td><?php echo $Product_Type_Completed; ?></td>

                                        <td><?php echo $State_Completed; ?></td>

                                        <td><?php echo $Plan_Name_Completed ?></td>                                       

                                    </tr>

                                    <?php
                                    $i3++;
                                }
                                ?>

                            </tbody>

                        </table>

                    </form>

                </div>

            </div>

        </div>

        <!--  View Client Order Completed Popup End Here -->

        <!--  View Client Order Hold Popup Start Here -->

        <div id="view_client_orderhold_model" class="modal fade" tabindex="-1" aria-hidden="true">

            <div class="modal-dialog modal-lg">

                <div class="modal-content">

                    <div class="modal-header">

                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>

                        <h4 class="modal-title">Hold Orders</h4>
						<div class="tools hidden-xs" style="width:15%; margin:-3% 80% 0%;">
                            <button id="btnExport_Hold" class="btn-default">Export to excel</button>
                        </div>

                    </div>

                    <form role="form" class="form-horizontal popuptable">

                        <table class="sample_2 table table-hover" id="Export_Excel_Hold">

                            <thead>

                                <tr class="odd gradeX">
                                    <th style="width:35px;">S.No</th> 
									
                                    <th style="width:100px;">Order No</th>                                  

                                    <th style="width:100px;">Order Date</th>

                                    <th style="width:100px;">Property Address</th>

                                    <th style="width:100px;">Product Type </th>

                                    <th style="width:100px;">State&County</th>

                                    <th style="width:100px;">Plan</th>

                                </tr>

                            </thead>

                            <tbody>

                                <?php
                                $i4 = 1;
                                foreach ($q_hold->result() as $row_hold) {

                                    $Order_Id_Hold = $row_hold->Order_Id;

                                    $Order_Number_Hold = $row_hold->Order_Number;

                                    $Order_Date1_Hold = $row_hold->Order_Date;

                                    $Order_Date_Hold = date("d-M-Y", strtotime($Order_Date1_Hold));

                                    $Street_Hold = $row_hold->Street;

                                    $Product_Type_Hold = $row_hold->Product_Type;

                                    $State_Hold = $row_hold->State_County;

                                    $Plan_Id_Hold = $row_hold->Plan_Id;

                                    $Order_Status_Hold = $row_hold->Order_Status;



                                    $this->db->where('Plan_Id', $Plan_Id_Hold);

                                    $q_plan_hold = $this->db->get('tbl_plan');

                                    foreach ($q_plan_hold->result() as $row_plan_hold) {

                                        $Plan_Name_Hold = $row_plan_hold->Plan_Name;
                                    }
                                    ?>



                                    <tr class="odd gradeX">
                                        <td><?php echo $i4; ?></td>

                                        <td>
                                            <a href="<?php echo site_url('Client/editorder/' . $Order_Id_Hold); ?>">
                                            <?php echo $Order_Number_Hold; ?>
                                            </a>
                                        </td>

                                        <td><?php echo $Order_Date_Hold; ?></td>

                                        <td><?php echo $Street_Hold; ?></td>

                                        <td><?php echo $Product_Type_Hold; ?></td>

                                        <td><?php echo $State_Hold; ?></td>

                                        <td><?php echo $Plan_Name_Hold; ?></td>                                       

                                    </tr>

                                    <?php
                                    $i4++;
                                }
                                ?>

                            </tbody>

                        </table>

                    </form>

                </div>

            </div>

        </div>

        <!--  View Client Order Hold Popup End Here -->



        <!-- View Client Order Cancel Popup Start here-->

        <div id="view_client_ordercancel_model" class="modal fade" tabindex="-1" aria-hidden="true">

            <div class="modal-dialog modal-lg">

                <div class="modal-content">

                    <div class="modal-header">

                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>

                        <h4 class="modal-title">Canceled Orders</h4>
						<div class="tools hidden-xs" style="width:15%; margin:-3% 80% 0%;">
                            <button id="btnExport_Cancel" class="btn-default">Export to excel</button>
                        </div>

                    </div>

                    <form role="form" class="form-horizontal popuptable">

                        <table class="sample_2 table table-hover" id="Export_Excel_Cancel">

                            <thead>

                                <tr class="odd gradeX">
                                    <th style="width:35px;">S.No</th> 

                                    <th style="width:100px;">Order No</th>                                  

                                    <th style="width:100px;">Order Date</th>

                                    <th style="width:100px;">Property Address</th>

                                    <th style="width:100px;">Product Type </th>

                                    <th style="width:100px;">State&County</th>

                                    <th style="width:100px;">Plan</th>

                                </tr>

                            </thead>

                            <tbody>

                                <?php
                                $i5 = 1;
                                foreach ($q_cancel->result() as $row_cancel) {

                                    $Order_Id_Cancel = $row_cancel->Order_Id;

                                    $Order_Number_Cancel = $row_cancel->Order_Number;

                                    $Order_Date1_Cancel = $row_cancel->Order_Date;

                                    $Order_Date_Cancel = date("d-M-Y", strtotime($Order_Date1_Cancel));

                                    $Street_Cancel = $row_cancel->Street;

                                    $Product_Type_Cancel = $row_cancel->Product_Type;

                                    $State_Cancel = $row_cancel->State_County;

                                    $Plan_Id_Cancel = $row_cancel->Plan_Id;

                                    $Order_Status_Cancel = $row_cancel->Order_Status;



                                    $this->db->where('Plan_Id', $Plan_Id_Cancel);

                                    $q_plan_cancel = $this->db->get('tbl_plan');

                                    foreach ($q_plan_cancel->result() as $row_plan_cancel) {

                                        $Plan_Name_Cancel = $row_plan_cancel->Plan_Name;
                                    }
                                    ?>



                                    <tr class="odd gradeX">
                                        <td><?php echo $i5; ?></td>
                                        <td>

                                            <a href="<?php echo site_url('Client/editorder/' . $Order_Id_Cancel); ?>">

                                             <?php echo $Order_Number_Cancel; ?>

                                            </a>

                                        </td>

                                        <td><?php echo $Order_Date_Cancel; ?></td>

                                        <td><?php echo $Street_Cancel; ?></td>

                                        <td><?php echo $Product_Type_Cancel; ?></td>

                                        <td><?php echo $State_Cancel; ?></td>

                                        <td><?php echo $Plan_Name_Cancel; ?></td>                                       

                                    </tr>

                                    <?php
                                    $i5++;
                                }
                                ?>

                            </tbody>

                        </table>

                    </form>

                </div>

            </div>

        </div>

        <!--  View Client Order Cancel Popup End Here -->



        <!-- Delete Order Popup Start Here -->

        <div id="client_delete_order_model" class="modal fade" tabindex="-1" aria-hidden="true">

            <div class="modal-dialog">

                <div class="modal-content">

                    <div class="modal-header">

                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>

                        <h4 class="modal-title">Cancel Order</h4>

                    </div>

                    <form role="form" id="delete_client_orderinfo_form" method="post" class="form-horizontal" name="delete_client_orderinfo_form">



                    </form>

                </div>

            </div>

        </div>

        <!-- Delete Order Popup End Here -->

        <!-- END PAGE CONTENT-->

    </div>

</div>

<script>
    $(document).ready(function () {
		
		 $("#btnExport_Processing1").click(function () {
            $("#Export_Excel_processing1").btechco_excelexport({
                containerid: "Export_Excel_processing1",
                datatype: $datatype.Table,
                 title:"Processing Order"
            });
        });
		
        $("#btnExport_Pending").click(function () {
            $("#Export_Excel_Pending").btechco_excelexport({
                containerid: "Export_Excel_Pending",
                datatype: $datatype.Table,
                 title:"Pending Order"
            });
        });

        $("#btnExport_Completed").click(function () {
            $("#Export_Excel_Completed").btechco_excelexport({
                containerid: "Export_Excel_Completed",
                datatype: $datatype.Table,
                 title:"Completed Order"
            });
        });

        $("#btnExport_Hold").click(function () {
            $("#Export_Excel_Hold").btechco_excelexport({
                containerid: "Export_Excel_Hold",
                datatype: $datatype.Table,
                 title:"Hold Order"
            });
        });

        $("#btnExport_Cancel").click(function () {
            $("#Export_Excel_Cancel").btechco_excelexport({
                containerid: "Export_Excel_Cancel",
                datatype: $datatype.Table,
                 title:"Cancel Order"
            });
        });
    });
</script>
