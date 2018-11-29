<div class="row">
  <div class="col-sm-12">
    <div class="form-group device_list_action">
      <label>Device Group List</label><p class="empty-paragraph"></p>
      <label><input class="bootstrap-toggle" name="device_list_action" data-type="checkbox" data-default="unchecked" data-pickup="true" data-width="100" data-toggle="toggle" type="checkbox" data-on="<i class='fa fa-check'></i> Allow" data-off="<i class='fa fa-close'></i> Deny" data-onstyle="success" data-offstyle="danger" unchecked> access to the list of device groups below</label>
      <p class="help-block">default action to the list below. <i class="text-success">Allow</i> means< - allow ONLY that list, <i class="text-danger">Deny</i> means - allow all EXCEPT the list of device</p>
      <input type="hidden" name="device_list_action_native">
    </div>
  </div>
</div>
<div class="device_action_change deny">
  <div class="row">
  <div class="col-lg-12 col-md-12">
  	<div class="form-group device_group_list">
  		<label for="group">Device Groups List</label>
      <select class="select_device_group_list form-control select2" multiple="multiple" data-default="" data-type="select" style="width:100%"></select>
      <textarea class="hidden form-control" name="device_group_list" data-type="input" data-default="" data-pickup="true" value=""></textarea>
      <textarea class="hidden form-control" name="device_group_list_native" value=""></textarea>
  		<p class="help-block"></p>
  	</div>
  </div>
  </div>
  <div class="row">
  <div class="col-lg-12 col-md-12">
  	<div class="form-group device_list">
  		<label for="group">Device List</label>
      <select class="select_device_list form-control select2" multiple="multiple" data-default="" data-type="select" style="width:100%"></select>
      <textarea class="hidden form-control" name="device_list" data-type="input" data-default="" data-pickup="true" value=""></textarea>
      <textarea class="hidden form-control" name="device_list_native" value=""></textarea>
  		<p class="help-block"></p>
  	</div>
  </div>
  </div>
</div>
