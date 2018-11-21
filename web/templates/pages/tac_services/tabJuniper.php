<div class="row">
  <div class="col-md-3">
    <ul class="nav nav-pills nav-stacked">
      <li class="active"><a href="#juniper_general" data-toggle="tab" aria-expanded="true">General</a></li>
      <li><a href="#juniper_manual" data-toggle="tab" aria-expanded="true">Manual</a></li>
    </ul>
  </div>
  <div class="col-md-9">
    <div class="tab-content">
      <div class="tab-pane active" id="juniper_general">
        <div class="row">
        	<div class="col-md-6">
        		<div class="checkbox icheck">
        			<label>
        				<input type="checkbox" unchecked> Enable Juniper Pattern
        			</label>
        			<p class="help-block">it is not working now</p>
        			<input type="hidden" value="">
        		</div>
        	</div>
        </div>
        <h4>Attributes List</h4>
        <div class="row">
          <div class="col-sm-6">
            <div class="form-group username">
              <label for="username">Local User Name</label>
                <input type="text" class="form-control" autocomplete="new-password">
              <p class="help-block">local-user-name attribute</p>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-12">
            <div class="form-group username">
              <label for="username">Allow Commands</label>
                <textarea type="text" class="form-control" autocomplete="new-password"></textarea>
              <p class="help-block">allow-commands attribute, e.g. <i>(ping .*)|(traceroute .*)|(show .*)|(configure .*)|(edit)|(exit)|(commit)|(rollback .*)</i></p>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-12">
            <div class="form-group username">
              <label for="username">Allow Configuration Regexps</label>
                <textarea type="text" class="form-control" autocomplete="new-password"></textarea>
              <p class="help-block">allow-configuration-regexps attribute, e.g. <i>(interfaces .* unit 0 family ethernet-switching vlan mem.* .*)|(interfaces .* native.* .*)|(interfaces .* unit 0 family ethernet-switching interface-mo.* .*)|(interfaces .* unit .*)|(interfaces .* disable)|(interfaces .* description .*)|(vlans .* vlan-.* .*)</i></p>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-12">
            <div class="form-group username">
              <label for="username">Deny Commands</label>
                <textarea type="text" class="form-control" autocomplete="new-password"></textarea>
              <p class="help-block">deny-commands attribute, e.g. <i>(configure .*)|(edit)</i></p>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-12">
            <div class="form-group username">
              <label for="username">Deny Configuration Regexps</label>
                <textarea type="text" class="form-control" autocomplete="new-password"></textarea>
              <p class="help-block">deny-configuration-regexps attribute, e.g. <i class="text-red">.*</i> (deny any command except permited)</p>
            </div>
          </div>
        </div>
      </div>
      <!-- /.tab-pane -->
      <div class="tab-pane" id="juniper_manual">
        <div class="row manualConfiguration">
        <div class="col-md-12">
        	<div class="form-group manualConfiguration">
        		<label for="manualConfiguration">Manual configuration (end of user settings)</label>
        		<p class="bg-warning">here you can add your own configuration, <b class="text-red">be careful with that field</b></p>
        		<textarea class="form-control" rows="9" placeholder="Manual configuration" value=""></textarea>
        		<textarea value="" style="display: none"></textarea>
        	</div>
        </div>
        </div>
      </div>
      <!-- /.tab-pane -->
    </div>
  </div>
</div>
