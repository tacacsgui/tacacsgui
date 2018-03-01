<!-- Modal Add User Group -->
<div id="addGroup" class="modal fade" role="dialog">
	<div class="modal-dialog modal-lg">
	<!-- Modal content-->
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h4 class="modal-title">Add New User Group</h4>
		</div>
		<div class="modal-body">
		<form id="addGroupForm">
			<div class="row">
			<div class="col-lg-6 col-md-6">
				<div class="form-group name">
					<label for="name">Name</label>
					<input type="text" class="form-control" name="name" placeholder="Enter Group Name" autocomplete="off">
					<p class="help-block">it should be unique and you can change it later</p>
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
			<button type="button" class="btn btn-flat btn-success" onclick="addGroup()">Add Group</button>
		</div>			
	</div>
	</div>
</div>
      <!-- Modal Add User Group -->