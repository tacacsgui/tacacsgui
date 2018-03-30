<!DOCTYPE html>
<!---->
<?php
///CONFIGURATION FILE///
require __DIR__ . '/config.php';
///PAGE VARIABLES///START
$PAGE_HEADER = 'MAVIS OTP Auth';
$PAGE_SUBHEADER = 'MAVIS module that can auth user via One Time Password';
$PAGE_TITLE = 'TacacsGUI';
$PAGE_SUBTITLE = 'MAVIS OTP Auth';
$BREADCRUMB = array(
	'Home' => [
		'name' => 'MAVIS', 
		'href' => '', 
		'icon' => 'fa fa-cog', 
		'class' => ''  //last item should have active class!!
	], 
	'Tacacs' => [
		'name' => 'OTP Auth', 
		'href' => '', 
		'icon' => 'fa fa-cog', 
		'class' => 'active'  //last item should have active class!!
	], 
);
///!!!!!////
$ACTIVE_MENU_ID=900;
$ACTIVE_SUBMENU_ID=910;
///!!!!!////
///PAGE VARIABLES///END
?>
<html>

<?php
require __DIR__ . '/templates/header.php';
?>
<!--ADDITIONAL CSS FILES START-->

	<!-- iCheck -->
	<link rel="stylesheet" href="/plugins/iCheck/square/blue.css">
<!--ADDITIONAL CSS FILES END-->
<?php 

require __DIR__ . '/templates/body_start.php'; 

?>
<!--MAIN CONTENT START-->
<style>
.otp-container {
	position: relative;
}
.otp-enabled {
    background-color: #ddddddc2;
    position: absolute;
    width: 101.6%;
    height: 101.6%;
    z-index: 10;
    left: -0.8%;
    top: -0.8%;
}
</style>

<div class="box box-success">
	<div class="box-header with-border">
		<h3 class="box-title">One Time Password Settings</h3>
	</div>
	<div class="box-body">
		<div class="row">
			<div class="col-xs-12 col-sm-10 col-sm-offset-1 col-md-4 col-md-offset-4 col-lg-4 col-lg-offset-4">
				<div class="form-group enabled">
					<label>MAVIS One Time Password Module</label>
					<div class="checkbox icheck enabled">
						<label>
						<input type="checkbox" > Enabled
						</label>
					</div>
                </div>
			</div>
		</div>
		<hr>
		<div class="otp-container">
		<div class="otp-enabled"></div>
		<div class="title text-center">
			<h4>Default Settings</h4>
		</div>
		<div class="row">
			<div class="col-md-4">
				<div class="form-group period">
					<label>Period</label>
					<input type="number" class="form-control period" placeholder="Period"/>
					<p class="help-block">period of generating OTP. By default, the period for a TOTP is 30 seconds</p>
                </div>
			</div>
			<div class="col-md-4">
				<div class="form-group digits">
					<label>Digits</label>
					<input type="number" class="form-control digits" placeholder="Digits"/>
					<p class="help-block">by default the number of digits is 6, more than 10 may be difficult to use by the owner</p>
                </div>
			</div>
			<div class="col-md-4">
				<div class="form-group digest">
					<label>Digest</label>
					<select class="form-control digest">
						<option value="sha1" selected>sha1</option>
						<option value="md5">md5</option>
					</select>
					<p class="help-block">if you don't know what to choose leave it as default (first value)</p>
                </div>
			</div>
		</div>
		</div>
<div class="form-group">
<div class="row">
<div class="col-lg-12 text-center">
	<div class="form-group">
		<p>It is time based parameter, synchronize your time before use it</p>
		<p>Current server time is <b><time class="current-time text-warning"></time></b></p>
		<button type="button"class="btn btn-warning btn-flat" onclick="getCurrentTime()">Check it again</button>
	</div>
</div>
</div>
</div>
	</div>
	<!-- /.box-body -->
	<div class="box-footer">
		<button class="btn btn-success btn-flat submit">Apply</button>
	</div>
</div>

<div class="box box-warning">
	<div class="box-header with-border">
		<h3 class="box-title">Check OTP</h3>
	</div>
	<div class="box-body">
		<div class="row">
			<div class="col-xs-12">
				<p>Here you can verify access for specific user</p>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12">
				<div class="callout callout-danger otp-check-alert" style="display:none">
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-4 col-sm-6">
				<div class="form-group">
					<label>Username</label>
					<input type="text" class="form-control otp-check-username" placeholder="Username"/>
					<p class="help-block">username of pre-configured user</p>
                </div>
			</div>
			<div class="col-md-4 col-sm-6">
				<div class="form-group">
					<label>Password</label>
					<input type="text" class="form-control otp-check-password" placeholder="One Time Password"/>
					<p class="help-block">OTP of that user</p>
                </div>
			</div>
		</div>
<pre class="otp-check-output">
Info will appeared here
</pre>
	</div>
	<!-- /.box-body -->
	<div class="box-footer">
		<button class="btn btn-warning btn-flat otp-check">Check connection</button>
	</div>
</div>

<!--MAIN CONTENT END-->

<?php 

require __DIR__ . '/templates/body_end.php'; 

?>


<?php

require __DIR__ . '/templates/footer_end.php';

?>
<!-- ADDITIONAL JS FILES START-->
	<!-- iCheck -->
	<script src="/plugins/iCheck/icheck.min.js"></script>
	
	<!-- main js MAIN Functions -->
    <script src="dist/js/pages/mavis_otp/main.js"></script>

<!-- ADDITIONAL JS FILES END-->
</body>

</html>