<!DOCTYPE html>
<!---->
<?php
///CONFIGURATION FILE///
require __DIR__ . '/config.php';
///PAGE VARIABLES///START
$PAGE_HEADER = 'Tacacs Global Settings';
$PAGE_SUBHEADER = 'Here you can global settings of tacacs';
$PAGE_TITLE = 'TacacsGUI';
$PAGE_SUBTITLE = 'Tacacs Global Settings';
$BREADCRUMB = array(
	'Tacacs' => [
		'name' => 'Tacacs', 
		'href' => '', 
		'icon' => 'fa fa-cogs', 
		'class' => ''  //last item should have active class!!
	], 
	'Global_Settings' => [
		'name' => 'Global Settings', 
		'href' => '', 
		'icon' => 'fa fa-server', //leave empty if you won't put icon
		'class' => 'active' //last item should have active class!!
	]
);
///!!!!!////
$ACTIVE_MENU_ID=40;
$ACTIVE_SUBMENU_ID=410;
///!!!!!////
///PAGE VARIABLES///END
?>
<html>

<?php
require __DIR__ . '/templates/header.php';
?>
<!--ADDITIONAL CSS FILES START-->

<!--ADDITIONAL CSS FILES END-->

<?php 

require __DIR__ . '/templates/body_start.php'; 

?>
<!--MAIN CONTENT START-->

<div class="row">
	<div class="col-xs-12">
		<div class="box box-success">
			<div class="box-header">
				<h3 class="box-title">Start/Stop/Reload Tacacs Deamon</h3>
			</div>
			<!-- /.box-header -->
			<div class="box-body">
				<div class="row">
					<div class="col-xs-12">
						<a class="btn btn-app" onclick="deamonConfig('start')">
							<i class="fa fa-play"></i> Start
						</a>
						<a class="btn btn-app" onclick="deamonConfig('stop')">
							<i class="fa fa-pause"></i> Stop
						</a>
						<a class="btn btn-app">
							<i class="fa fa-repeat" onclick="deamonConfig('reload')"></i> Reload
						</a>
						<a class="btn btn-app">
							<i class="fa fa-info" onclick="deamonConfig()"></i> Get Status
						</a>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-12">
						<div class="form-group">
							<label>Current Status</label>
							<input type="text" class="form-control" name="deamon_status" disabled placeholder="Loading...">
						</div>
					</div>
				</div>
			</div>
			<!-- /.box-body -->
		</div>
		<!-- /.box -->
	</div>
	<!-- /.col -->
</div>

<div class="row">
	<div class="col-xs-12">
		<div class="box box-success">
			<div class="box-header">
				<h3 class="box-title">Global Settings</h3>
			</div>
			<!-- /.box-header -->
			<div class="box-body">
				<div class="row">
				<div class="col-md-4 col-lg-4">
					<div class="form-group port">
						<label>Listening Port</label>
						<input type="number" class="form-control" name="port" placeholder="Enter Listening Port">
					</div>
				</div>
				</div>
				<hr>
				<h3>Authentication</h3>
				<div class="row">
				<div class="col-md-4 col-lg-4">
					<div class="form-group max_attempts">
						<label>Authentication Max Attempt</label>
						<input type="number" class="form-control max_attempts" name="max_attempts" placeholder="Enter Max Attempt">
						<p class="help-block">that parameter limits the number of <i>Password:</i> prompts per TACACS+ session at login, default: 1</p>
					</div>
				</div>
				<div class="col-md-4 col-lg-4">
					<div class="form-group backoff">
						<label>Backoff Timer</label>
						<input type="number" class="form-control backoff" name="backoff" placeholder="Enter Backoff Timer">
						<p class="help-block">tacacs will wait for <i>seconds</i> before returning a final authentication failure (password incorrect) message, default: 1 second</p>
					</div>
				</div>
				</div>
				<hr>
				<h3>Limits and Timeouts</h3>
				<div class="row">
				<div class="col-md-4 col-lg-4">
					<div class="form-group connection_timeout">
						<label>Connection Timeout</label>
						<input type="number" class="form-control" name="connection_timeout" placeholder="Enter Connection Timeout">
						<p class="help-block">terminate a connection to a NAS after an idle period of at least <i>s</i> seconds, default: 600 seconds</p>
					</div>
				</div>
				<div class="col-md-4 col-lg-4">
					<div class="form-group context_timeout">
						<label>Context Timeout</label>
						<input type="number" class="form-control" name="context_timeout" placeholder="Enter Context Timeout">
						<p class="help-block">clears context cache entries after <i>s</i> seconds of inactivity, default: 3600 seconds</p>
					</div>
				</div>
				</div>
				<hr>
				<h3>Reports Settings</h3>
				<small class="text-red">be careful with those settings! it influences on log parser script!</small>
				<div class="row">
				<div class="col-md-4 col-lg-4">
					<div class="form-group authentication">
						<label>Authentication</label>
						<input type="text" class="form-control" name="authentication" placeholder="Enter Authentication Settings">
						<p class="help-block">here you can set path to file on the server, command or syslog server ip and port, <text class="text-red">by default it used for Log Parser script</text></p>
					</div>
				</div>
				<div class="col-md-4 col-lg-4">
					<div class="form-group authorization">
						<label>Authorization</label>
						<input type="text" class="form-control" name="authorization" placeholder="Enter Authorization Settings">
						<p class="help-block">here you can set path to file on the server, command or syslog server ip and port, <text class="text-red">by default it used for Log Parser script</text></p>
					</div>
				</div>
				<div class="col-md-4 col-lg-4">
					<div class="form-group accounting">
						<label>Accounting</label>
						<input type="text" class="form-control" name="accounting" placeholder="Enter Accounting Settings">
						<p class="help-block">here you can set path to file on the server, command or syslog server ip and port, <text class="text-red">by default it used for Log Parser script</text></p>
					</div>
				</div>
				</div>
				<!--<div class="row">
				<div class="col-md-4 col-lg-4">
					<div class="form-group">
						<label>Log Separator</label>
						<input type="text" class="form-control" name="separator" placeholder="Enter Log Separator">
						<p class="help-block">here you can set a set of chars that will separate log attributes in a log string <text class="text-red">by default it used for Log Parser script</text></p>
					</div>
				</div>
				</div>-->
				<hr>
				<h3>Manual Configuration</h3>
				<small class="text-red">be careful with those settings! by default it influences on log parser script!</small>
				<p class="help-block">that configuration will be added to the top of global configuration, after port listening settings</p>
				<div class="row">
				<div class="col-md-12 col-lg-12">
					<div class="form-group manual">
						<textarea rows="6" class="form-control" name="manual" placeholder="Manual configuration"></textarea>
					</div>
				</div>
				</div>
				<hr>
				<div class="row">
					<div class="col-lg-4 col-lg-offset-4 col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3 col-xs-8 col-xs-offset-2">
						<button type="button" class="btn btn-block btn-warning btn-flat applySettings">Apply Global Settings</button>
					</div>
				</div>
				<!-- <div class="row"><div class="col-xs-12"><p class="text-muted pull-right">Last update was: <lastupdate></lastupdate></p></div></div> -->
			</div>
			<!-- /.box-body -->
		</div>
		<!-- /.box -->
	</div>
	<!-- /.col -->
</div>

<!--MAIN CONTENT END-->

<?php 

require __DIR__ . '/templates/body_end.php'; 

?>


<?php

require __DIR__ . '/templates/footer_end.php';

?>
<!-- ADDITIONAL JS FILES START-->

	<!-- main js Device MAIN Functions -->
    <script src="dist/js/pages/tac_global_settings/main.js"></script>
<!-- ADDITIONAL JS FILES END-->
</body>

</html>