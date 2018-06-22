<!DOCTYPE html>
<!---->
<?php
///CONFIGURATION FILE///
require __DIR__ . '/config.php';
///PAGE VARIABLES///START
$PAGE_HEADER = 'Tacacs Device Groups';
$PAGE_SUBHEADER = 'Subheader Template';
$PAGE_TITLE = 'TacacsGUI';
$PAGE_SUBTITLE = 'Tacacs Device Groups';
$BREADCRUMB = array(
	'Tacacs' => [
		'name' => 'Tacacs',
		'href' => '',
		'icon' => 'fa fa-cogs',
		'class' => ''  //last item should have active class!!
	],
	'Devices' => [
		'name' => 'Device Groups',
		'href' => '',
		'icon' => 'fa fa-server', //leave empty if you won't put icon
		'class' => 'active' //last item should have active class!!
	]
);
///!!!!!////
$ACTIVE_MENU_ID=20;
$ACTIVE_SUBMENU_ID=220;
///!!!!!////
///PAGE VARIABLES///END
?>
<html>

<?php
require __DIR__ . '/templates/header.php';
?>
<!--ADDITIONAL CSS FILES START-->
	<!-- DataTables -->
	<link rel="stylesheet" href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
	<!-- iCheck -->
	<link rel="stylesheet" href="/plugins/iCheck/square/blue.css">
	<style>
	.greenRow{
		background-color: #00800036 !important;
	}
	</style>
</head>
<!--ADDITIONAL CSS FILES END-->

<?php

require __DIR__ . '/templates/body_start.php';

?>
<!--MAIN CONTENT START-->

<div class="row">
	<div class="col-xs-12">
		<div class="box box-primary">
			<div class="box-header">
				<h3 class="box-title">Tacacs Device Groups</h3>
				<div class="dropdown pull-right">
					<a class="btn btn-flat btn-success" id="addGroupBtn" data-toggle="modal" data-target="#addDeviceGroup">+ Add Group</a>
					<a class="btn btn-flat btn-info" id="filterButton">Filter</a>
				</div>
			</div><!-- /.box-header -->
			<div class="box-body">
				<div class="table-responsive">
					<table id="deviceGroupsDataTable" class="table-striped display table table-bordered" style="overflow: auto;">

					</table>
				</div>
			</div><!-- /.box-body -->
		</div><!-- /.box -->
	</div><!-- /.col -->
</div><!-- /.row -->

<!--MAIN CONTENT END-->

<?php

require __DIR__ . '/templates/pages/tac_device_groups/modalAddGroup.php';

?>

<?php

require __DIR__ . '/templates/pages/tac_device_groups/modalEditGroup.php';

?>

<?php

require __DIR__ . '/templates/body_end.php';

?>


<?php

require __DIR__ . '/templates/footer_end.php';

?>
<!-- ADDITIONAL JS FILES START-->

	<!-- DataTables -->
	<script src="bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
	<script src="bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
	<!-- iCheck -->
	<script src="/plugins/iCheck/icheck.min.js"></script>


	<!-- DATATABLES MAIN -->
  <script src="dist/js/pages/tac_device_groups/datatables.js"></script>
	<!-- main Object -->
	<script src="dist/js/pages/tac_device_groups/tgui_devGrp.js"></script>
	<!-- main js User MAIN Functions -->
  <script src="dist/js/pages/tac_device_groups/main.js"></script>

<!-- ADDITIONAL JS FILES END-->
</body>

</html>
