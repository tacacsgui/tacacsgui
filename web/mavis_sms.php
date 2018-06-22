<!DOCTYPE html>
<!---->
<?php
///CONFIGURATION FILE///
require __DIR__ . '/config.php';
///PAGE VARIABLES///START
$PAGE_HEADER = 'MAVIS SMS Auth';
$PAGE_SUBHEADER = 'MAVIS module that can auth user via SMS';
$PAGE_TITLE = 'TacacsGUI';
$PAGE_SUBTITLE = 'MAVIS SMS Auth';
$BREADCRUMB = array(
	'Home' => [
		'name' => 'MAVIS',
		'href' => '',
		'icon' => 'fa fa-cog',
		'class' => ''  //last item should have active class!!
	],
	'Tacacs' => [
		'name' => 'SMS Auth',
		'href' => '',
		'icon' => 'fa fa-cog',
		'class' => 'active'  //last item should have active class!!
	],
);
///!!!!!////
$ACTIVE_MENU_ID=900;
$ACTIVE_SUBMENU_ID=930;
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
.sms-container {
	position: relative;
}
</style>

<div class="box box-success">
	<div class="box-header with-border">
		<h3 class="box-title">SMPP client settings</h3>
	</div>
	<div class="box-body">
		<div class="row">
			<div class="col-xs-12 col-sm-10 col-sm-offset-1 col-md-4 col-md-offset-4 col-lg-4 col-lg-offset-4">
				<div class="form-group enabled">
					<label>MAVIS SMS Authentication Module</label>
					<div class="checkbox icheck">
						<label>
						<input type="checkbox" name="enabled" data-type="checkbox" data-default="unchecked" data-pickup="true"> Enabled
						</label>
						<input type="hidden" name="enabled_native" value="">
					</div>
                </div>
			</div>
		</div>
		<hr>
		<div class="sms-container">
		<div class="disabled_shield"></div>
		<div class="title text-center">
			<h4>SMPP Settings</h4>
			<small>it support SMPP v.3.4</small>
		</div>
		<div class="row">
			<div class="col-md-4">
				<div class="form-group ipaddr">
					<label>IP Address</label>
					<input type="text" class="form-control" name="ipaddr" data-type="input" data-default="" data-pickup="true" placeholder="IP Address"/>
					<p class="help-block">ip address of SMPP server</p>
					<input type="hidden" name="ipaddr_native" value="">
        </div>
			</div>
			<div class="col-md-3">
				<div class="form-group port">
					<label>Port</label>
					<input type="number" class="form-control" name="port" data-type="input" data-default="" data-pickup="true" placeholder="Port"/>
					<p class="help-block">port of SMPP server</p>
					<input type="hidden" name="port_native" value="">
        </div>
			</div>
			<div class="col-md-4">
				<div class="form-group srcname">
					<label>Source Name</label>
					<input type="text" class="form-control" name="srcname" data-type="input" data-default="" data-pickup="true" placeholder="Source Name"/>
					<p class="help-block">you can get that information from your provider</p>
					<input type="hidden" name="srcname_native" value="">
        </div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-4">
				<div class="form-group login">
					<label>Username</label>
					<input type="text" class="form-control" name="login" data-type="input" data-default="" data-pickup="true" placeholder="Username"/>
					<p class="help-block"></p>
					<input type="hidden" name="login_native" value="">
        </div>
			</div>
			<div class="col-md-4">
				<div class="form-group pass">
					<label>Passsword</label>
					<input type="password" class="form-control" name="pass" data-type="input" data-default="" data-pickup="true" placeholder="Passsword"/>
					<p class="help-block"></p>
					<input type="hidden" name="pass_native" value="">
        </div>
			</div>
		</div>

		</div>
	</div>
	<!-- /.box-body -->
	<div class="box-footer">
		<button class="btn btn-success btn-flat" onclick="tgui_sms.save()">Apply</button>
	</div>
</div>

<div class="box box-warning">
	<div class="box-header with-border">
		<h3 class="box-title">Check SMS Authentication</h3>
	</div>
	<div class="box-body">
		<div class="row">
			<div class="col-xs-12">
				<p>Here you can verify access for specific user</p>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6">
				<div class="box-body">
					<div class="title text-center"><h4>Send SMS to</h4></div>
					<div class="col-md-12">
						<div class="form-group username">
							<label>Username</label>
							<input type="text" class="form-control" name="username" data-type="input" data-default="" placeholder="Username"/>
							<p class="help-block">username of pre-configured user</p>
						</div>
					</div>
					<div class="col-md-12">
						<div class="form-group phone_number">
							<label>Phone Number</label>
							<input type="text" class="form-control" name="phone_number" data-type="input" data-default="" placeholder="Phone Number"/>
							<p class="help-block">(optional) phone number that will receive sms</p>
						</div>
					</div>
					<div class="action text-center"><button class="btn btn-flat btn-success" onclick="tgui_sms.sendSMS()">Send SMS</button></div>
				</div>
			</div>

			<div class="col-md-6">
				<div class="box-body">
					<div class="title text-center"><h4>Check OTP from SMS</h4></div>
					<div class="col-md-12">
						<div class="form-group test_username">
							<label>Username</label>
							<input type="text" class="form-control" name="test_username" data-type="input" data-default="" placeholder="Username"/>
							<p class="help-block">username of pre-configured user</p>
						</div>
					</div>
					<div class="col-md-12">
						<div class="form-group sms_password">
							<label>OTP Password</label>
							<input type="text" class="form-control" name="sms_password" data-type="input" data-default="" placeholder="One-Time Password"/>
							<p class="help-block">OTP from sms for that user</p>
						</div>
					</div>
					<div class="action text-center"><button class="btn btn-flat btn-warning" onclick="tgui_sms.tester()">Check Auth</button></div>
				</div>
			</div>
		</div>
<pre class="check_result">
Info will appeared here
</pre>
	</div>
	<!-- /.box-body -->
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

	<!-- main Object -->
  <script src="dist/js/pages/mavis_sms/tgui_sms.js"></script>
	<!-- main js MAIN Functions -->
  <script src="dist/js/pages/mavis_sms/main.js"></script>

<!-- ADDITIONAL JS FILES END-->
</body>

</html>
