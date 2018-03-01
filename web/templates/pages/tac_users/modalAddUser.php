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
			<div class="row">
			<div class="col-lg-6 col-md-6">
				<div class="form-group username">
					<label for="username">Username</label>
					<div class="input-group">
						<input type="text" class="form-control" name="username" placeholder="Enter User Name" autocomplete="off">
						<div class="input-group-btn disabled">
							<button type="button" class="btn btn-flat btn-success" onclick="disabledSwitcher('add')">Enabled</button>
							<input type="number" name="disabled" value="0" style="display:none;">
						</div>
					</div>
					<p class="help-block">it will be used for authorization and you can change it later</p>
                </div>
            </div>
			<div class="col-lg-6 col-md-6">
				<div class="form-group group">
					<label>User Group Name</label>
					<select class="select_group form-control select2" style="width:100%"></select>
					<p class="help-block">Preconfigured values: <small class="label bg-yellow" style="margin:3px">e</small> - enable; <small class="label bg-gray" style="margin:3px">m</small> - message</p>
                </div>
            </div>
            </div>
			<div class="row">
				<div class="col-lg-6 col-md-6">
					<div class="form-group login">
						<label for="login">Login Password</label>
						<input type="text" class="form-control" name="login" placeholder="Write Login Password" value="" autocomplete="off">
					</div>
				</div>
				<div class="col-lg-6 col-md-6">	
					<div class="form-group login_flag">
						<label for="login_flag">Enable Encryption</label>
						<select class="form-control" name="login_flag">
							<option value="0">Clear Text</option>
							<option value="1" selected>MD5</option>
							<option value="2">DES</option>
							<!--<option value="7">7 (from Cisco Device)</option>-->
						</select>
					</div>
				</div>
			</div>
			<div class="row login_encrypt_section">
				<div class="col-lg-12">
					<div class="checkbox icheck">
						<label>
							<input type="checkbox" name="login_encrypt" checked> Encrypt the login password
						</label>
						<p class="help-block">unchecked box will mean that you put encrypted password</p>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-6 col-md-6">
					<div class="form-group enable">
						<label for="enable">Enable Password</label>
						<input type="text" class="form-control" name="enable" placeholder="Write Enable Password" value="" autocomplete="off">
					</div>
				</div>
				<div class="col-lg-6 col-md-6">	
					<div class="form-group enable_flag">
						<label for="enable_flag">Enable Encryption</label>
						<select class="form-control" name="enable_flag">
							<option value="0">Clear Text</option>
							<option value="1" selected>MD5</option>
							<option value="2">DES</option>
							<!--<option value="7">7 (from Cisco Device)</option>-->
						</select>
					</div>
				</div>
			</div>
			<div class="row enable_encrypt_section">
				<div class="col-lg-12">
					<div class="checkbox icheck">
						<label>
							<input type="checkbox" name="enable_encrypt" checked> Encrypt the enable password
						</label>
						<p class="help-block">unchecked box will mean that you put encrypted password</p>
					</div>
				</div>
			</div>
			<div class="row">
			<div class="col-lg-6 col-md-6">
				<div class="form-group message">
					<label for="group">Message</label>
					<textarea type="text" class="form-control" name="message" placeholder="Write message here"></textarea>
					<p class="help-block">this message will appear after login and MOTD (if configured) for that user </p>
				</div>
			</div>
			</div>
			<div class="row default_service">
				<div class="col-lg-12">
					<div class="checkbox icheck">
						<label>
							<input type="checkbox" name="default_service" checked> Default service
						</label>
						<p class="help-block">be careful with that checkbox, if you don't know what is it just leave it checked</p>
					</div>
				</div>
			</div>
			<div class="row manualConfTrigger">
			<div class="col-md-12">
				<a href="#" class="manualConfTrigger">Manual configuration</a>	
			</div>
			</div>
			<div class="row manualConfiguration" style="display: none">
			<div class="col-md-12">
				<div class="form-group manualConfiguration">
					<label for="manualConfiguration">Manual configuration</label>
					<p class="bg-warning">here you can add your own configuration, <b class="text-red">be careful with that field</b></p>
					<textarea class="form-control" name="manual" placeholder="Manual configuration" value=""></textarea>
				</div>
			</div>
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