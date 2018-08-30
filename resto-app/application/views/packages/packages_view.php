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
                    <li class="active">Packages List</li>
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
                            <h3 class="panel-title">Packages Information Table</h3>
                        </div>
                        <div class="panel-body">
                            <?php
                                if ($this->session->userdata('administrator') == '1')
                                {
                            ?>
                                    <button class="btn btn-success" onclick="add_package()"><i class="fa fa-plus-square"></i> &nbsp;Add New Package</button>
                            <?php
                                }
                            ?>
                            
                            <button class="btn btn-default" onclick="reload_table()"><i class="fa fa-refresh"></i> &nbsp;Reload</button>
                            <br><br>
                            <table id="packages-table" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th style="width:60px;">Pack ID</th>
                                        <th>Name</th>
                                        <th>Short Name</th>
                                        <th>Description</th>
                                        <th>Price</th>
                                        <th>Sold</th>
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
                    <div class="col-md-8">
                        <span>Legend: [ &nbsp; <i style = "color: #ccccff;" class="fa fa-square"></i> - No assigned items &nbsp; | &nbsp; <i style = "color: #ccff99;" class="fa fa-square"></i><i style = "color: #ccffcc;" class="fa fa-square"></i> - Best selling &nbsp; ]</span>
                    </div>
                    <?php
                        if ($this->session->userdata('administrator') == '1')
                        {
                    ?>
                            <button class="control-label col-md-4 btn btn-mint" onclick="set_packages_pdf()" style="font-size: 14px;"><i class="fa fa-database"></i> &nbsp;Generate PDF Report</button>
                    <?php
                        }
                    ?>
                    <hr>
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
                            <h3 class="modal-title">Package Form</h3>
                        </div>
                        <div class="modal-body form">
                            <form action="#" id="form" class="form-horizontal">

                                <input type="hidden" value="" name="pack_id"/>
                                <input type="hidden" value="" name="current_name"/>
                                <input type="hidden" value="" name="current_short_name"/>
                                
                                <div class="form-body">

                                    <div class="form-group">
                                        <label class="control-label col-md-3">Name :</label>
                                        <div class="col-md-9">
                                            <input name="name" placeholder="Package Name" class="form-control" type="text">
                                            <span class="help-block"></span>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-md-3">Short Name (maximum of 12 characters):</label>
                                        <div class="col-md-9">
                                            <input name="short_name" placeholder="Package Short Name" class="form-control" type="text" maxlength="12">
                                            <span class="help-block"></span>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-md-3">Description :</label>
                                        <div class="col-md-9">
                                            <textarea name="descr" placeholder="Package Desctription" class="form-control"></textarea>
                                            <span class="help-block"></span>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-md-3">Price :</label>
                                        <div class="col-md-9">
                                            <input name="price" placeholder="Package Price" class="form-control" type="number">
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