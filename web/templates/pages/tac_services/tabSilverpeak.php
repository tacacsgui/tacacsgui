<div class="row">
  <div class="col-md-3">
    <ul class="nav nav-pills nav-pills-edit nav-stacked">
      <li class="active"><a href="#silverpeak_general" data-init="true" data-toggle="tab" aria-expanded="true">General</a></li>
      <li><a href="#silverpeak_manual" data-toggle="tab" aria-expanded="true">Manual</a></li>
    </ul>
  </div>
  <div class="col-md-9">
    <div class="tab-content tab-content-edit">
      <div class="tab-pane active" id="silverpeak_general">
        <div class="row">
        	<div class="col-md-6">
            <div class="form-group silverpeak_enable">
              <label for="silverpeak_enable">Activate Pattern</label><p class="empty-paragraph"></p>
              <input class="form-control bootstrap-toggle" type="checkbox" name="silverpeak_enable" data-type="checkbox" data-default="unchecked" data-pickup="true" data-width="100" data-toggle="toggle" data-on="<i class='fa fa-check'></i> Enable" data-off="<i class='fa fa-close'></i> Disable" data-onstyle="success" data-offstyle="warning">
        			<input type="hidden" name="silverpeak_enable_native">
        	  </div>
        	</div>
        </div>
        <h4>Attributes List</h4>
        <div class="row">
          <div class="col-sm-6">
            <div class="form-group silverpeak_role">
              <label for="username">Role</label>
                <select class="form-control" name="silverpeak_role" data-type="input" data-default="" data-pickup="true">
                  <option value="admin" selected>admin</option>
                  <option value="monitor">monitor</option>
                </select>
                <input type="hidden" name="silverpeak_role_native">
              <p class="help-block"></p>
            </div>
          </div>
        </div>
      </div>
      <!-- /.tab-pane -->
      <div class="tab-pane" id="silverpeak_manual">
        <div class="row">
        <div class="col-md-12">
        	<div class="form-group silverpeak_manual">
        		<label for="silverpeak_manual">Manual configuration (end of user settings)</label>
        		<p class="bg-warning">here you can add your own configuration, <b class="text-red">be careful with that field</b></p>
        		<textarea class="form-control" rows="9" name="silverpeak_manual" data-type="input" data-default="" data-pickup="true" placeholder="Manual configuration" value=""></textarea>
        		<textarea name="silverpeak_manual_native" style="display: none"></textarea>
        	</div>
        </div>
        </div>
      </div>
      <!-- /.tab-pane -->
    </div>
  </div>
</div>
