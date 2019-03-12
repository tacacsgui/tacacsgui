<div id="editModel" class="modal fade" role="dialog">
	<div class="modal-dialog modal-lg">
	<!-- Modal content-->
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h4 class="modal-title">Edit Model <elName class="text-green"></elName></h4>
		</div>
		<div class="modal-body">
		<form id="editModelForm">
			<div class="nav-tabs-custom">
				<ul class="nav nav-tabs">
					<li class="active"><a href="#general_info_edit" data-toggle="tab" aria-expanded="true">General</a></li>
					<li><a href="#export_edit" class="export_tab" data-toggle="tab" aria-expanded="true">Export</a></li>
				</ul>
				<div class="tab-content">
					<div class="tab-pane active" id="general_info_edit">
						<?php include __DIR__ . '/tabGeneralInfo.php';?>
					</div>
					<!-- /.tab-pane -->
					<div class="tab-pane" id="export_edit">
						<?php include __DIR__ . '/tabExport.php';?>
					</div>
					<!-- /.tab-pane -->
				<!-- /.tab-content -->
				</div>
			</div>
		</form>
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-flat pull-left" data-dismiss="modal">Close</button>
			<button type="button" class="btn btn-flat btn-success" onclick="cm_models.edit()">Edit Model</button>
		</div>
	</div>
	</div>
</div>
