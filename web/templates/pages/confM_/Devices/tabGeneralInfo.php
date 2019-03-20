<div class="row">
  <div class="col-sm-4">
    <div class="form-group name">
      <label for="Name">Device Name</label>
      <input type="hidden"  data-type="input" data-default="" name="name_native">
      <input type="hidden"  data-type="input" data-default="" data-pickup="true" name="id">
      <input type="text" class="form-control" name="name" data-type="input" data-default="" data-pickup="true" placeholder="Enter Device Name" autocomplete="off">
      <p class="help-block">it should be unique, but you can change it later</p>
      <p class="text-danger">beware, name changing will change filename!</p>
    </div>
  </div>
  <div class="col-sm-4">
    <div class="form-group ip">
      <label for="Name">Device IP Address</label>
      <input type="hidden"  data-type="input" data-default="" name="ip_native">
      <input type="text" class="form-control" name="ip" data-type="input" data-default="" data-pickup="true" placeholder="Enter IP Address" autocomplete="off">
      <p class="help-block"></p>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-sm-3">
    <div class="form-group protocol">
      <label for="Name">Protocol</label>
      <input type="hidden"  data-type="input" data-default="" name="protocol_native">
      <select class="form-control" name="protocol" data-type="input" data-default="ssh" data-pickup="true">
        <option value="ssh">ssh</option>
        <option value="telnet">telnet</option>
      </select>
      <p class="help-block">only ssh version 2 supported</p>
    </div>
  </div>
  <div class="col-sm-3">
    <div class="form-group port">
      <label for="Name">Port</label>
      <input type="hidden"  data-type="input" data-default="" name="port_native">
      <input type="number" class="form-control" name="port" data-type="input" data-default="22" data-pickup="true" value="22" placeholder="Enter Port" autocomplete="off">
      <p class="help-block">default port for ssh is 22, for telnet is 23</p>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-sm-6">
    <div class="form-group prompt">
      <label for="Name">Prompt List (Optional)</label>
      <input type="hidden"  data-type="input" data-default="" name="prompt_native">
      <input type="text" class="form-control" name="prompt" data-type="input" data-default="" data-pickup="true" placeholder="Enter Prompt List" autocomplete="off">
      <p class="help-block">if set, prompt list inside of Model will be ignored. Comma separated list</p>
    </div>
  </div>
  <div class="col-sm-6">
    <div class="form-group credential">
      <label for="Name">Credential (Optional)</label>
      <input type="hidden"  data-type="input" data-default="" name="credential_native">
      <select class="form-control select2 select_creden"  name="credential" data-type="select" data-default="" data-pickup="true" style="width:100%"></select>
      <p class="help-block">if set, Query settings will be ignored</p>
    </div>
  </div>
</div>
