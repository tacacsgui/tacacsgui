<?php $modalFormName_TacUser = 'edit'; ?>
<!-- Modal Edit User -->
<div id="editUser" class="modal fade" role="dialog">
	<div class="modal-dialog modal-lg">
	<!-- Modal content-->
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h4 class="modal-title">Edit New User <username class="text-green"></username></h4>
		</div>
		<div class="modal-body">
		<form id="editUserForm">
		<div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#general_info_edit" data-toggle="tab" aria-expanded="true">General</a></li>
              <li class=""><a href="#message_edit" data-toggle="tab" aria-expanded="false">Message</a></li>
              <li class=""><a href="#access_edit" data-toggle="tab" aria-expanded="false">Access Rules</a></li>
			  <li class=""><a href="#otp_edit" data-toggle="tab" aria-expanded="false">OTP Auth</a></li>
			  <li class=""><a href="#sms_edit" data-toggle="tab" aria-expanded="false">SMS Auth</a></li>
			  <li class="pull-right"><a href="#manual_edit" data-toggle="tab" aria-expanded="false" class="text-muted"><i class="fa fa-gear"></i></a></li>
            </ul>
            <div class="tab-content">
				<div class="tab-pane active" id="general_info_edit">
					<?php include __DIR__ . '/tabGeneralInfo.php';?>
					<hr>
					<div class="row">
					<div class="col-md-4 col-lg-4">
						<div class="form-group">
							<label>NX-OS Support</label>
							<div class="checkbox icheck">
								<label>
									<input type="checkbox" name="nxos_support"> NX-OS Support
								</label>
							</div>
							<p class="help-block">will be added additional parameter <i>pap</i></p>
						</div>
					</div>
					</div>
					<input type="hidden" value="" name="id"/>
					<input type="hidden" value="" name="username_old"/>
				</div>
				<!-- /.tab-pane -->
				<div class="tab-pane" id="message_edit">
					<?php include __DIR__ . '/tabMessage.php';?>
				</div>
				<!-- /.tab-pane -->
				<div class="tab-pane" id="access_edit">
					<?php include __DIR__ . '/tabAccessRules.php';?>
				</div>
				<!-- /.tab-pane -->
				<div class="tab-pane" id="otp_edit">
					<?php include __DIR__ . '/tabOTPAuth.php';?>
				</div>
				<!-- /.tab-pane -->
				<div class="tab-pane" id="sms_edit">
					<?php include __DIR__ . '/tabSMSAuth.php';?>
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
			<button type="button" class="btn btn-flat btn-success" onclick="submitUserChanges()">Edit User</button>
		</div>
	</div>
	</div>
</div>
      <!-- Modal Edit User -->
