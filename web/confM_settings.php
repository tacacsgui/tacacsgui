<!DOCTYPE html>
<!---->
<?php
///CONFIGURATION FILE///
require __DIR__ . '/config.php';
///PAGE VARIABLES///START
$PAGE_HEADER = 'Configuration Manager. Settings';
$PAGE_SUBHEADER = 'the main settings';
$PAGE_TITLE = 'TacacsGUI';
$PAGE_SUBTITLE = 'Configuration Manager. Settings';
$BREADCRUMB = array(
	'confM' => [
		'name' => 'Configuration Manager',
		'href' => '',
		'icon' => 'fa fa-copy',
		'class' => ''  //last item should have active class!!
	],
	'confM_main' => [
		'name' => 'Settings',
		'href' => '',
		'icon' => '', //leave empty if you won't put icon
		'class' => '' //last item should have active class!!
	],
);
///!!!!!////
$ACTIVE_MENU_ID=[1300,1320,1328];
#$ACTIVE_SUBMENU_ID=525;
///!!!!!////
///PAGE VARIABLES///END
?>

<html>

<?php
require __DIR__ . '/templates/header.php';
?>
<!--ADDITIONAL CSS FILES START-->
<!-- bootstrap-datetimepicker -->
<link rel="stylesheet" href="plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css">
<!--ADDITIONAL CSS FILES END-->

<?php

require __DIR__ . '/templates/body_start.php';

?>
<style media="screen">
	.btn-control {
		min-width: 135px;
		margin-right: 3px;
	}
</style>
<!--MAIN CONTENT START-->

<div class="box box-solid">
  <div class="box-header">
    <h3>Main Settings</h3>
  </div>
  <div class="box-body">
		<div class="row">
			<div class="col-xs-12">
				<a class="btn btn-flat btn-primary btn-lg btn-control ladda-button" data-style="expand-right" onclick="confM_set.toggle('start', this)">
					<span class="ladda-label"><i class="fa fa-play"></i> Start</span>
				</a>
				<a class="btn btn-flat btn-primary btn-lg btn-control ladda-button" data-style="expand-right" onclick="confM_set.toggle('stop', this)">
					<span class="ladda-label"><i class="fa fa-pause"></i> Stop</span>
				</a>
				<!-- <a class="btn btn-app">
					<i class="fa fa-repeat" onclick="confM_set.toggle('reload')"></i> Reload
				</a> -->
				<a class="btn btn-flat btn-primary btn-lg btn-control ladda-button" data-style="expand-right" onclick="confM_set.info(this)">
					<span class="ladda-label"><i class="fa fa-info"></i> Get Status</span>
				</a>
				<a class="btn btn-flat btn-primary btn-lg btn-control ladda-button" data-style="expand-right" onclick="confM_set.toggle('force', this)">
					<span class="ladda-label"><i class="fa fa-rocket"></i> Force Start</span>
				</a>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12">
				<div class="form-group">
					<label>Current Status</label>
					<input type="text" class="form-control" name="deamon_status" disabled="" placeholder="Loading...">
				</div>
			</div>
		</div>
	</div>
</div>
<div class="box box-stripped">
	<div class="box-header">
		<h4>Cron Settings</h4>
	</div>
	<div class="box-body">
		<form id="cronForm">
			<div class="row">
				<div class="col-sm-6 col-md-4">
					<label>Configuration Manager Start</label>
					<div class="form-group">
						<div class="radio">
						  <label><input type="radio" name="cm_period" value="day" checked>every day</label>
						</div>
						<div class="radio">
						  <label><input type="radio" name="cm_period" value="week">every week</label>
						</div>
						<input type="hidden" name="cm_period_native">
					</div>
					<div class="row">
						<div class="col-sm-6">
							<div class="form-group">
				          <div class='input-group date cm_scheduler_time'>
				              <input type='text' class="form-control" />
				              <span class="input-group-addon">
				                  <span class="glyphicon glyphicon-time"></span>
				              </span>
				          </div>
				      </div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<select class="form-control" name="week" data-type="select" data-default="1" data-pickup="true" disabled>
									<option value="1">Monday</option>
									<option value="2">Tuesday</option>
									<option value="3">Wednesday</option>
									<option value="4">Thursday</option>
									<option value="5">Friday</option>
									<option value="6">Saturday</option>
									<option value="0">Sunday</option>
								</select>
								<input type="hidden" name="week_native">
							</div>
						</div>
					</div>
					<p class="help-block">select time when to run configuration manager, time to start collecting data</p>
				</div>
				<div class="col-sm-6 col-md-4">
					<label>Git Commit Start Every</label>
					<div class="form-group">
						<select class="form-control" name="git_period" data-type="select" data-default="60" data-pickup="true">
							<option value="10">10 minutes</option>
							<option value="20">20 minutes</option>
							<option value="30">30 minutes</option>
							<option value="40">40 minutes</option>
							<option value="50">50 minutes</option>
							<option value="60" selected>60 minutes</option>
						</select>
					</div>
					<p class="help-block">select time when configuration manager will check any changes inside of local files (configurations)</p>
				</div>
			</div><!--.row-->
		</form>
	</div><!--.box-body-->
	<div class="box-footer">
		<button class="btn btn-flat btn-warning ladda-button" data-style="expand-right" onclick="confM_set.editCron(this)"><span class="ladda-label">Apply</span></button>
	</div>
</div>
<div class="box box-stripped">
	<div class="box-header">
		<h4>Full Configuration Preview</h4>
	</div>
	<div class="box-body">
		<button class="btn btn-flat btn-warning ladda-button" data-style="expand-right" onclick="confM_set.getPreview(this)"><span class="ladda-label">Get Preview</span></button>
		<hr>
		<pre class="cm-settings-preview">Click Get Preview button to get settings preview.</pre>
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
	<!-- moment -->
	<script src="bower_components/moment/moment.js"></script>
	<!-- bootstrap-datetimepicker -->
	<script src="plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js"></script>
  <!-- main Object -->
  <script src="dist/js/pages/confM_/settings/confM_settings.js"></script>
	<!-- main js MAIN Functions -->
  <script src="dist/js/pages/confM_/settings/main.js"></script>
<!-- ADDITIONAL JS FILES END-->
</body>
</html>
