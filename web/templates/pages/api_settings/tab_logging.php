<div class="box box-solid">
  <div class="box-body">
    <div class="row">
      <div class="col-md-6">
        <h4>API Logging</h4>
        <div class="form-group">
          <label>Delete Logging</label>
          <div class="input-group">
            <span class="input-group-btn">
              <button type="button" class="btn btn-danger btn-flat" onclick="tgui_apiSettings.delete.api_log()">Delete</button>
            </span>
            <select class="form-control" name="api_log_date">
              <option value="3 years">older then 3 years</option>
              <option value="1 year">older then 1 years</option>
              <option value="6 months">older then 6 months</option>
              <option value="3 months">older then 3 months</option>
              <option value="1 month">older then 1 month</option>
              <option value="all">ALL LOGS</option>
            </select>
          </div>
        </div>
      </div>
    </div>
    <hr>
    <div class="row">
      <div class="col-md-6">
        <h4>Tacacs Authintication Logging</h4>
        <div class="form-group">
          <label>Delete Logging</label>
          <div class="input-group">
            <span class="input-group-btn">
              <button type="button" class="btn btn-danger btn-flat" onclick="tgui_apiSettings.delete.tac_log('authentication')">Delete</button>
            </span>
            <select class="form-control" name="tac_log_authentication">
              <option value="3 years">older then 3 years</option>
              <option value="1 year">older then 1 years</option>
              <option value="6 months">older then 6 months</option>
              <option value="3 months">older then 3 months</option>
              <option value="1 month">older then 1 month</option>
              <option value="all">ALL LOGS</option>
            </select>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-6">
        <h4>Tacacs Authorization Logging</h4>
        <div class="form-group">
          <label>Delete Logging</label>
          <div class="input-group">
            <span class="input-group-btn">
              <button type="button" class="btn btn-danger btn-flat" onclick="tgui_apiSettings.delete.tac_log('authorization')">Delete</button>
            </span>
            <select class="form-control" name="tac_log_authorization">
              <option value="3 years">older then 3 years</option>
              <option value="1 year">older then 1 years</option>
              <option value="6 months">older then 6 months</option>
              <option value="3 months">older then 3 months</option>
              <option value="1 month">older then 1 month</option>
              <option value="all">ALL LOGS</option>
            </select>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-6">
        <h4>Tacacs Accounting Logging</h4>
        <div class="form-group">
          <label>Delete Logging</label>
          <div class="input-group">
            <span class="input-group-btn">
              <button type="button" class="btn btn-danger btn-flat" onclick="tgui_apiSettings.delete.tac_log('accounting')">Delete</button>
            </span>
            <select class="form-control" name="tac_log_accounting">
              <option value="3 years">older then 3 years</option>
              <option value="1 year">older then 1 years</option>
              <option value="6 months">older then 6 months</option>
              <option value="3 months">older then 3 months</option>
              <option value="1 month">older then 1 month</option>
              <option value="all">ALL LOGS</option>
            </select>
          </div>
        </div>
      </div>
    </div>
    <hr>
    <div class="row">
      <div class="col-md-6">
        <h4>Logging tree</h4>
        <div id="logging-folder-tree">
        </div>
        <p class="text-muted">just click on file that you want to download</p>
      </div>
    </div>
  </div>
  <div class="overlay">
    <i class="fa fa-refresh fa-spin"></i>
  </div>
</div>
