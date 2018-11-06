<!DOCTYPE html>
<!---->
<?php
///CONFIGURATION FILE///
require __DIR__ . '/config.php';
///PAGE VARIABLES///START
$PAGE_HEADER = 'Tacacs Users';
$PAGE_SUBHEADER = 'Subheader Template';
$PAGE_TITLE = 'TacacsGUI';
$PAGE_SUBTITLE = 'Tacacs Users';
$BREADCRUMB = array(
	'Tacacs' => [
		'name' => 'Tacacs',
		'href' => '',
		'icon' => 'fa fa-cogs',
		'class' => ''  //last item should have active class!!
	],
	'Users' => [
		'name' => 'Users',
		'href' => '',
		'icon' => 'fa fa-child', //leave empty if you won't put icon
		'class' => 'active' //last item should have active class!!
	]
);
///!!!!!////
$ACTIVE_MENU_ID=30;
$ACTIVE_SUBMENU_ID=310;
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
	<!-- Select2 -->
	<link rel="stylesheet" href="bower_components/select2/dist/css/select2.min.css">
	<!-- bootstrap-datetimepicker -->
	<link rel="stylesheet" href="plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css">

<!--ADDITIONAL CSS FILES END-->

<?php

require __DIR__ . '/templates/body_start.php';
?>
<!--MAIN CONTENT START-->

<div class="row">
	<div class="col-xs-12">
		<div class="box box-primary">
			<div class="box-header">
				<h3 class="box-title">Tacacs Users</h3>
			</div><!-- /.box-header -->
			<div class="box-body">
				<?php
				$addBtn = ['name'=>'+ Add User', 'id' => 'addUserBtn', 'modalId' => '#addUser'];
				$filterBtn = true;
				$filterHint = 'e.g. username=user1, group=1';
				$filterPopover =
				[
					'username' => 'Username',
					'id' => 'ID',
					'group' => 'Group ID',
				];
				$extraBtn = ['exportCsv' => true, 'delete' => true];
				require __DIR__ . '/templates/parts/part_tableManager.php';

				?>

				<div class="table-responsive">
					<table id="usersDataTable" class="table-striped display table table-bordered" style="overflow: auto;">

					</table>
				</div>
			</div><!-- /.box-body -->
		</div><!-- /.box -->
	</div><!-- /.col -->
</div><!-- /.row -->
<?php
$jsMainObjName = 'tgui_tacUser';
require __DIR__ . '/templates/parts/part_csvParser.php';

?>
<!--MAIN CONTENT END-->

<?php

require __DIR__ . '/templates/pages/tac_users/modalAddUser.php';

?>

<?php

require __DIR__ . '/templates/pages/tac_users/modalEditUser.php';

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
	<!-- Select2 -->
	<script src="bower_components/select2/dist/js/select2.full.min.js"></script>
	<!-- jquery-csv -->
	<script src="plugins/jquery-csv/jquery-csv.min.js"></script>
	<!-- jquery-qrcode -->
	<script src="plugins/qrcode/jquery.qrcode.min.js"></script>
	<!-- moment -->
	<script src="bower_components/moment/moment.js"></script>
	<!-- bootstrap-datetimepicker -->
	<script src="plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js"></script>
	<!-- tgui_expander -->
	<script src="dist/js/tgui_expander.js"></script>

	<!-- Select2 Object -->
	<script src="dist/js/tgui_select2.js"></script>
	<!-- tgui_csvParser Object -->
  <script src="dist/js/tgui_csvParser.js"></script>
	<!-- MAIN Object-->
  <script src="dist/js/pages/tac_users/tgui_tacUser.js"></script>
	<!-- DATATABLES MAIN -->
  <script src="dist/js/tgui_datatables.js"></script>
	<!-- DATATABLES MAIN -->
  <script src="dist/js/pages/tac_users/datatables.js"></script>

  <script src="dist/js/pages/tac_users/main.js"></script>
<!-- ADDITIONAL JS FILES END-->
</body>
</html>
