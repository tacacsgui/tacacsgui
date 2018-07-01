<h4>API Configuration Backup</h4>
<p><small class="text-muted">here is stored information api users, groups and settings</small></p>
<form id="apicfg_backupForm" method="post" enctype="multipart/form-data" data-comment="apicfg">
<div class="row">
  <div class="col-sm-6">
    <div class="checkbox icheck">
      <label>
        <input type="checkbox" name="apicfgSet" data-type="checkbox" data-default="check" data-pickup="true"> Make backup every time when api user or group is added
      </label>
      <input type="hidden" name="makeTcfgBackup_native" value="">
      <p class="help-block"></p>
    </div>
    <div class="form-group">
      <label for="file">Make backup right now</label>
      <div class="">
        <input type="button" class="btn btn-flat btn-primary" onclick="tgui_apiBackup.make('apicfg')" value="Create Backup">
      </div>
    </div>
    <div class="form-group">
      <div class="checkbox icheck">
        <label>
          <input type="checkbox" name="diff" data-type="checkbox" data-default="check" checked> Check difference with the last backup
        </label>
      </div>
      <p class="help-block">if difference will not found backup will not made</p>
    </div>
  </div>
  <div class="col-sm-6">
      <div class="form-group">
        <label for="file">File input</label>
        <input type="file" name="file" id="file">
        <p class="help-block">file must be named as &lt;date&gt;_apicfg_&lt;revision_number&gt;.sql</p>
      </div>
      <div class="form-group">
        <input type="button" class="btn btn-flat btn-primary" onclick="tgui_apiBackup.upload(this)" value="Upload">
        <p class="" name="file_status"></p>
      </div>
      <div class="row">
        <div class="col-xs-12">
          <div class="progress progress-sm active">
            <div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
              <span class="sr-only">0% Complete</span>
            </div>
          </div>
        </div>
      </div>
  </div>
</div>
</form>
<hr>
<div class="table-responsive">
  <table id="apicfgDataTable" class="table-striped display table table-bordered" style="overflow: auto;">

  </table>
</div>
