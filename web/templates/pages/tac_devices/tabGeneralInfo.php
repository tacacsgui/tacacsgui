<div class="row">
<div class="col-sm-6">
  <div class="form-group name">
    <label for="Name">Device's Name</label>
    <div class="input-group">
      <input type="hidden"  data-type="input" data-default="" name="name_native">
      <input type="hidden"  data-type="input" data-default="" data-pickup="true" name="id">
      <input type="text" class="form-control" data-type="input" data-default="" data-pickup="true" name="name" placeholder="Enter Device Name" autocomplete="off">
      <div class="input-group-btn disabled">
        <button type="button" class="btn btn-flat btn-success disable-toggle" onclick="tgui_supplier.toggle(this)">Enabled</button>
        <input type="hidden" name="disabled_native" data-default="0" data-type="input" value="0">
        <input type="hidden" name="disabled" data-default="0" data-type="input" value="0" data-pickup="true">
      </div>
    </div>
    <p class="help-block">it should be unique, but you can change it later</p>
          </div>
      </div>
<div class="col-sm-6">
  <div class="form-group group">
    <label>Device Group Name</label>
    <input type="hidden" name="group_native" value="">
    <select class="select_group form-control select2" name="group" data-type="select" data-default="" data-pickup="true" style="width:100%"></select>
    <p class="help-block">Preconfigured values: <small class="label bg-green" style="margin:3px">k</small> - key; <small class="label bg-yellow" style="margin:3px">e</small> - enable; <small class="label bg-gray" style="margin:3px">d</small> - default</p>
          </div>
        </div>
</div>
<div class="row">
  <div class="col-sm-6">
    <div class="form-group ipaddr">
      <label for="IPAddress">Device's IP Address</label>
      <div class="input-group">
        <input type="text" class="form-control" data-type="input" data-default="" name="ipaddr" data-pickup="true" placeholder="Enter IP Address" autocomplete="off">
        <input type="hidden" name="ipaddr_native" value="">
        <div class="input-group-btn">
          <button type="button" class="btn btn-flat btn-gray" onclick="tgui_device.ping(this)">Ping</button>
        </div>
      </div>
    </div>
  </div>
  <div class="col-sm-5">
    <div class="form-group prefix">
      <label for="Prefix">Prefix</label>
      <span><b>/<span name="prefix-value">32</span></b></span>
      <input name="prefix" class="slider" data-slider-id="prefix_slider" type="text" data-slider-min="8" data-slider-max="32" data-slider-step="1" data-slider-value="32">
      <input type="hidden" name="prefix_native" value="">
    </div>
  </div>
</div>
<div class="row">
  <div class="col-sm-6">
    <div class="form-group key">
      <label for="key">Tacacs Key</label>
      <input type="text" class="form-control" name="key" data-type="input" data-default="" data-pickup="true" placeholder="Write Tacacs Key" value="" autocomplete="off">
      <input type="hidden" name="key_native" value="">
    </div>
  </div>
  <div class="col-sm-6">


  </div>
</div>
<div class="row">
  <div class="col-sm-6">
    <div class="form-group enable">
      <label for="enable">Enable Password</label>
      <input type="text" class="form-control" name="enable" data-type="input" data-default="" data-pickup="true" placeholder="Write Enable Password" value="" autocomplete="off">
      <input type="hidden" name="enable_native" value="">
    </div>
  </div>
  <div class="col-sm-6">
    <div class="form-group enable_flag">
      <label for="enable_flag">Type of storing</label>
      <select class="form-control" name="enable_flag" data-objtype="password" data-object="enable" data-type="select" data-default="1" data-pickup="true">
        <option value="0">Clear Text</option>
        <option value="1" selected>MD5</option>
        <!-- <option value="2">DES</option> -->
      </select>
      <input type="hidden" name="enable_flag_native" value="">
    </div>
  </div>
</div>
<div class="row enable_encrypt_section">
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
