<!-- Modal Add Device Group-->
<div id="addDeviceGroup" class="modal fade" role="dialog">
	<div class="modal-dialog modal-lg">
	<!-- Modal content-->
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h4 class="modal-title">Add New Device Group</h4>
		</div>
		<div class="modal-body">
		<form id="addDeviceGroupForm">
			<div class="row">
				<div class="col-lg-6 col-md-6">
					<div class="form-group name">
						<label for="Name">Device Group Name</label>
						<input type="text" class="form-control" name="name" placeholder="Enter Device Group Name" autocomplete="off">
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
				<div class="col-lg-6 col-md-6">
					<div class="form-group key">
						<label for="key">Tacacs Key</label>
						<input type="text" class="form-control" name="key" placeholder="Write Tacacs Key" value="" autocomplete="off">
					</div>
				</div>
				<div class="col-lg-6 col-md-6">	
					
					
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
			<div class="col-md-12">
				<!-- Custom Tabs (Pulled to the right) -->
				<div class="nav-tabs-custom">
					<ul class="nav nav-tabs pull-right">
						<li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true"><b>Welcome</b></a></li>
						<li class=""><a href="#tab_2" data-toggle="tab" aria-expanded="false"><b>MOTD</b></a></li>
						<!--<li class=""><a href="#tab_3" data-toggle="tab" aria-expanded="false"><b>Message</b></a></li> -->
						<li class=""><a href="#tab_4" data-toggle="tab" aria-expanded="false"><b>Failed Auth</b></a></li>
						<li class=""><a href="#tab_5" data-toggle="tab" aria-expanded="false"><b>General Info</b></a></li>
						<li class="pull-left header"><i class="fa fa-align-justify"></i> Banners</li>
					</ul>
					<div class="tab-content">
						<div class="tab-pane active" id="tab_1">
							<div class="form-group">
								<label>Welcome Banner</label>
								<textarea class="form-control" rows="3" name="banner_welcome" placeholder="Enter Some Text Here"></textarea>
							</div><!-- /.form-group -->
						</div><!-- /.tab-pane -->
						<div class="tab-pane" id="tab_2">
							<div class="form-group">
								<label>MOTD Banner</label>
								<textarea class="form-control" rows="3" name="banner_motd" placeholder="Enter Some Text Here"></textarea>	
							</div><!-- /.form-group -->
						</div><!-- /.tab-pane -->
						<!--<div class="tab-pane " id="tab_3">
							<div class="form-group">
								<label>Message Banner</label>
								<textarea class="form-control" rows="3" name="banner_message" placeholder="Enter Some Text Here"></textarea>	
							</div><!-- /.form-group -->
						<!--</div> /.tab-pane -->
						<div class="tab-pane " id="tab_4">
							<div class="form-group">
								<label>Authorization Failed Banner</label>
								<textarea class="form-control" rows="3" name="banner_failed" placeholder="Enter Some Text Here"></textarea>	
							</div><!-- /.form-group -->
						</div><!-- /.tab-pane -->
						<div class="tab-pane " id="tab_5">
							<b>General Info</b>
<pre class="cli_style">
<cli_text_general><cli_text_banner>Test Welcome</cli_text_banner>	<cli_text_comment>### Welcome banner</cli_text_comment>
Password:
Password incorrect.
<cli_text_banner>Failed Auth! Get out!</cli_text_banner>	<cli_text_comment>### Failed Auth banner</cli_text_comment>
<cli_text_banner>Test Welcome</cli_text_banner>	<cli_text_comment>### Welcome banner</cli_text_comment>
Password:
<cli_text_banner>Test MOTD</cli_text_banner>	<cli_text_comment>### MOTD banner</cli_text_comment>
Switch#</cli_text_general>
</pre>
						</div><!-- /.tab-pane -->
					</div><!-- /.tab-content -->
				</div><!-- nav-tabs-custom -->
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
			<button type="button" class="btn btn-flat btn-success" onclick="addDeviceGroup()">Add Device Group</button>
		</div>			
	</div>
	</div>
</div>
      <!-- Modal Add Device Group -->