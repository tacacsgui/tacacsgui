<div class="row">
  <div class="col-md-3">
    <ul class="nav nav-pills nav-pills-edit nav-stacked">
      <li class="active"><a href="#general" data-init="true" data-toggle="tab" aria-expanded="true">General</a></li>
      <li><a href="#restrictions" data-toggle="tab" aria-expanded="true">CMD Restrictions</a></li>
      <li><a href="#autocmd" data-toggle="tab" aria-expanded="true">AutoCMD</a></li>
      <li><a href="#cisco_rs_manual" data-toggle="tab" aria-expanded="true">Manual</a></li>
    </ul>
  </div>
  <div class="col-md-9">
    <div class="tab-content tab-content-edit">
      <div class="tab-pane active" id="general">
        <div class="row">
        	<div class="col-md-6">
            <div class="form-group cisco_rs_enable">
              <label for="cisco_rs_enable">Activate Pattern</label><p class="empty-paragraph"></p>
              <input class="form-control bootstrap-toggle" type="checkbox" name="cisco_rs_enable" data-type="checkbox" data-default="unchecked" data-pickup="true" data-width="100" data-toggle="toggle" data-on="<i class='fa fa-check'></i> Enable" data-off="<i class='fa fa-close'></i> Disable" data-onstyle="success" data-offstyle="warning">
        			<input type="hidden" name="cisco_rs_enable_native" data-type="input" data-default="">
        	  </div>
        	</div>
        </div>
        <hr>
        <div class="row">
        	<div class="col-sm-4">
            <div class="form-group cisco_rs_privlvl">
              <label for="cisco_rs_privlvl">Privilege Level</label>
              <input type="number" class="form-control" name="cisco_rs_privlvl" data-type="input" data-default="15" data-pickup="true" value="15" min=0 max=15>
        			<input type="hidden" name="cisco_rs_privlvl_native" data-type="input" data-default="">
        	  </div>
        	</div>
        	<div class="col-sm-4">
            <div class="form-group cisco_rs_def_cmd">
              <label for="cisco_rs_def_cmd">Default command</label><p class="empty-paragraph"></p>
              <input type="checkbox" class="form-control bootstrap-toggle" name="cisco_rs_def_cmd"  data-type="checkbox" data-default="checked" data-pickup="true" data-toggle="toggle" data-on="<i class='fa fa-check'></i> Enable" data-off="<i class='fa fa-close'></i> Disable" data-onstyle="success" data-offstyle="warning" data-width="100" checked>
        			<input type="hidden" name="cisco_rs_def_cmd_native" data-type="input" data-default="">
        	  </div>
        	</div>
        	<div class="col-sm-4">
            <div class="form-group cisco_rs_def_attr">
              <label for="cisco_rs_def_attr">Default attribute</label><p class="empty-paragraph"></p>
              <input type="checkbox"  class="form-control bootstrap-toggle" name="cisco_rs_def_attr"  data-type="checkbox" data-default="checked" data-pickup="true" data-toggle="toggle" data-on="<i class='fa fa-check'></i> Enable" data-off="<i class='fa fa-close'></i> Disable" data-onstyle="success" data-offstyle="warning" data-width="100" checked>
        			<input type="hidden" name="cisco_rs_def_attr_native" data-type="input" data-default="">
        	  </div>
        	</div>
        </div>
        <div class="tgui_expander">
        	<div class="header">
        		<h4><i class="fa fa-plus-square"></i> Advanced Settings </h4>
        	</div>
        	<div class="body">
        		<div class="row">
              <div class="col-sm-6">
                <div class="form-group cisco_rs_idletime">
                  <label for="cisco_rs_idletime">Idle Time</label>
                  <input type="number" class="form-control" name="cisco_rs_idletime" data-type="input" data-default="" data-pickup="true" value="">
            			<input type="hidden" name="cisco_rs_idletime_native" data-type="input" data-default="">
                  <p class="help-block">in minutes, after which an IDLE session will be terminated</p>
            	  </div>
            	</div>
              <div class="col-sm-6">
                <div class="form-group cisco_rs_timeout">
                  <label for="cisco_rs_timeout">Connection Timeout</label>
                  <input type="number" class="form-control" name="cisco_rs_timeout" data-type="input" data-default="" data-pickup="true" value="">
            			<input type="hidden" name="cisco_rs_timeout_native" data-type="input" data-default="">
                  <p class="help-block">the time until an exec session disconnects unconditionally (in minutes)</p>
            	  </div>
            	</div>
            </div>
            <div class="row">
              <div class="col-sm-6">
                <div class="form-group cisco_rs_debug_message">
                  <label for="cisco_rs_debug_message">Show Debug Message</label><p class="empty-paragraph"></p>
                  <input type="checkbox" class="form-control bootstrap-toggle" name="cisco_rs_debug_message"  data-type="checkbox" data-default="unchecked" data-pickup="true" data-toggle="toggle" data-on="<i class='fa fa-check'></i> Enable" data-off="<i class='fa fa-close'></i> Disable" data-onstyle="success" data-offstyle="warning" data-width="100">
            			<input type="hidden" name="cisco_rs_debug_message_native" data-type="input" data-default="">
                  <p class="help-block">while you type any command it will show you examples of the command restrictions</p>
            	  </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- /.tab-pane -->
      <div class="tab-pane" id="restrictions">
        <div class="form-group cisco_rs_cmd_list">
      		<label for="cisco_rs_cmd_list">Search CMD Name</label>
          <select class="select_cmd_cisco form-control select2" multiple="multiple" name="cisco_rs_cmd_list" style="width:100%"></select>
          <input type="hidden" name="cisco_rs_cmd" data-type="input" data-default="" data-type="input" data-default="" data-pickup="true">
          <input type="hidden" name="cisco_rs_cmd_native">
          <!-- <div class="tgui-search-bar"></div> -->
      		<p class="help-block">search for pre-configured cmd sets</p>
        </div>
      </div>
      <!-- /.tab-pane -->
      <div class="tab-pane tab-autocmd" id="autocmd">
        <div class="row">
          <div class="col-sm-6">
            <div class="form-group">
              <label for="login">Add AutoCMD Form</label>
      				<input type="hidden" name="cisco_rs_autocmd">
              <div class="input-group input-group-sm">
              <input type="text" class="form-control atocmd-creator">
                  <span class="input-group-btn">
                    <button type="button" class="btn btn-success btn-flat" onclick="tgui_device_patterns.pattern.cisco.rs.autocmd.append(this);"><i class="fa  fa-arrow-right"></i></button>
                  </span>
              </div>
              <p class="help-block">e.g., show ver</p>
            </div>
        	</div>

          <div class="col-sm-6">
            <label>AutoCMD List</label>
        		<ul class="tgui_sortable">

        		</ul>
        		<p class="help-block">list of attributes</p>
          </div>
      </div>
      </div>
      <!-- /.tab-pane -->
      <div class="tab-pane tab-pane-edit" id="cisco_rs_manual">
        <div class="row">
        <div class="col-md-12">
          <div class="form-group cisco_rs_manual">
            <label for="cisco_rs_manual">Manual configuration</label>
            <p class="bg-warning">here you can add your own configuration, <b class="text-red">be careful with that field</b></p>
            <textarea class="form-control" name="cisco_rs_manual" rows="9" placeholder="Manual configuration" data-type="input" data-default="" data-pickup="true"></textarea>
            <textarea name="cisco_rs_manual_native" style="display: none"></textarea>
          </div>
        </div>
        </div>
      </div>
      <!-- /.tab-pane -->
    </div>
  </div>
</div>
