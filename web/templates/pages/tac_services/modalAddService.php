<!-- Modal Add Service -->
<div id="addService" class="modal fade" role="dialog">
	<div class="modal-dialog modal-lg">
	<!-- Modal content-->
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h4 class="modal-title">Add New Service</h4>
		</div>
		<div class="modal-body">
		<form id="addServiceForm">
		<div class="nav-tabs-custom">
      <ul class="nav nav-tabs">
        <li class="active"><a href="#general_info" data-toggle="tab" aria-expanded="true">General</a></li>
        <li><a href="#cisco" data-toggle="tab" aria-expanded="true">Cisco</a></li>
        <li><a href="#ciscowlc" data-toggle="tab" aria-expanded="true">CiscoWLC</a></li>
        <li><a href="#juniper" data-toggle="tab" aria-expanded="true">Juniper</a></li>
        <li><a href="#huawei" data-toggle="tab" aria-expanded="true">Huawei</a></li>
        <li><a href="#fortios" data-toggle="tab" aria-expanded="true">FortiOS</a></li>
  			<li class="pull-right"><a href="#manual" data-toggle="tab" aria-expanded="false" class="text-muted"><i class="fa fa-gear"></i></a></li>
      </ul>
      <div class="tab-content">
				<div class="tab-pane active" id="general_info">
					<?php include __DIR__ . '/tabGeneralInfo.php';?>
				</div>
				<!-- /.tab-pane -->
				<div class="tab-pane" id="cisco">
					<?php include __DIR__ . '/tabCisco.php';?>
				</div>
				<!-- /.tab-pane -->
				<div class="tab-pane" id="ciscowlc">
					<?php include __DIR__ . '/tabCiscoWLC.php';?>
				</div>
				<!-- /.tab-pane -->
				<div class="tab-pane" id="juniper">
					<?php include __DIR__ . '/tabJuniper.php';?>
				</div>
				<!-- /.tab-pane -->
				<div class="tab-pane" id="huawei">
					<?php include __DIR__ . '/tabHuawei.php';?>
				</div>
				<!-- /.tab-pane -->
				<div class="tab-pane" id="fortios">
					<?php include __DIR__ . '/tabFortiOS.php';?>
				</div>
				<!-- /.tab-pane -->
				<div class="tab-pane" id="manual">
					<?php include __DIR__ . '/tabManualSettings.php';?>
				</div>
				<!-- /.tab-pane -->
      </div>
    	<!-- /.tab-content -->
		</div>
		</form>
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-flat pull-left" data-dismiss="modal">Close</button>
			<button type="button" class="btn btn-flat btn-success" onclick="tgui_service.add()">Add Service</button>
		</div>
	</div>
	</div>
</div>
      <!-- Modal Add Service -->
