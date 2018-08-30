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
                    <li><a href="<?php echo base_url('statistics-page');?>">Statistics / Charts</a></li>
                </ol>
                <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                <!--End breadcrumb-->
                <!--Page content-->
                <!--===================================================-->

                <div class="col-md-12">
                    <div class="col-md-5">
                        <div id="page-content" class="panel panel-light panel-colorful col-md-12">
                        
                            <div class="panel-heading">
                                <h3 class="panel-title">Product Categories Pie Chart</h3>
                            </div>
                            <br>

                            <div id="container-products-category" style="width: 100%; height: 100%; margin: 0 auto"></div>

                            <?php
                                $cat_index = -1; // initialize index to use

                                foreach ($cat_array as $categories)
                                {
                                    $cat_index++;

                                    echo '<input type="hidden" value="' . $categories['name'] . '" name="cat_name' . $cat_index . '"/>';
                                    echo '<input type="hidden" value="' . $categories['cat_prod_count'] . '" name="cat_prod_count' . $cat_index . '"/>';
                                    echo '<input type="hidden" value="' . $categories['cat_prod_sales'] . '" name="cat_prod_sales' . $cat_index . '"/>';
                                    echo '<input type="hidden" value="' . $categories['cat_prod_sold'] . '" name="cat_prod_sold' . $cat_index . '"/>';
                                }
                                echo '<input type="hidden" value="' . $cat_index . '" name="cat_index"/>'; // send index value to use
                            ?>

                            
                        </div>
                    </div>
                    <div class="col-md-7">
                        <div id="page-content" class="panel panel-light panel-colorful col-md-12">
                        
                            <div class="panel-heading">
                                <h3 class="panel-title">Top Selling Menu Items Bar Chart</h3>
                            </div>
                            <br>

                            <div id="container-top-selling-menu-items" style="width: 100%; height: 100%; margin: 0 auto"></div>

                            <?php
                                $bs_index = -1; // initialize index to use

                                foreach ($bs_array as $bs_menu)
                                {
                                    $bs_index++;

                                    echo '<input type="hidden" value="' . $bs_menu['menu_id'] . '" name="menu_id' . $bs_index . '"/>';
                                    echo '<input type="hidden" value="' . $bs_menu['menu_name'] . '" name="menu_name' . $bs_index . '"/>';
                                    echo '<input type="hidden" value="' . $bs_menu['menu_sold'] . '" name="menu_sold' . $bs_index . '"/>';
                                    echo '<input type="hidden" value="' . $bs_menu['menu_sales'] . '" name="menu_sales' . $bs_index . '"/>';
                                }
                                echo '<input type="hidden" value="' . $bs_index . '" name="bs_index"/>'; // send index value to use
                            ?>
                            
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div id="page-content" class="panel panel-light panel-colorful col-md-12">
                        
                            <div class="panel-heading">
                                <h3 class="panel-title col-md-9">Net Sales ( Results as of <?php echo date('l, F j, Y', strtotime(date('Y-m-d'))); ?> )</h3>
                                <h3 class="panel-title col-md-3">Net Sales ( Results as of <?php echo date('l, F j, Y', strtotime(date('Y-m-d'))); ?> )</h3>
                            </div>
                            <br>

                            <div id="container-current-net-sales" style="width: 80%; height: 100%; margin: 0 auto"></div>

                            <!-- Hidden input files to be fetched by charts (MONTHLY REGISTRATION LINE CHART)-->

                            <input type="hidden" value=<?php echo "'" . $current_year . "'"; ?> name="current_year"/>

                            <input type="hidden" value=<?php echo "'" . $jan . "'"; ?> name="jan"/>
                            <input type="hidden" value=<?php echo "'" . $feb . "'"; ?> name="feb"/>
                            <input type="hidden" value=<?php echo "'" . $mar . "'"; ?> name="mar"/>
                            <input type="hidden" value=<?php echo "'" . $apr . "'"; ?> name="apr"/>

                            <input type="hidden" value=<?php echo "'" . $may . "'"; ?> name="may"/>
                            <input type="hidden" value=<?php echo "'" . $jun . "'"; ?> name="jun"/>
                            <input type="hidden" value=<?php echo "'" . $jul . "'"; ?> name="jul"/>
                            <input type="hidden" value=<?php echo "'" . $aug . "'"; ?> name="aug"/>

                            <input type="hidden" value=<?php echo "'" . $sep . "'"; ?> name="sep"/>
                            <input type="hidden" value=<?php echo "'" . $oct . "'"; ?> name="oct"/>
                            <input type="hidden" value=<?php echo "'" . $nov . "'"; ?> name="nov"/>
                            <input type="hidden" value=<?php echo "'" . $dec . "'"; ?> name="dec"/>

                            <input type="hidden" value=<?php echo "'" . $year_total . "'"; ?> name="year_total"/>
                            
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div id="page-content" class="panel panel-light panel-colorful col-md-12">
                        
                            <div class="panel-heading">
                                <h3 class="panel-title">Employee Cashier Stats</h3>
                            </div>
                            <br>

                            <div id="container-users-cashier" style="width: 100%; height: 100%; margin: 0 auto"></div>

                            <?php
                                $cashier_index = -1; // initialize index to use

                                foreach ($cashier_array as $cashier)
                                {
                                    $cashier_index++;

                                    echo '<input type="hidden" value="' . $cashier['cashier_id'] . '" name="cashier_id' . $cashier_index . '"/>';
                                    echo '<input type="hidden" value="' . $cashier['cashier_user_name'] . '" name="cashier_user_name' . $cashier_index . '"/>';
                                    echo '<input type="hidden" value="' . $cashier['cashier_trans_count'] . '" name="cashier_trans_count' . $cashier_index . '"/>';
                                    echo '<input type="hidden" value="' . $cashier['cashier_net_sales'] . '" name="cashier_net_sales' . $cashier_index . '"/>';
                                }
                                echo '<input type="hidden" value="' . $cashier_index . '" name="cashier_index"/>'; // send index value to use
                            ?>
                            
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div id="page-content" class="panel panel-light panel-colorful col-md-12">
                        
                            <div class="panel-heading">
                                <h3 class="panel-title">Employee Staff Stats</h3>
                            </div>
                            <br>

                            <div id="container-users-staff" style="width: 100%; height: 100%; margin: 0 auto"></div>

                            <?php
                                $staff_index = -1; // initialize index to use

                                foreach ($staff_array as $staff)
                                {
                                    $staff_index++;

                                    echo '<input type="hidden" value="' . $staff['staff_id'] . '" name="staff_id' . $staff_index . '"/>';
                                    echo '<input type="hidden" value="' . $staff['staff_user_name'] . '" name="staff_user_name' . $staff_index . '"/>';
                                    echo '<input type="hidden" value="' . $staff['staff_trans_count'] . '" name="staff_trans_count' . $staff_index . '"/>';
                                    echo '<input type="hidden" value="' . $staff['staff_net_sales'] . '" name="staff_net_sales' . $staff_index . '"/>';
                                }
                                echo '<input type="hidden" value="' . $staff_index . '" name="staff_index"/>'; // send index value to use
                            ?>
                            
                        </div>
                    </div>
                </div>

                

                        


                    














                </div>
                <!--===================================================-->
                <!--End page content-->


            </div>
            <!--===================================================-->
            <!--END CONTENT CONTAINER-->


            
        