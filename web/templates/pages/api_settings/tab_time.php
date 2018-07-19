<div class="box box-solid">
  <div class="box-body">
    <form id="timeSettings">
      <div class="row">
      <div class="col-lg-4 col-md-4 col-sm-6">
        <div class="form-group text-center">
          <p>Current server time is <b><time class="current-time text-warning"></time></b></p>
          <button type="button"class="btn btn-warning btn-flat" onclick="tgui_apiSettings.time.getTime()">Check it again</button>
        </div>
      </div>
      <div class="col-lg-4 col-md-4 col-sm-6">
        <div class="form-group timezone">
          <label>Timezones List</label>
          <input type="hidden" name="timezone_native">
          <select class="select_timezone form-control select2" style="width:100%"></select>
        </div>
      </div>
      </div>
      <div class="row">
        <div class="col-md-8 col-xs-12">
          <div class="form-group ntp_list">
            <label for="ntp_list">NTP Server list</label>
            <textarea type="text" class="form-control" name="ntp_list" data-type="input" data-default="" data-pickup="true" placeholder="NTP Server List"></textarea>
            <input type="hidden" name="ntp_list_native" value="">
            <p class="text-muted">e.g. ntp.server.com;192.168.1.2;</p>
          </div>
        </div>
      </div>
      <hr>
      <div class="row">
        <div class="col-xs-12">
          <button type="button" class="btn btn-flat btn-success" onclick="tgui_apiSettings.time.save()">Apply</button>
        </div>
      </div>
      <hr>
      <h4>NTP Status check</h4>
<pre class="ntp-check">...</pre>
      <div class="row">
        <div class="col-xs-12">
          <button type="button" class="btn btn-flat btn-warning" onclick="tgui_apiSettings.time.status()">Check</button>
        </div>
      </div>
    </form>
  </div><!--.box-body-->
  <div class="overlay">
    <i class="fa fa-refresh fa-spin"></i>
  </div>
</div>
