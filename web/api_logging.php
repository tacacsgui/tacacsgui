<!DOCTYPE html>
<!---->
<?php
///CONFIGURATION FILE///
require __DIR__ . '/config.php';
///PAGE VARIABLES///START
$PAGE_HEADER = 'API Logging';
$PAGE_SUBHEADER = 'here you can track all users actions';
$PAGE_TITLE = 'TacacsGUI';
$PAGE_SUBTITLE = 'API Logging';
$BREADCRUMB = array(
	'Logging' => [
		'name' => 'API Logging',
		'href' => '',
		'icon' => 'fa fa-search',
		'class' => ''  //last item should have active class!!
	]
);
///!!!!!////
$ACTIVE_MENU_ID=[1100];
$ACTIVE_SUBMENU_ID=0;
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

<!--ADDITIONAL CSS FILES END-->

<?php

require __DIR__ . '/templates/body_start.php';

?>
<!--MAIN CONTENT START-->

<div class="row">
	<div class="col-xs-12">
		<div class="box box-primary">
			<div class="box-header">
				<h3 class="box-title">API Logging</h3>
			</div><!-- /.box-header -->
			<div class="box-body">
				<?php
				$addBtn = [];
				$filterBtn = true;
				$filterHint = 'e.g. username=user1, section=auth';
				$filterPopover =
				[
					'username' => 'Username',
					'section' => 'Section',
					'action' => 'Action',
					'message' => 'Message',
					'id' => 'ID',
				];
				$extraBtn = ['exportCsv' => true, 'delete' => false];
				require __DIR__ . '/templates/parts/part_tableManager.php';

				?>
				<div class="table-responsive">
					<table id="apiLoggingDataTable" class="table-striped display table table-bordered" style="overflow: auto;">

					</table>
				</div>
			</div><!-- /.box-body -->
		</div><!-- /.box -->
	</div><!-- /.col -->
</div><!-- /.row -->

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

	<!-- DATATABLES MAIN -->
  <script src="dist/js/tgui_datatables.js"></script>
	<!-- DATATABLES MAIN -->
  <script src="dist/js/pages/api_logging/datatables.js"></script>

<!-- ADDITIONAL JS FILES END-->
</body>
</html>
