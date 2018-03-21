<div class="row">
<div class="col-lg-6 col-md-6">
	<div class="form-group priv-lvl">
		<label for="priv-lvl">Privilege Level</label>
		<div class="input-group">
				<div class="input-group-btn">
                  <button type="button" class="btn btn-default btn-flat" onclick="setPrivLvl('subtract')"><i class="fa fa-minus"></i></button>
                </div>
                <input type="number" class="form-control text-center" name="priv-lvl" value="-1" autocomplete="off" disabled>
				<div class="input-group-btn">
					<button type="button" class="btn btn-default btn-flat" onclick="setPrivLvl('add')"><i class="fa fa-plus"></i></button>
					<button type="button" class="btn btn-warning btn-flat" onclick="setPrivLvl('unset')">Unset</button>
                </div>
        </div>
		<p class="help-block">if it is not set (-1) here or in a group, then it will be equal 15 in configuration</p>
    </div>
</div>
<div class="col-lg-6 col-md-6">
	<div class="form-group group">
		<label>Access Control List</label>
		<select class="select_acl form-control select2" style="width:100%"></select>
		<p class="help-block">select ACL</p>
    </div>
</div>
</div>
<div class="row default_service">
	<div class="col-lg-12">
		<div class="checkbox icheck">
			<label>
				<input type="checkbox" name="default_service" checked> Default service
			</label>
			<p class="help-block">be careful with that checkbox, if you don't know what is it just leave it checked</p>
		</div>
	</div>
</div>