<div class="row">
	<div class="col-sm-6">
		<div class="form-group acl">
			<label>Access Control List</label>
			<select class="select_acl form-control select2" name="acl" data-type="select" data-default="" data-pickup="true" style="width:100%"></select>
			<p class="help-block">select ACL</p>
			<input type="hidden" name="acl_native" value="">
	    </div>
	</div>
	<div class="col-sm-6">
		<div class="form-group user_group">
			<label>Default User Group</label>
			<select class="select_user_group form-control select2" name="user_group" data-type="select" data-default="" data-pickup="true" style="width:100%"></select>
			<input type="hidden" name="user_group_native" value="">
			<p class="help-block">select default user group, for users without any group membership this directive may be used to assign one</p>
	    </div>
	</div>
</div>

<div class="tgui_expander">
	<div class="header">
		<h4><i class="fa fa-plus-square"></i> Advanced Settings</h4>
	</div>
	<div class="body">
		<div class="row">
		  <div class='col-sm-6'>
		      <div class="form-group connection_timeout">
							<label>Connection Timeout</label>
              <input type="number" class="form-control" data-type="input" data-default="0" data-pickup="true" name="connection_timeout" placeholder="Timeout in Seconds" autocomplete="off">
		          <p class="help-block">terminate a connection to this NAS after an idle period of at least <i>s</i> seconds. If it is 0 or empty, global param will be used</p>
							<input type="hidden" name="connection_timeout_native" value="">
		      </div>
		  </div>
		</div>

	</div>
</div>
