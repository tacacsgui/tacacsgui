
var tgui_service = {
  formSelector_add: 'form#addServiceForm',
  formSelector_edit: 'form#editServiceForm',
  init: function() {
    var self = this;
    /*cleare forms when modal is hided*/
    $('#addService').on('hidden.bs.modal', function(){
    	self.clearForm();
    })
    $('#editService').on('hidden.bs.modal', function(){
    	self.clearForm();
    })/*cleare forms*///end
  },
  add: function() {
    console.log('Adding new service');
    var self = this;
    var formData = tgui_supplier.getFormData(self.formSelector_add);
    var ajaxProps = {
      url: API_LINK+"tacacs/services/add/",
      data: formData
    };//ajaxProps END
    ajaxRequest.send(ajaxProps).then(function(resp) {
      if (tgui_supplier.checkResponse(resp.error, self.formSelector_add)){
        return;
      }
      tgui_error.local.show({type:'success', message: "Service "+ $(self.formSelector_add + ' input[name="name"]').val() +" was added"})
      $("#addService").modal("hide");
      tgui_status.changeStatus(resp.changeConfiguration)
      self.clearForm();
      setTimeout( function () {dataTable.ajax.reload()}, 2000 );
    }).fail(function(err){
      tgui_error.getStatus(err, ajaxProps)
    })
    return this;
  },
  getService: function(id, name) {
    var self = this;
    var ajaxProps = {
      url: API_LINK+"tacacs/services/edit/",
      type: "GET",
      data: {
        "name": name,
        "id": id,
      }
    };//ajaxProps END

    ajaxRequest.send(ajaxProps).then(function(resp) {
      tgui_supplier.fulfillForm(resp.service, self.formSelector_edit);

      $(self.formSelector_edit + ' input[name="priv-lvl-preview"]').val( ( parseInt(resp.service['priv-lvl']) > -1) ? resp.service['priv-lvl'] :  "Undefined");
      $('#editService').modal('show')
    }).fail(function(err){
      tgui_error.getStatus(err, ajaxProps)
    })
  },
  edit: function() {
    console.log('Editing service');
    var self = this;
    var formData = tgui_supplier.getFormData(self.formSelector_edit, true);

    var ajaxProps = {
      url: API_LINK+"tacacs/services/edit/",
      type: 'POST',
      data: formData
    };//ajaxProps END

    if ( Object.keys(ajaxProps.data).length <= 1) {
      if (Object.keys(ajaxProps.data)[0] == "id") {
        tgui_error.local.show({type:'warning', message: "Changes did not found"})
        return;
      }
    }
    ajaxRequest.send(ajaxProps).then(function(resp) {
      if (tgui_supplier.checkResponse(resp.error, self.formSelector_edit)){
        return;
      }
      tgui_error.local.show({type:'success', message: "Service "+ $(self.formSelector_edit + ' input[name="name"]').val() +" was edited"})
      $("#editService").modal("hide");
      tgui_status.changeStatus(resp.changeConfiguration)
      self.clearForm();
      setTimeout( function () {dataTable.ajax.reload()}, 2000 );
    }).fail(function(err){
      tgui_error.getStatus(err, ajaxProps)
    })
    return this;
  },
  delete: function(id, name) {
    id = id || 0;
    name = name || 'undefined';
    if (!confirm("Do you want delete '"+name+"'?")) return;
    var ajaxProps = {
      url: API_LINK+"tacacs/services/delete/",
      data: {
        "name": name,
        "id": id,
      }
    };//ajaxProps END
    ajaxRequest.send(ajaxProps).then(function(resp) {
      if( parseInt(resp.result) != 1) {
        tgui_error.local.show( {type:'error', message: "Oops! Unknown error appeared :("} ); return;
      }
      tgui_error.local.show({type:'success', message: "Service "+ name +" was deleted"})
      tgui_status.changeStatus(resp.changeConfiguration)
      setTimeout( function () {dataTable.ajax.reload()}, 2000 );
    }).fail(function(err){
      tgui_error.getStatus(err, ajaxProps)
    })
    return this;
  },
  clearForm: function() {
    tgui_supplier.clearForm();
    /*---*/
    $('.nav.nav-tabs a[href="#general_info"]').tab('show');//select first tab
  	$('.nav.nav-tabs a[href="#general_info_edit"]').tab('show');//select first tab
  }
}
