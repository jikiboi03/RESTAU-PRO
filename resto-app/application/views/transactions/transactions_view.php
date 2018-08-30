<?php echo $refresh_meta_tag; ?> <!-- REFRESH TRANSACTIONS PAGE EVERY 5 SECONDS -->

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
                    <li class="active">Transactions List</li>
                </ol>

                <input type="hidden" value=<?php echo "'" . $trans_status . "'"; ?> name="trans_status"/>
                <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                <!--End breadcrumb-->
                <!--Page content-->
                <!--===================================================-->
                <div id="page-content">
                    <!-- Basic Data Tables -->
                    <!--===================================================-->
                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title">Transactions Information Table</h3>
                        </div>
                        <div class="panel-body">
                            <!-- <button class="btn btn-success" onclick="add_table()"><i class="fa fa-plus-square"></i> &nbsp;Add New Table</button> -->
                            <button class="btn btn-default col-md-1" onclick="reload_table()"><i class="fa fa-refresh"></i> &nbsp;Reload</button>
                            <br><br>
                            <table id="transactions-table" class="table table-striped table-bordered" cellspacing="0" width="100%" style="font-size: 14px;">
                                <thead>
                                    <tr>
                                        <th style="width:60px;">Trans ID</th>
                                        <th>DateTime</th>
                                        <th>OrderType</th>

                                        <th>Gross</th>
                                        <th>Discount</th>
                                        <th>TotalDue</th>
                                        
                                        <?php 
                                            if ($trans_status == 'ONGOING')
                                            {
                                                echo '<th>TableOccupied</th>';
                                                echo '<th>Staff</th>';
                                            }
                                            else
                                            {
                                                echo '<th>PaymentMethod</th>';
                                                echo '<th>Cashier</th>';   
                                            }
                                        ?>

                                        <th style="width:30px;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>

                            <?php
                                if ($trans_status == 'CLEARED'){ // if transaction status is cleared, enable reprint and refund buttons
                            ?>
                            <div class="col-md-12">
                                <button class="btn btn-dark col-md-2" onclick="reprint_last_trans_receipt()"><i class="fa fa-print"></i> &nbsp;REPRINT LAST RECEIPT</button>
                            </div>
                            <?php
                                }
                            ?>
                        </div>
                    </div>
                    <!--===================================================-->
                    <!-- End Striped Table -->
                    <div class="col-md-8">
                        <span>Legend: [ &nbsp; <i style = "color: #ffffff;" class="fa fa-square"></i><i style = "color: #cccccc;" class="fa fa-square"></i> - Dine-In &nbsp; | &nbsp; <i style = "color: #ffffcc;" class="fa fa-square"></i><i style = "color: #ffff99;" class="fa fa-square"></i> - Take-Out &nbsp; ]</span>
                    </div>
                    <?php
                        if ($trans_status != 'ONGOING') // if transaction status is cleared, enable reprint and refund buttons
                        { 
                            if ($this->session->userdata('administrator') == '1')
                            {
                    ?>
                                <button class="control-label col-md-4 btn btn-mint" <?php echo 'onclick="set_transactions_pdf('."'".$trans_status."'".')"'; ?>style="font-size: 14px;"><i class="fa fa-database"></i> &nbsp;Generate PDF Report</button>
                    <?php 
                            }
                        } 
                    ?>
                </div>
                <!--===================================================-->
                <!--End page content-->
            </div>
            <!--===================================================-->
            <!--END CONTENT CONTAINER-->

        
            <input type="hidden" value=<?php echo "'" . $managers_password . "'"; ?> name="managers_password"/>