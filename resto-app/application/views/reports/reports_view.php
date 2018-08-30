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
                    <li class="active">Generate Reports</li>
                </ol>
                <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                <!--End breadcrumb-->
                <!--Page content-->
                <!--===================================================-->
                <div class="col-md-12">
                    <!-- Basic Data Tables -->
                    <!--===================================================-->
                    <div class="col-md-12">
                        <div id="page-content" class="panel panel-light panel-colorful col-md-12">
                            <!--===================================================-->
                            <div class="panel-heading">
                                <h3 class="panel-title"><i class="fa fa-calendar"></i>&nbsp; Date Range Filter Selection</h3>
                            </div>

                            <div class="panel-body">
                                <form action="#" id="form" class="form-horizontal">
                                    <div class="form-group">
                                        <label class="control-label col-md-2">Select Filter Type :</label>
                                        <div class="col-md-6">
                                            <select name="report_type" id="report_type" class="form-control" style="font-size: 15px;">
                                                <option value="alltime">All Time</option>
                                                <option value="annual">Annual</option>
                                                <option value="monthly">Monthly</option>
                                                <option value="custom">Custom Range</option>
                                            </select>
                                        </div>
                                        <br><br><hr>
                                        <div class="col-md-12" id="year_month_div" style="display: none;">
                                            <label class="control-label col-md-2">Select Year :</label>
                                            <div class="col-md-2">
                                                <input name="current_year" type="hidden" value="<?php echo $current_year; ?>" >
                                                <select name="year" id="year" class="form-control" style="font-size: 15px;">
                                                    <option value="2018">2018</option>
                                                    <option value="2019">2019</option>
                                                    <option value="2020">2020</option>
                                                    <option value="2021">2021</option>
                                                    <option value="2022">2022</option>
                                                </select>
                                            </div>
                                            <div class="col-md-4" id="month_div">
                                            <label class="control-label col-md-6">Select Month :</label>
                                            <div class="col-md-6">
                                                <input name="current_month" type="hidden" value="<?php echo $current_month; ?>" >
                                                <select name="month" id="month" class="form-control" style="font-size: 15px;">
                                                    <option value="01">January</option>
                                                    <option value="02">February</option>
                                                    <option value="03">March</option>
                                                    <option value="04">April</option>
                                                    <option value="05">May</option>
                                                    <option value="06">June</option>
                                                    <option value="07">July</option>
                                                    <option value="08">August</option>
                                                    <option value="09">September</option>
                                                    <option value="10">October</option>
                                                    <option value="11">November</option>
                                                    <option value="12">December</option>
                                                </select>
                                            </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12" id="custom_range_div" style="display: none;">
                                            <label class="control-label col-md-2">Date From :</label>
                                            <div class="col-md-2">
                                                <input name="date_from" class="form-control" type="date" value="<?php echo $today; ?>" style="font-size: 14px;">
                                            </div>
                                            <label class="control-label col-md-2">Date To :</label>
                                            <div class="col-md-2">
                                                <input name="date_to" class="form-control" type="date" value="<?php echo $today; ?>" style="font-size: 14px;">
                                            </div>
                                        </div>

                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                    <div class="col-md-6">
                        <div id="page-content" class="panel panel-light panel-colorful">
                            <!--===================================================-->
                            <div class="panel-heading">
                                <h3 class="panel-title"><i class="fa fa-qrcode"></i>&nbsp; Transaction Reports</h3>
                            </div>

                            <div class="panel-body">
                                <form action="#" id="form" class="form-horizontal">
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Select Report Type :</label>
                                        <div class="col-md-9">
                                            <select name="trans_report_type" id="report_type" class="form-control" style="font-size: 15px;">
                                                <option value="trans-all">All Transaction Status</option>
                                                <option value="trans-cleared">Cleared Transactions</option>
                                                <option value="trans-cancelled">Cancelled Transactions</option>
                                                <option value="trans-refunded">Refunded Transactions</option>
                                            </select>
                                        </div>
                                        
                                        <br><br><hr>
                                        <div class="col-md-8"></div>
                                        <button type="button" id="generate_report" onclick="set_report_transactions()" class="btn btn-dark col-md-4" style="font-size: 15px;"><i class="fa fa-file"></i> &nbsp;Generate Report</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div id="page-content" class="panel panel-light panel-colorful">
                            <!--===================================================-->
                            <div class="panel-heading">
                                <h3 class="panel-title"><i class="fa fa-cutlery"></i>&nbsp; Menu Item Reports</h3>
                            </div>

                            <div class="panel-body">
                                <form action="#" id="form" class="form-horizontal">
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Select Report Type :</label>
                                        <div class="col-md-9">
                                            <select name="menu_items_report_type" id="report_type" class="form-control" style="font-size: 15px;">
                                                <option value="menu-products">Menu Products</option>
                                                <option value="menu-packages">Menu Packages</option>
                                                <option value="menu-top-selling">Top Selling</option>
                                            </select>
                                        </div>
                                        
                                        <br><br><hr>
                                        <div class="col-md-8"></div>
                                        <button type="button" id="generate_report" onclick="set_report_menu_items()" class="btn btn-dark col-md-4" style="font-size: 15px;"><i class="fa fa-file"></i> &nbsp;Generate Report</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div id="page-content" class="panel panel-light panel-colorful">
                            <!--===================================================-->
                            <div class="panel-heading">
                                <h3 class="panel-title"><i class="fa fa-user-circle"></i>&nbsp; Users Reports</h3>
                            </div>

                            <div class="panel-body">
                                <form action="#" id="form" class="form-horizontal">
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Select Report Type :</label>
                                        <div class="col-md-9">
                                            <select name="users_report_type" id="report_type" class="form-control" style="font-size: 15px;">
                                                <option value="users-all">All Users</option>
                                                <option value="users-admin">Admin Users</option>
                                                <option value="users-cashier">Cashier Users</option>
                                                <option value="users-staff">Staff Users</option>
                                            </select>
                                        </div>
                                        
                                        <br><br><hr>
                                        <div class="col-md-8"></div>
                                        <button type="button" id="generate_report" onclick="set_report_users()" class="btn btn-dark col-md-4" style="font-size: 15px;"><i class="fa fa-file"></i> &nbsp;Generate Report</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>



                </div>
                <!--===================================================-->
                <!--End page content-->
            </div>
            <!--===================================================-->
            <!--END CONTENT CONTAINER-->

