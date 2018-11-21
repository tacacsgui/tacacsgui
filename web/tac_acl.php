<!DOCTYPE html>
<!---->
<?php
///CONFIGURATION FILE///
require __DIR__ . '/config.php';
///PAGE VARIABLES///START
$PAGE_HEADER = 'Tacacs ACLs';
$PAGE_SUBHEADER = 'Here you can add Access Control Lists';
$PAGE_TITLE = 'TacacsGUI';
$PAGE_SUBTITLE = 'Tacacs ACLs';
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
	'ACLs' => [
		'name' => 'ACLs',
		'href' => '',
		'icon' => '', //leave empty if you won't put icon
		'class' => 'active' //last item should have active class!!
	]
);
///!!!!!////
$ACTIVE_MENU_ID=[50,510];
$ACTIVE_SUBMENU_ID=510;
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
	<!-- Select2 -->
	<link rel="stylesheet" href="bower_components/select2/dist/css/select2.min.css">
	<style>
		#prefix_slider .slider-selection{
			background:#444;
		}
	</style>
	<style>
	.blockAnimation
	{
		animation:bg 3s ease-in;
		-webkit-animation:bg 3s ease-in;
		-moz-animation:bg 3s ease-in;
		-ms-animation:bg 3s ease-in;
		-o-animation:bg 3s ease-in;
	}
	@-webkit-keyframes bg {
		0%{
			background:rgba(221,75,57,1)
		}
		20%{
			background:rgba(221,75,57,0.8)
		}
		50% 70%{
			background:rgba(221,75,57,0.5)
		}
		100%{
			background:rgba(221,75,57,0)
		}
	}
	@-moz-keyframes bg {
		0%{
			background:rgba(221,75,57,1)
		}
		20%{
			background:rgba(221,75,57,0.8)
		}
		50% 70%{
			background:rgba(221,75,57,0.5)
		}
		100%{
			background:rgba(221,75,57,0)
		}
	}
	@-ms-keyframes bg {
		0%{
			background:rgba(221,75,57,1)
		}
		20%{
			background:rgba(221,75,57,0.8)
		}
		50% 70%{
			background:rgba(221,75,57,0.5)
		}
		100%{
			background:rgba(221,75,57,0)
		}
	}
	@-o-keyframes bg {
		0%{
			background:rgba(221,75,57,1)
		}
		20%{
			background:rgba(221,75,57,0.8)
		}
		50% 70%{
			background:rgba(221,75,57,0.5)
		}
		100%{
			background:rgba(221,75,57,0)
		}
	}
	@media (min-width: 992px){
		.modal-lg {
			width: 1000px;
		}
	}
</style>
<!--ADDITIONAL CSS FILES END-->

<?php

require __DIR__ . '/templates/body_start.php';

?>
<!--MAIN CONTENT START-->

<div class="row">
	<div class="col-xs-12">
		<div class="box box-primary">
			<div class="box-header">
				<h3 class="box-title">Tacacs ACLs</h3>
			</div><!-- /.box-header -->
			<div class="box-body">
				<?php
				$addBtn = ['name'=>'+ Add ACL', 'id' => 'addACLBtn', 'modalId' => '#addACL'];
				$filterBtn = true;
				$filterHint = 'e.g. name=group1, id=1';
				$filterPopover =
				[
					'name' => 'Name',
					'id' => 'ID',
				];
				$extraBtn = ['exportCsv' => true, 'delete' => true];
				require __DIR__ . '/templates/parts/part_tableManager.php';

				?>

				<div class="table-responsive">
					<table id="aclDataTable" class="table-striped display table table-bordered" style="overflow: auto;">

					</table>
				</div>
			</div><!-- /.box-body -->
		</div><!-- /.box -->
	</div><!-- /.col -->
</div><!-- /.row -->
<?php
$jsMainObjName = 'tgui_acl';
require __DIR__ . '/templates/parts/part_csvParser.php';

?>
<!--MAIN CONTENT END-->

<?php

require __DIR__ . '/templates/pages/tac_acl/modalAddACL.php';

?>

<?php

require __DIR__ . '/templates/pages/tac_acl/modalEditACL.php';

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
	<!-- Select2 -->
	<script src="bower_components/select2/dist/js/select2.full.min.js"></script>
	<!-- jquery-csv -->
	<script src="plugins/jquery-csv/jquery-csv.min.js"></script>

	<!-- tgui_csvParser Object -->
  <script src="dist/js/tgui_csvParser.js"></script>

	<script src="dist/js/pages/tac_acl/datatables_acl_add.js"></script>
	<script src="dist/js/pages/tac_acl/datatables_acl_edit.js"></script>
	<!-- main Object -->
  <script src="dist/js/pages/tac_acl/tgui_acl.js"></script>
	<!-- DATATABLES MAIN -->
  <script src="dist/js/tgui_datatables.js"></script>
	<!-- DATATABLES MAIN -->
	<script src="dist/js/pages/tac_acl/datatables.js"></script>

	<!-- main js User MAIN Functions -->
  <script src="dist/js/pages/tac_acl/main.js"></script>
<!-- ADDITIONAL JS FILES END-->
</body>
</html>
