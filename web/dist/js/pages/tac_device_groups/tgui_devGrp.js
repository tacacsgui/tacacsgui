/*
  tgui_devGrp
    init:
    add:
    getGrpInfo:
    edit:
    delete:
    clearForm:

 */
var tgui_devGrp = {
  formSelector_add: 'form#addDeviceGroupForm',
  formSelector_edit: 'form#editDeviceGroupForm',
  init:function() {
    var self = this;
    /*cleare forms when modal is hided*/
    $('#addDeviceGroup').on('hidden.bs.modal', function(){
    	self.clearForm();
    })
    $('#editDeviceGroup').on('hidden.bs.modal', function(){
    	self.clearForm();
    })/*cleare forms*///end

    $(this.formSelector_add + ' select[name="enable_flag"]').change(function(){
    	var en_encr = self.formSelector_add + ' div.enable_encrypt_section';
    	if ($(this).val() == 1 || $(this).val() == 2){
    		$(en_encr).show()
    	} else {
    		$(en_encr).hide()
    	}
    })
    $(this.formSelector_edit + ' select[name="enable_flag"]').change(function(){
      var en_encr = self.formSelector_edit + ' div.enable_encrypt_section';
      if ($(this).val() == 1 || $(this).val() == 2){
    		$(en_encr).show()
    	} else {
    		$(en_encr).hide()
    	}
    })

    /*fix tab IDs for tabMessages template*/
    var tabLinks = $(this.formSelector_edit + ' .message-tabs ul li a')
    var tabs = $(this.formSelector_edit + ' div.message-tabs div.tab-content div.tab-pane')
    for (var i = 0, len = tabLinks.length; i < len; i++) {
      $(tabLinks[i]).attr('href',$(tabLinks[i]).attr('href')+'_edit');
    }
    for (var i = 0, len = tabs.length; i < len; i++) {
      $(tabs[i]).attr('id',$(tabs[i]).attr('id')+'_edit');
    }
    /*fix tab IDs for tabMessages template*///end
  },
  add: function(){
    console.log('Adding new device group');
    var self = this;
    var formData = tgui_supplier.getFormData(self.formSelector_add);
    var ajaxProps = {
      url: API_LINK+"tacacs/device/group/add/",
      data: formData
    };//ajaxProps END
    console.log(formData);
    ajaxRequest.send(ajaxProps).then(function(resp) {
      if (tgui_supplier.checkResponse(resp.error, self.formSelector_add)){
        return;
      }
      tgui_error.local.show({type:'success', message: "Device Group"+ $(self.formSelector_add + ' input[name="name"]').val() +" was added"})
      $("#addDeviceGroup").modal("hide");
			tgui_status.changeStatus(resp.changeConfiguration)
			self.clearForm();
			setTimeout( function () {dataTable.ajax.reload()}, 2000 );
    }).fail(function(err){
      tgui_error.getStatus(err, ajaxProps)
    })
    return this;
  },
  getGrpInfo: function(id, name) {
    var self = this;
    var ajaxProps = {
      url: API_LINK+"tacacs/device/group/edit/",
      type: "GET",
      data: {
        "name": name,
        "id": id,
      }
    };//ajaxProps END
    var el = {}, el_n = {};
    ajaxRequest.send(ajaxProps).then(function(resp) {
      tgui_supplier.fulfillForm(resp.group, self.formSelector_edit);

      var enable_encryption = (resp.group.enable_flag == 1 || resp.group.enable_flag == 2) ? 'uncheck' : 'check';
      $(self.formSelector_edit + ' input[name="enable_encrypt"]').iCheck(enable_encryption)
      if (enable_encryption == 'check') {$(self.formSelector_edit + ' div.enable_encrypt_section').hide()}
      else ($(self.formSelector_edit + ' div.enable_encrypt_section').show())

      if (resp.group.default_flag == 1) $(self.formSelector_edit + ' input[name="default_flag"]').iCheck('disable');

      $('#editDeviceGroup').modal('show')
    }).fail(function(err){
      tgui_error.getStatus(err, ajaxProps)
    })
  },
  edit: function() {
    console.log('Editing device group');
    var self = this;
    var formData = tgui_supplier.getFormData(this.formSelector_edit, true);

    var ajaxProps = {
      url: API_LINK+"tacacs/device/group/edit/",
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
      tgui_error.local.show({type:'success', message: "Device Group"+ $(self.formSelector_edit + ' input[name="name"]').val() +" was edited"})
      $("#editDeviceGroup").modal("hide");
      tgui_status.changeStatus(resp.changeConfiguration)
      self.clearForm();
      setTimeout( function () {dataTable.ajax.reload()}, 2000 );
    }).fail(function(err){
      tgui_error.getStatus(err, ajaxProps)
    })
    return this;
  },
  delete: function(id, name) {
    console.log('Deleting DeviceGroupID:'+id+' with name '+ name)
    id = id || 0;
    name = name || 'undefined';
    if (!confirm("Do you want delete '" + name + "'?")) return;
    var ajaxProps = {
      url: API_LINK+"tacacs/device/group/delete/",
      data: {
        "name": name,
        "id": id,
      }
    };//ajaxProps END
    ajaxRequest.send(ajaxProps).then(function(resp) {
      if(resp.result != 1) {
        (resp.error.message) ?
          tgui_error.local.show( {type:'error', message: resp.error.message} )
        :
          tgui_error.local.show( {type:'error', message: "Oops! Unknown error appeared :("} );
        return;
      }
      tgui_error.local.show({type:'success', message: "Device Group"+ name +" was deleted"})
      tgui_status.changeStatus(resp.changeConfiguration)
      setTimeout( function () {dataTable.ajax.reload()}, 2000 );
    }).fail(function(err){
      tgui_error.getStatus(err, ajaxProps)
    })
    return this;
  },
  clearForm: function() {
    tgui_supplier.clearForm();
    $('input[name="default_flag"]').iCheck('enable');
    $('.nav.nav-tabs a[href="#tab_1"]').tab('show');//select first banner tab
  	$('.nav.nav-tabs a[href="#tab_1_edit"]').tab('show');//select first banner tab
  	$('.nav.nav-tabs a[href="#general_info"]').tab('show');//select first tab
  	$('.nav.nav-tabs a[href="#general_info_edit"]').tab('show');//select first tab
  },
}
