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
                    <li class="active">Tables List</li>
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
                            <h3 class="panel-title">Tables Information Table</h3>
                        </div>
                        <div class="panel-body">
                            <?php
                                if ($this->session->userdata('administrator') == '1')
                                {
                            ?>
                                    <button class="btn btn-success" onclick="add_table()"><i class="fa fa-plus-square"></i> &nbsp;Add New Table</button>
                            <?php
                                }
                            ?>
                            <button class="btn btn-default" onclick="reload_table()"><i class="fa fa-refresh"></i> &nbsp;Reload</button>
                            <br><br>
                            <table id="tables-table" class="table table-striped table-bordered" cellspacing="0" width="100%" style="font-size: 14px;">
                                <thead>
                                    <tr>
                                        <th style="width:60px;">Tbl ID</th>
                                        <th>Name</th>
                                        <th>Status</th>
                                        <th class="min-desktop">Current Transaction</th>
                                        <th class="min-desktop">Encoded</th>
                                        <th style="width:90px;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!--===================================================-->
                    <!-- End Striped Table -->
                    <span>Legend: [ &nbsp; <i style = "color: #99cccc;" class="fa fa-square"></i> - Occupied &nbsp; | &nbsp; <i style = "color: #cccc99;" class="fa fa-square"></i> - Reserved &nbsp; | &nbsp; <i style = "color: #999999;" class="fa fa-square"></i> - Unavailable &nbsp; ]</span>
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
                            <h3 class="modal-title">Table Form</h3>
                        </div>
                        <div class="modal-body form">
                            <form action="#" id="form" class="form-horizontal">

                                <input type="hidden" value="" name="tbl_id"/>
                                <input type="hidden" value="" name="current_name"/>
                                
                                <div class="form-body">

                                    <div class="form-group">
                                        <label class="control-label col-md-3">Name :</label>
                                        <div class="col-md-9">
                                            <input name="name" placeholder="Table Name" class="form-control" type="text">
                                            <span class="help-block"></span>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-md-3">Status :</label>
                                        <div class="col-md-9">
                                            <select name="status" class="form-control">
                                                <option value="0">Available</option>
                                                <option value="1">Reserved</option>
                                                <option value="2">Unavailable</option>
                                            </select>
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