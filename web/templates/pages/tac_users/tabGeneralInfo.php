<div class="row">
	<div class="col-lg-6 col-md-6">
		<div class="form-group username">
			<label for="username">Username</label>
			<div class="input-group">
				<input type="text" class="form-control" name="username" data-type="input" data-default="" data-pickup="true" placeholder="Enter User Name" autocomplete="off">
				<input type="hidden"  data-type="input" data-default="" name="username_native">
				<input type="hidden"  data-type="input" data-default="" data-pickup="true" name="id">
				<div class="input-group-btn disabled">
					<button type="button" class="btn btn-flat btn-success" onclick="tgui_supplier.toggle(this)">Enabled</button>
					<input type="hidden" name="disabled" value="0" data-type="input" data-default="0" data-pickup="true">
					<input type="hidden" data-type="input" data-default="" name="disabled_native">
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
			<input type="hidden" name="group_native" value="">
		</div>
	</div>
</div>
<div class="row">
	<div class="col-lg-6 col-md-6">
		<div class="form-group login">
			<label for="login">Login Password</label>
			<input type="text" class="form-control" name="login" data-type="input" data-default="" data-pickup="true" placeholder="Write Login Password" value="" autocomplete="off">
			<input type="hidden" name="login_native" value="">
		</div>
	</div>
	<div class="col-lg-6 col-md-6">
		<div class="form-group login_flag">
			<label for="login_flag">Enable Encryption</label>
			<select class="form-control" name="login_flag" data-type="select" data-default="1" data-pickup="true">
				<option value="0">Clear Text</option>
				<option value="1" selected>MD5</option>
				<option value="2">DES</option>
				<!--<option value="7">7 (from Cisco Device)</option>-->
			</select>
			<input type="hidden" name="login_flag_native" value="">
		</div>
	</div>
</div>
<div class="row login_encrypt_section">
	<div class="col-lg-12">
		<div class="checkbox icheck">
			<label>
				<input type="checkbox" name="login_encrypt" data-type="checkbox" data-default="checked" data-pickup="true" checked> Encrypt the login password
			</label>
			<p class="help-block">unchecked box will mean that you put encrypted password</p>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-lg-6 col-md-6">
		<div class="form-group enable">
			<label for="enable">Enable Password</label>
			<input type="text" class="form-control" name="enable" data-type="input" data-default="" data-pickup="true" placeholder="Write Enable Password" value="" autocomplete="off">
			<input type="hidden" name="enable_native" value="">
		</div>
	</div>
	<div class="col-lg-6 col-md-6">
		<div class="form-group enable_flag">
			<label for="enable_flag">Enable Encryption</label>
			<select class="form-control" name="enable_flag" data-type="select" data-default="1" data-pickup="true">
				<option value="0">Clear Text</option>
				<option value="1" selected>MD5</option>
				<option value="2">DES</option>
				<!--<option value="7">7 (from Cisco Device)</option>-->
			</select>
			<input type="hidden" name="enable_flag_native" value="">
		</div>
	</div>
</div>
<div class="row enable_encrypt_section">
	<div class="col-lg-12">
		<div class="checkbox icheck">
			<label>
				<input type="checkbox" name="enable_encrypt" data-type="checkbox" data-default="checked" data-pickup="true" checked> Encrypt the enable password
			</label>
			<p class="help-block">unchecked box will mean that you put encrypted password</p>
		</div>
	</div>
</div>
