<!-- Modal Add Service -->
<div id="addCMD_junos" class="modal fade" role="dialog">
	<div class="modal-dialog modal-lg">
	<!-- Modal content-->
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h4 class="modal-title">Add Command Set (JunOS)</h4>
		</div>
		<div class="modal-body">
		<form id="addCMDForm_junos">
		<div class="nav-tabs-custom">
      <ul class="nav nav-tabs">
        <li class="active"><a href="#general_info" data-toggle="tab" aria-expanded="true">General</a></li>
      </ul>
      <div class="tab-content">
				<div class="tab-pane active" id="general_info">
					<?php include __DIR__ . '/tabGeneralInfo_Junos.php';?>
				</div>
				<!-- /.tab-pane -->
      </div>
    	<!-- /.tab-content -->
		</div>
		</form>
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-flat pull-left" data-dismiss="modal">Close</button>
			<button type="button" class="btn btn-flat btn-success" onclick="tgui_cmd.add_junos()">Add CMD</button>
		</div>
	</div>
	</div>
</div>
      <!-- Modal Add Service -->
