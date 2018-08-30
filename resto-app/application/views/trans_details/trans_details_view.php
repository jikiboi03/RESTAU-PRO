            <!--CONTENT CONTAINER-->
            <!--===================================================-->
            <div id="content-container">
                
                <!--Page Title-->
                <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                <div id="page-title">
                    <h1 class="page-header text-overflow"><?php echo $title; ?> : <?php if ($transaction->receipt_no != 10000000){ echo ' [ S' . $transaction->trans_id . ' ] [ RCPT#POS-' . $transaction->receipt_no . ' ]'; } else { echo ' [ S' . $transaction->trans_id . ' ]';} ?> </h1>

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
                <div class="col-md-10">
                    <ol class="breadcrumb">
                        <li><a href="<?php echo base_url('dashboard');?>">Dashboard</a></li>
                        <li><a href="<?php echo base_url('/transactions-page');?>">Transactions List</a></li>
                        <li class="active"><?php echo ' [ S' . $transaction->trans_id . ' ] : ' . $transaction->datetime; ?></li>
                    </ol>
                </div>
                <div class="col-md-2">

                    <?php 
                        if ($transaction->status == 'ONGOING'){
                    ?>
                    <button class="btn btn-default col-md-11" align="right" onclick="go_to_ongoing_trans()"><i class="fa fa-reply"></i> &nbsp;ONGOING TRANS</button>
                    <?php
                        } else if ($transaction->status == 'CLEARED'){
                    ?>
                    <button class="btn btn-default col-md-11" align="right" onclick="go_to_cleared_trans()"><i class="fa fa-reply"></i> &nbsp;CLEARED TRANS</button>
                    <?php
                        } else if ($transaction->status == 'CANCELLED'){
                    ?>
                    <button class="btn btn-default col-md-11" align="right" onclick="go_to_cancelled_trans()"><i class="fa fa-reply"></i> &nbsp;CANCELLED TRANS</button>
                    <?php
                        } else if ($transaction->status == 'REFUNDED'){
                    ?>
                    <button class="btn btn-default col-md-11" align="right" onclick="go_to_refunded_trans()"><i class="fa fa-reply"></i> &nbsp;REFUNDED TRANS</button>
                    <?php
                        }
                    ?>
                </div>
                <br>
                <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                <!--End breadcrumb-->
                <!--Page content-->
                <!--===================================================-->
                <div id="page-content">
                    <!-- Basic Data Tables -->
                    <!--===================================================-->
                    <div class="panel" style="height: 1000px;">

                        <div class="panel-heading">

                            <div class="panel-body col-md-12">

                                <?php if ($transaction->status == 'ONGOING'){ $status = '<label class="control-label label-success col-md-2 badge">STATUS <h4 style="color: darkgreen;">[ ONGOING ]</h4>'; }

                                else if ($transaction->status == 'CANCELLED'){ $status = '<label class="control-label label-danger col-md-2 badge">STATUS <h4 style="color: white;">[ CANCELLED ]</h4>'; }

                                else if ($transaction->status == 'CLEARED'){ $status = '<label class="control-label col-md-2 badge">STATUS <h4 style="color: white;">[ CLEARED ]</h4>'; }

                                else if ($transaction->status == 'REFUNDED'){ $status = '<label class="control-label label-warning col-md-2 badge">STATUS <h4 style="color: white;">[ REFUNDED ]</h4>'; } echo $status; ?></h4></label>

                                <label class="control-label col-md-2">ORDER TYPE <h4><?php echo $transaction->order_type; ?></h4></label>
                                <label class="control-label col-md-2">DISCOUNT TYPE <h4><?php if ($transaction->disc_type == 0){ echo 'n/a'; }else{ echo $this->discounts->get_discount_name($transaction->disc_type); } ?></h4></label>

                                <label class="control-label col-md-1" style="text-align: right;">ITEMS <h4><input type="text" value="" name="item_count" size="4" style="border: none; text-align: center;" readonly/></h4></label>

                                <?php

                                    $discount = $transaction->discount;

                                    $net_total = $gross_total - $discount;
                                ?>

                                <label class="control-label col-md-2" style="text-align: right;">GROSS TOTAL <h4><?php echo number_format($gross_total, 2); ?></h4></label>
                                <label class="control-label col-md-1" style="text-align: right;">DISCOUNT <h4 style="color: brown;"><?php echo number_format($discount, 2); ?></h4></label>

                                <label class="control-label col-md-2" style="text-align: right;">NET TOTAL <h4 style="color: darkblue;"><?php echo number_format($net_total, 2); ?></h4></label>
                                

                            </div>
                        </div>

                        
                        


                        
                        <div class="panel-body col-md-12" style="margin-top: -5%">

                            <br>
                            <hr>

                            <table id="trans-details-table" class="table table-striped table-bordered" cellspacing="0" width="100%" style="font-size: 14px;">
                                <thead>
                                    <tr>
                                        <th style="width:60px;">ID</th>
                                        <th>Name</th>

                                        <th>Price</th>
                                        <th>Qty</th>
                                        <th>Total</th>

                                        <th style="width:60px;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                            

                            <?php 
                                if ($transaction->status == 'ONGOING'){
                            ?>
                                <button class="btn btn-default col-md-1" onclick="reload_page()"><i class="fa fa-refresh"></i> &nbsp;RELOAD</button>

                                <button class="btn btn-success col-md-2" onclick="set_payment()"><i class="fa fa-plus-square"></i> &nbsp;SET PAYMENT</button>

                                <button class="btn btn-warning col-md-2" onclick="set_discount()"><i class="fa fa-minus-square"></i> &nbsp;SET DISCOUNT</button>

                                <button class="btn btn-primary col-md-2" onclick="print_bill_out(<?php echo $transaction->trans_id; ?>)"><i class="fa fa-print"></i> &nbsp;PRINT BILL-OUT</button>

                                <label class="control-label col-md-3"></label>

                                <button class="btn btn-danger col-md-2" onclick="set_cancel(<?php echo $transaction->trans_id; ?>)"><i class="fa fa-ban"></i> &nbsp;CANCEL TRANSACTION</button>
                                
                            <?php
                                }
                                else if ($transaction->status == 'CLEARED')
                                {
                            ?>
                                
                                
                                
                            <?php
                                }
                            ?>
                            <br>
                            <hr>

                            <div class="col-md-5" style="border-top: 2px solid #cccccc; border-radius: 10px;">
                                <label class="control-label col-md-5" style="margin-top: 10px;">Payment Method: <h4><?php echo $transaction->method; ?></h4></label>
                                <label class="control-label col-md-7" style="margin-top: 10px;">Card Number: <h4><?php echo $transaction->card_number; ?></h4></label>
                            </div>
                            <div class="col-md-7" style="border-bottom: 2px solid #cccccc; border-radius: 10px;">
                                <label class="control-label col-md-4" style="text-align: right; margin-top: 10px;">AMOUNT DUE: <h3 style="color: #006699;">( ₱ <?php echo number_format($net_total, 2); ?> )</h3></label>
                                <label class="control-label col-md-4" style="text-align: right; margin-top: 10px;">CASH: <h3 style="color: green;">₱ <?php echo number_format($transaction->cash_amt, 2); ?></h3></label>
                                <label class="control-label col-md-4" style="text-align: right; margin-top: 10px;">CHANGE: <h3 style="color: brown;">₱ <?php echo number_format($transaction->change_amt, 2); ?></h3></label>
                            </div>

                            <div class="col-md-5" style="border-bottom: 2px solid #cccccc; border-radius: 10px;">
                                <label class="control-label col-md-5">Staff: <h4><?php echo $this->users->get_username($transaction->user_id); ?></h4></label>
                                <label class="control-label col-md-7">Customer Name: <h4><?php echo $transaction->cust_name; ?></h4></label>
                                <br><hr><br>

                                <label class="control-label col-md-5">Cashier: <h4><?php if ($transaction->cashier_id == 0){ echo "n/a"; }else{ echo $this->users->get_username($transaction->cashier_id); } ?></h4></label>
                                <label class="control-label col-md-7">Discount ID#: <h4><?php echo $transaction->cust_disc_id; ?></h4></label>
                                <br><hr><br>

                                <label class="control-label col-md-12">Table(s): <h4><?php echo $table_str; ?></h4></label>
                            </div>

                        </div>
                    </div>
                    <!--===================================================-->
                    <!-- End Striped Table -->
                    <span>Legend: [ &nbsp; <i style = "color: #ffffff;" class="fa fa-square"></i> - Regular Products &nbsp; | &nbsp; <i style = "color: #ffcc66;" class="fa fa-square"></i> - Packages &nbsp; | &nbsp; <i style = "color: #ffffcc;" class="fa fa-square"></i> - Package-products &nbsp; ]</span>
                </div>
                <!--===================================================-->
                <!--End page content-->
            </div>
            <!--===================================================-->
            <!--END CONTENT CONTAINER-->


            <!-- Bootstrap modal -->
            <div class="modal fade" id="modal_form_set_payment" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h3 class="modal-title">Set Payment Form</h3>
                        </div>
                        <div class="modal-body form">
                            <form action="#" id="form_set_payment" class="form-horizontal">

                                <input type="hidden" value=<?php echo "'" . $transaction->trans_id . "'"; ?> name="trans_id"/> 
                                <input type="hidden" value=<?php echo "'" . $net_total . "'"; ?> name="amount_due"/>

                                <input type="hidden" value=<?php echo "'" . $managers_password . "'"; ?> name="managers_password"/>
                                
                                <div class="form-body">

                                    <div class="form-group">
                                        <label class="control-label col-md-3">Amount Due :</label>
                                        <div class="col-md-9">
                                            <h3><input type="text" value=<?php echo "'" . "₱ " . number_format($net_total, 2) . "'"; ?> name="amount_due_str" size="15" style="border: none; text-align: right; color: darkblue;" readonly/></h3>
                                        </div>
                                    </div>



                                    <div class="form-group">
                                        <label class="control-label col-md-3">Payment Method :</label>
                                        <div class="col-md-9">
                                            <select id="method" name="method" class="form-control" style="font-size: 15px;" >
                                                <option value="Cash">Cash</option>
                                                <option value="Credit Card">Credit Card</option>
                                                <option value="Cash Card">Cash Card</option>
                                            </select>
                                            <span class="help-block"></span>
                                        </div>
                                    </div>

                                    <div id="cash_input_div">
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Cash :</label>
                                            <div class="col-md-6">
                                                <input id="cash_amt" name="cash_amt" placeholder="Cash Amount" class="form-control" type="number" style="font-size: 15px;" >
                                                <span class="help-block"></span>
                                            </div>
                                            <button class="btn btn-success col-md-2" id="exact_amt" onclick="exact_amt_cash_input()">EXACT AMT</button>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-md-3">Change :</label>
                                            <div class="col-md-9">
                                                <input id="change_amt" name="change_amt" placeholder="Change Amount" class="form-control" type="text" value="0.00" style="font-size: 18px; color: brown; font-weight: bold" readonly>
                                                <span class="help-block"></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="card_methods" style="display: none;">
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Card Number :</label>
                                            <div class="col-md-9">
                                                <input id="card_number" name="card_number" placeholder="Card Number" class="form-control" type="text" style="font-size: 15px;">
                                                <span class="help-block"></span>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-md-3">Customer Name (Optional) :</label>
                                            <div class="col-md-9">
                                                <input id="cust_name" name="cust_name" placeholder="Customer Full Name" class="form-control" value=<?php if ($transaction->cust_name != 'n/a')
                                                {
                                                    echo "'" . $transaction->cust_name . "'";
                                                }
                                                else
                                                {
                                                    echo "''";
                                                }

                                                 ?> stype="text" style="font-size: 15px;">
                                                <span class="help-block"></span>
                                            </div>
                                        </div>
                                    </div>    

                                    <div id="cash_buttons">
                                        <div class="form-group">
                                            <label class="control-label col-md-1"></label>
                                            <button class="btn btn-default col-md-2" id="cash_1" onclick="add_cash_input(1)">1</button>
                                            <button class="btn btn-info col-md-2" id="cash_5" onclick="add_cash_input(5)">5</button>
                                            <button class="btn btn-default col-md-2" id="cash_10" onclick="add_cash_input(10)">10</button>
                                            <button class="btn btn-info col-md-2" id="cash_20" onclick="add_cash_input(20)">20</button>
                                            <button class="btn btn-default col-md-2" id="cash_50" onclick="add_cash_input(50)">50</button>
                                            <label class="control-label col-md-1"></label>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-md-1"></label>
                                            <button class="btn btn-default col-md-2" id="cash_100" onclick="add_cash_input(100)">100</button>
                                            <button class="btn btn-info col-md-2" id="cash_200" onclick="add_cash_input(200)">200</button>
                                            <button class="btn btn-default col-md-2" id="cash_500" onclick="add_cash_input(500)">500</button>
                                            <button class="btn btn-info col-md-2" id="cash_1000" onclick="add_cash_input(1000)">1000</button>
                                            <button class="btn btn-warning col-md-2" id="cash_clear" onclick="clear_cash_input()">CLEAR</button>
                                            <label class="control-label col-md-1"></label>
                                        </div>
                                    </div>

                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" id="btnSave" onclick="confirm_trans()" class="btn btn-primary"><i class="fa fa-floppy-o"></i> &nbsp;Confirm</button>

                            <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> &nbsp;Cancel</button>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->
            <!-- End Bootstrap modal -->

            <!-- Bootstrap modal -->
            <div class="modal fade" id="modal_form_set_discount" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h3 class="modal-title">Set Discount Form</h3>
                        </div>
                        <div class="modal-body form">
                            <form action="#" id="form_set_discount" class="form-horizontal">

                                <input type="hidden" value=<?php echo "'" . $transaction->trans_id . "'"; ?> name="trans_id"/>
                                <input type="hidden" value=<?php echo "'" . $gross_total . "'"; ?> name="gross_total"/>
                                
                                <div class="form-body">

                                    <div class="form-group">
                                        <label class="control-label col-md-3">Gross Total :</label>
                                        <div class="col-md-9">
                                            <h3><input type="text" value=<?php echo "'" . "₱ " . number_format($gross_total, 2) . "'"; ?> name="gross_total_str" size="15" style="border: none; text-align: right; color: darkblue;" readonly/></h3>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-md-3">Discount Type :</label>
                                        <div class="col-md-9">
                                            <select id="disc_type_trans_details" name="disc_type" class="form-control" style="font-size: 15px;" >
                                                <option value="">-- Select Discount Type --</option>
                                                <?php 
                                                    foreach($discounts as $row)
                                                    { 
                                                      echo '<option value="'.$row->disc_id.'">'.$row->name.'</option>';
                                                    }
                                                ?>
                                                <option value="0">Remove Discount</option>
                                            </select>
                                            <span class="help-block"></span>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-md-3">Calculated Discount :</label>
                                        <div class="col-md-9">
                                            <input name="calc_disc" placeholder="Calculated Discount Amount" class="form-control" type="text" style="font-size: 15px;" readonly>
                                            <span class="help-block"></span>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-md-3">Actual Discount :</label>
                                        <div class="col-md-9">
                                            <input name="discount" placeholder="Actual Discount Amount" class="form-control" type="number" style="font-size: 15px;" >
                                            <span class="help-block"></span>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-md-3">ID Number :</label>
                                        <div class="col-md-9">
                                            <input name="cust_disc_id" placeholder="Customer Discount ID Number" class="form-control" type="text" style="font-size: 15px;">
                                            <span class="help-block"></span>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-md-3">Customer Name (Optional) :</label>
                                        <div class="col-md-9">
                                            <input name="cust_name" placeholder="Customer Full Name" class="form-control" value=<?php if ($transaction->cust_name != 'n/a')
                                            {
                                                echo "'" . $transaction->cust_name . "'";
                                            }
                                            else
                                            {
                                                echo "''";
                                            }

                                             ?> type="text" style="font-size: 15px;">
                                            <span class="help-block"></span>
                                        </div>
                                    </div>

                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" id="btnSave" onclick="confirm_trans()" class="btn btn-primary"><i class="fa fa-floppy-o"></i> &nbsp;Confirm</button>

                            <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> &nbsp;Cancel</button>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->
            <!-- End Bootstrap modal -->

