<!-- Modal Edit Service -->
<div id="editService" class="modal fade" role="dialog">
	<div class="modal-dialog modal-lg">
	<!-- Modal content-->
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h4 class="modal-title">Edit Service <elName class="text-green"></elName></h4>
		</div>
		<div class="modal-body">
		<form id="editServiceForm">
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
									<li><a href="#" data-pattern="cisco-rs" data-disabled="1" onclick="tgui_device_patterns.switch(this)"><i class="fa fa-square-o"></i> Cisco R/S</a></li>
									<li><a href="#" data-pattern="cisco-nexus" data-disabled="1" onclick="tgui_device_patterns.switch(this)"><i class="fa fa-square-o"></i> Cisco Nexus</a></li>
									<li><a href="#" data-pattern="cisco-wlc" data-disabled="1" onclick="tgui_device_patterns.switch(this)"><i class="fa fa-square-o"></i> Cisco WLC</a></li>
								</ul>
							</li>
							<li><a href="#" data-pattern="juniper" data-disabled="1" onclick="tgui_device_patterns.switch(this)"><i class="fa fa-square-o"></i> Juniper</a></li>
							<li><a href="#" data-pattern="huawei" data-disabled="1" onclick="tgui_device_patterns.switch(this)"><i class="fa fa-square-o"></i> Huawei</a></li>
							<li><a href="#" data-pattern="paloalto" data-disabled="1" onclick="tgui_device_patterns.switch(this)"><i class="fa fa-square-o"></i> Palo Alto</a></li>
							<li><a href="#" data-pattern="fortios" data-disabled="1" onclick="tgui_device_patterns.switch(this)"><i class="fa fa-square-o"></i> FortiOS</a></li>
						</ul>
					</li>
					<li class="active"><a href="#general_info_edit" data-toggle="tab" aria-expanded="true">General</a></li>
					<li class="device-pattern device-pattern-hidden cisco-rs"><a href="#cisco_edit" data-toggle="tab" aria-expanded="true">Cisco R/S</a></li>
					<li class="device-pattern device-pattern-hidden cisco-wlc"><a href="#cisco-wlc_edit" data-toggle="tab" aria-expanded="true">Cisco WLC</a></li>
					<li class="device-pattern device-pattern-hidden cisco-nexus"><a href="#cisco-nexus_edit" data-toggle="tab" aria-expanded="true">Cisco Nexus</a></li>
					<li class="device-pattern device-pattern-hidden juniper"><a href="#juniper_edit" data-toggle="tab" aria-expanded="true">Juniper</a></li>
					<li class="device-pattern device-pattern-hidden huawei"><a href="#huawei_edit" data-toggle="tab" aria-expanded="true">Huawei</a></li>
					<li class="device-pattern device-pattern-hidden paloalto"><a href="#paloalto_edit" data-toggle="tab" aria-expanded="true">Palo Alto</a></li>
					<li class="device-pattern device-pattern-hidden fortios"><a href="#fortios_edit" data-toggle="tab" aria-expanded="true">FortiOS</a></li>
					<li class="pull-right"><a href="#manual_edit" data-toggle="tab" aria-expanded="false" class="text-muted"><i class="fa fa-gear"></i></a></li>
				</ul>
				<div class="tab-content">
					<div class="tab-pane active" id="general_info_edit">
						<?php include __DIR__ . '/tabGeneralInfo.php';?>
					</div>
					<!-- /.tab-pane -->
					<div class="tab-pane" id="cisco_edit">
						<?php include __DIR__ . '/tabCisco.php';?>
					</div>
					<!-- /.tab-pane -->
					<div class="tab-pane" id="cisco-nexus_edit">
						What should be here? :(
					</div>
					<!-- /.tab-pane -->
					<div class="tab-pane" id="cisco-wlc_edit">
						<?php include __DIR__ . '/tabCiscoWLC.php';?>
					</div>
					<!-- /.tab-pane -->
					<div class="tab-pane" id="juniper_edit">
						What should be here? :(
					</div>
					<!-- /.tab-pane -->
					<div class="tab-pane" id="huawei_edit">
						What should be here? :(
					</div>
					<!-- /.tab-pane -->
					<div class="tab-pane" id="paloalto_edit">
						<?php include __DIR__ . '/tabPaloAlto.php';?>
					</div>
					<!-- /.tab-pane -->
					<div class="tab-pane" id="fortios_edit">
						<?php include __DIR__ . '/tabFortiOS.php';?>
					</div>
					<!-- /.tab-pane -->
					<div class="tab-pane" id="manual_edit">
						<?php include __DIR__ . '/tabManualSettings.php';?>
					</div>
					<!-- /.tab-pane -->
				</div>
				<!-- /.tab-content -->
			</div>
		</form>
		<p class="text-muted"><text class="created_at"></text><text class="updated_at pull-right"></text></p>
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-flat pull-left" data-dismiss="modal">Close</button>
			<button type="button" class="btn btn-flat btn-success" onclick="tgui_service.edit()">Edit Service</button>
		</div>
	</div>
	</div>
</div>
      <!-- Modal Edit Service -->
