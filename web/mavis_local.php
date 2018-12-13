<!DOCTYPE html>
<!---->
<?php
///CONFIGURATION FILE///
require __DIR__ . '/config.php';
///PAGE VARIABLES///START
$PAGE_HEADER = 'MAVIS Local Database';
$PAGE_SUBHEADER = 'MAVIS module that can auth user via local database';
$PAGE_TITLE = 'TacacsGUI';
$PAGE_SUBTITLE = 'MAVIS Local Database';
$BREADCRUMB = array(
	'Home' => [
		'name' => 'MAVIS',
		'href' => '',
		'icon' => 'fa fa-cog',
		'class' => ''  //last item should have active class!!
	],
	'Tacacs' => [
		'name' => 'Local DB',
		'href' => '',
		'icon' => 'fa fa-cog',
		'class' => 'active'  //last item should have active class!!
	],
);
///!!!!!////
$ACTIVE_MENU_ID=[900,940];
$ACTIVE_SUBMENU_ID=940;
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
		<h3 class="box-title">MAVIS Local Database Settings</h3>
	</div>
	<div class="box-body">
		<div class="row">
			<div class="col-xs-12 col-sm-10 col-sm-offset-1 col-md-4 col-md-offset-4 col-lg-4 col-lg-offset-4">
				<div class="form-group enabled">
					<label>MAVIS Local Database Module</label>
					<div class="checkbox icheck">
						<p class="empty-paragraph"></p>
			      <input class="bootstrap-toggle" name="enabled" data-type="checkbox" data-default="checked" data-pickup="true" data-toggle="toggle" type="checkbox" data-on="<i class='fa fa-check'></i> Enabled" data-off="<i class='fa fa-close'></i> Disabled" data-onstyle="success" data-offstyle="warning" checked>
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
			<div class="col-sm-6">
				<div class="form-group period">
					<label>Change Password via NAS CLI</label>
          <div class="checkbox icheck change_passwd_cli">
						<label>
						<input type="checkbox" name="change_passwd_cli" data-type="checkbox" data-default="" data-pickup="true"> Enabled
						</label>
						<input type="hidden" name="change_passwd_cli_native" value="">
					</div>
					<p class="help-block">user will be able to change your password via device (NAS) CLI, empty password at login, the user is given the option to change his password</p>
        </div>
			</div>
			<div class="col-sm-6">
				<div class="form-group period">
					<label>Change Password via GUI</label>
          <div class="checkbox icheck change_passwd_gui">
						<label>
						<input type="checkbox" name="change_passwd_gui" data-type="checkbox" data-default="" data-pickup="true"> Enabled
						</label>
						<input type="hidden" name="change_passwd_gui_native" value="">
					</div>
					<p class="help-block">user will be able to change your password via GUI</p>
        </div>
			</div>
		</div>
  </div>
	</div>
	<!-- /.box-body -->
	<div class="box-footer">
		<button class="btn btn-success btn-flat" onclick="tgui_local.save()">Apply</button>
	</div>
</div>

<div class="box box-solid">
	<!--<div class="box-header with-border">
		<h3 class="box-title">Check Local</h3>
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
					<input type="text" class="form-control" name="password" data-type="input" data-default="" placeholder="Password"/>
					<p class="help-block">password of that user</p>
				</div>
			</div>
		</div>
<pre class="check_result">
Info will appeared here
</pre>
</div> -->
	<!-- /.box-body -->
	<!--<div class="box-footer">
		<button class="btn btn-warning btn-flat" onclick="tgui_local.tester()">Check connection</button>
	</div> -->
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
  <script src="dist/js/pages/mavis_local/tgui_local.js"></script>
	<!-- main js MAIN Functions -->
  <script src="dist/js/pages/mavis_local/main.js"></script>

<!-- ADDITIONAL JS FILES END-->
</body>

</html>
