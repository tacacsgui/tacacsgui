<div class="row">
  <div class="col-sm-6">
    <div class="form-group name">
      <label for="Name">User Group Name</label>
      <input type="text" class="form-control" name="name" data-type="input" data-default="" data-pickup="true" placeholder="Enter User Group Name" autocomplete="off">
      <p class="help-block">it should be unique, but you can change it later</p>
      <input type="hidden"  data-type="input" data-default="" name="name_native">
      <input type="hidden"  data-type="input" data-default="" data-pickup="true" name="id">
    </div>
  </div>
  <div class="col-sm-6">
    <label for="Name">Set as Default</label>
    <div class="checkbox icheck">
      <label>
        <input type="checkbox" name="default_flag" data-type="checkbox" data-default="uncheck" data-pickup="true"> Set Group As Default
      </label>
      <input type="hidden"  data-type="input" data-default="" name="default_flag_native">
      <p class="help-block">if you check it, that group will be as a default group</p>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-md-5 col-lg-5">
    <div class="form-group">
      <label>All available access rights</label>
      <select multiple="" size="10" class="form-control availableOptions">
      </select>
    </div>
  </div>
  <div class="col-md-2 col-lg-2 text-center" style="padding-top: 30px;">
    <div class="btn-group-vertical">
                <button type="button" class="btn btn-default moveOptionRight"><i class="fa fa-angle-double-right"></i></button>
                <button type="button" class="btn btn-default moveOptionLeft"><i class="fa fa-angle-double-left"></i></button>
              </div>
  </div>
  <div class="col-md-5 col-lg-5">
    <div class="form-group rights">
      <label>Rights for that group</label>
      <select multiple="" size="10" class="form-control selectedOptions">
      </select>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-md-12 col-lg-12">
  <p class="help-block">use <kbd>ctrl</kbd> to select multiple options</p>
  </div>
</div>
