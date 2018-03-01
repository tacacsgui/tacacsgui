<!DOCTYPE html>
<!---->
<?php
///CONFIGURATION FILE///
require __DIR__ . '/config.php';
///PAGE VARIABLES///START
$PAGE_HEADER = 'Tacacs Authentication';
$PAGE_SUBHEADER = 'Authentication report';
$PAGE_TITLE = 'TacacsGUI';
$PAGE_SUBTITLE = 'Tacacs Authentication';
$BREADCRUMB = array(
	'Tacacs' => [
		'name' => 'Tacacs Reports', 
		'href' => '', 
		'icon' => 'fa fa-cogs', 
		'class' => ''  //last item should have active class!!
	], 
	'Devices' => [
		'name' => 'Authentication', 
		'href' => '', 
		'icon' => 'fa fa-search', //leave empty if you won't put icon
		'class' => 'active' //last item should have active class!!
	]
);
///!!!!!////
$ACTIVE_MENU_ID=90;
$ACTIVE_SUBMENU_ID=910;
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
				<h3 class="box-title">Tacacs Authentication Report</h3>
				<div class="dropdown pull-right">
					<a class="btn btn-flat btn-info" id="filterButton">Filter</a>
				</div>
			</div><!-- /.box-header -->
			<div class="box-body">
				<div class="table-responsive">
					<table id="authenticationDataTable" class="table-striped display table table-bordered" style="overflow: auto;">
	
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
	<!-- date-range-picker -->
	<script src="bower_components/moment/min/moment.min.js"></script>
	<script src="bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>

	
	<!-- DATATABLES MAIN -->
    <script src="dist/js/pages/tac_reports/authentication/datatables.js"></script>

<!-- ADDITIONAL JS FILES END-->
</body>

</html>