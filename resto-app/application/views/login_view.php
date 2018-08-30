<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Login page | Restaurant App</title>
	<!--STYLESHEET-->
	<!--=================================================-->
	<!--Open Sans Font [ OPTIONAL ] -->
 	<link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700&amp;subset=latin" rel="stylesheet">
	<!--Bootstrap Stylesheet [ REQUIRED ]-->
	<link href="assets/css/bootstrap.min.css" rel="stylesheet">
	<!--Nifty Stylesheet [ REQUIRED ]-->
	<link href="assets/css/nifty.min.css" rel="stylesheet">
	<!--Font Awesome [ OPTIONAL ]-->
	<link href="assets/css/font-awesome.min.css" rel="stylesheet">
	<!-- Create your own class to load custum image [ SAMPLE ]-->
	<style>
		.demo-my-bg{
			background-image : url("assets/img/bg-img.jpg");
		}
	</style>
	<!--Page Load Progress Bar [ OPTIONAL ]-->
	<link href="assets/css/pace.min.css" rel="stylesheet">
	<script src="assets/js/pace.min.js"></script>
</head>
<body>
	<div id="container" class="cls-container">	
		<!-- BACKGROUND IMAGE -->
		<!--===================================================-->
		<div id="bg-overlay" class="bg-img demo-my-bg"></div>	
		<!-- HEADER -->
		<!--===================================================-->
		<div class="cls-header cls-header-lg">
			<div class="cls-brand">
				<a class="box-inline" href="index.html">
					<!-- <img alt="Nifty Admin" src="img/logo.png" class="brand-icon"> -->
					<span class="brand-title">Resto App | <span class="text-thin"> POS</span></span>
				</a>
			</div>
		</div>
		<!--===================================================-->
		<!-- LOGIN FORM -->
		<!--===================================================-->
		<div class="cls-content">
			<div class="cls-content-sm panel">
				<div class="panel-body">
					<!-- <img src="assets/img/anc.jpg" style="width: 70%;"> -->
					<hr>
					<p class="pad-btm">Sign In to your account</p>
					<form id="login" action="<?php echo base_url();?>login_controller/login_validation" method="post" >
						<div class="form-group">
							<div class="input-group">
								<div class="input-group-addon"><i class="fa fa-user"></i></div>
								<input type="text" class="form-control" name="username" id="username" placeholder="Username">
								<span class="text-danger"><?php echo form_error('username');?></span>
							</div>
						</div>
						<div class="form-group">
							<div class="input-group">
								<div class="input-group-addon"><i class="fa fa-asterisk"></i></div>
								<input type="password" class="form-control" name="password" id="password" placeholder="Password">
								<span class="text-danger"><?php echo form_error('password');?></span>
							</div>
						</div>
						<?php echo '<label class="text-danger">'.$this->session->flashdata("error").'</label>';?>
						<div class="row">
							<div class="col-xs-8 text-left checkbox">
								<!-- <label class="form-checkbox form-icon">
								<input type="checkbox"> Remember me
								</label> -->
							</div>
							<div class="col-xs-4">
								<div class="form-group text-right">
								<input class="btn btn-success text-uppercase" name="insert" type="submit" value="Sign In"/>
								</div>
							</div>
						</div>
						
					</form>
				</div>
			</div>

		</div>
		<!--===================================================-->		
	</div>
	<!--===================================================-->
	<!-- END OF CONTAINER -->		
	<!--JAVASCRIPT-->
	<!--=================================================-->
	<!--jQuery [ REQUIRED ]-->
	<script src="assets/js/jquery-2.1.1.min.js"></script>
	<!--BootstrapJS [ RECOMMENDED ]-->
	<script src="assets/js/bootstrap.min.js"></script>
	<!--Fast Click [ OPTIONAL ]-->
	<script src="assets/js/fastclick.min.js"></script>
	<!--Nifty Admin [ RECOMMENDED ]-->
	<script src="assets/js/nifty.min.js"></script>
</body>
</html>
