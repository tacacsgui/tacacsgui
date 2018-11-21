<div class="row">
  <div class="col-md-3">
    <ul class="nav nav-pills nav-pills-edit nav-stacked">
      <li class="active"><a href="#fortios_general" data-init="true" data-toggle="tab" aria-expanded="true">General</a></li>
      <li><a href="#fortios_manual" data-toggle="tab" aria-expanded="true">Manual</a></li>
    </ul>
  </div>
  <div class="col-md-9">
    <div class="tab-content tab-content-edit">
      <div class="tab-pane active" id="fortios_general">
        <div class="row">
        	<div class="col-md-6">
            <div class="form-group fortios_enable">
              <label for="fortios_enable">Activate Pattern</label><p class="empty-paragraph"></p>
              <input class="form-control bootstrap-toggle" type="checkbox" name="fortios_enable" data-type="checkbox" data-default="unchecked" data-pickup="true" data-width="100" data-toggle="toggle" data-on="<i class='fa fa-check'></i> Enable" data-off="<i class='fa fa-close'></i> Disable" data-onstyle="success" data-offstyle="warning">
        			<input type="hidden" name="fortios_enable_native">
        	  </div>
        	</div>
        </div>
        <h4>Attributes List</h4>
        <div class="row">
          <div class="col-sm-6">
            <div class="form-group fortios_admin_prof">
              <label for="username">Admin Profile</label>
                <input type="text" class="form-control" name="fortios_admin_prof" data-type="input" data-default="" data-pickup="true" autocomplete="new-password">
                <input type="hidden" name="fortios_admin_prof_native">
              <p class="help-block">admin_prof attribute, pre-configured administrator profile name</p>
            </div>
          </div>
        </div>
      </div>
      <!-- /.tab-pane -->
      <div class="tab-pane" id="fortios_manual">
        <div class="row">
        <div class="col-md-12">
        	<div class="form-group fortios_manual">
        		<label for="fortios_manual">Manual configuration (end of user settings)</label>
        		<p class="bg-warning">here you can add your own configuration, <b class="text-red">be careful with that field</b></p>
        		<textarea class="form-control" rows="9" name="fortios_manual" data-type="input" data-default="" data-pickup="true" placeholder="Manual configuration" value=""></textarea>
        		<textarea name="fortios_manual_native" style="display: none"></textarea>
        	</div>
        </div>
        </div>
      </div>
      <!-- /.tab-pane -->
    </div>
  </div>
</div>
