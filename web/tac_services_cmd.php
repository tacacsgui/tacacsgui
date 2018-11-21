<!DOCTYPE html>
<!---->
<?php
///CONFIGURATION FILE///
require __DIR__ . '/config.php';
///PAGE VARIABLES///START
$PAGE_HEADER = 'Tacacs CMD Attributes';
$PAGE_SUBHEADER = 'Here you can add cmd attributes to control user access';
$PAGE_TITLE = 'TacacsGUI';
$PAGE_SUBTITLE = 'Tacacs CMD Attributes';
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
		'name' => 'CMD Attributes',
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

	<!-- dropdown-submenu -->
	<link rel="stylesheet" href="/dist/css/dropdown-submenu.css">
	<!-- tgui_sortable -->
	<link rel="stylesheet" href="/dist/css/tgui_sortable.css">

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
				$addBtn = ['name'=>'+ Add CMD', 'id' => 'addCMDBtn', 'modalId' => '#addCMD',
				'html' => '<div class="btn-group">
                  <button type="button" class="btn btn-success btn-flat" data-toggle="modal" data-target="#addCMD">+ Add CMD</button>
                  <button type="button" class="btn btn-success btn-flat dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    <span class="caret"></span>
                    <span class="sr-only">Toggle Dropdown</span>
                  </button>
                  <ul class="dropdown-menu" role="menu">
                    <li><a href="#" data-toggle="modal" data-target="#addCMD" >Cisco Type</a></li>
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
$jsMainObjName = 'tgui_service';
require __DIR__ . '/templates/parts/part_csvParser.php';

?>
<!--MAIN CONTENT END-->

<?php

require __DIR__ . '/templates/pages/tac_services_cmd/modalAddCMD.php';

?>

<?php

require __DIR__ . '/templates/pages/tac_services_cmd/modalEditCMD.php';

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
