<form id="notification_settings">
  <h4>Bad Authentication Settings</h4>
  <div class="row">
    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
      <div class="form-group bad_authentication_enable">
      <div class="checkbox icheck">
        <label>
          <input type="checkbox" name="bad_authentication_enable" data-type="checkbox" data-default="checked" data-pickup="true"> Enable Notification
        </label>
        <input type="hidden" name="bad_authentication_enable_native" value="">
        <p class="help-block"></p>
      </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
      <div class="form-group bad_authentication_count">
        <label for="bad_authentication_count">Bad Authentication count</label>
        <input type="number" class="form-control" name="bad_authentication_count" data-type="input" data-default="" data-pickup="true" placeholder="Interval" value="" autocomplete="off">
        <input type="hidden" name="bad_authentication_count_native" value="">
        <p class="help-block">bad authentications in a minute</p>
      </div>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
      <div class="form-group bad_authentication_interval">
        <label for="bad_authentication_interval">Interval</label>
        <input type="number" class="form-control" name="bad_authentication_interval" data-type="input" data-default="" data-pickup="true" placeholder="Interval" value="" autocomplete="off">
        <input type="hidden" name="bad_authentication_interval_native" value="">
        <p class="help-block">if a notification is corresponding to the same ip address, it will be suspended for the time interval (minutes)</p>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-xs-12">
      <div class="form-group bad_authentication_email_list">
        <label for="bad_authentication_email_list">Additional Email List</label>
        <textarea type="number" class="form-control" name="bad_authentication_email_list" data-type="input" data-default="" data-pickup="true" placeholder="Additional Email List" value="" autocomplete="off"></textarea>
        <input type="hidden" name="bad_authentication_email_list_native" value="">
        <p class="help-block">list of email user1@example.com;user2@example.com</p>
      </div>
    </div>
  </div>
  <hr>
  <h4>Bad Authorization Settings</h4>
  <div class="row">
    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
      <div class="checkbox icheck">
        <label>
          <input type="checkbox" name="bad_authorization_enable" data-type="checkbox" data-default="checked" data-pickup="true"> Enable Notification
        </label>
        <input type="hidden" name="bad_authorization_enable_native" value="">
        <p class="help-block"></p>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
      <div class="form-group bad_authorization_count">
        <label for="bad_authorization_count">Bad Authorization count</label>
        <input type="number" class="form-control" name="bad_authorization_count" data-type="input" data-default="" data-pickup="true" placeholder="Interval" value="" autocomplete="off">
        <input type="hidden" name="bad_authorization_count_native" value="">
        <p class="help-block">bad authorization in a minute</p>
      </div>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
      <div class="form-group bad_authorization_interval">
        <label for="bad_authorization_interval">Interval</label>
        <input type="number" class="form-control" name="bad_authorization_interval" data-type="input" data-default="" data-pickup="true" placeholder="Interval" value="" autocomplete="off">
        <input type="hidden" name="bad_authorization_interval_native" value="">
        <p class="help-block">if a notification is corresponding to the same ip address, it will be suspended for the time interval (minutes)</p>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-xs-12">
      <div class="form-group bad_authorization_email_list">
        <label for="bad_authorization_email_list">Additional Email List</label>
        <textarea type="number" class="form-control" name="bad_authorization_email_list" data-type="input" data-default="" data-pickup="true" placeholder="Additional Email List" value="" autocomplete="off"></textarea>
        <input type="hidden" name="bad_authorization_email_list_native" value="">
        <p class="help-block">list of email user1@example.com;user2@example.com</p>
      </div>
    </div>
  </div>
</form>
<hr>
<div class="row">
  <div class="col-xs-12">
    <button type="button" class="btn btn-success btn-flat" onclick="api_notification.settings.save()">Save</button>
  </div>
</div>
