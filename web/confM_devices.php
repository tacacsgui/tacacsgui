<!DOCTYPE html>
<!---->
<?php
///CONFIGURATION FILE///
require __DIR__ . '/config.php';
///PAGE VARIABLES///START
$PAGE_HEADER = 'Configuration Manager. Devices';
$PAGE_SUBHEADER = 'the list of devices';
$PAGE_TITLE = 'TacacsGUI';
$PAGE_SUBTITLE = 'Configuration Manager. Devices';
$BREADCRUMB = array(
	'confM' => [
		'name' => 'Configuration Manager',
		'href' => '',
		'icon' => 'fa fa-copy',
		'class' => ''  //last item should have active class!!
	],
	'confM_main' => [
		'name' => 'Devices',
		'href' => '',
		'icon' => '', //leave empty if you won't put icon
		'class' => '' //last item should have active class!!
	],
);
///!!!!!////
$ACTIVE_MENU_ID=[1300,1320,1324];
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
	<!-- Select2 -->
	<link rel="stylesheet" href="bower_components/select2/dist/css/select2.min.css">
<!--ADDITIONAL CSS FILES END-->

<?php

require __DIR__ . '/templates/body_start.php';

?>
<!--MAIN CONTENT START-->
<div class="row">
	<div class="col-xs-12">
		<div class="box box-primary">
			<div class="box-header">
				<h3 class="box-title">Devices Table</h3>
			</div><!-- /.box-header -->
			<div class="box-body">
				<?php
				$addBtn = ['name'=>'+ Add Device', 'id' => 'addDeviceBtn', 'modalId' => '#addDevice'];
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
					<table id="devicesDataTable" class="table-striped display table table-bordered" style="overflow: auto;">

					</table>
				</div>
			</div><!-- /.box-body -->
		</div><!-- /.box -->
	</div><!-- /.col -->
</div><!-- /.row -->

<div class="row">
	<div class="col-xs-12">
		<div class="box box-primary">
			<div class="box-header">
				<h3 class="box-title">Fast Import from TacacsGUI Devices</h3>
			</div>
			<div class="box-body">
				<form id="fastImportForm">
				<div class="row">
				  <div class="col-sm-6">
				    <div class="form-group tac_device">
				      <label for="Name">Selet Device from TacGUI</label>
				      <input type="hidden"  data-type="input" data-default="" name="tac_device_native">
				      <select class="form-control select2 select_tac_dev"  name="tac_device" data-type="select" data-default="" data-pickup="true" style="width:100%"></select>
				      <p class="help-block">that match used for tacgui diff section</p>
				    </div>
				  </div>
				</div> <!-- /.row -->
				<div class="row">
					<div class="col-xs-12">
						<h4>Fill the form below</h4>
					</div>
				</div> <!-- /.row -->
				<div class="row">
					<div class="col-sm-3 col-lg-2">
				    <div class="form-group protocol">
				      <label for="Name">Protocol</label>
				      <input type="hidden"  data-type="input" data-default="" name="protocol_native">
				      <select class="form-control" name="protocol" data-type="input" data-default="ssh" data-pickup="true">
				        <option value="ssh">ssh</option>
				        <option value="telnet">telnet</option>
				      </select>
				      <p class="help-block">only ssh version 2 supported</p>
				    </div>
				  </div>
				  <div class="col-sm-3 col-lg-2">
				    <div class="form-group port">
				      <label for="Name">Port</label>
				      <input type="hidden"  data-type="input" data-default="" name="port_native">
				      <input type="number" class="form-control" name="port" data-type="input" data-default="22" data-pickup="true" value="22" placeholder="Enter Port" autocomplete="off">
				      <p class="help-block">default port for ssh is 22, for telnet is 23</p>
				    </div>
				  </div>
					<div class="col-sm-6 col-lg-3">
				    <div class="form-group credential">
				      <label for="Name">Credential (Optional)</label>
				      <input type="hidden"  data-type="input" data-default="" name="credential_native">
				      <select class="form-control select2 select_creden"  name="credential" data-type="select" data-default="" data-pickup="true" style="width:100%"></select>
				      <p class="help-block">if set, Query settings will be ignored</p>
				    </div>
				  </div>
					<div class="col-sm-6">
				    <div class="form-group prompt">
				      <label for="Name">Prompt List (Optional)</label>
				      <input type="hidden"  data-type="input" data-default="" name="prompt_native">
				      <input type="text" class="form-control" name="prompt" data-type="input" data-default="" data-pickup="true" placeholder="Enter Prompt List" autocomplete="off">
				      <p class="help-block">if set, prompt list inside of Model will be ignored. Comma separated list</p>
				    </div>
				  </div>
				</div> <!-- /.row -->
				</form>
			</div><!-- /.box-body -->
			<div class="box-footer">
				<a class="btn btn-flat btn-primary" onclick="fastImport.start()">Import</a>
			</div>
		</div><!-- /.box -->
	</div><!-- /.col -->
</div>
<!--MAIN CONTENT END-->

<?php

require __DIR__ . '/templates/pages/confM_/Devices/modalAdd.php';

?>

<?php

require __DIR__ . '/templates/pages/confM_/Devices/modalEdit.php';

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

	<!-- iCheck -->
	<script src="plugins/iCheck/icheck.min.js"></script>
	<!-- DATATABLES MAIN -->
	<script src="dist/js/tgui_datatables.js"></script>
	<!-- Select2 Object -->
	<script src="dist/js/tgui_select2.js"></script>

	<!-- MAIN Object-->
	<script src="dist/js/pages/confM_/devices/fastImport.js"></script>
	<script src="dist/js/pages/confM_/devices/confM_devices.js"></script>

	<!-- DATATABLES MAIN -->
	<script src="dist/js/pages/confM_/devices/datatables.js"></script>
	<!-- main js tac services MAIN Functions -->
  <script src="dist/js/pages/confM_/devices/main.js"></script>
<!-- ADDITIONAL JS FILES END-->
</body>
</html>
