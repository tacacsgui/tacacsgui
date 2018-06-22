<div class="row">
	<div class="col-lg-6 col-md-6">
		<div class="form-group pap">
			<label for="pap">PAP Authentication</label>
			<input type="text" class="form-control" name="pap" data-type="input" data-default="" data-pickup="true" placeholder="Write PAP Password" value="" autocomplete="off">
			<input type="hidden" name="pap_native" value="">
      <p class="help-block">default empty, if empty that option will not appeared in configuration</p>
		</div>
	</div>
	<div class="col-lg-6 col-md-6">
		<div class="form-group pap_flag">
			<label for="pap_flag">Enable Encryption</label>
			<select class="form-control" name="pap_flag" data-type="select" data-default="1" data-pickup="true">
				<option value="0">Clear Text</option>
				<option value="1" selected>MD5</option>
				<option value="2">DES</option>
				<!--<option value="7">7 (from Cisco Device)</option>-->
			</select>
			<input type="hidden" name="pap_flag_native" value="">
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-6 pap_encrypt_section">
		<div class="checkbox icheck">
			<label>
				<input type="checkbox" name="pap_encrypt" data-type="checkbox" data-default="checked" data-pickup="true" checked> Encrypt the pap password
			</label>
			<p class="help-block">unchecked box will mean that you put encrypted password</p>
		</div>
	</div>
  <div class="col-md-6">
		<div class="checkbox icheck">
			<label>
				<input type="checkbox" name="pap_clone" data-type="checkbox" data-default="unchecked" data-pickup="true"> Clone the login password
			</label>
			<p class="help-block">checked box will mean that you will use login password (configured on General tab)</p>
		</div>
    <input type="hidden" name="pap_clone_native" value="">
	</div>
</div>
<div class="row">
	<div class="col-lg-6 col-md-6">
		<div class="form-group chap">
			<label for="chap">CHAP Authentication</label>
			<input type="text" class="form-control" name="chap" data-type="input" data-default="" data-pickup="true" placeholder="Write CHAP Password" value="" autocomplete="off">
			<input type="hidden" name="chap_native" value="">
      <p class="help-block">default empty, if empty that option will not appeared in configuration</p>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-lg-6 col-md-6">
		<div class="form-group ms-chap">
			<label for="ms-chap">MS-CHAP Authentication</label>
			<input type="text" class="form-control" name="ms-chap" data-type="input" data-default="" data-pickup="true" placeholder="Write MS-CHAP Password" value="" autocomplete="off">
			<input type="hidden" name="ms-chap_native" value="">
      <p class="help-block">default empty, if empty that option will not appeared in configuration</p>
		</div>
	</div>
</div>
