<h4>Network Settings</h4>
<div class="box box-solid">
  <div class="box-body">
    <form id="networkForm">
    <div class="row">
      <div class="col-sm-3">
        <div class="form-group">
          <label>Select Interfase</label>
          <select class="form-control" placeholder="Select Interface" name="network_interface" data-type="input" data-pickup="true" onchange="tgui_apiSettings.network.get()">
          </select>
          <input type="hidden" name="network_interface_native" value="">
        </div>
      </div>
      <div class="col-sm-9">
        <div class="row">
          <div class="col-md-6 col-xs-12">
            <div class="form-group network_address">
              <label for="network_address">IP Address</label>
              <input type="text" class="form-control" name="network_address" data-type="input" data-default="" data-pickup="true" placeholder="IP Address" value="" autocomplete="off">
              <input type="hidden" name="network_address_native" value="">
              <p class="text-muted">ip address of interface</p>
            </div>
          </div>
          <div class="col-md-6 col-xs-12">
            <div class="form-group network_mask">
              <label for="network_mask">Network Mask</label>
              <input type="text" class="form-control" name="network_mask" data-type="input" data-default="" data-pickup="true" placeholder="Mask" value="" autocomplete="off">
              <input type="hidden" name="network_mask_native" value="">
              <p class="text-muted">network mask</p>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6 col-xs-12">
            <div class="form-group network_gateway">
              <label for="network_gateway">Gateway</label>
              <input type="text" class="form-control" name="network_gateway" data-type="input" data-default="" data-pickup="true" placeholder="Gateway" value="" autocomplete="off">
              <input type="hidden" name="network_gateway_native" value="">
              <p class="text-muted">network gateway</p>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6 col-xs-12">
            <div class="form-group network_dns1">
              <label for="network_dns1">DNS Server Primary</label>
              <input type="text" class="form-control" name="network_dns1" data-type="input" data-default="" data-pickup="true" placeholder="DNS Primary" value="" autocomplete="off">
              <input type="hidden" name="network_dns1_native" value="">
              <p class="text-muted">ip address of dns server</p>
            </div>
          </div>
          <div class="col-md-6 col-xs-12">
            <div class="form-group network_dns2">
              <label for="network_dns2">DNS Server Secondary</label>
              <input type="text" class="form-control" name="network_dns2" data-type="input" data-default="" data-pickup="true" placeholder="DNS Secondary" value="" autocomplete="off">
              <input type="hidden" name="network_dns2_native" value="">
              <p class="text-muted">ip address of dns server</p>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-12">
            <div class="form-group network_more">
              <label for="network_more">More settings</label>
              <textarea type="text" class="form-control" name="network_more" rows="5" data-type="input" data-default="" data-pickup="true" placeholder="More Settings">#test</textarea>
              <input type="hidden" name="network_more_native" value="">
              <p class="text-muted">here you can ser routes and so on, if you don't know what is it please do not put here anything</p>
            </div>
          </div>
        </div>
      </div>
    </div>
    </form>
    <div class="row">
      <div class="col-xs-12">
        <button class="btn btn-flat btn-success" onclick="tgui_apiSettings.network.save()">Save Settings</button>
      </div>
    </div>
  </div>
  <div class="overlay">
    <i class="fa fa-refresh fa-spin"></i>
  </div>
</div>
