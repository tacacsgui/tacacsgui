<div class="row">
  <div class="col-sm-3">
    <div class="form-group name">
      <label for="Name">Model Name</label>
      <input type="hidden"  data-type="input" data-default="" name="name_native">
      <input type="hidden"  data-type="input" data-default="" data-pickup="true" name="id">
      <input type="text" class="form-control" name="name" data-type="input" data-default="" data-pickup="true" placeholder="Enter Model Name" autocomplete="off">
      <p class="help-block">it should be unique, but you can change it later</p>
    </div>
  </div>
  <div class="col-sm-6">
    <div class="form-group prompt">
      <label for="Name">Default Prompt List</label>
      <input type="hidden"  data-type="input" data-default="" name="prompt_native">
      <input type="text" class="form-control" name="prompt" data-type="input" data-default="" data-pickup="true" placeholder="Enter Prompt List" autocomplete="off">
      <p class="help-block">comma separated promp list, e.g. $,>,#</p>
    </div>
  </div>
  <div class="col-sm-3">
    <div class="form-group pull-right">
      <button type="button" class="btn btn-xs btn-default btn-flat" onclick="cm_models.expect.upload(this)"><i class="fa fa-upload"></i> Upload</button>
      <input type='file' class="import-yaml" onchange="cm_models.expect.import(this)" style="display:none"/>
    </div>
  </div>
</div>
<div class="row expectation-form">
  <input type="hidden" name="ex_id">
  <div class="col-sm-6">
    <div class="form-group expect">
      <label for="Name">Expect</label>
      <input type="text" class="form-control" name="expect" placeholder="Expect Prompt" autocomplete="off">
      <p class="help-block">optional if default prompt set</p>
    </div>
  </div>
  <div class="col-sm-6">
    <div class="form-group send">
      <label for="Name">Send</label>
      <div class="input-group">
        <input type="text" class="form-control" name="send" placeholder="Send Line" autocomplete="off">
        <span class="input-group-addon">
          <input type="checkbox" name="hidden" data-edit="false"> Hide
        </span>
      </div>
      <!-- /input-group -->
      <p class="help-block">send line (command), when an expect matches</p>
    </div>
  </div>
  <div class="col-xs-12">
    <div class="form-group">
      <input type="checkbox" name="write" checked> Collect output (write to file)
    </div>
  </div>
  <div class="col-xs-12 addNewLine">
    <div class="btn-group pull-left">
      <button type="button" class="btn btn-success btn-sm" onclick="cm_models.expect.add(this, 'down')">Add<i class="fa fa-level-up"></i></button>
      <button type="button" class="btn btn-success btn-sm" onclick="cm_models.expect.add(this, 'up')">Add<i class="fa fa-level-down"></i></button>
    </div>
  </div>
  <div class="col-xs-12 editLine" style="display: none;">
    <div class="btn-group pull-left">
      <button type="button" class="btn btn-warning btn-sm" onclick="cm_models.expect.edit(this)">Edit</button>
      <button type="button" class="btn btn-default btn-sm" onclick="cm_models.expect.clear(true)">Cancel</button>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-lg-12">
    <div class="form-group ">
      <label for="Name">List of Expectations</label>
      <ul class="expectations">
      </ul>
    </div>
  </div>
</div>
<textarea name="native_settings" style="display:none;"></textarea>
