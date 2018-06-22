<!DOCTYPE html>
<!---->
<?php
///CONFIGURATION FILE///
require __DIR__ . '/config.php';
///PAGE VARIABLES///START
$PAGE_HEADER = 'Tacacs Configuration File';
$PAGE_SUBHEADER = 'Here you can see configuration file, test and apply configuration';
$PAGE_TITLE = 'TacacsGUI';
$PAGE_SUBTITLE = 'Tacacs Configuration File';
$BREADCRUMB = array(
	'Tacacs' => [
		'name' => 'Tacacs',
		'href' => '',
		'icon' => 'fa fa-cogs',
		'class' => ''  //last item should have active class!!
	],
	'Devices' => [
		'name' => 'Configuration File',
		'href' => '',
		'icon' => 'fa fa-cog', //leave empty if you won't put icon
		'class' => 'active' //last item should have active class!!
	]
);
///!!!!!////
$ACTIVE_MENU_ID=40;
$ACTIVE_SUBMENU_ID=420;
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

	<!-- Custom Style -->
	<link rel="stylesheet" href="/dist/css/pages/tac_configuration/main.css">
	<link rel="stylesheet" href="/dist/css/pages/tac_configuration/theme-stripped.css">
</head>
<!--ADDITIONAL CSS FILES END-->

<?php

require __DIR__ . '/templates/body_start.php';

?>
<!--MAIN CONTENT START-->
<div class="row">
	<div class="col-md-12">
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title">Test and Apply Tacacs Configuration</h3>
			</div>
			<!-- /.box-header -->
			<!-- form start -->
			<div class="box-body">
				<div class="row">
				<div class="col-md-3">
					<div class="form-group"><a class="btn btn-app bg-green" onclick="tgui_configEngine.testConf()">
						<i class="fa fa-gears"></i> Test
					</a>
					<a class="btn btn-app bg-orange" onclick="tgui_configEngine.applyConf()">
						<i class="fa fa-save"></i> Apply
					</a></div>
					</br>
					<div class="form-group icheck"><input type="checkbox" class="doBackup from-control" checked> Make backup after applying</div>
				</div>
				<div class="col-md-9">
					<ul class="timeline">
						<!-- timeline time label -->
						<li class="time-label">
							<span class="configurationStatus bg-gray">Loading...</span>
						</li>
						<!-- /.timeline-label -->
						<!-- timeline item -->
						<li class="testConfigurationItem">
						<i class="fa fa-gears bg-gray testIcon"></i>

						<div class="timeline-item">
							<!-- <span class="time"><i class="fa fa-clock-o"></i> 12:05</span> -->

							<h3 class="timeline-header">Test configuration
								<i class="fa fa-check text-green testSuccess" style="display:none"></i>
								<i class="fa fa-times-circle text-red testError" style="display:none"></i>
							</h3>

							<div class="timeline-body testItemBody">
								Output of test will appear here...
							</div>
							<!--<div class="timeline-footer">
							<a class="btn btn-primary btn-xs">Read more</a>
							<a class="btn btn-danger btn-xs">Delete</a>
							</div>-->
						</div>
						</li>
						<!-- END timeline item -->
						<!-- timeline item -->
						<li class="applyConfigurationItem">
						<i class="fa fa-save bg-gray applyIcon"></i>

						<div class="timeline-item">
							<!-- <span class="time"><i class="fa fa-clock-o"></i> 5 mins ago</span> -->

							<h3 class="timeline-header no-border">Apply and Save Configuration
								<i class="fa fa-check text-green applySuccess" style="display:none"></i>
								<i class="fa fa-times-circle text-red applyError" style="display:none"></i>
							</h3>
							<div class="timeline-body applyItemBody">
								Output of the save process will appear here...
							</div>
						</div>
						</li>
						<!-- END timeline item -->
						<li class="endOfTimeine">
							<i class="fa fa-clock-o bg-gray"></i>
						</li>
					</ul>
				</div>
				</div>
			</div>
		</div>
	</div>
</div>

<pre class="configurationFile line-numbers language-none">
Loading...
</pre>
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

	<!-- main js User MAIN Functions -->
  <script src="dist/js/pages/tac_configuration/tgui_configEngine.js"></script>
	<!-- main js User MAIN Functions -->
  <script src="dist/js/pages/tac_configuration/main.js"></script>
<!-- ADDITIONAL JS FILES END-->
</body>

</html>
