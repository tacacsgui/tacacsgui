var cm_devices = {
  formSelector_add: ' form#addDeviceForm ',
  formSelector_edit: ' form#editDeviceForm ',
  select_creden_add: ' form#addDeviceForm ' + ' .select_creden.select2 ',
  select_creden_edit: ' form#editDeviceForm ' + ' .select_creden.select2',
  select_tac_dev_add: ' form#addDeviceForm ' + ' .select_tac_dev.select2 ',
  select_tac_dev_edit: ' form#editDeviceForm ' + ' .select_tac_dev.select2',
  init: function() {
    var self = this;

    /*Select2 TAC Devices*/
    this.tacDevSelect2 = new tgui_select2({
      ajaxUrl : API_LINK+"tacacs/device/list/",
      template: this.selectionTemplate_credential,
      placeholder: "Select TacGUI Device",
      allowClear: true,
      add: this.select_tac_dev_add,
      edit: this.select_tac_dev_edit,
    });
    $(this.select_tac_dev_add).select2(this.tacDevSelect2.select2Data());
    $(this.select_tac_dev_edit).select2(this.tacDevSelect2.select2Data());
    /*Select2 TAC Devices*///END
    /*Select2 Credential*/
    this.credenSelect2 = new tgui_select2({
      ajaxUrl : API_LINK+"confmanager/credentials/list/",
      template: this.selectionTemplate_credential,
      placeholder: "Select Credential",
      allowClear: true,
      add: this.select_creden_add,
      edit: this.select_creden_edit,
    });
    $(this.select_creden_add).select2(this.credenSelect2.select2Data());
    $(this.select_creden_edit).select2(this.credenSelect2.select2Data());
    /*Select2 Credential*///END

    /*cleare forms when modal is hided*/
    $('#addDevice').on('hidden.bs.modal', function(){
      self.clearForm();
    })
    $('#editDevice').on('hidden.bs.modal', function(){
      self.clearForm();
    })/*cleare forms*///end
  },
  add: function() {
    var self = this;
    var formData = tgui_supplier.getFormData(self.formSelector_add);

    var ajaxProps = {
      url: API_LINK+"confmanager/devices/add/",
      data: formData
    };//ajaxProps END
    ajaxRequest.send(ajaxProps).then(function(resp) {
      if (tgui_supplier.checkResponse(resp.error, self.formSelector_add)){
        return;
      }
      tgui_error.local.show({type:'success', message: "Device "+ $(self.formSelector_add + ' input[name="name"]').val() +" was added"})
      $("#addDevice").modal("hide");

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
      url: API_LINK+"confmanager/devices/edit/",
      type: "GET",
      data: {
        "name": name,
        "id": id,
      }
    };//ajaxProps END

    ajaxRequest.send(ajaxProps).then(function(resp) {
      tgui_supplier.fulfillForm(resp.device, self.formSelector_edit);
      if (resp.device.creden) self.credenSelect2.preSelection(resp.device.creden, 'edit');
      if (resp.device.tac_dev) self.tacDevSelect2.preSelection(resp.device.tac_dev, 'edit');
      $('#editDevice').modal('show')
    }).fail(function(err){
      tgui_error.getStatus(err, ajaxProps)
    })
  },//get edit device

  edit: function() {
    var self = this;

    var formData = tgui_supplier.getFormData(self.formSelector_edit, true);

    var ajaxProps = {
      url: API_LINK+"confmanager/devices/edit/",
      data: formData
    };//ajaxProps END

    if ( ! tgui_supplier.checkChanges(ajaxProps.data, ['id']) ) return false;

    if ( formData.name ) formData.name_old = $(self.formSelector_edit + '[name="name_native"]').val()

    ajaxRequest.send(ajaxProps).then(function(resp) {
      if (tgui_supplier.checkResponse(resp.error, self.formSelector_edit)){
        return;
      }
      tgui_error.local.show({type:'success', message: "Device "+ $(self.formSelector_edit + ' input[name="name"]').val() +" was edited"})
      self.clearForm();
      setTimeout( function () {dataTable.table.ajax.reload()}, 2000 );
      $('#editDevice').modal('hide')
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
      url: API_LINK+"confmanager/devices/delete/",
      data: {
        "name": name,
        "id": id,
      }
    };//ajaxProps END
    ajaxRequest.send(ajaxProps).then(function(resp) {
      if( parseInt(resp.result) != 1) {
        tgui_error.local.show( {type:'error', message: "Oops! Unknown error appeared :("} ); return;
      }
      tgui_error.local.show({type:'success', message: "Device "+ name +" was deleted"})
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
  selectionTemplate_credential: function(data){
    //console.log(data);
    var output='<div class="selectServiceOption">';
      output += '<text>'+data.text+'</text>';
      output += '<input class="item-attr" type="hidden" name="id" value="'+data.id+'">';
      output += '</div>'
    return output;
  },
}
