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
                    <li><a href="<?php echo base_url('/stores-page');?>">Store Configurations</a></li>
                </ol>
                <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                <!--End breadcrumb-->
                <!--Page content-->
                <!--===================================================-->
                <div id="page-content">
                    <!-- Basic Data Tables -->
                    <!--===================================================-->
                    <div class="panel" style="height: 1500px;">



                        <div class="panel-heading">
                            <h3 class="panel-title"><b><?php echo $store->name . ' [ Branch #: ' . $store->branch_id . ' ]'; ?></b></h3>
                        </div>

                        <div class="panel-body col-md-12">

                            <div class="control-label col-md-3">

                                <img id="image1" src=<?php echo "'assets/img/" . $store->img . "'"; ?> style="width:100%; max-height: 275px; margin-top:15px;">                       

                                <?php echo form_open_multipart('Store_config/Store_config_controller/do_upload');?> 
                                  <form action = "" method = "">
                                     <br />  
                                     <input type = "file" name = "userfile1" id="userfile1" size = "20" style = "width:100%;"/> 
                                     <br />
                                     
                                     <input type = "submit" value = "Upload" class="btn btn-primary" style = "width:100%;"/>
                                  </form>
                            </div>
                    
                            
                            <div class="col-md-9" style="border-bottom: 2px solid #cccccc; border-top: 2px solid #cccccc; border-radius: 10px;">
                                <div class="form-body">
                                <div class="form-group">

                                    <label class="control-label col-md-12"><br></label>
                                                      
                                    <label class="control-label col-md-4">Store Name: <h4><?php echo $store->name; ?></h4></label>

                                    <label class="control-label col-md-4">Address: <h4><?php echo $store->address; ?></h4></label>

                                    <label class="control-label col-md-4">City: <h4><?php echo $store->city; ?></h4></label>


                                    <label class="control-label col-md-12"><h4><?php echo "<hr>" ?></h4></label>


                                    <label class="control-label col-md-4">TIN: <h4><?php echo $store->tin; ?></h4></label>

                                    
                                    <label class="control-label col-md-4">TELEPHONE: <h4><?php echo $store->telephone; ?></h4></label>

                                    <label class="control-label col-md-4">MOBILE: <h4><?php echo $store->mobile; ?></h4></label>


                                    <label class="control-label col-md-12"><h4><?php echo "<hr>" ?></h4></label>


                                    
                                    <div class="col-md-4">
                                        <label class="control-label col-md-8" id="pw_unmask" style="display: none;">Manager's Password: <h4><?php echo $store->password; ?></h4></label>
                                        <label class="control-label col-md-8" id="pw_mask" style="display: block;">Manager's Password: <h4>****************</h4></label>
                                        <button class="control-label col-md-2 btn btn-primary" title="mask/unmask password" onclick="toggle_pw_mask()" style="font-size: 14px;"><i class="fa fa-eye"></i></button>
                                    </div>

                                    <label class="control-label col-md-4">VAT: <h4><?php echo $store->vat; ?></h4></label>

                                    <label class="control-label col-md-4">Best Selling Minimum Price: <h4>₱ <?php echo number_format($store->bs_price, 2, '.', ','); ?></h4></label>


                                    <label class="control-label col-md-12"><h4><?php echo "<hr>" ?></h4></label>


                                    <label class="control-label col-md-4"></label>

                                    

                                    <button class="control-label col-md-4 btn btn-info" onclick="edit_store_config(1)" style="font-size: 14px;"><i class="fa fa-pencil-square-o"></i> &nbsp;Edit Store Config</button>
                                    <button class="control-label col-md-4 btn btn-dark" onclick="back_up_db()" style="font-size: 14px;"><i class="fa fa-database"></i> &nbsp;Backup Database</button>

                                    <label class="control-label col-md-12"><br></label>
                                    
                                </div>   
                                </div>
                            </div>

                        </div>
                        <!-- <div class="control-label col-md-12">
                        
                        <hr style="background-color: #ccccff; height: 3px;">

                        <div class="panel-heading">
                            <h3 class="panel-title">store Details Table</h3>
                        </div>
                        <hr>
                        </div> -->


                        
                        <!-- <div class="panel-body col-md-12">

                            
                            <button class="btn btn-default" onclick="reload_table()"><i class="fa fa-refresh"></i> &nbsp;Reload</button>
                            <br><br>
                            <table id="prod-details-table" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th style="width:60px;">Item ID</th>
                                        <th>Name</th>
                                        <th>Description</th>
                                        <th>Qty</th>

                                        <th class="min-desktop">Encoded</th>
                                        <th style="width:60px;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div> -->
                    </div>
                    <!--===================================================-->
                    <!-- End Striped Table -->
                    <!-- <span>Legend: [ &nbsp; <i style = "color: #99ff99;" class="fa fa-square"></i> - Today &nbsp; | &nbsp; <i style = "color: #cccccc;" class="fa fa-square"></i> - Ended &nbsp; | &nbsp; <i style = "color: #ffffff;" class="fa fa-square"></i> - Incoming &nbsp; ]</span> -->
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
                            <h3 class="modal-title">Store Config Form</h3>
                        </div>
                        <div class="modal-body form">
                            <form action="#" id="form" class="form-horizontal">

                                <input type="hidden" value=<?php echo "'" . $store->conf_id . "'"; ?> name="conf_id"/>
                                
                                <div class="form-body">

                                    <div class="form-group">
                                        <label class="control-label col-md-3">Store Name :</label>
                                        <div class="col-md-9">
                                            <input name="name" placeholder="Store / Company Name" class="form-control" value="" type="text">
                                            <span class="help-block"></span>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-md-3">Street Address :</label>
                                        <div class="col-md-9">
                                            <textarea name="address" placeholder="Branch Street Address" class="form-control"></textarea>
                                            <span class="help-block"></span>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-md-3">City :</label>
                                        <div class="col-md-9">
                                            <input name="city" placeholder="Branch City / Municipality" class="form-control" value="" type="text">
                                            <span class="help-block"></span>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-md-3">Telephone # :</label>
                                        <div class="col-md-9">
                                            <input name="telephone" placeholder="Company Telephone #" class="form-control" value="" type="text">
                                            <span class="help-block"></span>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-md-3">Mobile # :</label>
                                        <div class="col-md-9">
                                            <input name="mobile" placeholder="Company Mobile #" class="form-control" value="" type="text">
                                            <span class="help-block"></span>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-md-3">TIN :</label>
                                        <div class="col-md-9">
                                            <input name="tin" placeholder="Company TIN Identification #" class="form-control" value="" type="text">
                                            <span class="help-block"></span>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-md-3">VAT (Value Added Tax) :</label>
                                        <div class="col-md-9">
                                            <input name="vat" placeholder="VAT Percentage Value" class="form-control" value="12" type="number" maxlength="2">
                                            <span class="help-block"></span>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-md-3">Best Selling Minimum Price :</label>
                                        <div class="col-md-9">
                                            <input name="bs_price" placeholder="Minimum Price Value" class="form-control" value="40.00" type="number">
                                            <span class="help-block"></span>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-md-3">Manager's Password :</label>
                                        <div class="col-md-9">
                                            <input name="password" placeholder="Manager's Password" class="form-control" type="text">
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