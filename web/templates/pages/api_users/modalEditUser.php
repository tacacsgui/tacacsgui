<!-- Modal Edit User -->
<div id="editUser" class="modal fade" role="dialog">
	<div class="modal-dialog modal-lg">
	<!-- Modal content-->
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h4 class="modal-title">Edit User <elName class="text-green"></elName></h4>
		</div>
		<div class="modal-body">
		<form id="editUserForm">
			<div class="nav-tabs-custom">
				<ul class="nav nav-tabs">
					<li class="active"><a href="#general_info_edit" data-toggle="tab" aria-expanded="true">General</a></li>
					<li><a href="#notifications_edit" data-toggle="tab" aria-expanded="true">Notifications</a></li>
				</ul>
				<div class="tab-content">
					<div class="tab-pane active" id="general_info_edit">
						<?php include __DIR__ . '/tabGeneralInfo.php';?>
					</div>
					<!-- /.tab-pane -->
					<div class="tab-pane" id="notifications_edit">
						<?php include __DIR__ . '/tabNotifications.php';?>
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
			<button type="button" class="btn btn-flat btn-success" onclick="tgui_userApi.edit()">Edit User</button>
		</div>
	</div>
</div>
</div>
<!-- Modal Edit User -->
