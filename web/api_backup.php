<!DOCTYPE html>
<!---->
<?php
///CONFIGURATION FILE///
require __DIR__ . '/config.php';
///PAGE VARIABLES///START
$PAGE_HEADER = 'System Backup';
$PAGE_SUBHEADER = 'Backup of different configurations';
$PAGE_TITLE = 'TacacsGUI';
$PAGE_SUBTITLE = 'System Backup';
$BREADCRUMB = array(
	'Tacacs' => [
		'name' => 'System Backup',
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
	<!-- iCheck -->
	<link rel="stylesheet" href="/plugins/iCheck/square/blue.css">

<!--ADDITIONAL CSS FILES END-->

<?php

require __DIR__ . '/templates/body_start.php';

?>
<!--MAIN CONTENT START-->

<div class="row">
	<div class="col-xs-12">
		<div class="box box-primary">
			<div class="box-header">
				<h3 class="box-title">Backup Tables</h3>
				<!--<div class="dropdown pull-right">
					<a class="btn btn-flat btn-info" id="filterButton">Filter</a>
				</div>-->
			</div><!-- /.box-header -->
			<div class="box-body">
				<div class="nav-tabs-custom">
					<ul class="nav nav-tabs">
						<li class="active"><a href="#tcfg" data-toggle="tab" aria-expanded="true">Tacacs CFG</a></li>
						<li class=""><a href="#apicfg" data-toggle="tab" aria-expanded="true">API CFG</a></li>
						<li class=""><a href="#full" data-toggle="tab" aria-expanded="true">Full Backup</a></li>
					</ul>
					<div class="tab-content">
						<div class="tab-pane active" id="tcfg">
							<?php include __DIR__ . '/templates/pages/api_backup/tab_tcfgBackup.php';?>
						</div>
						<!-- /.tab-pane -->
						<div class="tab-pane" id="apicfg">
							<?php include __DIR__ . '/templates/pages/api_backup/tab_apicfgBackup.php';?>
						</div>
						<!-- /.tab-pane -->
						<div class="tab-pane" id="full">
							<?php include __DIR__ . '/templates/pages/api_backup/tab_fullBackup.php';?>
						</div>
						<!-- /.tab-pane -->
					</div>
					<!-- /.tab-content -->
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
	<!-- iCheck -->
	<script src="/plugins/iCheck/icheck.min.js"></script>

	<!-- DATATABLES MAIN -->
  <script src="dist/js/pages/api_backup/datatables.js"></script>
	<!-- main Object -->
  <script src="dist/js/pages/api_backup/tgui_apiBackup.js"></script>
	<!-- main js Backup MAIN Functions -->
  <script src="dist/js/pages/api_backup/main.js"></script>

<!-- ADDITIONAL JS FILES END-->
</body>

</html>
