<div class="row">
	<div class="col-sm-6">
		<div class="form-group name">
			<label for="name">Command Set Name</label>
				<input type="text" class="form-control" name="name" data-type="input" data-default="" data-pickup="true" placeholder="Enter Name" autocomplete="off">
				<input type="hidden" name="name_native" data-type="input" data-default="">
				<input type="hidden"  data-type="input" data-default="" data-pickup="true" name="id">
				<input type="hidden" name="type" data-type="input" data-default="junos" data-pickup="true" value="junos">
				<input type="hidden" name="type_native">
			  <p class="help-block">unique name of attribute used only as a name for search</p>
		</div>
	</div>
</div>
<div class="row">
  <div class="col-sm-12">
    <label for="name">List of Commands</label>
    <input data-role="tagsinput" name="tagsinput">
    <input type="hidden" name="cmd_attr" data-type="input" data-default="" data-pickup="true">
    <input type="hidden" name="cmd_attr_native">
    <p class="help-block">user <kbd>Enter &#8629;</kbd> or comma (<kbd> , </kbd>) key to separate commands</p>
  </div>
</div>
