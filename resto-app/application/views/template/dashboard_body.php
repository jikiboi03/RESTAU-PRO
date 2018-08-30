            <!--CONTENT CONTAINER-->
            <!--===================================================-->
            <div id="content-container">
                
                <!--Page Title-->
                <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                <div id="page-title">
                    <div class="col-md-2">
                        <img src=<?php echo "'assets/img/" . $store->img . "'"; ?> style="width: 100%; margin-top: 0%; margin-right: 3%;">
                    </div>
                    <div class="col-md-8">
                        <h1 class="page-header text-overflow"><br><br><b><?php echo $store->name; ?></b><br><span style="font-size: 16px;">R e s t o A p p | Restaurant Point of Sales App by InnoTech Solutions</span></h1>
                    </div>

                    <div class="col-md-2"><br><br><br><br>
                        <h1 class="page-header text-overflow" align="center">[ <?php echo $title; ?> ]</h1>
                    </div>

                    <!-- For alert and notifications assets/js/demo/nifty-demo.js-->

                    <input type="hidden" value=<?php echo "'" . $this->session->userdata('firstname').' '.$this->session->userdata('lastname') . "'"; ?> name="user_fullname"/>

                    <input type="hidden" value=<?php echo "'" . date('l, F j, Y', strtotime(date('Y-m-d'))) . "'"; ?> name="current_date"/>

                </div>
                <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                <!--End page title-->

                <!--Breadcrumb-->
                <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                <!-- <ol class="breadcrumb">
                    <li><a href="#">Home</a></li>
                    <li><a href="#">Library</a></li>
                    <li class="active">Data</li>
                </ol> -->
                <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                <!--End breadcrumb-->
                <!--Page content-->
                <!--===================================================-->
                <div id="page-content">
                    
                    <div class="panel">
                        <div class="panel-heading">
                            <h1 align="right" class="panel-title"><i class="fa fa-pie-chart"></i> <i style="font-size: 18px;">Daily Stats | <?php echo date('l, F j, Y', strtotime(date('Y-m-d'))); ?></i></h1>
                        </div>
                    </div>
                    <!--Tiles - Bright Version-->
                    <!--===================================================-->

                    <!--===================================================-->
                    <!--End Tiles - Bright Version-->               
                    <div class="row">
                        <div class="col-lg-12">                  
                            <div class="row">
                                
                                <!--Large tile (Visit Today)-->
                                <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                                 <div class="col-sm-6 col-md-3">
                                    <div class="panel panel-dark panel-colorful">
                                        <div class="panel-body text-center">
                                            <p class="text-uppercase mar-btm text-md">Total Net Sales Today</p>
                                            <i class="fa fa-money fa-5x"></i>
                                            <hr>
                                            <p class="h1 text-thin">
                                            <?php echo $today_net_sales_str; ?>     
                                            </p>
                                            <small><span class="text-semibold" style="font-size: 12px;"><?php echo $percent_net_sales_str ?></small>
                                        </div>
                                    </div>
                                </div>
                                <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                                <!--End large tile (Visit Today)-->

                                <!--Large tile (New orders)-->
                                <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                                <div class="col-sm-6 col-md-2">
                                    <div class="panel panel-danger panel-colorful">
                                        <div class="panel-body text-center">
                                            <p class="text-uppercase mar-btm text-md">Transactions Today</p>
                                            <i class="fa fa-qrcode fa-5x"></i>
                                            <hr>
                                            <p class="h1 text-thin"><?php echo $total_trans_count_today; ?> </p>
                                            <small><span class="text-semibold" style="font-size: 12px;">Dine in: [ <?php echo $dine_in_today; ?> ] | Take out: [ <?php echo $take_out_today; ?> ]</small>
                                        </div>
                                    </div>
                                </div>
                                <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                                <!--End Large tile (New orders)-->

                                <!--Large tile (Comments)-->
                                <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                                <div class="col-sm-6 col-md-2">
                                    <div class="panel panel-warning panel-colorful">
                                        <div class="panel-body text-center">
                                            <p class="text-uppercase mar-btm text-md">Menu Items Sold Today</p>
                                            <i class="fa fa-cutlery fa-5x"></i>
                                            <hr>
                                            <p class="h1 text-thin"><?php echo $total_menu_items_sold_today; ?> </p>
                                            <small><span class="text-bold" style="font-size: 12px;">Products: [ <?php echo $individual_products_sold_today; ?> ] | Packages: [ <?php echo $packages_sold_today; ?> ]</small>
                                        </div>
                                    </div>
                                </div>
                                <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                                <!--Large tile (Comments)-->

                                <!--Large tile (New orders)-->
                                <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                                <div class="col-sm-6 col-md-3">
                                    <div class="panel panel-success panel-colorful">
                                        <div class="panel-body text-center">
                                            <p class="text-uppercase mar-btm text-md">Discounts Rendered Today</p>
                                            <i class="fa fa-percent fa-5x"></i>
                                            <hr>
                                            <p class="h1 text-thin"><?php echo $discounts_rendered_today_str; ?></p>
                                            <small><span class="text-semibold" style="font-size: 12px;"><?php echo $discounts_gross_percentage_str; ?></small>
                                        </div>
                                    </div>
                                </div>
                                <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                                <!--End Large tile (New orders)-->

                                <!--Large tile (New orders)-->
                                <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                                <div class="col-sm-6 col-md-2">
                                    <div class="panel panel-mint panel-colorful">
                                        <div class="panel-body text-center">
                                            <p class="text-uppercase mar-btm text-md">Cancelled Trans Today</p>
                                            <i class="fa fa-window-close-o fa-5x"></i>
                                            <hr>
                                            <p class="h1 text-thin"><?php echo $cancelled_trans_today; ?></p>
                                            <small><span class="text-semibold" style="font-size: 12px;"><?php echo $voided_menu_items_today_str; ?></small>
                                        </div>
                                    </div>
                                </div>
                                <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                                <!--End Large tile (New orders)-->

                            </div>                
                        </div>
                    </div>
                    
                    
                    <!-- Basic Data Tables -->
                    <!--===================================================-->
                    <div class="panel">
                        <div class="panel-heading">
                            <h1 class="panel-title"><i class="fa fa-calendar-check-o"></i> <i style="font-size: 18px;">Menu Items Sold Today</i></h1>
                        </div>

                        <div class="panel-body">
                            
                            <table id="sold-today-table" class="table table-striped table-bordered" cellspacing="0" width="100%" style="font-size: 14px;">
                                <thead>
                                    <tr>
                                        <th style="width:60px;">ID</th>
                                        <th>Name</th>
                                        <th>Type</th>
                                        <th>Price</th>
                                        <th>Sold</th>
                                        <th>Sales</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!--===================================================-->
                    <!-- End Striped Table -->
                    <div class="col-md-8">
                        <span>Legend: [ &nbsp; <i style = "color: #ccff99;" class="fa fa-square"></i><i style = "color: #ccffcc;" class="fa fa-square"></i> - Best selling &nbsp; ]</span>
                    </div>
                    <button class="control-label col-md-4 btn btn-mint" onclick="set_dashboard_pdf()" style="font-size: 14px;"><i class="fa fa-database"></i> &nbsp;Generate Daily PDF Report</button>

















                </div>
                <!--=================================================== -->
                <!-- End page content-->
                <br>
                <hr>

            </div>
            <!--===================================================-->
            <!--END CONTENT CONTAINER-->


            
        