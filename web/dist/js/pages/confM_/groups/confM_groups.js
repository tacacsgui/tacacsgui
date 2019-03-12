var cm_groups = {
  formSelector_add: ' form#addGroupForm ',
  formSelector_edit: ' form#editGroupForm ',
  init: function() {
    var self = this

    /*cleare forms when modal is hided*/
    $('#addGroup').on('hidden.bs.modal', function(){
      self.clearForm();
    })
    $('#editGroup').on('hidden.bs.modal', function(){
      self.clearForm();
    })/*cleare forms*///end
  },
  add: function() {
    var self = this;
    var formData = tgui_supplier.getFormData(self.formSelector_add);

    var ajaxProps = {
      url: API_LINK+"confmanager/groups/add/",
      data: formData
    };//ajaxProps END
    ajaxRequest.send(ajaxProps).then(function(resp) {
      if (tgui_supplier.checkResponse(resp.error, self.formSelector_add)){
        return;
      }
      tgui_error.local.show({type:'success', message: "Group "+ $(self.formSelector_add + ' input[name="name"]').val() +" was added"})
      $("#addGroup").modal("hide");
      self.clearForm();
      setTimeout( function () {dataTable.table.ajax.reload()}, 2000 );
    }).fail(function(err){
      tgui_error.getStatus(err, ajaxProps)
    })
    return this;
  },//add device

  get: function(id, name) {
    var self = this;

    var ajaxProps = {
      url: API_LINK+"confmanager/groups/edit/",
      type: "GET",
      data: {
        "name": name,
      }
    };//ajaxProps END

    ajaxRequest.send(ajaxProps).then(function(resp) {
      tgui_supplier.fulfillForm(resp.group, self.formSelector_edit);
      $(self.formSelector_edit + '[name="name_old"]').val(resp.group.name)
      $('#editGroup').modal('show')
    }).fail(function(err){
      tgui_error.getStatus(err, ajaxProps)
    })
  },//get edit device

  edit: function() {
    var self = this;

    var formData = tgui_supplier.getFormData(self.formSelector_edit, true);

    var ajaxProps = {
      url: API_LINK+"confmanager/groups/edit/",
      data: formData
    };//ajaxProps END

    if ( ! tgui_supplier.checkChanges(ajaxProps.data, ['id']) ) return false;

    formData.name_old = $(self.formSelector_edit + '[name="name_old"]').val();

    ajaxRequest.send(ajaxProps).then(function(resp) {
      if (tgui_supplier.checkResponse(resp.error, self.formSelector_edit)){
        return;
      }
      tgui_error.local.show({type:'success', message: "Group "+ $(self.formSelector_edit + ' input[name="name"]').val() +" was edited"})
      self.clearForm();
      setTimeout( function () {dataTable.table.ajax.reload()}, 2000 );
      $('#editGroup').modal('hide')
    }).fail(function(err){
      tgui_error.getStatus(err, ajaxProps)
    })
  },//post edit device

  del: function(id, name, flag) {
    id = id || 0;
    flag = (flag !== undefined) ? false : true;
    name = name || 'undefined';
    if (flag && !confirm("Do you want delete '"+name+"'?")) return;
    var ajaxProps = {
      url: API_LINK+"confmanager/groups/delete/",
      data: {
        "name": name,
        "id": id,
      }
    };//ajaxProps END
    ajaxRequest.send(ajaxProps).then(function(resp) {
      if( parseInt(resp.result) == 2) {
        tgui_error.local.show( {type:'error', message: "Group has members! We can delete ONLY empty groups"} ); return;
      }
      if( parseInt(resp.result) != 1) {
        tgui_error.local.show( {type:'error', message: "Oops! Unknown error appeared :("} ); return;
      }
      tgui_error.local.show({type:'success', message: "Group "+ name +" was deleted"})
      setTimeout( function () {dataTable.table.ajax.reload()}, 2000 );
    }).fail(function(err){
      tgui_error.getStatus(err, ajaxProps)
    })
    return this;
  },//delete device

  clearForm: function() {
    tgui_supplier.clearForm();
    /*---*/
  },
}
