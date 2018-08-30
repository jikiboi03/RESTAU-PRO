<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resto App | Restaurant Point of Sale
    </title>
    <!--STYLESHEET-->
    <!--=================================================-->
    <!--Open Sans Font [ OPTIONAL ] -->
    <!-- <link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700&amp;subset=latin" rel="stylesheet"> -->
    <!--Bootstrap Stylesheet [ REQUIRED ]-->
    <link href="<?php echo base_url();?>assets/css/bootstrap.min.css" rel="stylesheet">
    <!--Nifty Stylesheet [ REQUIRED ]-->
    <link href="<?php echo base_url();?>assets/css/nifty.min.css" rel="stylesheet">
    <!--Font Awesome [ OPTIONAL ]-->
    <link href="<?php echo base_url();?>assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!--Animate.css [ OPTIONAL ]-->
    <link href="<?php echo base_url();?>assets/plugins/animate-css/animate.min.css" rel="stylesheet">
    <!--Morris.js [ OPTIONAL ]-->
    <link href="<?php echo base_url();?>assets/plugins/morris-js/morris.min.css" rel="stylesheet">
    <!--Switchery [ OPTIONAL ]-->
    <link href="<?php echo base_url();?>assets/plugins/switchery/switchery.min.css" rel="stylesheet">
    <!--Bootstrap Select [ OPTIONAL ]-->
    <link href="<?php echo base_url();?>assets/plugins/bootstrap-select/bootstrap-select.min.css" rel="stylesheet">
    <!--Demo script [ DEMONSTRATION ]-->
    <link href="<?php echo base_url();?>assets/css/demo/nifty-demo.min.css" rel="stylesheet">
    <!--Bootstrap Table [ OPTIONAL ]-->
    <link href="<?php echo base_url();?>assets/plugins/datatables/media/css/dataTables.bootstrap.css" rel="stylesheet">
    <link href="<?php echo base_url();?>assets/plugins/datatables/extensions/Responsive/css/dataTables.responsive.css" rel="stylesheet">
    <link href="<?php echo base_url();?>assets/css/custom.css" rel="stylesheet">
    <!--SCRIPT-->
    <!--=================================================-->
    <!--Page Load Progress Bar [ OPTIONAL ]-->
    <link href="<?php echo base_url();?>assets/plugins/pace/pace.min.css" rel="stylesheet">
    <script src="<?php echo base_url();?>assets/plugins/pace/pace.min.js">
    </script>

    <script src="<?php echo base_url();?>assets/plugins/highcharts/code/highcharts.js">
    </script>
    <script src="<?php echo base_url();?>assets/plugins/highcharts/code/highcharts-3d.js">
    </script>
    <script src="<?php echo base_url();?>assets/plugins/highcharts/code/highcharts-more.js">
    </script>
    <script src="<?php echo base_url();?>assets/plugins/highcharts/code/modules/exporting.js">
    </script>
    <!--
REQUIRED
You must include this in your project.
RECOMMENDED
This category must be included but you may modify which plugins or components which should be included in your project.
OPTIONAL
Optional plugins. You may choose whether to include it in your project or not.
DEMONSTRATION
This is to be removed, used for demonstration purposes only. This category must not be included in your project.
SAMPLE
Some script samples which explain how to initialize plugins or components. This category should not be included in your project.
Detailed information and more samples can be found in the document.
-->
  </head>
  <!--TIPS-->
  <!--You may remove all ID or Class names which contain "demo-", they are only used for demonstration. -->
  <body>




    <?php if($title == 'Transaction Page') :?>
    <div id="container" class="effect mainnav-sm">
      <?php else :?> 
      <div id="container" class="effect mainnav-lg">
        <?php endif; ?>   
        <!--NAVBAR-->
        <!--===================================================-->
        <header id="navbar">
          <div id="navbar-container" class="boxed">
            <!--Brand logo & name-->
            <!--================================-->
            <div class="navbar-header">
              <a href="<?php echo base_url();?>dashboard" class="navbar-brand">
                <img src="<?php echo base_url();?>assets/img/logo.png" alt="InnoTechSolutions" class="brand-icon">
                <div class="brand-title">
                  <span class="brand-text" style="margin-left: 2px;">InnoTechSolutions
                  </span>

                </div>

              </a>
            </div>

            <!--================================-->
            <!--End brand logo & name-->
            <!--Navbar Dropdown-->
            <!--================================-->
            <div class="navbar-content clearfix">
              <ul class="nav navbar-top-links pull-left">
                <!--Navigation toogle button-->
                <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                <li class="tgl-menu-btn">
                  <a class="mainnav-toggle" href="#">
                    <i class="fa fa-navicon fa-lg">
                    </i>
                  </a>
                </li>
                
                
                <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                <!--End Navigation toogle button-->
                <!--Messages Dropdown-->
                <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<!--                 <li class="dropdown">
                  <a href="#" data-toggle="dropdown" class="dropdown-toggle">
                    <i class="fa fa-envelope fa-lg">
                    </i>
                    <span class="badge badge-header badge-warning">9
                    </span>
                  </a> -->
                  <!--Message dropdown menu-->
<!--                   <div class="dropdown-menu dropdown-menu-md with-arrow">
                    <div class="pad-all bord-btm">
                      <p class="text-lg text-muted text-thin mar-no">You have 3 messages.
                      </p>
                    </div>
                    <div class="nano scrollable">
                      <div class="nano-content">
                        <ul class="head-list"> -->
                          <!-- Dropdown list-->
<!--                           <li>
                            <a href="#" class="media">
                              <div class="media-left">
                                <img src="<?php echo base_url();?>assets/img/av2.png" alt="Profile Picture" class="img-circle img-sm">
                              </div>
                              <div class="media-body">
                                <div class="text-nowrap">Andy sent you a message
                                </div>
                                <small class="text-muted">15 minutes ago
                                </small>
                              </div>
                            </a>
                          </li> -->
                          <!-- Dropdown list-->
<!--                           <li>
                            <a href="#" class="media">
                              <div class="media-left">
                                <img src="<?php echo base_url();?>assets/img/av4.png" alt="Profile Picture" class="img-circle img-sm">
                              </div>
                              <div class="media-body">
                                <div class="text-nowrap">Lucy sent you a message
                                </div>
                                <small class="text-muted">30 minutes ago
                                </small>
                              </div>
                            </a>
                          </li> -->
                          <!-- Dropdown list-->
 <!--                          <li>
                            <a href="#" class="media">
                              <div class="media-left">
                                <img src="<?php echo base_url();?>assets/img/av3.png" alt="Profile Picture" class="img-circle img-sm">
                              </div>
                              <div class="media-body">
                                <div class="text-nowrap">Jackson sent you a message
                                </div>
                                <small class="text-muted">40 minutes ago
                                </small>
                              </div>
                            </a>
                          </li> -->
                          <!-- Dropdown list-->
<!--                           <li>
                            <a href="#" class="media">
                              <div class="media-left">
                                <img src="<?php echo base_url();?>assets/img/av6.png" alt="Profile Picture" class="img-circle img-sm">
                              </div>
                              <div class="media-body">
                                <div class="text-nowrap">Donna sent you a message
                                </div>
                                <small class="text-muted">5 hours ago
                                </small>
                              </div>
                            </a>
                          </li> -->
                          <!-- Dropdown list-->
<!--                           <li>
                            <a href="#" class="media">
                              <div class="media-left">
                                <img src="<?php echo base_url();?>assets/img/av4.png" alt="Profile Picture" class="img-circle img-sm">
                              </div>
                              <div class="media-body">
                                <div class="text-nowrap">Lucy sent you a message
                                </div>
                                <small class="text-muted">Yesterday
                                </small>
                              </div>
                            </a>
                          </li> -->
                          <!-- Dropdown list-->
<!--                           <li>
                            <a href="#" class="media">
                              <div class="media-left">
                                <img src="<?php echo base_url();?>assets/img/av3.png" alt="Profile Picture" class="img-circle img-sm">
                              </div>
                              <div class="media-body">
                                <div class="text-nowrap">Jackson sent you a message
                                </div>
                                <small class="text-muted">Yesterday
                                </small>
                              </div>
                            </a>
                          </li>
                        </ul>
                      </div>
                    </div> -->
                    <!--Dropdown footer-->
 <!--                    <div class="pad-all bord-top">
                      <a href="#" class="btn-link text-dark box-block">
                        <i class="fa fa-angle-right fa-lg pull-right">
                        </i>Show All Messages
                      </a>
                    </div>
                  </div>
                </li> -->
                <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                <!--End message dropdown-->
                <!--Notification dropdown-->
                <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<!--                 <li class="dropdown">
                  <a href="#" data-toggle="dropdown" class="dropdown-toggle">
                    <i class="fa fa-bell fa-lg">
                    </i>
                    <span class="badge badge-header badge-danger">5
                    </span>
                  </a> -->
                  <!--Notification dropdown menu-->
<!--                   <div class="dropdown-menu dropdown-menu-md with-arrow">
                    <div class="pad-all bord-btm">
                      <p class="text-lg text-muted text-thin mar-no">You have 3 messages.
                      </p>
                    </div>
                    <div class="nano scrollable">
                      <div class="nano-content">
                        <ul class="head-list"> -->
                          <!-- Dropdown list-->
<!--                           <li>
                            <a href="#">
                              <div class="clearfix">
                                <p class="pull-left">Database Repair
                                </p>
                                <p class="pull-right">70%
                                </p>
                              </div>
                              <div class="progress progress-sm">
                                <div style="width: 70%;" class="progress-bar">
                                  <span class="sr-only">70% Complete
                                  </span>
                                </div>
                              </div>
                            </a>
                          </li> -->
                          <!-- Dropdown list-->
<!--                           <li>
                            <a href="#">
                              <div class="clearfix">
                                <p class="pull-left">Upgrade Progress
                                </p>
                                <p class="pull-right">10%
                                </p>
                              </div>
                              <div class="progress progress-sm">
                                <div style="width: 10%;" class="progress-bar progress-bar-warning">
                                  <span class="sr-only">10% Complete
                                  </span>
                                </div>
                              </div>
                            </a>
                          </li> -->
                          <!-- Dropdown list-->
<!--                           <li>
                            <a href="#" class="media">
                              <div class="media-left">
                                <span class="icon-wrap icon-circle bg-primary">
                                  <i class="fa fa-comment fa-lg">
                                  </i>
                                </span>
                              </div>
                              <div class="media-body">
                                <div class="text-nowrap">New comments waiting approval
                                </div>
                                <small class="text-muted">15 minutes ago
                                </small>
                              </div>
                            </a>
                          </li> -->
                          <!-- Dropdown list-->
<!--                           <li>
                            <a href="#" class="media">
                              <span class="badge badge-success pull-right">90%
                              </span>
                              <div class="media-left">
                                <span class="icon-wrap icon-circle bg-danger">
                                  <i class="fa fa-hdd-o fa-lg">
                                  </i>
                                </span>
                              </div>
                              <div class="media-body">
                                <div class="text-nowrap">HDD is full
                                </div>
                                <small class="text-muted">50 minutes ago
                                </small>
                              </div>
                            </a>
                          </li> -->
                          <!-- Dropdown list-->
<!--                           <li>
                            <a href="#" class="media">
                              <div class="media-left">
                                <span class="icon-wrap bg-info">
                                  <i class="fa fa-file-word-o fa-lg">
                                  </i>
                                </span>
                              </div>
                              <div class="media-body">
                                <div class="text-nowrap">Write a news article
                                </div>
                                <small class="text-muted">Last Update 8 hours ago
                                </small>
                              </div>
                            </a>
                          </li> -->
                          <!-- Dropdown list-->
<!--                           <li>
                            <a href="#" class="media">
                              <span class="label label-danger pull-right">New
                              </span>
                              <div class="media-left">
                                <span class="icon-wrap bg-purple">
                                  <i class="fa fa-comment fa-lg">
                                  </i>
                                </span>
                              </div>
                              <div class="media-body">
                                <div class="text-nowrap">Comment Sorting
                                </div>
                                <small class="text-muted">Last Update 8 hours ago
                                </small>
                              </div>
                            </a>
                          </li> -->
                          <!-- Dropdown list-->
<!--                           <li>
                            <a href="#" class="media">
                              <div class="media-left">
                                <span class="icon-wrap bg-success">
                                  <i class="fa fa-user fa-lg">
                                  </i>
                                </span>
                              </div>
                              <div class="media-body">
                                <div class="text-nowrap">New User Registered
                                </div>
                                <small class="text-muted">4 minutes ago
                                </small>
                              </div>
                            </a>
                          </li>
                        </ul>
                      </div>
                    </div> -->
                    <!--Dropdown footer-->
<!--                     <div class="pad-all bord-top">
                      <a href="#" class="btn-link text-dark box-block">
                        <i class="fa fa-angle-right fa-lg pull-right">
                        </i>Show All Notifications
                      </a>
                    </div>
                  </div>
                </li> -->
                <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                <!--End notifications dropdown-->
              </ul>
              <ul class="nav navbar-top-links pull-right">
                <!--User dropdown-->
                <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                <li id="dropdown-user" class="dropdown">
                  <a href="#" data-toggle="dropdown" class="dropdown-toggle text-right">

                    <span class="pull-right">
                      <img class="img-circle img-user media-object" src="<?php echo base_url();?>assets/img/av1.png" alt="Profile Picture">
                    </span>
                    <div class="username hidden-xs">
                      <?php echo $this->session->userdata('username')?>
                    </div>
                  </a>
                  <div class="dropdown-menu dropdown-menu-md dropdown-menu-right with-arrow panel-default">
                    <!-- Dropdown heading  -->
                    <div class="pad-all bord-btm">
                      <p class="text-lg text-muted text-thin mar-btm">
                        <strong>
                          <?php
                            // check if the user is admin
                            if ($this->session->userdata('administrator') == 1)
                            {
                              $account_type = 'ADMIN';
                            }
                            else if ($this->session->userdata('cashier') == 1)
                            {
                              $account_type = 'CASHIER';
                            }
                            else
                            {
                              $account_type = 'STAFF';
                            }

                            echo '[ ' . $account_type . ' ACCOUNT ]';
                          ?>
                        </strong>
                      </p>
                      <p>
                        <?php echo $this->session->userdata('lastname').', '.$this->session->userdata('firstname').' '.$this->session->userdata('middlename'); ?>
                      </p>
                      <p>
                        <?php echo $this->session->userdata('email'); ?>
                      </p>
                    </div>
                    <!-- User dropdown menu -->
                    <!-- <ul class="head-list">
                      <li>
                        <a href="#">
                          <i class="fa fa-user fa-fw fa-lg">
                          </i> Profile
                        </a>
                      </li>
                      <li>
                        <a href="#">
                          <span class="badge badge-danger pull-right">9
                          </span>
                          <i class="fa fa-envelope fa-fw fa-lg">
                          </i> Messages
                        </a>
                      </li>
                    </ul> -->
                    <!-- Dropdown footer -->
                    <div class="pad-all text-right">
                      <button type="button" class="btn btn-dark col-md-6" onclick="print_s_reading()"><i class="fa fa-print"></i> S-Reading</button>
                        <button type="button" class="btn btn-success col-md-6" onclick="print_x_reading()"><i class="fa fa-print"></i> X-Reading</button>
                    </div>
                    <br>
                    <div class="pad-all text-right">  
                      <a href="<?php echo base_url('user-logout'); ?>" class="btn btn-primary col-md-12">
                        <i class="fa fa-sign-out fa-fw">
                        </i> Logout
                      </a>
                    </div>
                    <br><br>
                  </div>
                </li>
                <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                <!--End user dropdown-->
              </ul>
            </div>
            <!--================================-->
            <!--End Navbar Dropdown-->
          </div>
        </header>
        <!--===================================================-->
        <!--END NAVBAR-->
        <div class="boxed">
