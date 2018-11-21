<div class="row">
  <div class="col-md-3">
    <ul class="nav nav-pills nav-pills-edit nav-stacked">
      <li class="active"><a href="#cisco_wlc_general" data-init="true" data-toggle="tab" aria-expanded="true">General</a></li>
      <li><a href="#cisco_wlc_manual" data-toggle="tab" aria-expanded="true">Manual</a></li>
    </ul>
  </div>
  <div class="col-md-9">
    <div class="tab-content tab-content-edit">
      <div class="tab-pane tab-pane-edit active" id="cisco_wlc_general">
        <div class="row">
        	<div class="col-md-6">
            <div class="form-group">
              <label for="">Activate Pattern</label><p class="empty-paragraph"></p>
              <input class="bootstrap-toggle" name="cisco_wlc_enable" data-type="checkbox" data-default="unchecked" data-pickup="true" data-width="100" data-toggle="toggle" type="checkbox" data-on="<i class='fa fa-check'></i> Enable" data-off="<i class='fa fa-close'></i> Disable" data-onstyle="success" data-offstyle="warning">
        			<input type="hidden" name="cisco_wlc_enable_native" data-type="input" data-default="">
        	  </div>
        	</div>
        </div>
        <hr>
        <div class="row">
          <div class="form-group col-sm-5 col-md-4">
            <label>Role List</label>
            <select multiple="" class="form-control" name="cisco_wlc_roles_list" size="10">
              <option value="0">ALL (0)</option>
              <option value="2">LOBBY (2)</option>
              <option value="4">MONITOR (4)</option>
              <option value="8">WLAN (8)</option>
              <option value="10">CONTROLLER (10)</option>
              <option value="20">WIRELESS (20)</option>
              <option value="40">SECURITY (40)</option>
              <option value="80">MANAGEMENT (80)</option>
              <option value="100">COMMANDS (100)</option>
            </select>
            <input type="hidden" name="cisco_wlc_roles" data-type="input" data-default="" data-pickup="true">
            <input type="hidden" name="cisco_wlc_roles_native">
          </div>
          <div class="col-md-2 col-sm-2 text-center" style="padding-top: 30px;">
            <div class="btn-group-vertical">
              <button type="button" class="btn btn-default" onclick="tgui_device_patterns.pattern.cisco.wlc.right(this);"><i class="fa fa-angle-double-right"></i></button>
              <button type="button" class="btn btn-default" onclick="tgui_device_patterns.pattern.cisco.wlc.left(this);"><i class="fa fa-angle-double-left"></i></button>
            </div>
          </div>
          <div class="form-group col-md-4 col-sm-5">
            <label>Selected Roles</label>
            <select multiple="" class="form-control" name="cisco_wlc_roles_selected" size="10"></select>
          </div>
        </div>
      </div>
      <!-- /.tab-pane -->
      <div class="tab-pane tab-pane-edit" id="cisco_wlc_manual">
        <div class="row">
        <div class="col-md-12">
        	<div class="form-group cisco_wlc_manual">
        		<label for="cisco_wlc_manual">Manual configuration</label>
        		<p class="bg-warning">here you can add your own configuration, <b class="text-red">be careful with that field</b></p>
        		<textarea class="form-control" name="cisco_wlc_manual" rows="9" placeholder="Manual configuration" data-type="input" data-default="" data-pickup="true"></textarea>
        		<textarea name="cisco_wlc_manual_native" style="display: none"></textarea>
        	</div>
        </div>
        </div>
      </div>
      <!-- /.tab-pane -->
    </div>
  </div>
</div>
