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
                    <li><a href="<?php echo base_url('clients-page');?>">Clients List</a></li>
                    <li class="active">Client Profile</li>

                </ol>
                <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                <!--End breadcrumb-->
                <!--Page content-->
                <!--===================================================-->
                <div id="page-content">
                    <!-- Basic Data Tables -->
                    <!--===================================================-->
                    <div class="panel" style="height: 3000px;">
                        <div class="panel-heading">
                            <h3 class="panel-title"><b><?php echo $client->lname . ', ' . $client->fname ?></b></h3>
                        </div>
                        <br>

                        <div style="float:left;">

                        <!-- check for pic1 if empty. assign default images if empty base on sex -->
                        <?php if ($client->pic1 == ''){ ?>

                            <?php if ($client->sex == 'Male'){ ?>
                                <img id="image1" src="../uploads/pic1/male.png" style="width:200px; max-height: 275px; margin-left:20px;">
                            <?php } else { ?>
                                <img id="image1" src="../uploads/pic1/female.png" style="width:200px; max-height: 275px; margin-left:20px;">
                            <?php } ?>

                        <?php } else { ?>
                            <img id="image1" src=<?php echo "'" . "../uploads/pic1/" . $client->pic1 . "'"; ?>  style="width:200px; max-height: 275px; margin-left:20px;">
                        <?php } ?>
                        
                        <?php echo form_open_multipart('profiles/profiles_controller/do_upload');?> 
                          <form action = "" method = "">
                            <input type="hidden" value=<?php echo "'" . $client->client_id . "'"; ?> name="client_id"/> 
                             <br />  
                             <input type = "file" name = "userfile1" id="userfile1" size = "20" style = "padding-left: 20px;"/> 
                             <br />
                             
                             <input type = "submit" value = "Upload" class="btn btn-success" style = "width:200px; margin-left: 20px;"/>
                          </form>
                        </div>

                        <div class="form-body">
                        <div class="form-group">
                                              
                            <label class="control-label col-md-3">Client ID: <h4><?php echo ' C' . $client->client_id ?></h4></label>
                            <label class="control-label col-md-3">Gender: <h4><?php echo $client->sex ?></h4></label>
                            <label class="control-label col-md-3">Registered: <h4><?php echo $client->encoded ?></h4></label>

                            <label class="control-label col-md-3">Contact: <h4><?php echo $client->contact ?></h4></label>
                            <label class="control-label col-md-3">Address: <h4><?php echo $client->address ?></h4></label>
                            
                            
                            
                        </div>   
                        </div>


                        <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
                        <hr>
                        <div class="form-body">
                        <div class="form-group">
                            
                            <label class="control-label col-md-3">Company: <h4><?php echo $this->companies->get_company_name($client->comp_id) ?></h4></label>
                            <label class="control-label col-md-3">Job: <h4><?php echo $client->job ?></h4></label>

                            <label class="control-label col-md-3">Salary: <h4>₱ <?php echo number_format($client->salary, 2, '.', ','); ?></h4></label>
                            <label class="control-label col-md-3">Remarks: <h4><?php echo $client->remarks ?></h4></label>

                        </div>
                        </div>
                        

                        <br><br><br><br>
                    
                        <hr style="background-color: #ccccff; height: 30px;">
                        
                        <div class="form-body">
                        <div class="form-group">
                            
                            <label class="control-label col-md-3">ATM Bank: <h4><?php echo $this->atm->get_atm_name($client->atm_id) ?></h4></label>
                            <label class="control-label col-md-3">ATM Type: <h4><?php echo $client->atm_type ?></h4></label>

                            <label class="control-label col-md-3">ATM Pin: <h4><?php echo $client->pin ?></h4></label>

                        </div>
                        </div>

                        <br><br><br><br>



                        <hr style="background-color: #ccccff; height: 30px;">




<!-- ============================================================ LOAN HISTORY ==================================== -->
                        



                        <div class="panel-heading">
                            <h3 class="panel-title">Loans Infotmation Table</h3>    
                        </div>

                        <div class="panel-body">
                            <button class="btn btn-success" onclick="add_loan()"><i class="fa fa-plus-square"></i> &nbsp;Add New Loan</button>
                            <button class="btn btn-default" onclick="reload_table()"><i class="fa fa-refresh"></i> &nbsp;Reload</button>
                            <br><br>
                            <table id="loans-table" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th style="width:60px;">Loan ID</th>
                                        <th>I.Amount</th>
                                        <th>I.Interest</th>
                                        <th>I.Total Due</th>
                                        <th>Date Start</th>
                                        <th>Date End</th>
                                        <th>Status</th>
                                        <th style="width:90px;">Action</th>
                                        <th>Total Paid</th>
                                        <th>Balance</th>
                                        <th>Total Loan</th>
                                        <th>Remarks</th>
                                        <th>Encoded</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>

                            <!-- End Striped Table -->
                            <span>Legend: [ &nbsp; <i style = "color: #99ff99;" class="fa fa-square"></i> - New &nbsp; | &nbsp; <i style = "color: #ccff99;" class="fa fa-square"></i> - Ongoing &nbsp; | &nbsp; <i style = "color: #cccccc;" class="fa fa-square"></i> - Cleared &nbsp; ]</span>

                        </div>
                        
                        
<!-- ============================================================ IMAGES ============================================ -->
                       
                        <hr style="background-color: #cccccc; height: 3px;">
                        <h4 style="margin-left: 3%">Images</h4>
                        <hr>

                        <div style="float:left;">
                            <!-- check for pic1 if empty. assign default images if empty base on sex -->
                            <?php if ($client->pic2 == ''){ ?>
                                <img id="image2" src="../uploads/pic2/none.jpg" style="width:280px; max-height: 400px; margin-left:20px;">
                            <?php } else { ?>
                                <img id="image2" src=<?php echo "'" . "../uploads/pic2/" . $client->pic2 . "'"; ?>  style="width:280px; max-height: 400px; margin-left:20px;">
                            <?php } ?>
                            
                            <?php echo form_open_multipart('profiles/profiles_controller/do_upload_2');?> 
                              <form action = "" method = "">
                                <input type="hidden" value=<?php echo "'" . $client->client_id . "'"; ?> name="client_id"/> 
                                 <br />  
                                 <input type = "file" name = "userfile2" id="userfile2" size = "20" style = "padding-left: 20px;"/> 
                                 <br />
                                 
                                 <input type = "submit" value = "Upload" class="btn btn-success" style = "width:280px; margin-left: 20px;"/>
                              </form>
                        </div>


                        <div style="float:left;">
                            <!-- check for pic1 if empty. assign default images if empty base on sex -->
                            <?php if ($client->pic3 == ''){ ?>
                                <img id="image3" src="../uploads/pic3/none.jpg" style="width:280px; max-height: 400px; margin-left:20px;">
                            <?php } else { ?>
                                <img id="image3" src=<?php echo "'" . "../uploads/pic3/" . $client->pic3 . "'"; ?>  style="width:280px; max-height: 400px; margin-left:20px;">
                            <?php } ?>
                            
                            <?php echo form_open_multipart('profiles/profiles_controller/do_upload_3');?> 
                              <form action = "" method = "">
                                <input type="hidden" value=<?php echo "'" . $client->client_id . "'"; ?> name="client_id"/> 
                                 <br />  
                                 <input type = "file" name = "userfile3" id="userfile3" size = "20" style = "padding-left: 20px;"/> 
                                 <br />
                                 
                                 <input type = "submit" value = "Upload" class="btn btn-success" style = "width:280px; margin-left: 20px;"/>
                              </form>
                        </div>



                    </div>
                    <!--===================================================-->
                    
                </div>
                <!--===================================================-->
                <!--End page content-->
            </div>
            <!--===================================================-->
            <!--END CONTENT CONTAINER-->

        <!-- Bootstrap modal -->
            <div class="modal fade" id="modal_form" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h3 class="modal-title">Loan Form</h3>
                        </div>
                        <div class="modal-body form">
                            <form action="#" id="form" class="form-horizontal">

                                <input type="hidden" value="" name="loan_id"/>
                                <input type="hidden" value=<?php echo "'" . $client->client_id . "'"; ?> name="client_id"/>
                                <input type="hidden" value=<?php echo "'" . $client->lname . ', ' . $client->fname . "'"; ?> name="client_name"/> 

                                <div class="form-body">
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Loan Amount :</label>
                                        <div class="col-md-9">
                                            <input id="amount" name="amount" placeholder="Loan Amount" class="form-control" type="number">
                                            <span class="help-block"></span>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-md-3">Int. Percentage :</label>
                                        <div class="col-md-9">
                                            <select id="percentage" name="percentage" class="form-control" style="background-color: lightblue;">
                                                <option value="0">Custom Amount</option>
                                                <option value=".05">5 %</option>
                                                <option value=".07">7 %</option>
                                                <option value=".10">10 %</option>
                                            </select>
                                            <span class="help-block"></span>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-md-3">Interest :</label>
                                        <div class="col-md-9">
                                            <input id="interest" name="interest" placeholder="Interest" class="form-control" type="number">
                                            <span class="help-block"></span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Total Due :</label>
                                        <div class="col-md-9">
                                            <input id="total" name="total" placeholder="Total Due" class="form-control" type="number" readonly>
                                            <span class="help-block"></span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Date Start :</label>
                                        <div class="col-md-9">
                                            <input name="date_start" placeholder="Date Start" class="form-control" type="date">
                                            <span class="help-block"></span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Loan Remarks :</label>
                                        <div class="col-md-9">
                                            <textarea name="remarks" placeholder="Loan Remarks" class="form-control"></textarea>
                                            <span class="help-block"></span>
                                        </div>
                                    </div>

                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" id="btnSave" onclick="save()" class="btn btn-primary"><i class="fa fa-floppy-o"></i> &nbsp;Save</button>

                            <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> &nbsp;Cancel</button>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->
            <!-- End Bootstrap modal -->


        <!-- Bootstrap modal -->
            <div class="modal fade" id="modal_form_edit_date_remarks" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h3 class="modal-title">Loan Form</h3>
                        </div>
                        <div class="modal-body form">
                            <form action="#" id="form_edit_date_remarks" class="form-horizontal">

                                <input type="hidden" value="" name="loan_id"/>
                                <input type="hidden" value=<?php echo "'" . $client->client_id . "'"; ?> name="client_id"/>
                                <input type="hidden" value=<?php echo "'" . $client->lname . ', ' . $client->fname . "'"; ?> name="client_name"/> 

                                <div class="form-body">
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Date Start :</label>
                                        <div class="col-md-9">
                                            <input name="date_start" placeholder="Date Start" class="form-control" type="date">
                                            <span class="help-block"></span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Loan Remarks :</label>
                                        <div class="col-md-9">
                                            <textarea name="remarks" placeholder="Loan Remarks" class="form-control"></textarea>
                                            <span class="help-block"></span>
                                        </div>
                                    </div>

                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" id="btnSave" onclick="save()" class="btn btn-primary"><i class="fa fa-floppy-o"></i> &nbsp;Save</button>

                            <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> &nbsp;Cancel</button>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->
            <!-- End Bootstrap modal -->