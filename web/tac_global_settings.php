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
$ACTIVE_MENU_ID=[40,410];
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
						<a class="btn btn-app" onclick="tgui_tacGlobal.daemon('start')">
							<i class="fa fa-play"></i> Start
						</a>
						<a class="btn btn-app" onclick="tgui_tacGlobal.daemon('stop')">
							<i class="fa fa-pause"></i> Stop
						</a>
						<a class="btn btn-app">
							<i class="fa fa-repeat" onclick="tgui_tacGlobal.daemon('reload')"></i> Reload
						</a>
						<a class="btn btn-app">
							<i class="fa fa-info" onclick="tgui_tacGlobal.daemon()"></i> Get Status
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
				<form id="tacGlobalForm" method="post">
				<div class="row">
				<div class="col-sm-4">
					<div class="form-group port">
						<label>Listening Port</label>
						<input type="number" class="form-control" name="port" data-type="input" data-default="" data-pickup="true" placeholder="Enter Listening Port">
						<input type="hidden" name="port_native" value="">
					</div>
				</div>
				</div>
				<hr>
				<h3>Authentication</h3>
				<div class="row">
				<div class="col-sm-4">
					<div class="form-group max_attempts">
						<label>Authentication Max Attempt</label>
						<input type="number" class="form-control max_attempts" name="max_attempts" data-type="input" data-default="" data-pickup="true" placeholder="Enter Max Attempt">
						<p class="help-block">that parameter limits the number of <i>Password:</i> prompts per TACACS+ session at login, default: 1</p>
						<input type="hidden" name="max_attempts_native" value="">
					</div>
				</div>
				<div class="col-sm-4">
					<div class="form-group backoff">
						<label>Backoff Timer</label>
						<input type="number" class="form-control backoff" name="backoff" data-type="input" data-default="" data-pickup="true" placeholder="Enter Backoff Timer">
						<p class="help-block">tacacs will wait for <i>seconds</i> before returning a final authentication failure (password incorrect) message, default: 1 second</p>
						<input type="hidden" name="backoff_native" value="">
					</div>
				</div>
				<div class="col-sm-4">
					<div class="form-group separation_tag">
						<label>Separation Tag</label>
						<input type="text" class="form-control separation_tag" name="separation_tag" data-type="input" data-default="" data-pickup="true" placeholder="Separation Tag">
						<p class="help-block">separation tag used to separate users and groups, by default <i>*</i> </p>
						<input type="hidden" name="separation_tag_native" value="">
					</div>
				</div>
				</div>
				<hr>
				<h3>Miscellaneous</h3>
				<div class="row">
				<div class="col-sm-4">
					<div class="form-group">
			      <label>Skip conflicting groups</label><p class="empty-paragraph"></p>
			      <input class="bootstrap-toggle" name="skip_conflicting_groups" data-type="checkbox" data-default="checked" data-pickup="true" data-width="100" data-toggle="toggle" type="checkbox" data-on="<i class='fa fa-check'></i> Yes" data-off="<i class='fa fa-close'></i> No" data-onstyle="success" data-offstyle="warning" checked>
						<input type="hidden" name="skip_conflicting_groups_native">
			    </div>
				</div>
				<div class="col-sm-4">
					<div class="form-group">
			      <label>Skip missing groups</label><p class="empty-paragraph"></p>
			      <input class="bootstrap-toggle" name="skip_missing_groups" data-type="checkbox" data-default="checked" data-pickup="true" data-width="100" data-toggle="toggle" type="checkbox" data-on="<i class='fa fa-check'></i> Yes" data-off="<i class='fa fa-close'></i> No" data-onstyle="success" data-offstyle="warning" checked>
						<input type="hidden" name="skip_missing_groups_native">
			    </div>
				</div>
				</div>
				<hr>
				<h3>Limits and Timeouts</h3>
				<div class="row">
				<div class="col-sm-4">
					<div class="form-group connection_timeout">
						<label>Connection Timeout</label>
						<input type="number" class="form-control" name="connection_timeout" data-type="input" data-default="" data-pickup="true" placeholder="Enter Connection Timeout">
						<p class="help-block">terminate a connection to a NAS after an idle period of at least <i>s</i> seconds, default: 600 seconds</p>
						<input type="hidden" name="connection_timeout_native" value="">
					</div>
				</div>
				<div class="col-sm-4">
					<div class="form-group context_timeout">
						<label>Context Timeout</label>
						<input type="number" class="form-control" name="context_timeout" data-type="input" data-default="" data-pickup="true" placeholder="Enter Context Timeout">
						<p class="help-block">clears context cache entries after <i>s</i> seconds of inactivity, default: 3600 seconds</p>
						<input type="hidden" name="context_timeout_native" value="">
					</div>
				</div>
				</div>
				<hr>
				<h3>Reports Settings</h3>
				<small class="text-red">be careful with those settings! it influences on log parser script!</small>
				<div class="row">
				<div class="col-sm-4">
					<div class="form-group authentication">
						<label>Authentication</label>
						<input type="text" class="form-control" name="authentication" data-type="input" data-default="" data-pickup="true" placeholder="Enter Authentication Settings">
						<p class="help-block">here you can set path to file on the server, command or syslog server ip and port, <text class="text-red">by default it used for Log Parser script</text></p>
						<input type="hidden" name="authentication_native" value="">
					</div>
				</div>
				<div class="col-sm-4">
					<div class="form-group authorization">
						<label>Authorization</label>
						<input type="text" class="form-control" name="authorization" data-type="input" data-default="" data-pickup="true" placeholder="Enter Authorization Settings">
						<p class="help-block">here you can set path to file on the server, command or syslog server ip and port, <text class="text-red">by default it used for Log Parser script</text></p>
						<input type="hidden" name="authorization_native" value="">
					</div>
				</div>
				<div class="col-sm-4">
					<div class="form-group accounting">
						<label>Accounting</label>
						<input type="text" class="form-control" name="accounting" data-type="input" data-default="" data-pickup="true" placeholder="Enter Accounting Settings">
						<p class="help-block">here you can set path to file on the server, command or syslog server ip and port, <text class="text-red">by default it used for Log Parser script</text></p>
						<input type="hidden" name="accounting_native" value="">
					</div>
				</div>
				</div>
				<!--<div class="row">
				<div class="col-sm-4">
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
						<textarea rows="9" class="form-control" name="manual" data-type="input" data-default="" data-pickup="true" placeholder="Manual configuration"></textarea>
						<textarea name="manual_native" value="" style="display: none"></textarea>
					</div>
				</div>
				</div>
				<hr>
				<div class="row">
					<div class="col-lg-4 col-lg-offset-4 col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3 col-xs-8 col-xs-offset-2">
						<button type="button" class="btn btn-block btn-warning btn-flat" onclick="tgui_tacGlobal.edit()">Apply Global Settings</button>
					</div>
				</div>
				<!-- <div class="row"><div class="col-xs-12"><p class="text-muted pull-right">Last update was: <lastupdate></lastupdate></p></div></div> -->
			</form>
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
<!-- iCheck -->
<script src="/plugins/iCheck/icheck.min.js"></script>
	<!-- main Object -->
  <script src="dist/js/pages/tac_global_settings/tgui_tacGlobal.js"></script>
	<!-- main js Device MAIN Functions -->
  <script src="dist/js/pages/tac_global_settings/main.js"></script>
<!-- ADDITIONAL JS FILES END-->
</body>

</html>
