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
                    <li><a href="<?php echo base_url('/packages-page');?>">Packages List</a></li>
                    <li class="active">G<?php echo $package->pack_id . ': ' . $package->name; ?></li>
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
                            <h3 class="panel-title"><b>G<?php echo $package->pack_id . ': ' . $package->name; ?></b></h3>
                        </div>



                        <div class="control-label col-md-3" style="margin-right: 20px;">

                            <!-- check for pic1 if empty. assign default images if empty base on sex -->
                            <?php if ($package->img == ''){ ?>

                                <img id="image1" src="../uploads/packages/none.jpg" style="width:100%; max-height: 275px; margin-left:20px; margin-top:15px;">

                            <?php } else { ?>

                                <img id="image1" src=<?php echo "'" . "../uploads/packages/" . $package->img . "'"; ?>  style="width:100%; max-height: 275px; margin-left:20px; margin-top:15px;">

                            <?php } ?>

                       

                            <?php echo form_open_multipart('Pack_details/Pack_details_controller/do_upload');?> 
                              <form action = "" method = "">
                                <input type="hidden" value=<?php echo "'" . $package->pack_id . "'"; ?> name="pack_id"/> 
                                 <br />  
                                 <input type = "file" name = "userfile1" id="userfile1" size = "20" style = "padding-left: 20px;"/> 
                                 <br />
                                 
                                 <input type = "submit" value = "Upload" class="btn btn-primary" style = "width:100%; margin-left: 20px;"/>
                              </form>
                        </div>
                
                        

                        <div class="form-body">
                        <div class="form-group">
                                              
                            <label class="control-label col-md-2">Short Name: <h4><?php echo $package->short_name; ?></h4></label>

                            <label class="control-label col-md-4">Description: <h4><?php echo $package->descr; ?></h4></label>

                            <label class="control-label col-md-8"><h4><?php echo "<hr>" ?></h4></label>

                            <label class="control-label col-md-2">Price: <h4>₱ <?php echo number_format($package->price, 2, '.', ','); ?></h4></label>
                            <label class="control-label col-md-1">Sold: <h4><?php echo $package->sold; ?></h4></label>
                            
                            
                            
                        </div>   
                        </div>

                        <div class="control-label col-md-12">
                        
                        <hr style="background-color: #ccccff; height: 3px;">

                        <div class="panel-heading">
                            <h3 class="panel-title">Package Details Table</h3>
                        </div>
                        <hr>
                        </div>


                        
                        <div class="panel-body col-md-12">

                            <button class="btn btn-success" onclick="add_pack_detail()"><i class="fa fa-plus-square"></i> &nbsp;Add New Package Product</button>
                            <button class="btn btn-default" onclick="reload_table()"><i class="fa fa-refresh"></i> &nbsp;Reload</button>
                            <br><br>
                            <table id="pack-details-table" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th style="width:60px;">Prod ID</th>
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
                        </div>
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
                            <h3 class="modal-title">Package Product Form</h3>
                        </div>
                        <div class="modal-body form">
                            <form action="#" id="form" class="form-horizontal">

                                <input type="hidden" value=<?php echo "'" . $package->pack_id . "'"; ?> name="pack_id"/>
                                <input type="hidden" value="" name="current_prod_id"/>
                                
                                <div class="form-body">

                                    <div class="form-group">
                                        <label class="control-label col-md-3">Product :</label>
                                        <div class="col-md-9">
                                            <select name="prod_id" class="form-control">
                                                <option value="">--Select Product--</option>
                                                <?php 
                                                    foreach($products as $row)
                                                    { 
                                                      echo '<option value="'.$row->prod_id.'">'.$row->name.'</option>';
                                                    }
                                                ?>
                                            </select>
                                            <span class="help-block"></span>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-md-3">Quantity :</label>
                                        <div class="col-md-9">
                                            <input name="qty" placeholder="Package Product Quantity" class="form-control" value="1" type="number">
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