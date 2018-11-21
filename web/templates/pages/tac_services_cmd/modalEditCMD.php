<!-- Modal Add Service -->
<div id="editCMD" class="modal fade" role="dialog">
	<div class="modal-dialog modal-lg">
	<!-- Modal content-->
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h4 class="modal-title">Edit CMD Attribute <elName class="text-green"></elName></h4>
		</div>
		<div class="modal-body">
		<form id="editCMDForm">
		<div class="nav-tabs-custom">
      <ul class="nav nav-tabs">
        <li class="active"><a href="#general_info_edit" data-toggle="tab" aria-expanded="true">General</a></li>
        <li><a href="#messages_edit" data-toggle="tab" aria-expanded="true">Messages</a></li>
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
				<div class="tab-pane" id="manual_edit">
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
			<button type="button" class="btn btn-flat btn-success" onclick="tgui_cmd.edit()">Edit CMD</button>
		</div>
	</div>
	</div>
</div>
      <!-- Modal Add Service -->
