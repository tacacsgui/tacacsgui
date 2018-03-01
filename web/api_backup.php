<!DOCTYPE html>
<!---->
<?php
///CONFIGURATION FILE///
require __DIR__ . '/config.php';
///PAGE VARIABLES///START
$PAGE_HEADER = 'Tacacs Backup';
$PAGE_SUBHEADER = 'Backup of Tacacs Configuration';
$PAGE_TITLE = 'TacacsGUI';
$PAGE_SUBTITLE = 'Backup';
$BREADCRUMB = array(
	'Tacacs' => [
		'name' => 'Backup', 
		'href' => '', 
		'icon' => 'fa fa-database', 
		'class' => ''  //last item should have active class!!
	], 
);
///!!!!!////
$ACTIVE_MENU_ID=1200;
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
	<link rel="stylesheet" href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">

<!--ADDITIONAL CSS FILES END-->

<?php 

require __DIR__ . '/templates/body_start.php'; 

?>
<!--MAIN CONTENT START-->

<div class="row"> 
	<div class="col-xs-12">
		<div class="box box-primary">
			<div class="box-header">
				<h3 class="box-title">Backup of Tacacs Configuration</h3>
				<!--<div class="dropdown pull-right">
					<a class="btn btn-flat btn-info" id="filterButton">Filter</a>
				</div>-->
			</div><!-- /.box-header -->
			<div class="box-body">
				<div class="table-responsive">
					<table id="accountingDataTable" class="table-striped display table table-bordered" style="overflow: auto;">
	
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
	<script src="bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>

	
	<!-- main js Backup MAIN Functions -->
    <script src="dist/js/pages/api_backup/main.js"></script>
	<!-- DATATABLES MAIN -->
    <script src="dist/js/pages/api_backup/datatables.js"></script>

<!-- ADDITIONAL JS FILES END-->
</body>

</html>