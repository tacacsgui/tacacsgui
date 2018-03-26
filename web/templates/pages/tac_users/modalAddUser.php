<!-- Modal Add User -->
<div id="addUser" class="modal fade" role="dialog">
	<div class="modal-dialog modal-lg">
	<!-- Modal content-->
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h4 class="modal-title">Add New User</h4>
		</div>
		<div class="modal-body">
		<form id="addUserForm">
		<div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#general_info" data-toggle="tab" aria-expanded="true">General</a></li>
              <li class=""><a href="#message" data-toggle="tab" aria-expanded="false">Message</a></li>
              <li class=""><a href="#access" data-toggle="tab" aria-expanded="false">Access Rules</a></li>
			  <li class="pull-right"><a href="#manual" data-toggle="tab" aria-expanded="false" class="text-muted"><i class="fa fa-gear"></i></a></li>
            </ul>
            <div class="tab-content">
				<div class="tab-pane active" id="general_info">
					<?php include __DIR__ . '/tabGeneralInfo.php';?>
				</div>
				<!-- /.tab-pane -->
				<div class="tab-pane" id="message">
					<?php include __DIR__ . '/tabMessage.php';?>
				</div>
				<!-- /.tab-pane -->
				<div class="tab-pane" id="access">
					<?php include __DIR__ . '/tabAccessRules.php';?>
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
			<button type="button" class="btn btn-flat btn-success" onclick="addUser()">Add User</button>
		</div>			
	</div>
	</div>
</div>
      <!-- Modal Add User -->