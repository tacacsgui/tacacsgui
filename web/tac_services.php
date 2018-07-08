<!DOCTYPE html>
<!---->
<?php
///CONFIGURATION FILE///
require __DIR__ . '/config.php';
///PAGE VARIABLES///START
$PAGE_HEADER = 'Tacacs Services';
$PAGE_SUBHEADER = 'Here you can add services and attributes to control access';
$PAGE_TITLE = 'TacacsGUI';
$PAGE_SUBTITLE = 'Tacacs Services';
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
	'Services' => [
		'name' => 'Services',
		'href' => '',
		'icon' => '', //leave empty if you won't put icon
		'class' => 'active' //last item should have active class!!
	]
);
///!!!!!////
$ACTIVE_MENU_ID=50;
$ACTIVE_SUBMENU_ID=520;
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
<!--ADDITIONAL CSS FILES END-->

<?php

require __DIR__ . '/templates/body_start.php';

?>
<!--MAIN CONTENT START-->

<div class="row">
	<div class="col-xs-12">
		<div class="box box-primary">
			<div class="box-header">
				<h3 class="box-title">Tacacs Services</h3>
			</div><!-- /.box-header -->
			<div class="box-body">
				<div class="row">
					<div class="col-xs-12">
						<div class="dropdown pull-right">
							<a class="btn btn-flat btn-success" id="addServiceBtn" data-toggle="modal" data-target="#addService">+ Add Service</a>
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
							<p class="text-muted">e.g. name=service1</p>
							<button class="btn btn-flat btn-default" id="filterInfo" data-placement="bottom" title="Filter Info"><i class="fa fa-info"></i> Filter Info</button>
							<div class="filterMessage pull-right" style="display: none;"></div>
            </div>
					</div>
				</div>
				</div>
				<div class="table-responsive">
					<table id="servicesDataTable" class="table-striped display table table-bordered" style="overflow: auto;">

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
				<button type="button" class="btn btn-success btn-flat" onclick="tgui_service.csvDownload()">Save as CSV</button>
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
				<button type="button" class="btn btn-warning btn-flat" onclick="tgui_service.csvParser.read()" >Upload CSV</button>
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

require __DIR__ . '/templates/pages/tac_services/modalAddService.php';

?>

<?php

require __DIR__ . '/templates/pages/tac_services/modalEditService.php';

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
	<script src="/plugins/iCheck/icheck.min.js"></script>
	<script src="plugins/jquery-csv/jquery-csv.min.js"></script>

	<!-- tgui_csvParser Object -->
  <script src="dist/js/tgui_csvParser.js"></script>
	<!-- main Object -->
  <script src="dist/js/pages/tac_services/tgui_service.js"></script>
	<!-- DATATABLES MAIN -->
  <script src="dist/js/tgui_datatables.js"></script>
	<!-- DATATABLES MAIN -->
  <script src="dist/js/pages/tac_services/datatables.js"></script>

	<!-- main js tac services MAIN Functions -->
  <script src="dist/js/pages/tac_services/main.js"></script>
<!-- ADDITIONAL JS FILES END-->
</body>
<div class="filter-info-content">
	<div class="box box-solid">
		<div class="box-body">
			<div class="filter-info-part attributes">
				<h4>List of Attributes</h4>
				<p><b>name</b> - Name</p>
				<p><b>id</b> - ID</p>
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
