<!DOCTYPE html>
<!---->
<?php
///CONFIGURATION FILE///
require __DIR__ . '/config.php';
///PAGE VARIABLES///START
$PAGE_HEADER = 'Tacacs Devices';
$PAGE_SUBHEADER = 'Here you can add some devices that will be use tacacs';
$PAGE_TITLE = 'TacacsGUI';
$PAGE_SUBTITLE = 'Tacacs Devices';
$BREADCRUMB = array(
	'Tacacs' => [
		'name' => 'Tacacs',
		'href' => '',
		'icon' => 'fa fa-cogs',
		'class' => ''  //last item should have active class!!
	],
	'Devices' => [
		'name' => 'Devices',
		'href' => '',
		'icon' => 'fa fa-server', //leave empty if you won't put icon
		'class' => 'active' //last item should have active class!!
	]
);
///!!!!!////
$ACTIVE_MENU_ID=20;
$ACTIVE_SUBMENU_ID=210;
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
	<!-- bootstrap slider -->
	<link rel="stylesheet" href="/plugins/bootstrap-slider/slider.css">
	<!-- iCheck -->
	<link rel="stylesheet" href="/plugins/iCheck/square/blue.css">
	<!-- Select2 -->
	<link rel="stylesheet" href="bower_components/select2/dist/css/select2.min.css">

	<style>
		#prefix_slider .slider-selection{
			background:#444;
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
				<h3 class="box-title">Tacacs Devices</h3>
			</div><!-- /.box-header -->
			<div class="box-body">
				<div class="row">
					<div class="col-xs-12">
						<div class="dropdown pull-right">
							<a class="btn btn-flat btn-success" id="addDeviceBtn" data-toggle="modal" data-target="#addDevice">+ Add Device</a>
							<a class="btn btn-flat btn-info" onclick="dataTable.settings.filter()">Filter</a>
							<div class="btn-group">
                <button type="button" class="btn btn-warning btn-flat dropdown-toggle" data-toggle="dropdown">
                  Action <span class="caret"></span>
                </button>
                <ul class="dropdown-menu dropdown-menu-right">
                  <li><a href="#" onclick="dataTable.settings.exportCsv()">Export Selected (CSV)</a></li>
                  <li><a href="#" onclick="dataTable.settings.deleteSelected()">Delete Selected</a></li>
                </ul>
              </div>
							<a class="btn btn-flat btn-warning" href="javascript: void(0)" id="exportLink" style="display: none;" target="_blank"><i class="fa fa-download"></i></a>
							<div class="btn-group">
                <button type="button" class="btn btn-default btn-flat dropdown-toggle" data-toggle="dropdown">
                  More Columns <span class="caret"></span>
                </button>
                <ul class="dropdown-menu dropdown-menu-right" id="columnsFilter">

                </ul>
              </div>
						</div>
					</div>
				</div>
				<div class="datatable-filter" style="display: none;">
				<div class="row">
					<div class="col-xs-12">
						<div class="form-group">
              <label>Table Filter</label>
							<div class="input-group input-group-sm">
                <input type="text" class="form-control" id="filterRequest" placeholder="Filter attributes...">
                <span class="input-group-btn">
                  <button type="button" class="btn btn-flat btn-default" onclick="dataTable.settings.filterErase()"><i class="fa fa-close"></i></button>
                </span>
              </div>
							<p class="text-muted">e.g. name=device1, ipaddr=10.1.1.1, group=1</p>
							<button class="btn btn-flat btn-default" id="filterInfo" data-placement="bottom" title="Filter Info"><i class="fa fa-info"></i> Filter Info</button>
							<div class="filterMessage pull-right" style="display: none;"></div>
            </div>
					</div>
				</div>
				</div>
				<div class="table-responsive">
					<table id="devicesDataTable" class="table-striped display table table-bordered" style="overflow: auto;">

					</table>
				</div>
			</div><!-- /.box-body -->
		</div><!-- /.box -->
	</div><!-- /.col -->
</div><!-- /.row -->
<div class="box box-solid">
	<div class="box-body">
		<div class="row">
			<div class="col-sm-6">
				<h4>Save all data as CSV table</h4>
				<div class="csv-link">
					<p>&lt;Link will appeared here&gt;</p>
				</div>
				<br>
				<button type="button" class="btn btn-success btn-flat" onclick="tgui_device.csvDownload()">Save as CSV</button>
			</div>
			<div class="col-sm-6">
				<div class="form-group">
	        <label for="file">File input</label>
	        <input type="file" name="csv-file" id="csv-file">
	        <p class="help-block">file must have header</p>
	      </div>
				<div class="form-group">
	        <label for="file">Separator</label>
					<div class="">
						<label class="radio-inline"><input type="radio" name="separator" value="," checked>,</label>
						<label class="radio-inline"><input type="radio" name="separator" value=";">;</label>
					</div>
	      </div>
				<button type="button" class="btn btn-warning btn-flat" onclick="tgui_device.csvParser.read()">Upload CSV</button>
			</div>
		</div>
		<div class="csvParserOutput">
			<hr>
			<pre id="csvParserOutput">CSV Parser Output</pre>
		</div>
	</div>
</div>
<!--MAIN CONTENT END-->

<?php

require __DIR__ . '/templates/pages/tac_devices/modalAddDevice.php';

?>

<?php

require __DIR__ . '/templates/pages/tac_devices/modalEditDevice.php';

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
	<!-- Bootstrap slider -->
	<script src="plugins/bootstrap-slider/bootstrap-slider.js"></script>
	<!-- iCheck -->
	<script src="plugins/iCheck/icheck.min.js"></script>
	<!-- Select2 -->
	<script src="bower_components/select2/dist/js/select2.full.min.js"></script>
	<!-- jquery-csv -->
	<script src="plugins/jquery-csv/jquery-csv.min.js"></script>

	<!-- Select2 Object -->
  <script src="dist/js/tgui_select2.js"></script>
	<!-- tgui_csvParser Object -->
  <script src="dist/js/tgui_csvParser.js"></script>
	<!-- main js Device Object -->
  <script src="dist/js/pages/tac_devices/tgui_device.js"></script>
	<!-- DATATABLES MAIN -->
  <script src="dist/js/tgui_datatables.js"></script>
	<!-- DATATABLES MAIN -->
  <script src="dist/js/pages/tac_devices/datatables.js"></script>
	<!-- main js Device MAIN Functions -->
  <script src="dist/js/pages/tac_devices/main.js"></script>
<!-- ADDITIONAL JS FILES END-->
</body>
<div class="filter-info-content">
	<div class="box box-solid">
		<div class="box-body">
			<div class="filter-info-part attributes">
				<h4>List of Attributes</h4>
				<p><b>name</b> - Name</p>
				<p><b>ipaddr</b> - ip address</p>
				<p><b>id</b> - ID</p>
				<p><b>group</b> - Group ID</p>
			</div>
			<div class="filter-info-part conditions" style="display:none">
				<h4>List of Conditions</h4>
				<p><b>=</b> - implicit equal</p>
				<p><b>!=</b> - implicit not equal</p>
				<p><b>==</b> - equal</p>
				<p><b>!==</b> - not equal</p>
			</div>
		</div>
		<div class="box-footer">
			<button type="button" onclick="$('.filter-info-part').hide(); $('.filter-info-part.attributes').show();">Attributes</button>
			<button type="button" onclick="$('.filter-info-part').hide(); $('.filter-info-part.conditions').show();">Conditions</button>
		</div>
	</div>
</div>
</html>
