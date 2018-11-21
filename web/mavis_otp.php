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
$ACTIVE_MENU_ID=[900,910];
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
						<input type="checkbox" name="enabled" data-type="checkbox" data-default="" data-pickup="true"> Enabled
						</label>
						<input type="hidden" name="enabled_native" value="">
					</div>
                </div>
			</div>
		</div>
		<hr>
		<div class="otp-container">
		<div class="disabled_shield"></div>
		<div class="title text-center">
			<h4>Default Settings</h4>
		</div>
		<div class="row">
			<div class="col-md-4">
				<div class="form-group period">
					<label>Period</label>
					<input type="number" class="form-control" name="period" data-type="input" data-default="" data-pickup="true" placeholder="Period"/>
					<p class="help-block">period of generating OTP. By default, the period for a TOTP is 30 seconds</p>
					<input type="hidden" name="period_native" value="">
                </div>
			</div>
			<div class="col-md-4">
				<div class="form-group digits">
					<label>Digits</label>
					<input type="number" class="form-control" name="digits" data-type="input" data-default="" data-pickup="true" placeholder="Digits"/>
					<p class="help-block">by default the number of digits is 6, more than 10 may be difficult to use by the owner</p>
					<input type="hidden" name="digits_native" value="">
                </div>
			</div>
			<div class="col-md-4">
				<div class="form-group digest">
					<label>Digest</label>
					<select class="form-control" name="digest" data-type="select" data-default="" data-pickup="true">
						<option value="sha1" selected>sha1</option>
						<option value="md5">md5</option>
					</select>
					<input type="hidden" name="digest_native" value="">
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
				<button type="button"class="btn btn-warning btn-flat" onclick="tgui_otp.getTime()">Check it again</button>
			</div>
		</div>
		</div>
		</div>
	</div>
	<!-- /.box-body -->
	<div class="box-footer">
		<button class="btn btn-success btn-flat" onclick="tgui_otp.save()">Apply</button>
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
			<div class="col-md-4 col-sm-6">
				<div class="form-group username">
					<label>Username</label>
					<input type="text" class="form-control" name="username" data-type="input" data-default="" placeholder="Username"/>
					<p class="help-block">username of pre-configured user</p>
				</div>
			</div>
			<div class="col-md-4 col-sm-6">
				<div class="form-group ot_password">
					<label>Password</label>
					<input type="text" class="form-control" name="ot_password" data-type="input" data-default="" placeholder="One Time Password"/>
					<p class="help-block">OTP of that user</p>
				</div>
			</div>
		</div>
<pre class="check_result">
Info will appeared here
</pre>
	</div>
	<!-- /.box-body -->
	<div class="box-footer">
		<button class="btn btn-warning btn-flat" onclick="tgui_otp.tester()">Check connection</button>
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
  <script src="dist/js/pages/mavis_otp/tgui_otp.js"></script>
	<!-- main js MAIN Functions -->
  <script src="dist/js/pages/mavis_otp/main.js"></script>

<!-- ADDITIONAL JS FILES END-->
</body>

</html>
