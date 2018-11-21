<div class="row">
  <div class="col-md-3">
    <ul class="nav nav-pills nav-pills-edit nav-stacked">
      <li class="active"><a href="#paloalto_general" data-init="true" data-toggle="tab" aria-expanded="true">General</a></li>
      <li><a href="#paloalto_manual" data-toggle="tab" aria-expanded="true">Manual</a></li>
    </ul>
  </div>
  <div class="col-md-9">
    <div class="tab-content tab-content-edit">
      <div class="tab-pane active" id="paloalto_general">
        <div class="row">
        	<div class="col-md-6">
            <div class="form-group paloalto_enable">
              <label for="paloalto_enable">Activate Pattern</label><p class="empty-paragraph"></p>
              <input class="form-control bootstrap-toggle" type="checkbox" name="paloalto_enable" data-type="checkbox" data-default="unchecked" data-pickup="true" data-width="100" data-toggle="toggle" data-on="<i class='fa fa-check'></i> Enable" data-off="<i class='fa fa-close'></i> Disable" data-onstyle="success" data-offstyle="warning">
        			<input type="hidden" name="paloalto_enable_native" data-type="input" data-default="">
        	  </div>
        	</div>
        </div>
        <h4>Attributes List</h4>
        <div class="row">
          <div class="col-sm-6">
            <div class="form-group paloalto_admin_role">
              <label for="paloalto_admin_role">PaloAlto Admin Role</label>
                <input type="text" class="form-control" name="paloalto_admin_role" data-type="input" data-default="" data-pickup="true" autocomplete="new-password">
                <input type="hidden" name="paloalto_admin_role_native" value="">
              <p class="help-block">a default (dynamic) administrative role name or a custom administrative role name on the firewall</p>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="form-group paloalto_admin_domain">
              <label for="paloalto_admin_domain">PaloAlto Admin Access Domain</label>
                <input type="text" class="form-control" name="paloalto_admin_domain" data-type="input" data-default="" data-pickup="true" autocomplete="new-password">
                <input type="hidden" name="paloalto_admin_domain_native" value="">
              <p class="help-block">the name of an access domain for firewall administrators (configured in the DeviceAccess Domains page). Define this VSA if the firewall has multiple virtual systems</p>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-6">
            <div class="form-group paloalto_panorama_admin_role">
              <label for="paloalto_panorama_admin_role">PaloAlto Panorama Admin Role</label>
                <input type="text" class="form-control" name="paloalto_panorama_admin_role" data-type="input" data-default="" data-pickup="true" autocomplete="new-password">
                <input type="hidden" name="paloalto_panorama_admin_role_native" value="">
              <p class="help-block">a default (dynamic) administrative role name or a custom administrative role name on Panorama</p>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="form-group paloalto_panorama_admin_domain">
              <label for="paloalto_panorama_admin_domain">PaloAlto Panorama Admin Access Domain</label>
                <input type="text" class="form-control" name="paloalto_panorama_admin_domain" data-type="input" data-default="" data-pickup="true" autocomplete="new-password">
                <input type="hidden" name="paloalto_panorama_admin_domain_native" value="">
              <p class="help-block">the name of an access domain for Device Group and Template administrators (configured in the PanoramaAccess Domains page)</p>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-6">
            <div class="form-group paloalto_user_group">
              <label for="paloalto_user_group">PaloAlto User Group</label>
                <input type="text" class="form-control" name="paloalto_user_group" data-type="input" data-default="" data-pickup="true" autocomplete="new-password">
                <input type="hidden" name="paloalto_user_group_native" value="">
              <p class="help-block">the name of a user group in the Allow List of an authentication profile</p>
            </div>
          </div>
        </div>
      </div>
      <!-- /.tab-pane -->
      <div class="tab-pane" id="paloalto_manual">
        <div class="row">
        <div class="col-md-12">
        	<div class="form-group paloalto_manual">
        		<label for="paloalto_manual">Manual configuration (end of user settings)</label>
        		<p class="bg-warning">here you can add your own configuration, <b class="text-red">be careful with that field</b></p>
        		<textarea class="form-control" rows="9" name="paloalto_manual" data-type="input" data-default="" data-pickup="true" placeholder="Manual configuration" value=""></textarea>
        		<textarea name="paloalto_manual_native" style="display: none"></textarea>
        	</div>
        </div>
        </div>
      </div>
      <!-- /.tab-pane -->
    </div>
  </div>
</div>
