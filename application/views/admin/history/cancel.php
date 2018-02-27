<?php
$this->db->order_by('Order_Date', 'desc');
$get_proecessing_data = array(
    'Order_Status' => 'Canceled',
    'Status' => 1
);
$this->db->where($get_proecessing_data);
$q_processing = $this->db->get('tbl_order');
?>
<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
    <div class="page-content">
        <div class="row">
            <div class="col-md-12">
                <div class="portlet box blue">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="icon-dislike"></i>Cancel History
                        </div>
						<div class="tools hidden-xs" style="width:15%">
                              <button id="btnExport" class="btn-default">Export to excel</button>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <table class="sample_2 table table-hover" id="Export_Excel">
                            <thead>
                                <tr>
                                    <th style="width:35px">Order No</th> 
                                    <th style="width:100px;">Client Name</th>
                                    <th style="width:100px;">Order Date</th>
                                    <th style="width:100px;">Plan Name</th>
                                    <th style="width:100px;">Product Type </th>
                                    <th style="width:100px;">State & County</th>                                    
                                    <th style="width:100px;">Status</th>
                                    <th style="width:100px;">Reason</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($q_processing->result() as $row) {
                                    $Order_Id = $row->Order_Id;
                                    $User_Id = $row->User_Id;
                                    $Order_Number = $row->Order_Number;
                                    $Order_Date1 = $row->Order_Date;
                                    $Order_Date = date("d-M-Y", strtotime($Order_Date1));
                                    $Street = $row->Street;
                                    $Product_Type = $row->Product_Type;
                                    $State_County = $row->State_County;
                                    
                                    $Plan_Id = $row->Plan_Id;
                                    $Order_Status = $row->Order_Status;
                                    $cancel_reason = $row->Cancel_Reason;
                                    $this->db->where('Plan_Id', $Plan_Id);
                                    $q_plan_name = $this->db->get('tbl_plan');
                                    foreach ($q_plan_name->result() as $row_plan) {
                                        $Plan_Name = $row_plan->Plan_Name;
                                        $Plan_Type = $row_plan->Type;
                                    }                                    
                                    $this->db->where('User_Id', $User_Id);
                                    $q_user = $this->db->get('tbl_user');
                                    foreach ($q_user->result() as $row_user) {
                                        $client_username = $row_user->Username;
                                    }
                                    ?>
                                    <tr class="odd gradeX">
                                        <td><?php echo $Order_Number; ?></td>
                                        <td><?php echo $client_username; ?></td>
                                        <td><?php echo $Order_Date; ?></td>
                                        <td><?php echo $Plan_Name .' '.$Plan_Type; ?></td>  
                                        <td><?php echo $Product_Type; ?></td>
                                        <td><?php echo $State_County; ?></td>                                        
                                        <td><?php echo $Order_Status; ?></td>
                                        <td><?php echo $cancel_reason; ?></td>
                                    </tr>
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
        <!-- END PAGE CONTENT INNER -->
    </div>
</div>
<!-- END CONTENT -->
