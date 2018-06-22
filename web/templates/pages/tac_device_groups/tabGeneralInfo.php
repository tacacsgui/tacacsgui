<div class="row">
  <div class="col-lg-6 col-md-6">
    <div class="form-group name">
      <label for="Name">Device Group Name</label>
      <input type="text" class="form-control" data-type="input" data-default="" data-pickup="true" name="name" placeholder="Enter Device Group Name" autocomplete="off">
      <input type="hidden"  data-type="input" data-default="" name="name_native">
      <input type="hidden"  data-type="input" data-default="" data-pickup="true" name="id">
      <p class="help-block">it should be unique, but you can change it later</p>
    </div>
  </div>
  <div class="col-lg-6 col-md-6">
    <label for="Name">Set as Default</label>
    <div class="checkbox icheck">
      <label>
        <input type="checkbox" name="default_flag" data-type="checkbox" data-default="unchecked" data-pickup="true" unchecked> Set Group As Default
      </label>
      <input type="hidden" name="default_flag_native" value="">
      <p class="help-block">if you check it, that group will be as a default group</p>
    </div>
  </div>
      </div>
<div class="row">
  <div class="col-lg-6 col-md-6">
    <div class="form-group key">
      <label for="key">Tacacs Key</label>
      <input type="text" class="form-control" data-type="input" data-default="" data-pickup="true" name="key" placeholder="Write Tacacs Key" value="" autocomplete="off">
      <input type="hidden" name="key_native" value="">
    </div>
  </div>
  <div class="col-lg-6 col-md-6">


  </div>
</div>
<div class="row">
  <div class="col-lg-6 col-md-6">
    <div class="form-group enable">
      <label for="enable">Enable Password</label>
      <input type="text" class="form-control" data-type="input" data-default="" data-pickup="true" name="enable" placeholder="Write Enable Password" value="" autocomplete="off">
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
      <input type="hidden" name="enable_encrypt_native" value="">
      <p class="help-block">unchecked box will mean that you put encrypted password</p>
    </div>
  </div>
</div>
