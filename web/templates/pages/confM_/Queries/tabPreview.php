<div class="row">
  <div class="col-sm-4">
    <div class="form-group">
      <label>Select Device</label>
      <select class="form-control" name="device_preview"></select>
    </div>
    <p><b>Selected Model:</b> <model></model></p>
    <p><b>Omit Lines:</b> <omitLines></omitLines></p>
    <div class="checkbox">
      <label><input type="checkbox" name="preview_debug">Debug</label>
    </div>
    <div class="">
      <a class="btn btn-flat btn-info btn-block" onclick="cm_queries.preview.run(this)">Preview</a>
    </div>
  </div>
  <div class="col-sm-8">
    <pre class="preview_resp">
    </pre>
  </div>
</div>
