<div class="row">
<div class="col-sm-6">
  <div class="form-group name">
    <label for="Name">ACL Name</label>
    <input type="hidden"  data-type="input" data-default="" name="name_native">
    <input type="hidden"  data-type="input" data-default="" data-pickup="true" name="id">
    <input type="text" class="form-control" name="name" data-type="input" data-default="" data-pickup="true" placeholder="Enter ACL Name" autocomplete="off">
    <p class="help-block">it should be unique, but you can change it later</p>
          </div>
      </div>
      </div>
<div class="row">
  <div class="col-lg-12">
    <div class="form-group ACEs">
      <label for="Name">Access Control Entries</label>
      <div class="table-responsive">
        <table class="table-striped display table table-bordered aclDT" style="overflow: auto;"></table>
      </div>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-lg-12">
    <div class="btn-group pull-right">
      <button type="button" class="btn btn-success" onclick="tgui_acl.ace.add(this,'down')">Add ACE <i class="fa fa-level-up"></i></button>
      <button type="button" class="btn btn-success" onclick="tgui_acl.ace.add(this,'top')">Add ACE <i class="fa fa-level-down"></i></button>
              </div>
  </div>
</div>
