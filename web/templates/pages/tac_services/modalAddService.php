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
				<li class="dropdown">
					<a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false" data-submenu="">
						<i class="fa fa-server"></i> Patterns <span class="caret"></span>
					</a>
					<ul class="dropdown-menu pattern-set">
						<li class="dropdown-submenu">
							<a href="#" data-toggle="dropdown"><i class="fa fa-clone"></i> Cisco Systems</a>
							<ul class="dropdown-menu">
								<li><a href="#" data-pattern="cisco-rs" data-disabled="1" onclick="tgui_device_patterns.switch(this)"><i class="fa fa-square-o"></i> Cisco General</a></li>
								<li><a href="#" data-pattern="cisco-wlc" data-disabled="1" onclick="tgui_device_patterns.switch(this)"><i class="fa fa-square-o"></i> Cisco WLC</a></li>
							</ul>
						</li>
						<li class="dropdown-submenu">
							<a href="#" data-toggle="dropdown"><i class="fa fa-clone"></i> Juniper</a>
							<ul class="dropdown-menu">
								<li><a href="#" data-pattern="juniper" data-disabled="1" onclick="tgui_device_patterns.switch(this)"><i class="fa fa-square-o"></i> Juniper General</a></li>
							</ul>
						</li>
						<li class="dropdown-submenu">
							<a href="#" data-toggle="dropdown"><i class="fa fa-clone"></i> H3C</a>
							<ul class="dropdown-menu">
								<li><a href="#" data-pattern="h3c-general" data-disabled="1" onclick="tgui_device_patterns.switch(this)"><i class="fa fa-square-o"></i> H3C General</a></li>
							</ul>
						</li>
						<li><a href="#" data-pattern="huawei" data-disabled="1" onclick="tgui_device_patterns.switch(this)"><i class="fa fa-square-o"></i> Huawei</a></li>
						<li><a href="#" data-pattern="paloalto" data-disabled="1" onclick="tgui_device_patterns.switch(this)"><i class="fa fa-square-o"></i> Palo Alto</a></li>
						<li><a href="#" data-pattern="fortios" data-disabled="1" onclick="tgui_device_patterns.switch(this)"><i class="fa fa-square-o"></i> FortiOS</a></li>
						<li><a href="#" data-pattern="silverpeak" data-disabled="1" onclick="tgui_device_patterns.switch(this)"><i class="fa fa-square-o"></i> Silver Peak</a></li>
					</ul>
				</li>
        <li class="active"><a href="#general_info" data-toggle="tab" aria-expanded="true">General</a></li>
        <li class="device-pattern device-pattern-hidden cisco-rs"><a href="#cisco" data-toggle="tab" aria-expanded="true">Cisco</a></li>
        <li class="device-pattern device-pattern-hidden cisco-wlc"><a href="#cisco-wlc" data-toggle="tab" aria-expanded="true">Cisco WLC</a></li>
        <li class="device-pattern device-pattern-hidden juniper"><a href="#juniper" data-toggle="tab" aria-expanded="true">Juniper</a></li>
				<li class="device-pattern device-pattern-hidden h3c-general"><a href="#h3c-general" data-toggle="tab" aria-expanded="true">H3C</a></li>
        <li class="device-pattern device-pattern-hidden huawei"><a href="#huawei" data-toggle="tab" aria-expanded="true">Huawei</a></li>
        <li class="device-pattern device-pattern-hidden paloalto"><a href="#paloalto" data-toggle="tab" aria-expanded="true">Palo Alto</a></li>
        <li class="device-pattern device-pattern-hidden fortios"><a href="#fortios" data-toggle="tab" aria-expanded="true">FortiOS</a></li>
        <li class="device-pattern device-pattern-hidden silverpeak"><a href="#silverpeak" data-toggle="tab" aria-expanded="true">Silver Peak</a></li>
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
				<div class="tab-pane" id="cisco-wlc">
					<?php include __DIR__ . '/tabCiscoWLC.php';?>
				</div>
				<!-- /.tab-pane -->
				<div class="tab-pane" id="h3c-general">
					<?php include __DIR__ . '/tabH3cGeneral.php';?>
				</div>
				<!-- /.tab-pane -->
				<div class="tab-pane" id="juniper">
					<?php include __DIR__ . '/tabJuniper.php';?>
				</div>
				<!-- /.tab-pane -->
				<div class="tab-pane" id="huawei">
					What should be here? :(
				</div>
				<!-- /.tab-pane -->
				<div class="tab-pane" id="paloalto">
					<?php include __DIR__ . '/tabPaloAlto.php';?>
				</div>
				<!-- /.tab-pane -->
				<div class="tab-pane" id="fortios">
					<?php include __DIR__ . '/tabFortiOS.php';?>
				</div>
				<!-- /.tab-pane -->
				<div class="tab-pane" id="silverpeak">
					<?php include __DIR__ . '/tabSilverpeak.php';?>
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
