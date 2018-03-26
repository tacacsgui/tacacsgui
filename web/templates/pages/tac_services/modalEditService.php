<!-- Modal Edit Service -->
<div id="editService" class="modal fade" role="dialog">
	<div class="modal-dialog modal-lg">
	<!-- Modal content-->
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h4 class="modal-title">Edit Service <serviceName class="text-green"></serviceName></h4>
		</div>
		<div class="modal-body">
		<form id="editServiceForm">
		<div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#general_info_edit" data-toggle="tab" aria-expanded="true">General</a></li>
			  <li class="pull-right"><a href="#manual_edit" data-toggle="tab" aria-expanded="false" class="text-muted"><i class="fa fa-gear"></i></a></li>
            </ul>
            <div class="tab-content">
				<div class="tab-pane active" id="general_info_edit">
					<?php include __DIR__ . '/tabGeneralInfo.php';?>
					<input type="hidden" value="" name="id"/>
					<input type="hidden" value="" name="name_old"/>
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
			<button type="button" class="btn btn-flat btn-success" onclick="submitServiceChanges()">Edit Service</button>
		</div>			
	</div>
	</div>
</div>
      <!-- Modal Edit Service -->