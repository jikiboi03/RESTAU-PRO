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
                    <li class="active">Product Discounts List</li>
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
                            <h3 class="panel-title">Product Discounts Information Table</h3>
                        </div>
                        <div class="panel-body">
                            <button class="btn btn-success" onclick="add_prod_discount()"><i class="fa fa-plus-square"></i> &nbsp;Add New Product Discount</button>
                            <button class="btn btn-default" onclick="reload_table()"><i class="fa fa-refresh"></i> &nbsp;Reload</button>
                            <br><br>
                            <table id="prod-discounts-table" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th style="width:60px;">#</th>
                                        <th>ProductID</th>
                                        <th>Name</th>
                                        <th>Remarks</th>
                                        <th>DateStart</th>
                                        <th>DateEnd</th>
                                        <th>Status</th>
                                        <th>DiscountedPrice</th>
                                        <th>LessAmount</th>
                                        <th style="width:60px;">Action</th>
                                        <th class="min-desktop">Encoded</th>s
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!--===================================================-->
                    <!-- End Striped Table -->
                    <span>Legend: [ &nbsp; <i style = "color: #99ff99;" class="fa fa-square"></i> - Active &nbsp; | &nbsp; <i style = "color: #cccccc;" class="fa fa-square"></i> - Inactive &nbsp; ]</span>
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
                            <h3 class="modal-title">Product Discount Form</h3>
                        </div>
                        <div class="modal-body form">
                            <form action="#" id="form" class="form-horizontal">

                                <input type="hidden" value="" name="pd_id"/>
                                <input type="hidden" value="" name="current_name"/>
                                
                                <div class="form-body">

                                    <div class="form-group">
                                        <label class="control-label col-md-3">Product :</label>
                                        <div class="col-md-9">
                                            <select id="discount_prod_id" name="prod_id" class="form-control">
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
                                        <label class="control-label col-md-3">Remarks :</label>
                                        <div class="col-md-9">
                                            <textarea name="remarks" placeholder="Discount Remarks" class="form-control"></textarea>
                                            <span class="help-block"></span>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-md-3">Date Start :</label>
                                        <div class="col-md-9">
                                            <input name="date_start" placeholder="Discount Date Start" class="form-control" type="date">
                                            <span class="help-block"></span>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-md-3">Date End :</label>
                                        <div class="col-md-9">
                                            <input name="date_end" placeholder="Discount Date End" class="form-control" type="date">
                                            <span class="help-block"></span>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-md-3">Status :</label>
                                        <div class="col-md-9">
                                            <select name="status" class="form-control">
                                                <option value="INACTIVE">INACTIVE</option>
                                                <option value="ACTIVE">ACTIVE</option>
                                            </select>
                                            <span class="help-block"></span>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-md-3">Original Price :</label>
                                        <div class="col-md-9">
                                            <input id="orig_price" name="orig_price" placeholder="Product Original Price" class="form-control" type="number" readonly>
                                            <span class="help-block"></span>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-md-3">Discounted Price :</label>
                                        <div class="col-md-9">
                                            <input id="new_price" name="new_price" placeholder="Product Discounted Price" class="form-control" type="number">
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