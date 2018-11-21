<!DOCTYPE html>
<!---->
<?php
///CONFIGURATION FILE///
require __DIR__ . '/config.php';
///PAGE VARIABLES///START
$PAGE_HEADER = 'Notification Settings';
$PAGE_SUBHEADER = 'Notification Log and Settings';
$PAGE_TITLE = 'TacacsGUI';
$PAGE_SUBTITLE = 'Tacacs Notification';
$BREADCRUMB = array(
	'Tacacs' => [
		'name' => 'Tacacs Reports',
		'href' => '',
		'icon' => 'fa fa-cogs',
		'class' => ''  //last item should have active class!!
	],
	'Devices' => [
		'name' => 'Notification',
		'href' => '',
		'icon' => 'fa fa-message', //leave empty if you won't put icon
		'class' => 'active' //last item should have active class!!
	]
);
///!!!!!////
$ACTIVE_MENU_ID=[90,940];
$ACTIVE_SUBMENU_ID=940;
///!!!!!////
///PAGE VARIABLES///END
?>
<html>

<?php
require __DIR__ . '/templates/header.php';
?>
<!--ADDITIONAL CSS FILES START-->

	<!-- DataTables -->
	<link rel="stylesheet" href="bower_components/datatables.net/css/select.dataTables.min.css">
	<link rel="stylesheet" href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
	 <!-- daterange picker -->
	<link rel="stylesheet" href="bower_components/bootstrap-daterangepicker/daterangepicker.css">
	<!-- iCheck -->
	<link rel="stylesheet" href="/plugins/iCheck/square/blue.css">

<!--ADDITIONAL CSS FILES END-->

<?php

require __DIR__ . '/templates/body_start.php';

?>
<!--MAIN CONTENT START-->

<div class="box box-solid">
	<div class="box-body">
		<div class="nav-tabs-custom">
            <ul class="nav nav-tabs notification">
							<li class="active"><a href="#settings" data-toggle="tab" data-section="time">Settings</a></li>
							<li><a href="#log" data-toggle="tab" data-section="smtp">Log</a></li>
              <li><a href="#buffer" data-toggle="tab" data-section="passwords">Buffer</a></li>
            </ul>
            <div class="tab-content">
							<div class="tab-pane active" id="settings">
                <?php include __DIR__ . '/templates/pages/api_notification/tab_settings.php';?>
              </div>
              <!-- /.tab-pane -->
							<div class="tab-pane" id="log">
                <?php include __DIR__ . '/templates/pages/api_notification/tab_log.php';?>
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="buffer">
                <?php include __DIR__ . '/templates/pages/api_notification/tab_buffer.php';?>
              </div>
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>
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

	<!-- DataTables -->
	<script src="bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
	<script src="bower_components/datatables.net/js/dataTables.select.min.js"></script>
	<script src="bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
	<!-- date-range-picker -->
	<script src="bower_components/moment/min/moment.min.js"></script>
	<script src="bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
	<!-- iCheck -->
	<script src="plugins/iCheck/icheck.min.js"></script>

	<!-- DATATABLES MAIN -->
  <script src="dist/js/tgui_datatables.js"></script>
	<!-- DATATABLES MAIN -->
  <script src="dist/js/pages/tac_reports/notification/api_notification.js"></script>
  <script src="dist/js/pages/tac_reports/notification/main.js"></script>

<!-- ADDITIONAL JS FILES END-->
</body>
</html>
