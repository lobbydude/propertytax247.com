<div class="page-content-wrapper">
    <div class="page-content">
        <!-- Tabs Menu Start Here-->
        <div class="row">
            <div class="col-md-12">
                <div class="tabbable tabbable-custom tabbable-noborder">
                    <ul class="nav nav-tabs" id="tabs">
                        <li class="active" onclick="otuser_tabopen('#navs', $(this).index())">
                            <a href="#tab_1_1" data-toggle="tab">
                                DASHBOARD </a>
                        </li>
                        <li onclick="otuser_tabopen('#navs', $(this).index())">
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
                                                        <h3 class="font-green-sharp"><small class="font-green-sharp"></small>0</h3>
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
                                                        <h3 class="font-red-haze">0</h3>
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
                                                        <h3 class="font-blue-sharp">0</h3>
                                                        <small>Completed</small>
                                                    </div>
                                                    <div class="icon">
                                                        <i class="icon-drawer"></i>
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
                                        </div>
                                        <div class="portlet-body">
                                            <table class="sample_2 table table-hover" id="sample_2">
                                                <thead>
                                                    <tr>
                                                        <th style="width:35px">Order No</th>                                  
                                                        <th>Order Date</th>
                                                        <th>Property Address</th>
                                                        <th>Product Type </th>
                                                        <th>State</th>
                                                        <th>County</th>
                                                        <th>Plan</th>
                                                        <th>Status</th>
                                                        <th style="background: none">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                   
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
        <!-- END PAGE CONTENT-->
    </div>
</div>

