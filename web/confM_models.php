<!DOCTYPE html>
<?php
///CONFIGURATION FILE///
require __DIR__ . '/config.php';
///PAGE VARIABLES///START
$PAGE_HEADER = 'Configuration Manager. Models';
$PAGE_SUBHEADER = 'the list of models used for queries';
$PAGE_TITLE = 'TacacsGUI';
$PAGE_SUBTITLE = 'Configuration Manager. Models';
$BREADCRUMB = array(
	'confM' => [
		'name' => 'Configuration Manager',
		'href' => '',
		'icon' => 'fa fa-copy',
		'class' => ''  //last item should have active class!!
	],
	'confM_main' => [
		'name' => 'Models',
		'href' => '',
		'icon' => '', //leave empty if you won't put icon
		'class' => '' //last item should have active class!!
	],
);
///!!!!!////
$ACTIVE_MENU_ID=[1300,1320,1325];
#$ACTIVE_SUBMENU_ID=525;
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

	<!-- main -->
	<link rel="stylesheet" href="/dist/css/pages/confM_/models/main.css">
<!--ADDITIONAL CSS FILES END-->

<?php

require __DIR__ . '/templates/body_start.php';

?>
<!--MAIN CONTENT START-->
<div class="row">
	<div class="col-xs-12">
		<div class="box box-primary">
			<div class="box-header">
				<h3 class="box-title">Models Table</h3>
			</div><!-- /.box-header -->
			<div class="box-body">
				<?php
				$addBtn = ['name'=>'+ Add Model', 'id' => 'addModelBtn', 'modalId' => '#addModel'];
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
					<table id="modelsDataTable" class="table-striped display table table-bordered" style="overflow: auto;">

					</table>
				</div>
			</div><!-- /.box-body -->
		</div><!-- /.box -->
	</div><!-- /.col -->
</div><!-- /.row -->

<!--MAIN CONTENT END-->

<?php

require __DIR__ . '/templates/pages/confM_/Models/modalAdd.php';

?>

<?php

require __DIR__ . '/templates/pages/confM_/Models/modalEdit.php';

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
	<script src="plugins/iCheck/icheck.min.js"></script>
	<script src="plugins/js-yaml/js-yaml.min.js"></script>

	<!-- MAIN Object-->
	<script src="dist/js/pages/confM_/models/confM_models.js"></script>
	<!-- DATATABLES MAIN -->
	<script src="dist/js/tgui_datatables.js"></script>

	<!-- DATATABLES MAIN -->
	<script src="dist/js/pages/confM_/models/datatables.js"></script>
	<!-- main js tac services MAIN Functions -->
  <script src="dist/js/pages/confM_/models/main.js"></script>
<!-- ADDITIONAL JS FILES END-->
</body>
</html>
