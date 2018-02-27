<?php
$User_Id = $this->session->userdata('client_id');
$this->db->order_by('Order_Id', 'desc');
$get_order_data = array('User_Id' => $User_Id, 'Order_Number' => $order_no, 'Status' => 1);
$this->db->where($get_order_data);
$q_order = $this->db->get('tbl_order');
$count_order = $q_order->num_rows();
?>
<script type="text/javascript" src="<?php echo site_url('assets/global/scripts/jquery.countdownTimer.js') ?>"></script>
<script>
    function delete_client_orderinfo(id, order_no) {
        var formdata = {order_id: id, order_no: order_no};
        $.ajax({type: "POST", url: "<?php echo site_url('Client/delete_orderinfo') ?>", data: formdata, cache: false, success: function (html) {
                $("#delete_client_orderinfo_form").html(html);
            }});
    }
</script>
<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">    
    <div class="page-content">       
        <div class="row">         
            <div class="col-md-12">        
                <div class="portlet box blue">        
                    <div class="portlet-title">        
                        <div class="caption">           
                            <i class="icon-layers"></i>Orders No : <?php echo $order_no; ?>  
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
                                    <th>Order Date</th>                                    
                                    <th>Property Address</th>                                    
                                    <th>Product Type </th>                                    
                                    <th>State & County</th>                                    
                                    <th>Plan Name</th>                                    
                                    <th>Status</th>                                    
                                    <th>Expected Time</th>                                    
                                    <th style="background: none">Action</th>                                
                                </tr>                            
                            </thead>                            
                            <tbody>                                
                                <?php
                                $i = 1;
                                foreach ($q_order->result() as $row) {
                                    $Order_Id = $row->Order_Id;
                                    $Order_Number = $row->Order_Number;
                                    $User_Id = $row->User_Id;
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
                                    $this->db->where('Plan_Id', $Plan_Id);
                                    $q_plan_name = $this->db->get('tbl_plan');
                                    foreach ($q_plan_name->result() as $row_plan) {
                                        $Plan_Name = $row_plan->Plan_Name;
                                        $Plan_Type = $row_plan->Type;
                                    }
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
                                        <td><?php echo $Plan_Name . "($Plan_Type)"; ?></td>                                 
                                        <td><?php echo $Order_Status; ?></td>                            
                                        <td>                                          
                                            <?php if ($init > 0) { ?><p id="hm_timer<?php echo $i; ?>"></p><?php
                                            } else {
                                                echo "Timeout";
                                            }
                                            ?>                              
                                        </td>                           
                                        <td>                              
                                            <a class="btn btn-xs black node-buttons" href="<?php echo site_url('Client/editorder/' . $Order_Id . '/upload'); ?>">                                               
                                                <span class="glyphicon glyphicon-upload fa fa-exclamation-triangle tooltips" data-original-title="Order Upload"></span>       
                                            </a>                                          
                                            <a class="btn btn-xs black node-buttons" href="#client_delete_order_model" data-toggle="modal" onclick="delete_client_orderinfo(<?php echo $Order_Id; ?>, '<?php echo $Order_Number; ?>')">   
                                                <span class="glyphicon glyphicon-remove-circle fa fa-exclamation-triangle tooltips" data-original-title="Cancel Order"></span> 
                                            </a>                         
                                        </td>                      
                                    </tr>                      
                                <script>
                                    $(function () {
                                        $('#hm_timer<?php echo $i; ?>').countdowntimer({hours: <?php echo $hours; ?>, minutes: <?php echo $minutes; ?>, seconds:<?php echo $seconds; ?>, size: "lg"});
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
        <!-- END PAGE CONTENT INNER -->  
    </div>
</div>
<!-- END CONTENT -->