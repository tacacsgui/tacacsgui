<div class="row">
<div class="col-sm-6">
	<div class="form-group name">
		<label for="Name">Service Name</label>
		<input type="text" class="form-control" name="name" data-type="input" data-default="" data-pickup="true" placeholder="Enter Service Name" autocomplete="off">
		<p class="help-block">it should be unique, but you can change it later</p>
    </div>
		<input type="hidden" name="id" value="" data-type="input" data-default="" data-pickup="true">
		<input type="hidden" name="name_native" value="">
</div>
</div>
<div class="row">
	<div class="col-sm-6">
		<div class="form-group priv-lvl">
			<label for="priv-lvl">Privilege Level</label>
			<div class="input-group">
				<div class="input-group-btn">
					<button type="button" class="btn btn-default btn-flat" onclick="tgui_supplier.privLvl('-', this)"><i class="fa fa-minus"></i></button>
				</div>
			<input type="text" class="form-control text-center" name="priv-lvl-preview" data-type="input" data-default="15" value="15" autocomplete="off" disabled>
			<input type="hidden" name="priv-lvl" data-type="input" data-default="15" data-pickup="true" value="15">
			<input type="hidden" name="priv-lvl_native" value="">
			<div class="input-group-btn">
				<button type="button" class="btn btn-default btn-flat" onclick="tgui_supplier.privLvl('+', this)"><i class="fa fa-plus"></i></button>
				<button type="button" class="btn btn-warning btn-flat" onclick="tgui_supplier.privLvl('unset', this)">Unset</button>
			</div>
			</div>
			<p class="help-block">default 15, if Undefined it will not appeared in configuration</p>
		</div>
	</div>
</div>
<div class="row default_service">
	<div class="col-md-6">
		<div class="checkbox icheck">
			<label>
				<input type="checkbox" name="default_cmd" data-type="checkbox" data-default="checked" data-pickup="true" checked> Default CMD Accepted
			</label>
			<p class="help-block">this directive specifies whether the daemon is to accept or reject commands not explicitly permitted</p>
			<input type="hidden" name="default_cmd_native" value="">
		</div>
	</div>
</div>
<div class="row manual_conf_only">
	<div class="col-md-6">
		<div class="checkbox icheck">
			<label>
				<input type="checkbox" name="manual_conf_only" data-type="checkbox" data-default="unchecked" data-pickup="true"> Use only manual configuration
			</label>
			<p class="help-block">if checked, only manual configuration will be used, above configuration will be omitted</p>
			<input type="hidden" name="manual_conf_only_native" value="">
		</div>
	</div>
</div>
