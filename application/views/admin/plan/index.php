<?php
$this->db->order_by('Plan_Id', 'desc');
$this->db->where('Status', 1);
$q = $this->db->get('tbl_plan');
?>
<script>    
function edit_Plan(id) {  
      $.ajax({            
	  type: "POST",            
	  url: "<?php echo site_url('Plan/Editplan') ?>",            
	  data: "plan_id=" + id,            
	  cache: false,            
	  success: function (html) {                
	  $("#editplan_form").html(html);           
	  }        
	  });    
	  }    
	  function delete_Plan(id) {        
	  $.ajax({            
	  type: "POST",            
	  url: "<?php echo site_url('Plan/Deleteplan') ?>",            
	  data: "plan_id=" + id,            
	  cache: false,            
	  success: function (html) {                
	  $("#deleteplan_form").html(html);            
	  }        
	  });    
	  }    
	  $('#add_plan_name').live('keydown', function (e) {
		  var keyCode = e.keyCode || e.which; 
		  if (keyCode == 32) {
			  e.preventDefault();  
			  }    
			  });    
			  $('#add_no_of_order').live('keydown', function (e) { 
			  var keyCode = e.keyCode || e.which;  
			  if (keyCode == 32) {       
			  e.preventDefault();        
			  }    
			  });    
			  $('#add_plan_price').live('keydown', function (e) { 
			  var keyCode = e.keyCode || e.which;  
			  if (keyCode == 32) {      
			  e.preventDefault();        
			  }   
			  });    
			  function add_change_order(type) {        
			  if (type == "Single") {           
			  $('#add_no_of_order').val("1");   
			  $("#add_no_of_order").attr("disabled", "disabled");     
			  } else {
				  $("#add_no_of_order").removeAttr("disabled"); 
				}    
			  }
			  </script>
			  <div class="page-content-wrapper">    
			  <div class="page-content">  
			  <div class="row">            
			  <div class="col-md-12 col-sm-12">
			  <div class="portlet box blue">   
			  <div class="portlet-title">                        
			  <div class="caption">                            
			  <i class="icon-wallet"></i>Plans                        
			  </div>						
			  <div class="tools hidden-xs" style="width:15%"> 
			  <button id="btnExport" class="btn-default">Export to excel</button> 
			  </div>                        
			  <div class="tools" style="padding-top: 12px;">
			  <a href="javascript:;" class="reload"></a>  
			  </div></div>                    
			  <div class="portlet-body">                        
			  <table class="sample_2 table table-hover" id="Export_Excel">                           
			  <thead>                                
			  <tr>                                    
			  <th style="width:35px">S.No</th>                                    
			  <th>Plan Name</th>                                    
			  <th>Type</th>                                    
			  <th>No Of Order(s)</th>                                    
			  <th>Price ($)</th>                                    
			  <th style="width:70px;background: none">Action</th>                                
			  </tr>
			  </thead>                            
			  <tbody>                                
			  <?php                                
			  $i = 1;                                
			  foreach ($q->result() as $row) {                                    
			  $plan_id = $row->Plan_Id;                                    
			  $plan_name = $row->Plan_Name;                                    
			  $type = $row->Type;                                    
			  $no_of_order = $row->No_Of_Order;                                    
			  $price1 = $row->Price;                                    
			  $price = number_format((float) $price1, 2, '.', '');                                    
			  ?>                                    
			  <tr class="odd gradeX">                                        
			  <td><?php echo $i; ?></td>                                        
			  <td><?php echo $plan_name; ?></td>                                        
			  <td><?php echo $type; ?></td>                                        
			  <td><?php echo $no_of_order; ?></td>                                        
			  <td><?php echo $price; ?></td>                                        
			  <td>                                                                                    
			  <a class="btn btn-xs black node-buttons" data-toggle="modal" href="#edit_plan_model" onclick="edit_Plan(<?php echo $plan_id; ?>)">  
			  <span class="glyphicon glyphicon-pencil"></span></a>    
			  <a class="btn btn-xs node-buttons" data-toggle="modal" href="#delete_plan_model" onclick="delete_Plan(<?php echo $plan_id; ?>)">
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
			  <!-- Add Plan Popup Start Here -->   
              <div id="add_plan_model" class="modal fade" tabindex="-1" aria-hidden="true">           
			  <div class="modal-dialog">                        
			  <div class="modal-content">                            
			  <div class="modal-header">                                
			  <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>   
			  <h4 class="modal-title">New Plan</h4>  
			  </div>                           
			  <form role="form" id="addplan_form" method="post" class="form-horizontal">  
			  <div class="modal-body">                                    
			  <div class="row">                                        
			  <div class="col-md-10">                                           
			  <div id="add_plan_success" class="alert alert-success" style="display:none;">Plan details added successfully.</div>   
			  <div id="add_plan_exists" class="alert alert-info" style="display:none;">Plan details already exists.</div>    
			  <div id="add_plan_error" class="alert alert-danger" style="display:none;">Failed to add plan details.</div>
			  </div>                                    
			  </div>                                    
			  <div class="row">                                       
			  <div class="form-group">                                            
			  <label class="control-label col-md-3">Plan Name <span class="required"> * </span>   
			  </label>                                            
			  <div class="col-md-8">        
			  <div class="form-group form-md-line-input has-info">  
			  <input type="text" class="form-control input-sm" id="add_plan_name" name="add_plan_name" placeholder="Plan Name"> 
			  <label for="form_control_1"></label>    
			  </div>                                            
			  </div>                                       
			  </div>                                        
			  <div class="form-group">                 
			  <label class="control-label col-md-3">Type <span class="required"> * </span> </label>
			  <div class="col-md-8">                                                
			  <select class="form-control select2me" id="add_order_type" name="add_order_type" onchange="add_change_order(this.value)"> 
			  <option value="Single">Single</option>         
			  <option value="Bulk">Bulk</option>         
			  </select>                                           
			  </div>                                        
			  </div>                                        
			  <div class="form-group">                                            
			  <label class="control-label col-md-3">No of Orders <span class="required"> * </span> </label> 
			  <div class="col-md-8">            
			  <div class="form-group form-md-line-input has-info">  
			  <input type="text" class="form-control input-sm" name="add_no_of_order" id="add_no_of_order" placeholder="No of Orders" value="1" disabled=disabled>
			  <label for="form_control_1"></label>  
			  </div>                                            
			  </div>                                        
			  </div>                                        
			  <div class="form-group">          
			  <label class="control-label col-md-3">Price ($) <span class="required"> * </span> </label>
			  <div class="col-md-8">                                                
			  <div class="form-group form-md-line-input has-info">                                                    
			  <input type="text" class="form-control input-sm" name="add_plan_price" id="add_plan_price" placeholder="Price"> 
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
			  <!-- Add Plan Popup End Here -->
			  <!-- Edit Plan Popup Start Here -->   
			  <div id="edit_plan_model" class="modal fade" tabindex="-1" aria-hidden="true">
			  <div class="modal-dialog">                       
			  <div class="modal-content">                            
			  <div class="modal-header">                                
			  <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button> 
			  <h4 class="modal-title">Edit Plan</h4>                         
			  </div>                            
			  <form role="form" id="editplan_form" method="post" class="form-horizontal">   
			  </form>                        
			  </div>                    
			  </div>                
			  </div>                
			  <!-- Edit Plan Popup End Here -->
			  <!-- Delete Plan Popup Start Here -->  
              <div id="delete_plan_model" class="modal fade" tabindex="-1" aria-hidden="true">      
              <div class="modal-dialog">                        
			  <div class="modal-content">                            
			  <div class="modal-header">                                
			  <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>    
			  <h4 class="modal-title">Delete Plan</h4>                            
			  </div>                            
			  <form role="form" id="deleteplan_form" method="post" class="form-horizontal">  
			  </form>                        
			  </div>                    
			  </div>                
			  </div>                
			  <!-- Delete Plan Popup End Here -->           
			  </div>        
			  </div>    
			  </div>    
			  <a class="b-c WpoiA" data-toggle="modal" href="#add_plan_model">   
			  <i class="fa fa-plus"></i></a></div>
			  