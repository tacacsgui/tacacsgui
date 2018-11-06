<!-- Modal Edit Device Group-->
<div id="editDeviceGroup" class="modal fade" role="dialog">
	<div class="modal-dialog modal-lg">
	<!-- Modal content-->
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h4 class="modal-title">Edit Device Group <elName class="text-green"></elName></h4>
		</div>
		<div class="modal-body">
		<form id="editDeviceGroupForm">
			<div class="nav-tabs-custom">
				<ul class="nav nav-tabs">
					<li class="active"><a href="#general_info_edit" data-toggle="tab" aria-expanded="true">General</a></li>
					<li class=""><a href="#messages_edit" data-toggle="tab" aria-expanded="false">Messages</a></li>
					<li class=""><a href="#access_edit" data-toggle="tab" aria-expanded="false">Access</a></li>
					<li class="pull-right"><a href="#manual_edit" data-toggle="tab" aria-expanded="false" class="text-muted"><i class="fa fa-gear"></i></a></li>
				</ul>
				<div class="tab-content">
					<div class="tab-pane active" id="general_info_edit">
						<?php include __DIR__ . '/tabGeneralInfo.php';?>
					</div>
					<!-- /.tab-pane -->
					<div class="tab-pane" id="messages_edit">
						<?php include __DIR__ . '/tabMessages.php';?>
					</div>
					<!-- /.tab-pane -->
					<div class="tab-pane" id="access_edit">
						<?php include __DIR__ . '/tabAccessRules.php';?>
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
			<button type="button" class="btn btn-flat btn-success" onclick="tgui_devGrp.edit()">Edit Device Group</button>
		</div>
	</div>
	</div>
</div>
      <!-- Modal Edit Device Group -->
