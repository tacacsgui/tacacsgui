<!-- Modal Edit User -->
<div id="editUser" class="modal fade" role="dialog">
	<div class="modal-dialog modal-lg">
	<!-- Modal content-->
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h4 class="modal-title">Edit User <username class="text-green"></username></h4>
		</div>
		<div class="modal-body">
		<form id="editUserForm">
			<div class="row">
			<div class="col-lg-6 col-md-6">
				<div class="form-group username">
					<label for="Username">Username</label>
					<input type="text" class="form-control" name="Username" placeholder="Enter User Name" disabled>
					<input type="hidden" value="" name="id"/>
					<p class="help-block">you can't change username</p>
                </div>
            </div>
			<div class="col-lg-6 col-md-6">
				<div class="form-group group">
					<label>User Group</label>
					<select class="select_group form-control select2" style="width:100%"></select>
                </div>
            </div>
            </div>
			<div class="row">
			<div class="col-lg-6 col-md-6">
				<div class="form-group password">
					<label for="Password">Change Password</label>
					<div class="input-group margin">
						<input type="password" class="form-control" name="Password" placeholder="Enter New Password" autocomplete="off">
						<div class="input-group-btn">
							<button type="button" class="btn btn-flat" onclick="document.getElementsByName('Password')[0].type = 'text'"
					  onmouseout="document.getElementsByName('Password')[0].type = 'password'"><i class="fa fa-eye"></i></button>
						</div>
                    </div><!-- /btn-group -->
				</div>
			</div>
			<div class="col-lg-6 col-md-6">
				<div class="form-group repPassword">
					<label for="RepPassword">Repeat Password</label>
					<div class="input-group margin">
						<input type="password" class="form-control" name="RepPassword" placeholder="Repeat Password" autocomplete="off">
						<div class="input-group-btn">
							<button type="button" class="btn btn-flat" onclick="document.getElementsByName('RepPassword')[0].type = 'text'"
							onmouseout="document.getElementsByName('RepPassword')[0].type = 'password'"><i class="fa fa-eye"></i></button>
						</div><!-- /btn-group -->
					</div><!-- /btn-group -->
				</div>
			</div>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<div class="cform-group changePasswd">
					<div class="checkbox icheck">
						<label>
							<input type="checkbox" name="changePasswd" checked> Change password in next login
						</label>
						<p class="help-block">user must change password in next login</p>
					</div>
					</div>
				</div>
			</div>
			<div class="row">
			<div class="col-lg-6 col-md-6">
				<div class="form-group firstname">
					<label for="Firstname">Firstname</label>
					<input type="text" class="form-control" name="Firstname" placeholder="Write Firstname" value="" autocomplete="off">
					<p class="help-block">Optional</p>
				</div>
			</div>
			<div class="col-lg-6 col-md-6">	
				<div class="form-group surname">
					<label for="Surname">Surname</label>
					<input type="text" class="form-control" name="Surname" placeholder="Write Surname" value="" autocomplete="off">
					<p class="help-block">Optional</p>
				</div>
			</div>
			</div>
			<div class="row">
			<div class="col-lg-6 col-md-6">
				<div class="form-group email">
					<label for="Email">Email</label>
					<input type="text" class="form-control" name="Email" placeholder="Write Email" value="" autocomplete="off">
					<p class="help-block">Optional</p>
				</div>
			</div>
			<div class="col-lg-6 col-md-6">	
				<div class="form-group position">
					<label for="Position">Position</label>
					<input type="text" class="form-control" name="Position" placeholder="Write Position" value="" autocomplete="off">
					<p class="help-block">Optional. For example, Network Engineer</p>
				</div>
			</div>
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