<!DOCTYPE html>
<!---->
<?php
///CONFIGURATION FILE///
require __DIR__ . '/config.php';
///PAGE VARIABLES///START
$PAGE_HEADER = 'Tacacs Command Sets';
$PAGE_SUBHEADER = 'Here you can add command sets to control user access';
$PAGE_TITLE = 'TacacsGUI';
$PAGE_SUBTITLE = 'Tacacs Command Sets';
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
	'autho' => [
		'name' => 'Authorisation Rules',
		'href' => '',
		'icon' => 'fa fa-lock', //leave empty if you won't put icon
		'class' => '' //last item should have active class!!
	],
	'cmd' => [
		'name' => 'Command Sets',
		'href' => '',
		'icon' => '', //leave empty if you won't put icon
		'class' => 'active' //last item should have active class!!
	]
);
///!!!!!////
$ACTIVE_MENU_ID=[50,520,528];
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
	<!-- bootstrap-tagsinput -->
	<link rel="stylesheet" href="plugins/bootstrap-tagsinput/bootstrap-tagsinput.css">

	<!-- dropdown-submenu -->
	<link rel="stylesheet" href="/dist/css/dropdown-submenu.css">
	<!-- tgui_sortable -->
	<link rel="stylesheet" href="/dist/css/tgui_sortable.css">
	<!-- page-main -->
	<link rel="stylesheet" href="/dist/css/pages/tac_service_cmd/main.css">

<!--ADDITIONAL CSS FILES END-->

<?php

require __DIR__ . '/templates/body_start.php';

?>

<!--MAIN CONTENT START-->

<div class="row">
	<div class="col-xs-12">
		<div class="box box-primary">
			<div class="box-header">
				<h3 class="box-title">Tacacs Command Sets <small>type: <cmdType></cmdType></small></h3>
			</div><!-- /.box-header -->
			<div class="box-body">
				<?php
				$addBtn = ['name'=>'+ Add CMD', 'id' => 'addCMDBtn', 'modalId' => '#addCMD',
				'html' => '<div class="btn-group">
                  <button type="button" class="btn btn-success btn-flat" onclick="tgui_cmd.selectType(255, true); return false;">+ Add CMD</button>
                  <button type="button" class="btn btn-success btn-flat dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    <span class="caret"></span>
                    <span class="sr-only">Toggle Dropdown</span>
                  </button>
                  <ul class="dropdown-menu" role="menu">
                    <li><a href="#" onclick="tgui_cmd.selectType(0, true); return false;" >General Type</a></li>
                    <li><a href="#" onclick="tgui_cmd.selectType(1, true); return false;" >Juniper Type</a></li>
                  </ul>
                </div>'
				];
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
					<table id="mainDataTable" class="table-striped display table table-bordered" style="overflow: auto;">

					</table>
				</div>
			</div><!-- /.box-body -->
		</div><!-- /.box -->
	</div><!-- /.col -->
</div><!-- /.row -->
<?php
$jsMainObjName = 'tgui_cmd';
require __DIR__ . '/templates/parts/part_csvParser.php';

?>
<!--MAIN CONTENT END-->

<?php

require __DIR__ . '/templates/pages/tac_services_cmd/modalAddCMD.php';
require __DIR__ . '/templates/pages/tac_services_cmd/modalAddCMD_Junos.php';

?>

<?php

require __DIR__ . '/templates/pages/tac_services_cmd/modalEditCMD.php';
require __DIR__ . '/templates/pages/tac_services_cmd/modalEditCMD_Junos.php';

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
	<script src="plugins/bootstrap-tagsinput/bootstrap-tagsinput.js"></script>

	<script src="plugins/jquery-csv/jquery-csv.min.js"></script>
	<script src="plugins/jQueryUI/jquery-ui.min.js"></script>

	<!-- tgui_device_patterns Object
  <script src="dist/js/tgui_device_patterns.js"></script>-->
	<!-- tgui_sortable Object -->
  <script src="dist/js/tgui_sortable.js"></script>
	<!-- tgui_csvParser Object -->
  <script src="dist/js/tgui_csvParser.js"></script>
	<!-- main Object -->
  <script src="dist/js/pages/tac_services_cmd/tgui_cmd.js"></script>
	<!-- DATATABLES MAIN -->
  <script src="dist/js/tgui_datatables.js"></script>
	<!-- DATATABLES MAIN -->
  <script src="dist/js/pages/tac_services_cmd/datatables.js"></script>

	<!-- main js tac cmd attributes MAIN Functions -->
  <script src="dist/js/pages/tac_services_cmd/main.js"></script>
<!-- ADDITIONAL JS FILES END-->
</body>
</html>
