<div class="row">
<div class="col-lg-6 col-md-6">
  <div class="form-group username">
    <label for="Username">Username</label>
    <input type="text" class="form-control" name="username" data-type="input" data-default="" data-pickup="true" placeholder="Enter User Name" autocomplete="off">
    <p class="help-block">it will be used for authorization and you can't change it further time</p>
    <input type="hidden"  data-type="input" data-default="" name="username_native">
    <input type="hidden"  data-type="input" data-default="" data-pickup="true" name="id">
  </div>
</div>
<div class="col-lg-6 col-md-6">
  <div class="form-group group">
    <label>User Group</label>
    <select class="select_group form-control select2" style="width:100%"></select>
    <input type="hidden" name="group_native">
  </div>
</div>
</div>
<div class="row">
<div class="col-lg-6 col-md-6">
  <div class="form-group password">
    <label for="Password">Password</label>
    <div class="input-group">
      <input type="password" class="form-control" name="password" data-type="input" data-default="" data-pickup="true" placeholder="Enter Password" autocomplete="off">
      <input type="hidden" name="password_native">
      <div class="input-group-btn">
        <button type="button" class="btn btn-flat" onclick="tgui_userApi.showPasswd(this, 'show')"
      onmouseout="tgui_userApi.showPasswd(this)"><i class="fa fa-eye"></i></button>
      </div>
    </div><!-- /btn-group -->
  </div>
</div>
<div class="col-lg-6 col-md-6">
  <div class="form-group rep_password">
    <label for="rep_password">Repeat Password</label>
    <div class="input-group">
      <input type="password" class="form-control" name="rep_password" data-type="input" data-default="" data-pickup="true" placeholder="Repeat Password" autocomplete="off">
      <input type="hidden" name="rep_password_native">
      <div class="input-group-btn">
        <button type="button" class="btn btn-flat" onclick="tgui_userApi.showPasswd(this, 'show')"
        onmouseout="tgui_userApi.showPasswd(this)"><i class="fa fa-eye"></i></button>
      </div><!-- /btn-group -->
    </div><!-- /btn-group -->
  </div>
</div>
</div>
<div class="row">
  <div class="col-lg-12">
    <div class="cform-group changePasswd">
    <div class="checkbox icheck">
      <label>
        <input type="checkbox" name="changePasswd" data-type="checkbox" data-default="uncheck" data-pickup="true"> Change password in next login
      </label>
      <input type="hidden" name="changePasswd_native" value="">
      <p class="help-block">user must change password in next login</p>
    </div>
    </div>
  </div>
</div>
<div class="row">
<div class="col-lg-6 col-md-6">
  <div class="form-group firstname">
    <label for="Firstname">Firstname</label>
    <input type="text" class="form-control" name="firstname" data-type="input" data-default="" data-pickup="true" placeholder="Write Firstname" value="" autocomplete="off">
    <p class="help-block">Optional</p>
    <input type="hidden" name="firstname_native" value="">
  </div>
</div>
<div class="col-lg-6 col-md-6">
  <div class="form-group surname">
    <label for="Surname">Surname</label>
    <input type="text" class="form-control" name="surname" data-type="input" data-default="" data-pickup="true" placeholder="Write Surname" value="" autocomplete="off">
    <p class="help-block">Optional</p>
    <input type="hidden" name="surname_native" value="">
  </div>
</div>
</div>
<div class="row">
<div class="col-lg-6 col-md-6">
  <div class="form-group email">
    <label for="Email">Email</label>
    <input type="text" class="form-control" name="email" data-type="input" data-default="" data-pickup="true" placeholder="Write Email" value="" autocomplete="off">
    <p class="help-block">Optional</p>
    <input type="hidden" name="email_native" value="">
  </div>
</div>
<div class="col-lg-6 col-md-6">
  <div class="form-group position">
    <label for="Position">Position</label>
    <input type="text" class="form-control" name="position" data-type="input" data-default="" data-pickup="true" placeholder="Write Position" value="" autocomplete="off">
    <p class="help-block">Optional. For example, Network Engineer</p>
    <input type="hidden" name="position_native" value="">
  </div>
</div>
</div>
