<div class="row">
  <div class="col-sm-6">
    <div class="form-group name">
      <label for="Name">Query Name</label>
      <input type="hidden"  data-type="input" data-default="" name="name_native">
      <input type="hidden"  data-type="input" data-default="" data-pickup="true" name="id">
      <div class="input-group">
        <input type="text" class="form-control" name="name" data-type="input" data-default="" data-pickup="true" placeholder="Enter Filename" autocomplete="off">
        <div class="input-group-btn disabled">
          <button type="button" class="btn btn-flat btn-success" onclick="tgui_supplier.toggle(this)">Enabled</button>
          <input type="hidden" name="disabled" value="0" data-type="input" data-default="0" data-pickup="true">
          <input type="hidden" data-type="input" data-default="" name="disabled_native">
        </div>
      </div>
      <p class="help-block">file will have name <i>device_name</i>_<i>query_name</i></p>
      <p class="text-danger">beware, name changing will change filename!</p>
    </div>
  </div>
  <div class="col-sm-6">
    <div class="form-group f_group">
      <label for="Name">Group</label>
      <input type="hidden"  data-type="input" data-default="" name="f_group_native">
      <select class="form-control select2 select_groups" name="f_group" data-type="select" data-default="" data-pickup="true" style="width:100%"></select>
      <p class="help-block">if selected, the file will be grouped</p>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-sm-4">
    <div class="form-group model">
      <label for="Name">Select Model</label>
      <input type="hidden"  data-type="input" data-default="" name="model_native">
      <select class="form-control select2 select_models"  name="model" data-type="select" data-default="" data-pickup="true" style="width:100%"></select>
      <p class="help-block">select predefined model</p>
    </div>
  </div>
  <div class="col-sm-6">
    <div class="form-group devices">
      <label for="Name">Select Device</label>
      <input type="hidden"  data-type="input" data-default="" name="devices_native">
      <select class="form-control select2 select_devices" multiple="multiple" data-type="select" data-default="" style="width:100%"></select>
      <textarea class="hidden form-control" name="devices" data-type="input" data-default="" data-pickup="true" value=""></textarea>
      <textarea class="hidden form-control" name="devices_native" value=""></textarea>
      <p class="help-block">select multiple device</p>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-sm-6">
    <div class="form-group creden">
      <label for="Name">Credential</label>
      <input type="hidden"  data-type="input" data-default="" name="creden_native">
      <select class="form-control select2 select_creden"  name="creden" data-type="select" data-default="" data-pickup="true" style="width:100%"></select>
      <p class="help-block"></p>
    </div>
  </div>
  <div class="col-sm-6">
    <div class="form-group omit_lines">
      <label for="Name">Omit lines</label>
      <input type="hidden"  data-type="input" data-default="" name="omit_lines_native">
      <input type="text" class="form-control" name="omit_lines" data-type="input" data-default="" data-pickup="true" placeholder="Enter Prompt List" autocomplete="off">
      <p class="help-block"></p>
    </div>
  </div>
</div>
