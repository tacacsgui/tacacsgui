<!-- Modal Add Device -->
<div id="addDevice" class="modal fade" role="dialog">
	<div class="modal-dialog modal-lg">
	<!-- Modal content-->
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h4 class="modal-title">Add New Device</h4>
		</div>
		<div class="modal-body">
		<form id="addDeviceForm">
			<div class="row">
			<div class="col-lg-6 col-md-6">
				<div class="form-group name">
					<label for="Name">Device's Name</label>
					<div class="input-group">
						<input type="text" class="form-control" name="name" placeholder="Enter Device's Name" autocomplete="off">
						<div class="input-group-btn disabled">
							<button type="button" class="btn btn-flat btn-success" onclick="disabledSwitcher('add')">Enabled</button>
							<input type="number" name="disabled" value="0" style="display:none;">
						</div>
					</div>
					<p class="help-block">it should be unique, but you can change it later</p>
                </div>
            </div>
			<div class="col-lg-6 col-md-6">
				<div class="form-group group">
					<label>Device Group Name</label>
					<select class="select_group form-control select2" style="width:100%"></select>
					<p class="help-block">Preconfigured values: <small class="label bg-green" style="margin:3px">k</small> - key; <small class="label bg-yellow" style="margin:3px">e</small> - enable; <small class="label bg-gray" style="margin:3px">d</small> - default</p>
                </div>
            </div>
            </div>
			<div class="row">
				<div class="col-lg-6 col-md-6">
					<div class="form-group ipaddr">
						<label for="IPAddress">Device's IP Address</label>
						<div class="input-group">
							<input type="text" class="form-control" name="ipaddr" placeholder="Enter IP Address" autocomplete="off">
							<div class="input-group-btn">
								<button type="button" class="btn btn-flat btn-gray" onclick="ping('add')">Ping</button>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-5 col-md-5">
					<div class="form-group prefix">
						<label for="Prefix">Prefix</label>
						<span><b>/<span name="prefix-value">32</span></b></span>
						<input name="prefix" data-slider-id="prefix_slider" type="text" data-slider-min="8" data-slider-max="32" data-slider-step="1" data-slider-value="32">
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
			<button type="button" class="btn btn-flat btn-success" onclick="addDevice()">Add Device</button>
		</div>			
	</div>
	</div>
</div>
      <!-- Modal Add Device -->