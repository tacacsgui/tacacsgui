<!DOCTYPE html>
<!---->
<?php
///CONFIGURATION FILE///
require __DIR__ . '/config.php';
///PAGE VARIABLES///START
$PAGE_HEADER = 'Dashboard';
$PAGE_SUBHEADER = 'There is a dashboard here';
$PAGE_TITLE = 'TacacsGUI';
$PAGE_SUBTITLE = 'Dashboard';
$BREADCRUMB = array(
	'Dashboard' => [
		'name' => 'Dashboard', 
		'href' => '', 
		'icon' => 'fa fa-dashboard', 
		'class' => ''  //last item should have active class!!
	], 
);
///!!!!!////
$ACTIVE_MENU_ID=10;
$ACTIVE_SUBMENU_ID=0;
///!!!!!////
///PAGE VARIABLES///END
?>
<html>

<?php
require __DIR__ . '/templates/header.php';
?>
<!--ADDITIONAL CSS FILES START-->

</head>
<!--ADDITIONAL CSS FILES END-->

<?php 

require __DIR__ . '/templates/body_start.php'; 

?>
<!--MAIN CONTENT START-->

<!-- Small boxes (Stat box) -->
<div class="row">
	<div class="col-lg-3 col-xs-6">
		<!-- small box -->
		<div class="small-box bg-green">
			<div class="inner">
			<h3 class="tacacsStatus">loading...</h3>
		
			<p>tacacs status</p>
			</div>
			<div class="icon">
			<i class="fa fa-gears"></i>
			</div>
			<a href="/tac_configuration.php" class="small-box-footer">
			More info <i class="fa fa-arrow-circle-right"></i>
			</a>
		</div>
	</div>
    <!-- ./col -->
	<div class="col-lg-3 col-xs-6">
	<!-- small box -->
		<div class="small-box bg-blue">
			<div class="inner">
			<h3 class="numberOfDevices">0</h3>
		
			<p>Devices</p>
			</div>
			<div class="icon">
			<i class="fa fa-server"></i>
			</div>
			<a href="/tac_devices.php" class="small-box-footer">
			More info <i class="fa fa-arrow-circle-right"></i>
			</a>
		</div>
	</div>
	<!-- ./col -->
	<div class="col-lg-3 col-xs-6">
	<!-- small box -->
		<div class="small-box bg-yellow">
			<div class="inner">
			<h3 class="numberOfUsers">0</h3>
		
			<p>Users</p>
			</div>
			<div class="icon">
			<i class="fa fa-child"></i>
			</div>
			<a href="/tac_users.php" class="small-box-footer">
			More info <i class="fa fa-arrow-circle-right"></i>
			</a>
		</div>
	</div>
	<!-- ./col -->
	<div class="col-lg-3 col-xs-6">
	<!-- small box -->
		<div class="small-box bg-teal">
			<div class="inner">
			<h3 class="numberOfAuthFails">0</h3>
		
			<p>Failed authentication (during the week)</p>
			</div>
			<div class="icon">
			<i class="fa fa-binoculars"></i>
			</div>
			<a href="/tac_authentication.php" class="small-box-footer">
			More info <i class="fa fa-arrow-circle-right"></i>
			</a>
		</div>
	</div>
	<!-- ./col -->
      </div>
      <!-- /.row -->

      <!-- =========================================================== -->
	  
<!-- DONUT CHART -->
	<div class="box box-success">
		<div class="box-header with-border">
			<h3 class="box-title">Top Chart</h3>
		
			<div class="box-tools pull-right">
			<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
			</button>
			<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
			</div>
		</div>
		<div class="box-body">
			<div class="row">
				<div class="col-lg-6 col-md-6">
					<div class="text-center"><h3>Top 5 Active Users</h3> <small>number of authentication per week</small></div>
					<div id="canvas-holder">
						<canvas class="chart-area1" />
					</div>
				</div>	
				<div class="col-lg-6 col-md-6">
					<div class="text-center"><h3>Top 5 Used Devices</h3> <small>number of authentication per week</small></div>
					<div id="canvas-holder">
						<canvas class="chart-area2" />
					</div>
				</div>	
			</div>	
		</div>
		<!-- /.box-body -->
	</div>
<!-- /.box -->

<!--MAIN CONTENT END-->
<?php 

require __DIR__ . '/templates/body_end.php'; 

?>

<?php

require __DIR__ . '/templates/footer_end.php';

?>
<!-- ADDITIONAL JS FILES START-->

	<!-- ChartJS -->
	<script src="bower_components/chart.js/Chart.bundle.js"></script>
	<script src="bower_components/chart.js/utils.js"></script>
	
	<!-- chartjs js -->
    <script src="dist/js/pages/dashboard/chartjs.js"></script>
	<!-- main js User MAIN Functions -->
    <script src="dist/js/pages/dashboard/main.js"></script>
<!-- ADDITIONAL JS FILES END-->
</body>

</html>