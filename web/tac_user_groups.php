<!DOCTYPE html>
<!---->
<?php
///CONFIGURATION FILE///
require __DIR__ . '/config.php';
///PAGE VARIABLES///START
$PAGE_HEADER = 'Tacacs User Groups';
$PAGE_SUBHEADER = 'Subheader Template';
$PAGE_TITLE = 'TacacsGUI';
$PAGE_SUBTITLE = 'Tacacs User Groups';
$BREADCRUMB = array(
	'Tacacs' => [
		'name' => 'Tacacs',
		'href' => '',
		'icon' => 'fa fa-cogs',
		'class' => ''  //last item should have active class!!
	],
	'Groups' => [
		'name' => 'User Groups',
		'href' => '',
		'icon' => 'fa fa-users', //leave empty if you won't put icon
		'class' => 'active' //last item should have active class!!
	]
);
///!!!!!////
$ACTIVE_MENU_ID=30;
$ACTIVE_SUBMENU_ID=320;
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
	<!-- Select2 -->
	<link rel="stylesheet" href="bower_components/select2/dist/css/select2.min.css">

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
				<h3 class="box-title">Tacacs User Groups</h3>
				<div class="dropdown pull-right">
					<a class="btn btn-flat btn-success" id="addGroupBtn" data-toggle="modal" data-target="#addGroup">+ Add Group</a>
					<a class="btn btn-flat btn-info" id="filterButton">Filter</a>
				</div>
			</div><!-- /.box-header -->
			<div class="box-body">
				<div class="table-responsive">
					<table id="userGroupsDataTable" class="table-striped display table table-bordered" style="overflow: auto;">

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

require __DIR__ . '/templates/pages/tac_user_groups/modalAddGroup.php';

?>

<?php

require __DIR__ . '/templates/pages/tac_user_groups/modalEditGroup.php';

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
	<!-- Select2 -->
	<script src="bower_components/select2/dist/js/select2.full.min.js"></script>


	<!-- main js User Groups MAIN Functions -->
		<!-- Select2 Object -->
		<script src="dist/js/tgui_select2.js"></script>
		<!-- main Object -->
    <script src="dist/js/pages/tac_user_groups/tgui_tacUserGrp.js"></script>
		<!-- DATATABLES MAIN -->
    <script src="dist/js/pages/tac_user_groups/datatables.js"></script>
		<!-- MAIN Script-->
    <script src="dist/js/pages/tac_user_groups/main.js"></script>


<!-- ADDITIONAL JS FILES END-->
</body>

</html>
