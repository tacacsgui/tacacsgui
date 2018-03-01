<!DOCTYPE html>
<!---->
<?php
///CONFIGURATION FILE///
require __DIR__ . '/config.php';
///PAGE VARIABLES///START
$PAGE_HEADER = 'Users of GUI';
$PAGE_SUBHEADER = 'Here you can do some manipulation of api users';
$PAGE_TITLE = 'TacacsGUI';
$PAGE_SUBTITLE = 'Users of GUI';
$BREADCRUMB = array(
	'Home' => [
		'name' => 'Administration', 
		'href' => '', 
		'icon' => 'fa fa-cog', 
		'class' => ''  //last item should have active class!!
	], 
	'Template' => [
		'name' => 'Users', 
		'href' => '', 
		'icon' => 'fa fa-user', //leave empty if you won't put icon
		'class' => 'active' //last item should have active class!!
	]
);
///!!!!!////
$ACTIVE_MENU_ID=1000;
$ACTIVE_SUBMENU_ID=1010;
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
				<h3 class="box-title">Tacacs GUI Users</h3>
				<div class="dropdown pull-right">
					<a class="btn btn-flat btn-success" id="addUserBtn" data-toggle="modal" data-target="#addUser">+ Add User</a>
					<a class="btn btn-flat btn-info" id="filterButton">Filter</a>
				</div>
			</div><!-- /.box-header -->
			<div class="box-body">
				<div class="table-responsive">
					<table id="usersDataTable" class="table-striped display table table-bordered" style="overflow: auto;">
	
					</table>	
				</div>
			</div><!-- /.box-body -->
		</div><!-- /.box --> 
	</div><!-- /.col -->
</div><!-- /.row -->

<!--MAIN CONTENT END-->

<?php 

require __DIR__ . '/templates/pages/api_users/modalAddUser.php'; 

?>

<?php 

require __DIR__ . '/templates/pages/api_users/modalEditUser.php'; 

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
	<!-- Select2 -->
	<script src="bower_components/select2/dist/js/select2.full.min.js"></script>
	
	
	<!-- main js User MAIN Functions -->
    <script src="dist/js/pages/api_users/main.js"></script>
	<!-- DATATABLES MAIN -->
    <script src="dist/js/pages/api_users/datatables.js"></script>
<!-- ADDITIONAL JS FILES END-->
</body>

</html>