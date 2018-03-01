<!-- Modal Add User Group-->
<div id="addUserGroup" class="modal fade" role="dialog">
	<div class="modal-dialog modal-lg">
	<!-- Modal content-->
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h4 class="modal-title">Add New User Group</h4>
		</div>
		<div class="modal-body">
		<form id="addUserGroupForm">
			<div class="row">
				<div class="col-lg-6 col-md-6">
					<div class="form-group name">
						<label for="Name">User Group Name</label>
						<input type="text" class="form-control" name="name" placeholder="Enter User Group Name" autocomplete="off">
						<p class="help-block">it should be unique, but you can change it later</p>
					</div>
				</div>
				<div class="col-lg-6 col-md-6">
					<label for="Name">Set as Default</label>
					<div class="checkbox icheck">
						<label>
							<input type="checkbox" name="default_flag"> Set Group As Default
						</label>
						<p class="help-block">if you check it, that group will be as a default group</p>
					</div>
				</div>
            </div>
			<div class="row">
				<div class="col-md-5 col-lg-5">
					<div class="form-group">
						<label>All available access rights</label>
						<select multiple="" size="10" class="form-control availableOptions">
						</select>
					</div>
				</div>
				<div class="col-md-2 col-lg-2 text-center" style="padding-top: 30px;">
					<div class="btn-group-vertical">
                      <button type="button" class="btn btn-default moveOptionRight"><i class="fa fa-angle-double-right"></i></button>
                      <button type="button" class="btn btn-default moveOptionLeft"><i class="fa fa-angle-double-left"></i></button>
                    </div>
				</div>
				<div class="col-md-5 col-lg-5">
					<div class="form-group rights">
						<label>Rights for that group</label>
						<select multiple="" size="10" class="form-control selectedOptions">
						</select>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12 col-lg-12">
				<p class="help-block">use <kbd>ctrl</kbd> to select multiple options</p>
				</div>
			</div>
		</form>
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-flat pull-left" data-dismiss="modal">Close</button>
			<button type="button" class="btn btn-flat btn-success" onclick="addUserGroup()">Add User Group</button>
		</div>			
	</div>
	</div>
</div>
      <!-- Modal Add User Group -->