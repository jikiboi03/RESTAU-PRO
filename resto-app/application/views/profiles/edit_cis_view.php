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
                    <li><a href="<?php echo base_url('cis-page');?>">Children List</a></li>
                    <li class="active">Child Profile</li>

                </ol>
                <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                <!--End breadcrumb-->
                <!--Page content-->
                <!--===================================================-->
                <div id="page-content">
                    <!-- Basic Data Tables -->
                    <!--===================================================-->
                    <div class="panel" style="height: 1200px;">
                        <div class="panel-heading">
                            <h3 class="panel-title"><b><?php echo $child->lastname . ', ' . $child->firstname . ' ' . $child->middlename ?></b></h3>
                        </div>
                        <br>

                        <div style="float:left;">

                        <!-- check for pic1 if empty. assign default images if empty base on sex -->
                        <?php if ($child->pic1 == ''){ ?>

                            <?php if ($child->sex == 'Male'){ ?>
                                <img id="image1" src="../../uploads/pic1/male.png" style="width:200px; max-height: 275px; margin-left:20px;">
                            <?php } else { ?>
                                <img id="image1" src="../../uploads/pic1/female.png" style="width:200px; max-height: 275px; margin-left:20px;">
                            <?php } ?>

                        <?php } else { ?>
                            <img id="image1" src=<?php echo "'" . "../../uploads/pic1/" . $child->pic1 . "'"; ?>  style="width:200px; max-height: 275px; margin-left:20px;">
                        <?php } ?>
                        
                        <?php echo form_open_multipart('profiles/profiles_controller/do_upload');?> 
                          <form action = "" method = "">
                            <input type="hidden" value=<?php echo "'" . $child->child_id . "'" ?> name="child_id"/>

                             <br />  
                             <input type = "file" name = "userfile1" id="userfile1" size = "20" style = "padding-left: 20px;"/> 
                             <br />
                             
                             <input type = "submit" value = "Upload" class="btn btn-success" style = "width:200px; margin-left: 20px;"/>
                          </form>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3" style="color:gray;"><h5>ID: <?php echo $child->child_id ?></h5></label>
                            <label class="control-label col-md-3" style="color:blue;"><h5>Status: <?php if($child->graduated == 0){ echo 'Ongoing Treatment'; }else{ echo 'Graduated'; } ?></h5></label>

                            <div align="right" style="margin-right: 3%">
                                <button type="button" id="btnSave" onclick="save_cis()" class="btn btn-primary"><i class="fa fa-floppy-o"></i> &nbsp;&nbsp;Save</button>

                                <button type="button" class="btn btn-danger"  onclick="cancel_cis()"><i class="fa fa-times"></i> &nbsp;Cancel</button>
                            </div>

                            <hr>
                        </div>    

                    <form action="#" id="form">
                        <input type="hidden" value=<?php echo "'" . $child->child_id . "'" ?> name="child_id"/>
                        <input type="hidden" value=<?php echo "'" . $child->lastname . $child->firstname . $child->middlename . "'" ?> name="current_name"/>
                        <div class="form-body col-md-9">

                            <div class="form-group">
                                <label class="control-label col-md-4">Last Name :</label>
                                <label class="control-label col-md-4">First Name :</label>
                                <label class="control-label col-md-4">Middle Name :</label>
                                <br><br>
                                <div class="col-md-4">
                                    <input name="lastname" placeholder="Child's Last Name" value=<?php echo "'" . $child->lastname . "'" ?> class="form-control" type="text">
                                    <span class="help-block"></span>
                                </div>
                                <div class="col-md-4">
                                    <input name="firstname" placeholder="Child's First Name" value=<?php echo "'" . $child->firstname . "'" ?> class="form-control" type="text">
                                    <span class="help-block"></span>
                                </div>
                                <div class="col-md-4">
                                    <input name="middlename" placeholder="Child's Middle Name" value=<?php echo "'" . $child->middlename . "'" ?> class="form-control" type="text">
                                    <span class="help-block"></span>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <hr>
                            </div>  

                            <div class="form-group">
                                <label class="control-label col-md-4">Sex :</label>
                                <label class="control-label col-md-4">Date of Birth :</label>
                                <label class="control-label col-md-4">Place of Birth :</label>
                                <br><br><br><br><br><br>
                                <div class="col-md-4">
                                    <select name="sex" class="form-control">
                                        <?php
                                            if ($child->sex == 'Male') // set selected as default
                                            {
                                                echo '<option value="Male" selected>Male</option>';  
                                                echo '<option value="Female">Female</option>';
                                            }
                                            else
                                            {
                                                echo '<option value="Male">Male</option>';  
                                                echo '<option value="Female" selected>Female</option>';   
                                            }
                                        ?>
                                    </select>
                                    <span class="help-block"></span>
                                </div>
                                <div class="col-md-4">
                                    <input name="dob" placeholder="Child's Date of Birth" value=<?php echo "'" . $child->dob . "'" ?>  class="form-control" type="date" style="height:33px;">
                                    <span class="help-block"></span>
                                </div>
                                <div class="col-md-4">
                                    <input name="pob" placeholder="Child's Place of Birth" value=<?php echo "'" . $child->pob . "'" ?> class="form-control" type="text">
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <br><br>
                            
                            <div class="form-group">
                                <label class="control-label col-md-8">Religion :</label>
                                <label class="control-label col-md-4">Date Registered :</label>
                                <br><br> 
                                
                                <div class="col-md-8">
                                    <input name="religion" placeholder="Child's Religion" value=<?php echo "'" . $child->religion . "'" ?> class="form-control" type="text">
                                    <span class="help-block"></span>
                                </div>
                                <div class="col-md-4">
                                    <input name="date_registered" placeholder="Registration Date" value=<?php echo "'" . $child->date_registered . "'" ?> class="form-control" type="date" style="height:33px;">
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <br><br>

                            <div class="form-group">
                                <label class="control-label col-md-4">Barangay :</label>
                                <label class="control-label col-md-8">Address :</label>
                                <br><br>
                                <div class="col-md-4">
                                    <select name="barangay_id" class="form-control">
                                        <?php 
                                            foreach($barangays as $row)
                                            { 
                                              if ($child->barangay_id == $row->barangay_id) // set selected as default
                                              {
                                                echo '<option value="'.$row->barangay_id.'" selected>'.$row->name.'</option>';  
                                              } 
                                              else
                                              {
                                                echo '<option value="'.$row->barangay_id.'">'.$row->name.'</option>';
                                              }
                                            }
                                        ?>
                                    </select>
                                    <span class="help-block"></span>
                                </div>
                                <div class="col-md-8">
                                    <textarea name="address" placeholder="Child's Home Address" class="form-control"><?php echo $child->address ?></textarea>
                                    <span class="help-block"></span>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <hr>
                            </div>  

                            <div class="form-group">
                                <label class="control-label col-md-3">Initial Weight (kg) :</label>
                                <div class="col-md-3">
                                    <input name="weight" placeholder="Child's Initial Weight" value=<?php echo "'" . $child->weight . "'" ?> class="form-control" type="number">
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Initial Height (cm) :</label>
                                <div class="col-md-3">
                                    <input name="height" placeholder="Child's Initial Height" value=<?php echo "'" . $child->height . "'" ?> class="form-control" type="number">
                                    <span class="help-block"></span>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <hr>
                            </div> 

                            <div class="form-group">
                                <label class="control-label col-md-4">Contact :</label>
                                <label class="control-label col-md-4">Grade Level :</label>
                                <label class="control-label col-md-4">School :</label>
                                <br><br>

                                <div class="col-md-4">
                                    <input name="contact" placeholder="Parents Contact Number" value=<?php echo "'" . $child->contact . "'" ?> class="form-control" type="text">
                                    <span class="help-block"></span>
                                </div>
                                <div class="col-md-4">
                                    <input name="grade_level" placeholder="Child's Grade Level" value=<?php echo "'" . $child->grade_level . "'" ?> class="form-control" type="text">
                                    <span class="help-block"></span>
                                </div>
                                <div class="col-md-4">
                                    <textarea name="school" placeholder="Child's School" class="form-control"><?php echo $child->school ?></textarea>
                                    <span class="help-block"></span>
                                </div>
                            </div>
        
                            <div class="form-group">
                                <label class="control-label col-md-2">Disability :</label>
                                <br>
                                <div class="col-md-10">
                                    <textarea name="disability" placeholder="Child's Disability" class="form-control"><?php echo $child->disability ?></textarea>
                                    <span class="help-block"></span>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <hr>
                            </div> 

                            <div class="form-group" align="right">
                                <button type="button" id="btnSave" onclick="save_cis()" class="btn btn-primary"><i class="fa fa-floppy-o"></i> &nbsp;&nbsp;Save</button>

                                <button type="button" class="btn btn-danger"  onclick="cancel_cis()"><i class="fa fa-times"></i> &nbsp;Cancel</button>
                            </div>
                        </div>
                    </form>

  



                        <!-- <div class="panel-body">
                            <button class="btn btn-success" onclick="add_cis()"><i class="fa fa-plus-square"></i> &nbsp;Register Child</button>
                            <button class="btn btn-default" onclick="reload_table()"><i class="fa fa-refresh"></i> &nbsp;Reload</button>
                            <br><br>
                            <table id="cis-table" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th style="width:60px;">ChildID</th>
                                        <th>LastName</th>
                                        <th>FirstName</th>
                                        <th>MiddleName</th>
                                        <th>Birthdate</th>
                                        <th>Mos.</th>
                                        <th>Sex</th>
                                        <th>Weight</th>
                                        <th>Height</th>
                                        <th>Barangay</th>
                                        <th style="width:50px;">Action</th>
                                        <th>Registered</th>
                                        <th>Encoded</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div> -->
                    </div>
                    <!--===================================================-->
                    <!-- End Striped Table -->
                    <!-- <span>&nbsp; <i style = "color: #99ffff;" class="fa fa-square"></i> - Male &nbsp; | &nbsp; <i style = "color: #ffcccc;" class="fa fa-square"></i> - Female</span> -->
                </div>
                <!--===================================================-->
                <!--End page content-->
            </div>
            <!--===================================================-->
            <!--END CONTENT CONTAINER-->

