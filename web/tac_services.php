<!DOCTYPE html>
<!---->
<?php
///CONFIGURATION FILE///
require __DIR__ . '/config.php';
///PAGE VARIABLES///START
$PAGE_HEADER = 'Tacacs Services';
$PAGE_SUBHEADER = 'Here you can add services and attributes to control access';
$PAGE_TITLE = 'TacacsGUI';
$PAGE_SUBTITLE = 'Tacacs Services';
$BREADCRUMB = array(
	'Tacacs' => [
		'name' => 'Tacacs',
		'href' => '',
		'icon' => 'fa fa-cogs',
		'class' => ''  //last item should have active class!!
	],
	'access_rules' => [
		'name' => 'Access Rules',
		'href' => '',
		'icon' => 'fa fa-exchange', //leave empty if you won't put icon
		'class' => '' //last item should have active class!!
	],
	'Services' => [
		'name' => 'Services',
		'href' => '',
		'icon' => '', //leave empty if you won't put icon
		'class' => 'active' //last item should have active class!!
	]
);
///!!!!!////
$ACTIVE_MENU_ID=50;
$ACTIVE_SUBMENU_ID=520;
///!!!!!////
///PAGE VARIABLES///END
?>

<html>

<?php
require __DIR__ . '/templates/header.php';
?>
<!--ADDITIONAL CSS FILES START-->
	<!-- DataTables Select-->
	<link rel="stylesheet" href="bower_components/datatables.net/css/select.dataTables.min.css">
	<!-- DataTables -->
	<link rel="stylesheet" href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
	<!-- iCheck -->
	<link rel="stylesheet" href="/plugins/iCheck/square/blue.css">
<!--ADDITIONAL CSS FILES END-->

<?php

require __DIR__ . '/templates/body_start.php';

?>
<!--MAIN CONTENT START-->

<div class="row">
	<div class="col-xs-12">
		<div class="box box-primary">
			<div class="box-header">
				<h3 class="box-title">Tacacs Services</h3>
			</div><!-- /.box-header -->
			<div class="box-body">
				<?php
				$addBtn = ['name'=>'+ Add Service', 'id' => 'addServiceBtn', 'modalId' => '#addService'];
				$filterBtn = true;
				$filterHint = 'e.g. name=service1, id=1';
				$filterPopover =
				[
					'name' => 'Name',
					'id' => 'ID',
				];
				$extraBtn = ['exportCsv' => true, 'delete' => true];
				require __DIR__ . '/templates/parts/part_tableManager.php';

				?>
				<div class="table-responsive">
					<table id="servicesDataTable" class="table-striped display table table-bordered" style="overflow: auto;">

					</table>
				</div>
			</div><!-- /.box-body -->
		</div><!-- /.box -->
	</div><!-- /.col -->
</div><!-- /.row -->
<?php
$jsMainObjName = 'tgui_service';
require __DIR__ . '/templates/parts/part_csvParser.php';

?>
<!--MAIN CONTENT END-->

<?php

require __DIR__ . '/templates/pages/tac_services/modalAddService.php';

?>

<?php

require __DIR__ . '/templates/pages/tac_services/modalEditService.php';

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
	<script src="bower_components/datatables.net/js/dataTables.select.min.js"></script>
	<script src="bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
	<!-- iCheck -->
	<script src="/plugins/iCheck/icheck.min.js"></script>
	<script src="plugins/jquery-csv/jquery-csv.min.js"></script>

	<!-- tgui_csvParser Object -->
  <script src="dist/js/tgui_csvParser.js"></script>
	<!-- main Object -->
  <script src="dist/js/pages/tac_services/tgui_service.js"></script>
	<!-- DATATABLES MAIN -->
  <script src="dist/js/tgui_datatables.js"></script>
	<!-- DATATABLES MAIN -->
  <script src="dist/js/pages/tac_services/datatables.js"></script>

	<!-- main js tac services MAIN Functions -->
  <script src="dist/js/pages/tac_services/main.js"></script>
<!-- ADDITIONAL JS FILES END-->
</body>
</html>
