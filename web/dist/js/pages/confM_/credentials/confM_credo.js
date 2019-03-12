var cm_credo = {
  formSelector_add: ' form#addCredoForm ',
  formSelector_edit: ' form#editCredoForm ',
  init: function() {
    var self = this;

    /*cleare forms when modal is hided*/
    $('#addCredo').on('hidden.bs.modal', function(){
      self.clearForm();
    })
    $('#editCredo').on('hidden.bs.modal', function(){
      self.clearForm();
    })/*cleare forms*///end
  },
  add: function() {
    var self = this;
    var formData = tgui_supplier.getFormData(self.formSelector_add);

    var ajaxProps = {
      url: API_LINK+"confmanager/credentials/add/",
      data: formData
    };//ajaxProps END
    ajaxRequest.send(ajaxProps).then(function(resp) {
      if (tgui_supplier.checkResponse(resp.error, self.formSelector_add)){
        return;
      }
      tgui_error.local.show({type:'success', message: "Credential "+ $(self.formSelector_add + ' input[name="name"]').val() +" was added"})
      $("#addCredo").modal("hide");

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
      url: API_LINK+"confmanager/credentials/edit/",
      type: "GET",
      data: {
        "name": name,
        "id": id,
      }
    };//ajaxProps END

    ajaxRequest.send(ajaxProps).then(function(resp) {
      tgui_supplier.fulfillForm(resp.credential, self.formSelector_edit);
      $('#editCredo').modal('show')
    }).fail(function(err){
      tgui_error.getStatus(err, ajaxProps)
    })
  },//get edit device

  edit: function() {
    var self = this;

    var formData = tgui_supplier.getFormData(self.formSelector_edit, true);

    var ajaxProps = {
      url: API_LINK+"confmanager/credentials/edit/",
      data: formData
    };//ajaxProps END

    if ( ! tgui_supplier.checkChanges(ajaxProps.data, ['id']) ) return false;

    ajaxRequest.send(ajaxProps).then(function(resp) {
      if (tgui_supplier.checkResponse(resp.error, self.formSelector_edit)){
        return;
      }
      tgui_error.local.show({type:'success', message: "Credential "+ $(self.formSelector_edit + ' input[name="name"]').val() +" was edited"})
      self.clearForm();
      setTimeout( function () {dataTable.table.ajax.reload()}, 2000 );
      $('#editCredo').modal('hide')
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
      url: API_LINK+"confmanager/credentials/delete/",
      data: {
        "name": name,
        "id": id,
      }
    };//ajaxProps END
    ajaxRequest.send(ajaxProps).then(function(resp) {
      if( parseInt(resp.result) != 1) {
        tgui_error.local.show( {type:'error', message: "Oops! Unknown error appeared :("} ); return;
      }
      tgui_error.local.show({type:'success', message: "Credential"+ name +" was deleted"})
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
