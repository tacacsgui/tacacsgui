<div class="row">
	<div class="col-sm-6">
		<div class="form-group username">
			<label for="username">Username</label>
			<div class="input-group">
				<input type="text" class="form-control" name="username" data-type="input" data-default="" data-pickup="true" placeholder="Enter User Name" autocomplete="new-password">
				<input type="hidden"  data-type="input" data-default="" name="username_native">
				<input type="hidden"  data-type="input" data-default="" data-pickup="true" name="id">
				<div class="input-group-btn disabled">
					<button type="button" class="btn btn-flat btn-success" onclick="tgui_supplier.toggle(this)">Enabled</button>
					<input type="hidden" name="disabled" value="0" data-type="input" data-default="0" data-pickup="true">
					<input type="hidden" data-type="input" data-default="" name="disabled_native">
				</div>
			</div>
			<p class="help-block">it will be used for authentication and you can change it later</p>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-sm-6">
		<div class="form-group login">
			<label for="login">Login Password</label>
			<input type="password" class="form-control" name="login" data-type="input" data-default="" data-pickup="true" placeholder="Write Login Password" value="" onfocus="tgui_supplier.clearOnFocus(this)" onfocusout="tgui_supplier.clearOnFocus(this,'out')" autocomplete="new-password">
			<input type="hidden" name="login_native" value="">
		</div>
	</div>
	<div class="col-sm-6">
		<div class="form-group login_flag">
			<label for="login_flag">Type of storing</label>
			<select class="form-control" name="login_flag" data-objtype="password" data-object="login" data-type="select" data-default="1" data-pickup="true">
				<option value="0">Clear Text</option>
				<option value="1">MD5</option>
				<!--<option value="2">DES (deprecated)</option>-->
				<option value="3" selected >Local Database (MAVIS)</option>
			</select>
			<input type="hidden" name="login_flag_native" value="">
			<p class="help-block">it can be stored as clear text, MD5 hash or inside of local database</p>
		</div>
	</div>
</div>
<div class="row login_encrypt_section" style="display: none;">
	<div class="col-lg-12">
		<div class="checkbox icheck">
			<label>
				<input type="checkbox" name="login_encrypt" data-type="checkbox" data-default="checked" data-pickup="true" checked> Encrypt the login password (hashing), uncheck it if you put hash
			</label>
			<p class="help-block">unchecked box will mean that you put encrypted (hashed) password</p>
			<input type="hidden" name="login_encrypt_native" value="1">
		</div>
	</div>
</div>
<div class="row login_change">
	<div class="col-lg-12">
		<div class="checkbox icheck">
			<label>
				<input type="checkbox" name="login_change" data-type="checkbox" data-default="checked" data-pickup="true" checked> User can change login password
			</label>
			<p class="help-block">user can change your password via device's CLI or via GUI portal</p>
			<input type="hidden" name="login_change_native" value="">
		</div>
	</div>
</div>
<div class="row">
	<div class="col-sm-6">
		<div class="form-group enable">
			<label for="enable">Enable Password</label>
			<input type="text" class="form-control" name="enable" data-type="input" data-default="#clone_login_password" data-pickup="true" placeholder="Write Enable Password" value="#clone_login_password" autocomplete="new-password" disabled>
			<input type="hidden" name="enable_native" value="">
		</div>
	</div>
	<div class="col-sm-6">
		<div class="form-group enable_flag">
			<label for="enable_flag">Type of storing</label>
			<select class="form-control" name="enable_flag" data-objtype="password" data-object="enable" data-type="select" data-default="4" data-pickup="true">
				<option value="0">Clear Text</option>
				<option value="1">MD5</option>
				<!--<option value="2">DES (deprecated)</option>-->
				<!-- <option value="3" >Local Database (MAVIS)</option> -->
				<option value="4" selected >Clone Login password</option>
			</select>
			<input type="hidden" name="enable_flag_native" value="">
		</div>
	</div>
</div>
<div class="row enable_encrypt_section" style="display: none;">
	<div class="col-lg-12">
		<div class="checkbox icheck">
			<label>
				<input type="checkbox" name="enable_encrypt" data-type="checkbox" data-default="checked" data-pickup="true" checked> Encrypt the enable password (hashing), uncheck it if you put hash
			</label>
			<p class="help-block">unchecked box will mean that you put encrypted (hashed) password</p>
			<input type="hidden" name="enable_encrypt_native" value="1">
		</div>
	</div>
</div>
<div class="row enable_change" style="display: none;">
	<div class="col-lg-12">
		<div class="checkbox icheck">
			<label>
				<input type="checkbox" name="enable_change" data-type="checkbox" data-default="checked" data-pickup="true" checked> User can change enable password
			</label>
			<p class="help-block">user can change your password via GUI portal</p>
			<input type="hidden" name="enable_change_native" value="">
		</div>
	</div>
</div>
