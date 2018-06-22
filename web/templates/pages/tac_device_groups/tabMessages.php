<div class="row">
<div class="col-md-12">
  <!-- Custom Tabs (Pulled to the right) -->
  <div class="nav-tabs-custom message-tabs">
    <ul class="nav nav-tabs pull-right">
      <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true"><b>Welcome</b></a></li>
      <li class=""><a href="#tab_2" data-toggle="tab" aria-expanded="false"><b>MOTD</b></a></li>
      <li class=""><a href="#tab_4" data-toggle="tab" aria-expanded="false"><b>Failed Auth</b></a></li>
      <li class=""><a href="#tab_5" data-toggle="tab" aria-expanded="false"><b>General Info</b></a></li>
      <li class="pull-left header"><i class="fa fa-align-justify"></i> Banners</li>
    </ul>
    <div class="tab-content">
      <div class="tab-pane active" id="tab_1">
        <div class="form-group">
          <label>Welcome Banner</label>
          <textarea class="form-control" rows="7" data-type="input" data-default="" data-pickup="true" name="banner_welcome" placeholder="Enter Some Text Here"></textarea>
          <textarea name="banner_welcome_native" value="" style="display: none"></textarea>
        </div><!-- /.form-group -->
      </div><!-- /.tab-pane -->
      <div class="tab-pane" id="tab_2">
        <div class="form-group">
          <label>MOTD Banner</label>
          <textarea class="form-control" rows="7" data-type="input" data-default="" data-pickup="true" name="banner_motd" placeholder="Enter Some Text Here"></textarea>
          <textarea name="banner_motd_native" value="" style="display: none"></textarea>
        </div><!-- /.form-group -->
      </div><!-- /.tab-pane -->
      <div class="tab-pane " id="tab_4">
        <div class="form-group">
          <label>Authorization Failed Banner</label>
          <textarea class="form-control" rows="7" data-type="input" data-default="" data-pickup="true" name="banner_failed" placeholder="Enter Some Text Here"></textarea>
          <textarea name="banner_failed_native" value="" style="display: none"></textarea>
        </div><!-- /.form-group -->
      </div><!-- /.tab-pane -->
      <div class="tab-pane " id="tab_5">
        <b>General Info</b>
<pre class="cli_style">
<cli_text_general><cli_text_banner>Test Welcome</cli_text_banner>	<cli_text_comment>### Welcome banner</cli_text_comment>
Password:
Password incorrect.
<cli_text_banner>Failed Auth! Get out!</cli_text_banner>	<cli_text_comment>### Failed Auth banner</cli_text_comment>
<cli_text_banner>Test Welcome</cli_text_banner>	<cli_text_comment>### Welcome banner</cli_text_comment>
Password:
<cli_text_banner>Test MOTD</cli_text_banner>	<cli_text_comment>### MOTD banner</cli_text_comment>
Switch#</cli_text_general>
</pre>
      </div><!-- /.tab-pane -->
    </div><!-- /.tab-content -->
  </div><!-- nav-tabs-custom -->
      </div>
</div>
