<div class="row">
<div class="col-lg-6 col-md-6">
	<div class="form-group name">
		<label for="Name">Service Name</label>
		<input type="text" class="form-control" name="name" placeholder="Enter Service Name" autocomplete="off">
		<p class="help-block">it should be unique, but you can change it later</p>
    </div>
</div>
</div>
<div class="row">
<div class="col-lg-6 col-md-6">
	<div class="form-group priv-lvl">
		<label for="priv-lvl">Privilege Level</label>
		<div class="input-group">
				<div class="input-group-btn">
                  <button type="button" class="btn btn-default btn-flat" onclick="setPrivLvl('subtract')"><i class="fa fa-minus"></i></button>
                </div>
                <input type="text" class="form-control text-center" name="priv-lvl" value="-1" autocomplete="off">
				<div class="input-group-btn">
					<button type="button" class="btn btn-default btn-flat" onclick="setPrivLvl('add')"><i class="fa fa-plus"></i></button>
					<button type="button" class="btn btn-warning btn-flat" onclick="setPrivLvl('unset')">Unset</button>
                </div>
        </div>
		<p class="help-block">if it is not set (-1) here or in a group, then it will be equal 15 in configuration</p>
    </div>
</div>
</div>
<div class="row default_service">
	<div class="col-md-6">
		<div class="checkbox icheck">
			<label>
				<input type="checkbox" name="default_cmd" checked> Default CMD Accepted
			</label>
			<p class="help-block">this directive specifies whether the daemon is to accept or reject commands not explicitly permitted</p>
		</div>
	</div>
</div>
<div class="row manual_conf_only">
	<div class="col-md-6">
		<div class="checkbox icheck">
			<label>
				<input type="checkbox" name="manual_conf_only"> Use only manual configuration
			</label>
			<p class="help-block">if checked, only manual configuration will be used, above configuration will be omitted</p>
		</div>
	</div>
</div>