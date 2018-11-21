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
	<div class="col-sm-4">
		<div class="form-group manual_conf_only">
			<label for="manual_conf_only">Only manual configuration</label><p class="empty-paragraph"></p>
			<input type="checkbox" class="form-control bootstrap-toggle" name="manual_conf_only"  data-type="checkbox" data-default="unchecked" data-pickup="true" data-toggle="toggle" data-on="<i class='fa fa-check'></i> Enable" data-off="<i class='fa fa-close'></i> Disable" data-onstyle="success" data-offstyle="warning" data-width="100">
			<input type="hidden" name="manual_conf_only_native">
			<p class="help-block">if checked, only manual configuration will be used</p>
		</div>
	</div>
</div>
