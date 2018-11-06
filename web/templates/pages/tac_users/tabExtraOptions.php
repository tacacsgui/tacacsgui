<div class="row">
	<div class="col-sm-6">
		<div class="form-group pap">
			<label for="pap">PAP Authentication</label>
			<input type="text" class="form-control" name="pap" data-type="input" data-default="#clone_login_password" data-pickup="true" placeholder="Write PAP Password" value="#clone_login_password" autocomplete="new-password" disabled>
			<input type="hidden" name="pap_native" value="">
      <p class="help-block">default login clone, if empty that option will not appeared in configuration</p>
		</div>
	</div>
	<div class="col-sm-6">
		<div class="form-group pap_flag">
			<label for="pap_flag">Type of storing</label>
			<select class="form-control" name="pap_flag" data-objtype="password" data-object="pap" data-type="select" data-default="4" data-pickup="true">
				<option value="0">Clear Text</option>
				<option value="1">MD5</option>
				<!--<option value="2">DES (deprecated)</option>-->
				<!-- <option value="3" selected >Local Database (MAVIS)</option> -->
				<option value="4" selected >Clone Login password</option>
			</select>
			<input type="hidden" name="pap_flag_native" value="">
		</div>
	</div>
</div>
<div class="row pap_encrypt_section" style="display: none;">
	<div class="col-lg-12">
		<div class="checkbox icheck">
			<label>
				<input type="checkbox" name="pap_encrypt" data-type="checkbox" data-default="checked" data-pickup="true" checked> Encrypt the pap password (hashing), uncheck it if you put hash
			</label>
			<p class="help-block">unchecked box will mean that you put encrypted (hashed) password</p>
			<input type="hidden" name="pap_encrypt_native" value="1">
		</div>
	</div>
</div>
<div class="row">
	<div class="col-sm-6">
		<div class="form-group chap">
			<label for="chap">CHAP Authentication</label>
			<input type="text" class="form-control" name="chap" data-type="input" data-default="" data-pickup="true" placeholder="Write CHAP Password" value="" autocomplete="off">
			<input type="hidden" name="chap_native" value="">
      <p class="help-block">default empty, if empty that option will not appeared in configuration</p>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-sm-6">
		<div class="form-group ms-chap">
			<label for="ms-chap">MS-CHAP Authentication</label>
			<input type="text" class="form-control" name="ms-chap" data-type="input" data-default="" data-pickup="true" placeholder="Write MS-CHAP Password" value="" autocomplete="off">
			<input type="hidden" name="ms-chap_native" value="">
      <p class="help-block">default empty, if empty that option will not appeared in configuration</p>
		</div>
	</div>
</div>
