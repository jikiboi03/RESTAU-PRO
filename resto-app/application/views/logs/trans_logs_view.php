            <!--CONTENT CONTAINER-->
            <!--===================================================-->
            <div id="content-container">
                
                <!--Page Title-->
                <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                <div id="page-title">
                    <h1 class="page-header text-overflow"><?php echo $title; ?></h1>

                    <!--Searchbox-->
                    <!-- <div class="searchbox">
                        <div class="input-group custom-search-form">
                            <input type="text" class="form-control" placeholder="Search..">
                            <span class="input-group-btn">
                                <button class="text-muted" type="button"><i class="fa fa-search"></i></button>
                            </span>
                        </div>
                    </div> -->
                </div>
                <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                <!--End page title-->

                <!--Breadcrumb-->
                <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                <ol class="breadcrumb">
                    <li><a href="<?php echo base_url('dashboard');?>">Dashboard</a></li>
                    <li class="active">Transaction Logs List</li>
                </ol>
                <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                <!--End breadcrumb-->
                <!--Page content-->
                <!--===================================================-->
                <div id="page-content">
                    <!-- Basic Data Tables -->
                    <!--===================================================-->
                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title">Transaction Logs Information Table</h3>
                        </div>

                        <div class="panel-body">
                            
                            <button class="btn btn-default" onclick="reload_table()"><i class="fa fa-refresh"></i> &nbsp;Reload</button>
                            <br><br>
                            <table id="trans-logs-table" class="table table-striped table-bordered" cellspacing="0" width="100%" style="font-size: 14px;">
                                <thead>
                                    <tr>
                                        <th>Log ID</th>
                                        <th>Type</th>
                                        <th>Details</th>
                                        <th>User</th>
                                        <th>Date & Time</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!--===================================================-->
                    <!-- End Striped Table -->
                    <span>Legend: [ &nbsp; <i style = "color: #ffffff;" class="fa fa-square"></i><i style = "color: #cccccc;" class="fa fa-square"></i> - SetOrder &nbsp; | &nbsp; <i style = "color: #99ff99;" class="fa fa-square"></i> - Payment &nbsp; | &nbsp; <i style = "color: #99ffff;" class="fa fa-square"></i> - UpdateOrder &nbsp; | &nbsp; <i style = "color: #ffcc99;" class="fa fa-square"></i> - Cancel &nbsp; | &nbsp; <i style = "color: #ff66cc;" class="fa fa-square"></i> - Void &nbsp; | &nbsp; <i style = "color: #ffcc33;" class="fa fa-square"></i> - Refund &nbsp; | &nbsp; <i style = "color: #999999;" class="fa fa-square"></i> - Discount &nbsp; ]</span>
                </div>
                <!--===================================================-->
                <!--End page content-->
            </div>
            <!--===================================================-->
            <!--END CONTENT CONTAINER-->
