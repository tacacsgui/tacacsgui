<div class="row">
  <div class="col-md-3">
    <ul class="nav nav-pills nav-pills-edit nav-stacked">
      <li class="active"><a href="#juniper_general" data-init="true" data-toggle="tab" aria-expanded="true">General</a></li>
      <li><a href="#juniper_o_mode" data-toggle="tab" aria-expanded="true">Operational mode</a></li>
      <li><a href="#juniper_conf_mode" data-toggle="tab" aria-expanded="true">Configuration mode</a></li>
      <li><a href="#juniper_manual" data-toggle="tab" aria-expanded="true">Manual</a></li>
    </ul>
  </div>
  <div class="col-md-9">
    <div class="tab-content tab-content-edit">
      <div class="tab-pane active" id="juniper_general">
        <div class="row">
        	<div class="col-md-6">
            <div class="form-group junos_enable">
              <label for="junos_enable">Activate Pattern</label><p class="empty-paragraph"></p>
              <input class="form-control bootstrap-toggle" type="checkbox" name="junos_enable" data-type="checkbox" data-default="unchecked" data-pickup="true" data-width="100" data-toggle="toggle" data-on="<i class='fa fa-check'></i> Enable" data-off="<i class='fa fa-close'></i> Disable" data-onstyle="success" data-offstyle="warning">
        			<input type="hidden" name="junos_enable_native" data-type="input" data-default="">
        	  </div>
        	</div>
        </div>
        <hr>
        <div class="row">
          <div class="col-sm-6">
            <div class="form-group junos_username">
              <label for="username">Local User Name</label>
              <input type="text" class="form-control" name="junos_username" data-type="input" data-default="" data-pickup="true">
              <input type="hidden" name="junos_username_native" data-type="input" data-default="">
              <p class="help-block">local-user-name attribute</p>
            </div>
          </div>
        </div>
      </div>
      <!-- /.tab-pane -->
      <div class="tab-pane" id="juniper_o_mode">
        <small>Here you can allow/deny commands inside of operational mode ( <kbd>&gt;</kbd> ).</small>
        <div class="row">
          <div class="col-sm-12">
            <div class="form-group junos_cmd_ao">
              <label for="junos_cmd_ao">Allow Command Sets</label>
              <select type="text" class="form-control select_cmd_junos_ao select2" name="junos_cmd_ao_list" multiple="multiple" style="width:100%"></select>
              <p class="help-block">list of command sets, that will be used to allow commands inside of the operation mode</p>
              <!-- <p class="help-block">allow-commands attribute, e.g. <i>(ping .*)|(traceroute .*)|(show .*)|(configure .*)|(edit)|(exit)|(commit)|(rollback .*)</i></p> -->
              <input type="hidden" name="junos_cmd_ao" data-type="input" data-default="" data-pickup="true">
              <input type="hidden" name="junos_cmd_ao_native">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-12">
            <div class="form-group junos_cmd_do">
              <label for="junos_cmd_do">Deny Command Sets</label>
              <select type="text" class="form-control select_cmd_junos_do select2" name="junos_cmd_do_list" multiple="multiple" style="width:100%"></select>
              <input type="hidden" name="junos_cmd_do" data-type="input" data-default="" data-pickup="true">
              <input type="hidden" name="junos_cmd_do_native">
              <p class="help-block">list of command sets, that will be used to deny commands inside of the operation mode</p>
              <!-- <p class="help-block">deny-commands attribute, e.g. <i>(configure .*)|(edit)</i></p> -->
            </div>
          </div>
        </div>
      </div>
      <!-- /.tab-pane -->
      <div class="tab-pane" id="juniper_conf_mode">
        <small>Here you can allow/deny commands inside of configuration mode ( <kbd>#</kbd> ).</small>
        <div class="row">
          <div class="col-sm-12">
            <div class="form-group junos_cmd_ac">
              <label for="junos_cmd_ac">Allow Configuration Command Sets</label>
              <select type="text" class="form-control select_cmd_junos_ac select2" name="junos_cmd_ac_list" multiple="multiple" style="width:100%"></select>
              <input type="hidden" name="junos_cmd_ac" data-type="input" data-default="" data-pickup="true">
              <input type="hidden" name="junos_cmd_ac_native">
              <p class="help-block">list of command sets, that will be used to allow commands inside of the configuration mode</p>
              <!-- <p class="help-block">allow-configuration-regexps attribute, e.g. <i>(interfaces .* unit 0 family ethernet-switching vlan mem.* .*)|(interfaces .* native.* .*)|(interfaces .* unit 0 family ethernet-switching interface-mo.* .*)|(interfaces .* unit .*)|(interfaces .* disable)|(interfaces .* description .*)|(vlans .* vlan-.* .*)</i></p> -->
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-12">
            <div class="form-group junos_cmd_dc">
              <label for="junos_cmd_dc">Deny Configuration Command Sets</label>
              <select type="text" class="form-control select_cmd_junos_dc select2" name="junos_cmd_dc_list" multiple="multiple" style="width:100%"></select>
              <input type="hidden" name="junos_cmd_dc" data-type="input" data-default="" data-pickup="true">
              <input type="hidden" name="junos_cmd_dc_native">
              <p class="help-block">list of command sets, that will be used to deny commands inside of the configuration mode</p>
              <!-- <p class="help-block">deny-configuration-regexps attribute, e.g. <i class="text-red">.*</i> (deny any command except permited)</p> -->
            </div>
          </div>
        </div>
      </div>
      <!-- /.tab-pane -->
      <div class="tab-pane" id="juniper_manual">
        <div class="row junos_manual">
        <div class="col-md-12">
        	<div class="form-group junos_manual">
        		<label for="junos_manual">Manual configuration (end of user settings)</label>
        		<p class="bg-warning">here you can add your own configuration, <b class="text-red">be careful with that field</b></p>
        		<textarea class="form-control" rows="9" name="junos_manual" placeholder="Manual configuration" data-type="input" data-default="" data-pickup="true"></textarea>
        		<textarea value="" name="junos_manual_native" style="display: none"></textarea>
        	</div>
        </div>
        </div>
      </div>
      <!-- /.tab-pane -->
    </div>
  </div>
</div>
