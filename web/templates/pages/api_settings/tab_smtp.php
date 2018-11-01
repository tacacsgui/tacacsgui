<div class="box box-solid">
  <div class="box-body">
    <form id="smtpForm">
    <div class="row">
      <div class="col-lg-6 col-md-6 col-sm-8 col-xs-12">
        <div class="form-group smtp_servers">
          <label for="smtp_servers">SMTP Servers list</label>
          <input type="text" class="form-control" name="smtp_servers" data-type="input" data-default="" data-pickup="true" placeholder="SMTP Servers list" value="" autocomplete="off">
          <input type="hidden" name="smtp_servers_native" value="">
          <p class="text-muted">specify main and backup SMTP servers, e.g. smtp1.example.com;smtp2.example.com</p>
        </div>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-4 col-xs-12">
        <div class="form-group smtp_auth">
          <label for="smtp_auth">SMTP authentication</label>
          <div class="checkbox icheck">
            <label>
              <input type="checkbox" name="smtp_auth" data-type="checkbox" data-default="checked" data-pickup="true"> Enable
            </label>
            <input type="hidden" name="smtp_auth_native" value="">
            <p class="text-muted"></p>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-6">
        <div class="form-group smtp_port">
          <label for="smtp_port">SMTP Server Port</label>
          <input type="number" class="form-control" name="smtp_port" data-type="input" data-default="" data-pickup="true" placeholder="SMTP Server Port" value="" autocomplete="off">
          <input type="hidden" name="smtp_port_native" value="">
          <p class="text-muted"></p>
        </div>
      </div>
      <div class="col-sm-6">
        <div class="form-group smtp_secure">
          <label for="smtp_port">SMTP Secure</label>
          <select class="form-control" name="smtp_secure" data-type="select" data-default="1" data-pickup="true">
            <option value="" selected>None</option>
            <option value="tls">TLS</option>
            <option value="ssl">SSL</option>
          </select>
          <input type="hidden" name="smtp_secure_native" value="">
          <p class="text-muted"></p>
        </div>
      </div>
    </div>
    <div class="row auth_params">
      <div class="col-sm-6 col-xs-12">
        <div class="form-group smtp_username">
          <label for="smtp_username">SMTP Username</label>
          <input type="text" class="form-control" name="smtp_username" data-type="input" data-default="" data-pickup="true" placeholder="SMTP Username" value="" autocomplete="off">
          <input type="hidden" name="smtp_username_native" value="">
          <p class="text-muted"></p>
        </div>
      </div>
      <div class="col-sm-6 col-xs-12">
        <div class="form-group smtp_password">
          <label for="smtp_password">SMTP Password</label>
          <input type="password" class="form-control" name="smtp_password" data-type="input" data-default="" data-pickup="true" placeholder="SMTP Password" value="" autocomplete="off">
          <input type="hidden" name="smtp_password_native" value="">
          <p class="text-muted"></p>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-6 col-xs-12">
        <div class="form-group smtp_from">
          <label for="smtp_from">From (Sender Address)</label>
          <input type="text" class="form-control" name="smtp_from" data-type="input" data-default="" data-pickup="true" placeholder="From Email Address" value="" autocomplete="off">
          <input type="hidden" name="smtp_from_native" value="">
          <p class="text-muted">type sender address</p>
        </div>
      </div>
    </div>
    <div class="tgui_expander">
      <div class="header">
        <h4><i class="fa fa-plus-square"></i> Advanced Settings</h4>
      </div>
      <div class="body">
        <div class="row">
          <div class="col-lg-6 col-md-6 col-sm-4 col-xs-12">
            <div class="form-group smtp_autotls">
              <label for="smtp_autotls">TLS Auto</label>
              <div class="checkbox icheck">
                <label>
                  <input type="checkbox" name="smtp_autotls" data-type="checkbox" data-default="unchecked" data-pickup="true"> Enable
                </label>
                <input type="hidden" name="smtp_autotls_native" value="">
                <p class="text-muted">by default disabled</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    </form>
    <hr>
    <div class="row">
      <div class="col-xs-12">
        <button type="button" class="btn btn-flat btn-success" onclick="tgui_apiSettings.smtp.save()">Apply</button>
      </div>
    </div>
    <hr>
    <h4>Send test message</h4>
    <form id="testSmtpForm">
      <div class="row">
        <div class="col-md-6">
          <div class="form-group smtp_test_email">
            <label for="smtp_test_email">SMTP Username</label>
            <input type="text" class="form-control" name="smtp_test_email" data-type="input" data-default="" data-pickup="true" placeholder="Email Address" value="" autocomplete="off">
            <p class="text-muted"></p>
          </div>
        </div>
      </div>
    </form>
    <div class="row">
      <div class="col-xs-12">
        <button type="button" class="btn btn-flat btn-warning" onclick="tgui_apiSettings.smtp.test()">Send</button>
      </div>
    </div>
    <hr>
    <div class="row">
      <div class="col-xs-12">
        <label>SMTP Engine Output</label>
<pre class="smtp_test_output">
...
</pre>
      </div>
    </div>
  </div><!--.box-body-->
  <div class="overlay">
    <i class="fa fa-refresh fa-spin"></i>
  </div>
</div>
