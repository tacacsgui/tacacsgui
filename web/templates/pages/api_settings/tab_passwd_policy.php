<form id="passwordPolicyForm">
<div class="box box-solid">
  <div class="box-body">
    <h4>Password Policy For API Users</h4>
    <div class="row">
      <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
    		<div class="form-group api_pw_length">
    			<label for="api_pw_length">Minimal Password Length</label>
    			<input type="number" class="form-control" name="api_pw_length" data-type="input" data-default="8" data-pickup="true" placeholder="Minimal Password Length" value="" autocomplete="off">
    			<input type="hidden" name="api_pw_length_native" value="">
    		</div>
    	</div>
    </div>
    <div class="row">
      <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
        <div class="checkbox icheck">
    			<label>
    				<input type="checkbox" name="api_pw_uppercase" data-type="checkbox" data-default="checked" data-pickup="true"> Upper-case letters
    			</label>
          <input type="hidden" name="api_pw_uppercase_native" value="">
          <p class="text-muted">must contain [A-Z]</p>
    		</div>
    	</div>
      <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
        <div class="checkbox icheck">
    			<label>
    				<input type="checkbox" name="api_pw_lowercase" data-type="checkbox" data-default="checked" data-pickup="true"> Lower-case letters
    			</label>
    			<input type="hidden" name="api_pw_lowercase_native" value="">
          <p class="text-muted">must contain [a-z]</p>
    		</div>
    	</div>
      <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
        <div class="checkbox icheck">
    			<label>
    				<input type="checkbox" name="api_pw_numbers" data-type="checkbox" data-default="checked" data-pickup="true"> Numbers
    			</label>
    			<input type="hidden" name="api_pw_numbers_native" value="">
          <p class="text-muted">must contain [0-9]</p>
    		</div>
    	</div>
      <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
        <div class="checkbox icheck">
    			<label>
    				<input type="checkbox" name="api_pw_special" data-type="checkbox" data-default="checked" data-pickup="true"> Special Characters
    			</label>
    			<input type="hidden" name="api_pw_special_native" value="">
          <p class="text-muted">must contain (~!@#$%^&amp;*_-+=`|(){}[]:;&gt;&lt;,.?/)</p>
    		</div>
    	</div>
      <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
        <div class="checkbox icheck">
    			<label>
    				<input type="checkbox" name="api_pw_same" data-type="checkbox" data-default="checked" data-pickup="true"> The same password check
    			</label>
    			<input type="hidden" name="api_pw_same_native" value="">
          <p class="text-muted">can't set the same password</p>
    		</div>
    	</div>
    </div>
    <hr>
    <h4>Password Policy For Tacacs Users and Devices</h4>
    <div class="row">
      <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
        <div class="form-group tac_pw_length">
          <label for="tac_pw_length">Minimal Password Length</label>
          <input type="number" class="form-control" name="tac_pw_length" data-type="input" data-default="8" data-pickup="true" placeholder="Minimal Password Length" value="" autocomplete="off">
          <input type="hidden" name="tac_pw_length_native" value="">
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
        <div class="checkbox icheck">
          <label>
            <input type="checkbox" name="tac_pw_uppercase" data-type="checkbox" data-default="checked" data-pickup="true"> Upper-case letters
          </label>
          <input type="hidden" name="tac_pw_uppercase_native" value="">
          <p class="text-muted">must contain [A-Z]</p>
        </div>
      </div>
      <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
        <div class="checkbox icheck">
          <label>
            <input type="checkbox" name="tac_pw_lowercase" data-type="checkbox" data-default="checked" data-pickup="true"> Lower-case letters
          </label>
          <input type="hidden" name="tac_pw_lowercase_native" value="">
          <p class="text-muted">must contain [a-z]</p>
        </div>
      </div>
      <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
        <div class="checkbox icheck">
          <label>
            <input type="checkbox" name="tac_pw_numbers" data-type="checkbox" data-default="checked" data-pickup="true"> Numbers
          </label>
          <input type="hidden" name="tac_pw_numbers_native" value="">
          <p class="text-muted">must contain [0-9]</p>
        </div>
      </div>
      <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
        <div class="checkbox icheck">
          <label>
            <input type="checkbox" name="tac_pw_special" data-type="checkbox" data-default="checked" data-pickup="true"> Special Characters
          </label>
          <input type="hidden" name="tac_pw_special_native" value="">
          <p class="text-muted">must contain (~!@#$%^&amp;*_-+=`|(){}[]:;&gt;&lt;,.?/)</p>
        </div>
      </div>
      <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
        <div class="checkbox icheck">
    			<label>
    				<input type="checkbox" name="tac_pw_same" data-type="checkbox" data-default="checked" data-pickup="true"> The same password check
    			</label>
    			<input type="hidden" name="tac_pw_same_native" value="">
          <p class="text-muted">can't set the same password</p>
    		</div>
    	</div>
    </div>
    <hr>
    <div class="row">
      <div class="col-xs-12">
        <button type="button" class="btn btn-flat btn-success" name="button" onclick="tgui_apiSettings.passwordPolicy.save()">Apply</button>
      </div>
    </div>
  </div>
  <div class="overlay">
    <i class="fa fa-refresh fa-spin"></i>
  </div>
</div><!--box-->
</form>
