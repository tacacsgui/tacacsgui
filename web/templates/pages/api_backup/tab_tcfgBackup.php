<h4>Tacacs Configuration Backup</h4>
<p><small class="text-muted">here is stored information about devices, users, acls, services and mavis modules</small></p>
<form id="tcfg_backupForm" method="post" enctype="multipart/form-data" data-comment="tcfg">
<div class="row">
  <div class="col-sm-6">
    <div class="checkbox icheck">
      <label>
        <input type="checkbox" name="tcfgSet" data-type="checkbox" data-default="check" data-pickup="true"> Make backup every time when configuration is applied
      </label>
      <input type="hidden" name="makeTcfgBackup_native" value="">
      <p class="help-block">when you make backup thsystem check changes</p>
    </div>
  </div>
  <div class="col-sm-6">
      <div class="form-group">
        <label for="file">File input</label>
        <input type="file" name="file" id="file">
        <p class="help-block">file must be named as &lt;date&gt;_tcfg_&lt;revision_number&gt;.sql</p>
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
  <table id="tcfgDataTable" class="table-striped display table table-bordered" style="overflow: auto;">

  </table>
</div>
