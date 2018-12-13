<div class="row">
  <div class="col-md-3">
    <ul class="nav nav-pills nav-pills-edit nav-stacked">
      <li class="active"><a href="#h3c_general" data-init="true" data-toggle="tab" aria-expanded="true">General</a></li>
      <li><a href="#h3c_restrictions" data-toggle="tab" aria-expanded="true">CMD Set</a></li>
      <li><a href="#h3c_manual" data-toggle="tab" aria-expanded="true">Manual</a></li>
    </ul>
  </div>
  <div class="col-md-9">
    <div class="tab-content tab-content-edit">
      <div class="tab-pane active" id="h3c_general">
        <div class="row">
        	<div class="col-md-6">
            <div class="form-group h3c_enable">
              <label for="h3c_enable">Activate Pattern</label><p class="empty-paragraph"></p>
              <input class="form-control bootstrap-toggle" type="checkbox" name="h3c_enable" data-type="checkbox" data-default="unchecked" data-pickup="true" data-width="100" data-toggle="toggle" data-on="<i class='fa fa-check'></i> Enable" data-off="<i class='fa fa-close'></i> Disable" data-onstyle="success" data-offstyle="warning">
        			<input type="hidden" name="h3c_enable_native" data-type="input" data-default="">
        	  </div>
        	</div>
        </div>
        <hr>
        <div class="row">
        	<div class="col-sm-4">
            <div class="form-group h3c_privlvl">
              <label for="h3c_privlvl">Privilege Level</label>
              <input type="number" class="form-control" name="h3c_privlvl" data-type="input" data-default="15" data-pickup="true" value="15" min="-1" max=15>
        			<input type="hidden" name="h3c_privlvl_native" data-type="input" data-default="">
        	  </div>
        	</div>
        	<div class="col-sm-4">
            <div class="form-group h3c_def_cmd">
              <label for="h3c_def_cmd">Default command</label><p class="empty-paragraph"></p>
              <input type="checkbox" class="form-control bootstrap-toggle" name="h3c_def_cmd"  data-type="checkbox" data-default="checked" data-pickup="true" data-toggle="toggle" data-on="<i class='fa fa-check'></i> Enable" data-off="<i class='fa fa-close'></i> Disable" data-onstyle="success" data-offstyle="warning" data-width="100" checked>
        			<input type="hidden" name="h3c_def_cmd_native" data-type="input" data-default="">
        	  </div>
        	</div>
        	<div class="col-sm-4">
            <div class="form-group h3c_def_attr">
              <label for="h3c_def_attr">Default attribute</label><p class="empty-paragraph"></p>
              <input type="checkbox"  class="form-control bootstrap-toggle" name="h3c_def_attr"  data-type="checkbox" data-default="checked" data-pickup="true" data-toggle="toggle" data-on="<i class='fa fa-check'></i> Enable" data-off="<i class='fa fa-close'></i> Disable" data-onstyle="success" data-offstyle="warning" data-width="100" checked>
        			<input type="hidden" name="h3c_def_attr_native" data-type="input" data-default="">
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
                <div class="form-group h3c_idletime">
                  <label for="h3c_idletime">Idle Time</label>
                  <input type="number" class="form-control" name="h3c_idletime" data-type="input" data-default="" data-pickup="true" value="">
            			<input type="hidden" name="h3c_idletime_native" data-type="input" data-default="">
                  <p class="help-block">in minutes, after which an IDLE session will be terminated</p>
            	  </div>
            	</div>
              <div class="col-sm-6">
                <div class="form-group h3c_timeout">
                  <label for="h3c_timeout">Connection Timeout</label>
                  <input type="number" class="form-control" name="h3c_timeout" data-type="input" data-default="" data-pickup="true" value="">
            			<input type="hidden" name="h3c_timeout_native" data-type="input" data-default="">
                  <p class="help-block">the time until an exec session disconnects unconditionally (in minutes)</p>
            	  </div>
            	</div>
            </div>
          </div>
        </div>
      </div>
      <!-- /.tab-pane -->
      <div class="tab-pane" id="h3c_restrictions">
        <div class="form-group h3c_cmd_list">
      		<label for="h3c_cmd_list">Search CMD Set Name</label>
          <select class="select_cmd_h3c form-control select2" multiple="multiple" name="h3c_cmd_list" style="width:100%"></select>
          <input type="hidden" name="h3c_cmd" data-type="input" data-default="" data-pickup="true">
          <input type="hidden" name="h3c_cmd_native">
          <!-- <div class="tgui-search-bar"></div> -->
      		<p class="help-block">search for pre-configured cmd sets</p>
        </div>
      </div>
      <!-- /.tab-pane -->
      <div class="tab-pane tab-pane-edit" id="h3c_manual">
        <div class="row">
        <div class="col-md-12">
          <div class="form-group h3c_manual">
            <label for="h3c_manual">Manual configuration</label>
            <p class="bg-warning">here you can add your own configuration, <b class="text-red">be careful with that field</b></p>
            <textarea class="form-control" name="h3c_manual" rows="9" placeholder="Manual configuration" data-type="input" data-default="" data-pickup="true"></textarea>
            <textarea name="h3c_manual_native" style="display: none"></textarea>
          </div>
        </div>
        </div>
      </div>
      <!-- /.tab-pane -->
    </div>
  </div>
</div>
