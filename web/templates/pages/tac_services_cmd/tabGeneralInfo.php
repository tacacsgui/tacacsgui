<div class="row">
	<div class="col-sm-6">
		<div class="form-group name">
			<label for="name">CMD Name</label>
				<input type="text" class="form-control" name="name" data-type="input" data-default="" data-pickup="true" placeholder="Enter Name" autocomplete="off">
				<input type="hidden" name="name_native" data-type="input" data-default="">
				<input type="hidden"  data-type="input" data-default="" data-pickup="true" name="id">
				<input type="hidden" name="type" data-type="input" data-default="cisco" data-pickup="true" value="cisco">
				<input type="hidden" name="type_native">
			  <p class="help-block">unique name of attribute used only as a name for search</p>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-sm-6">
    <div class="form-group cmd">
			<label for="">Main CMD Name</label>
				<input type="text" class="form-control" name="cmd" data-type="input" data-default="" data-pickup="true" placeholder="Start of command" autocomplete="off">
				<input type="hidden" name="cmd_native">
			  <p class="help-block">first part of command, e.g. <i>show</i>,<i>telnet</i>,<i>configure</i> and so on</p>
		</div>
	</div>
	<div class="col-sm-6">
    <div class="form-group">
      <label>Default Action</label><p class="empty-paragraph"></p>
      <input class="bootstrap-toggle" name="cmd_permit_end" data-type="checkbox" data-default="unchecked" data-pickup="true" data-width="100" data-toggle="toggle" type="checkbox" data-on="<i class='fa fa-check'></i> Permit" data-off="<i class='fa fa-close'></i> Deny" data-onstyle="success" data-offstyle="warning">
			<input type="hidden" name="cmd_permit_end_native" data-type="input" data-default="">
    </div>
	</div>
</div>
<div class="row">
  <div class="col-sm-6">
    <div style="background-color: #eee; padding: 5px;">
      <div class="form-group">
        <label for="login">CMD Attribute Form</label>
				<input type="hidden" name="cmd_attr">
        <div class="input-group input-group-sm">
        <input type="text" class="form-control cmd-attr-creator-val">
            <span class="input-group-btn">
              <button type="button" class="btn btn-success btn-flat" onclick="tgui_cmd.cmd_attr.add(this);"><i class="fa  fa-arrow-right"></i></button>
            </span>
        </div>
        <p class="help-block">second part of command, e.g. <i>startup-config</i>, <i>terminal</i>, <i>FastEhernet 0/1</i></p>
      </div>
      <div class="form-group">
        <label>Action</label>
        <div class="">
          <input class="bootstrap-toggle cmd-attr-creator-action" data-width="100" data-toggle="toggle" type="checkbox" data-on="<i class='fa fa-check'></i> Permit" data-off="<i class='fa fa-close'></i> Deny" data-onstyle="success" data-offstyle="warning" checked>
        </div>
      </div>
    </div>
	</div>

  <div class="col-sm-6">
    <label>CMD Attribute List</label>
		<ul class="tgui_sortable">

		</ul>
		<p class="help-block">list of attributes</p>
  </div>
 </div>
