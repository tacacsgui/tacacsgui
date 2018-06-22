/*
tgui_device.
  init:
    * init clear modal forms
    * change prefix when slideEvt
    * show (if Clear Text attr)/hide encryption parameters
    * fix banner tabs appearence
  add:
    * add device function
  getDevInfo (id,name):
  edit:
  delete(id,name):
  toggle:
  getFormAction:
  clearForm:
  checkResponse:
  select2Data: object, parameters for select2;
  selectionTemplate:
  ping:
*/
var tgui_device = {
  formSelector_add: 'form#addDeviceForm',
  formSelector_edit: 'form#editDeviceForm',
  select_group_add: '#addDeviceForm div.group .select_group.select2',
  select_group_edit: '#editDeviceForm div.group .select_group.select2',
  init: function() {
    var self = this;
    /*cleare forms when modal is hided*/
    $('#addDevice').on('hidden.bs.modal', function(){
    	self.clearForm();
    })
    $('#editDevice').on('hidden.bs.modal', function(){
    	self.clearForm();
    })/*cleare forms*///end

    $('input[name="prefix"]').on('slide', function(slideEvt){
    	$('span[name="prefix-value"]').text(slideEvt.value)
    })

    $(self.formSelector_add + ' select[name="enable_flag"]').change(function(){
    	var en_encr = self.formSelector_add + ' div.enable_encrypt_section';
    	if ($(this).val() == 1 || $(this).val() == 2){
    		$(en_encr).show()
    	} else {
    		$(en_encr).hide()
    	}
    })
    $(self.formSelector_edit + ' select[name="enable_flag"]').change(function(){
      var en_encr = self.formSelector_edit + ' div.enable_encrypt_section';
      if ($(this).val() == 1 || $(this).val() == 2){
    		$(en_encr).show()
    	} else {
    		$(en_encr).hide()
    	}
    })

    self.devGrpSelect2 = new tgui_select2({
      ajaxUrl : API_LINK+"tacacs/device/group/list/",
      template: this.selectionTemplate,
      add: this.select_group_add,
      edit: this.select_group_edit,
    });

    $(this.select_group_add).select2(self.devGrpSelect2.select2Data());
    $(this.select_group_edit).select2(self.devGrpSelect2.select2Data());
    $('#addDevice').on('show.bs.modal', function(){
    	self.devGrpSelect2.preSelection(0, 'add');
    })

    /*fix tab IDs for tabMessages template*/
    var tabLinks = $(self.formSelector_edit + ' .message-tabs ul li a')
    var tabs = $(self.formSelector_edit + ' div.message-tabs div.tab-content div.tab-pane')
    for (var i = 0, len = tabLinks.length; i < len; i++) {
      $(tabLinks[i]).attr('href',$(tabLinks[i]).attr('href')+'_edit');
    }
    for (var i = 0, len = tabs.length; i < len; i++) {
      $(tabs[i]).attr('id',$(tabs[i]).attr('id')+'_edit');
    }
    /*fix tab IDs for tabMessages template*///end
    return this;
  },
  add: function() {
    console.log('Adding new device');
    var self = this;
    var formData = tgui_supplier.getFormData(self.formSelector_add);
        formData.group = $(this.select_group_add).select2('data')[0].id;
        formData.prefix = $(self.formSelector_add + ' input[name="prefix"]').slider('getValue');
    var ajaxProps = {
      url: API_LINK+"tacacs/device/add/",
      data: formData
    };//ajaxProps END
    ajaxRequest.send(ajaxProps).then(function(resp) {
      if (tgui_supplier.checkResponse(resp.error, self.formSelector_add)){
        return;
      }
      tgui_error.local.show({type:'success', message: "Device "+ $(self.formSelector_add + ' input[name="name"]').val() +" was added"})
      $("#addDevice").modal("hide");
			tgui_status.changeStatus(resp.changeConfiguration)
			self.clearForm();
			setTimeout( function () {dataTable.ajax.reload()}, 2000 );
    }).fail(function(err){
      tgui_error.getStatus(err, ajaxProps)
    })
    return this;
  },/*add device end*/
  getDevInfo: function(id, name){
    var self = this;
    var ajaxProps = {
      url: API_LINK+"tacacs/device/edit/",
      type: "GET",
      data: {
        "name": name,
  			"id": id,
      }
    };//ajaxProps END
    var el = {}, el_n = {};
    ajaxRequest.send(ajaxProps).then(function(resp) {
      tgui_supplier.fulfillForm(resp.device, self.formSelector_edit);

      var enable_encryption = (resp.device.enable_flag == 1 || resp.device.enable_flag == 2) ? 'uncheck' : 'check';
      $(self.formSelector_edit + ' input[name="enable_encrypt"]').iCheck(enable_encryption)
      if (enable_encryption == 'check') {$(self.formSelector_edit + ' div.enable_encrypt_section').hide()}
      else ($(self.formSelector_edit + ' div.enable_encrypt_section').show())

      self.devGrpSelect2.preSelection(resp.device.group, 'edit');

      $(self.formSelector_edit + ' input[name="group_native"]').val(resp.device.group);
      $(self.formSelector_edit + ' input[name="prefix_native"]').val(resp.device.prefix);
      $(self.formSelector_edit + ' input[name="prefix"]').slider('setValue', resp.device.prefix);
      $('span[name="prefix-value"]').text(resp.device.prefix)

      if(resp.device.disabled == 1) tgui_supplier.toggle('disabled');

      $('#editDevice').modal('show')
    }).fail(function(err){
      tgui_error.getStatus(err, ajaxProps)
    })
  },/*get info device end*/
  edit: function() {
    console.log('Editing device');
    var self = this;
    var formData = tgui_supplier.getFormData(self.formSelector_edit, true);

    if ($(this.select_group_edit).select2('data')[0].id != $(self.formSelector_edit + ' [name="group_native"]').val()) {formData.group = $(this.select_group_edit).select2('data')[0].id;}

    if ($(self.formSelector_edit + ' input[name="prefix"]').slider('getValue') != $(self.formSelector_edit + ' input[name="prefix_native"]').val()) {formData.prefix = $(self.formSelector_edit + ' input[name="prefix"]').slider('getValue');}

    var enable_encrypt = formData.enable_encrypt;
    delete formData.enable_encrypt;

    if ( formData.enable ) { formData.enable_encrypt = enable_encrypt; formData.enable_flag = $(self.formSelector_edit + ' select[name="enable_flag"]').val(); }
    if ( formData.enable_flag && formData.enable_flag > 0) { formData.enable_encrypt = enable_encrypt; formData.enable = $(self.formSelector_edit + ' input[name="enable"]').val();}

    var ajaxProps = {
      url: API_LINK+"tacacs/device/edit/",
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
      tgui_error.local.show({type:'success', message: "Device "+ $(self.formSelector_edit + ' input[name="name"]').val() +" was edited"})
      $("#editDevice").modal("hide");
			tgui_status.changeStatus(resp.changeConfiguration)
			self.clearForm();
			setTimeout( function () {dataTable.ajax.reload()}, 2000 );
    }).fail(function(err){
      tgui_error.getStatus(err, ajaxProps)
    })
    return this;
  },/*edit device end*/
  delete: function(id, name){
    id = id || 0;
    name = name || 'undefined';
    if (!confirm("Do you want delete '"+name+"'?")) return;
    var ajaxProps = {
      url: API_LINK+"tacacs/device/delete/",
      data: {
        "name": name,
  			"id": id,
      }
    };//ajaxProps END
    ajaxRequest.send(ajaxProps).then(function(resp) {
      if(resp.result != 1) {
        tgui_error.local.show( {type:'error', message: "Oops! Unknown error appeared :("} ); return;
      }
      tgui_error.local.show({type:'success', message: "Device "+ name +" was deleted"})
			tgui_status.changeStatus(resp.changeConfiguration)
			setTimeout( function () {dataTable.ajax.reload()}, 2000 );
    }).fail(function(err){
      tgui_error.getStatus(err, ajaxProps)
    })
    return this;
  },/*delete device end*/
  getFormAction: function functionName(e, b) {
    if (b) return $($(e).parents('form')[0]).attr('form-action');
    return $(e).parents('form')[0];
  },
  clearForm: function(form){
    tgui_supplier.clearForm().toggle('reload');
    /*---*/
  	$('input[name="prefix"]').slider('setValue', 32)//clear prefix
  	$('span[name="prefix-value"]').text('32')//clear prefix
  	$('.nav.nav-tabs a[href="#tab_1"]').tab('show');//select first banner tab
  	$('.nav.nav-tabs a[href="#tab_1_edit"]').tab('show');//select first banner tab
  	$('.nav.nav-tabs a[href="#general_info"]').tab('show');//select first tab
  	$('.nav.nav-tabs a[href="#general_info_edit"]').tab('show');//select first tab
  	$('div.enable_encrypt_section').show();//select first tab
    /*---*/
  	$('.form-group.ipaddr button').text('Ping').removeClass('btn-success btn-warning btn-danger btn-gray m-progress').addClass('btn-gray');
    //remove all errors
    $('.form-group.has-error').removeClass('has-error');
  	$('p.text-red').remove();
  	$('p.help-block').show();
  },
  checkResponse: function(error, form){
    $('.form-group.has-error').removeClass('has-error');
  	$('.form-group p.text-red').remove();
  	$('.form-group p.help-block').show();
    if (error.status){
      for (v in error.validation){
        if (!(error.validation[v] == null)){
          $('form#'+form+'DeviceForm div.'+v).addClass('has-error')
          $('div.form-group.'+v+' p.help-block').hide()
          var error_message='';
          for (num in error.validation[v]){
            error_message+='<p class="text-red">'+error.validation[v][num]+'</p>';
            tgui_error.local.show({type:'error', message: error.validation[v][num]})
          }
          $('div.form-group.'+v).append(error_message)
        }
      }
      return true;
    }
    return false;
  },
  selectionTemplate: function(data){
    data.default_flag = (data.id != 0) ? data.default_flag : false;
  	var default_flag_class = (data.default_flag) ? 'option_default_flag': ''
  	var output='<div class="selectGroupOption '+ default_flag_class +'">';
  		output += '<text>'+data.text+'</text>';
  		output += '<specialFlags>';
  		output += (data.key) ? '<small class="label pull-right bg-green" style="margin:3px">k</small>' : '';
  		output += (data.enable) ? ' <small class="label pull-right bg-yellow" style="margin:3px">e</small>' : '';
  		output += (data.default_flag) ? ' <small class="label pull-right bg-gray" style="margin:3px">d</small>' : '';
  		output += '</specialFlags>'
  	output += '</div>'
  	return output;
  },
  ping: function(button){
    var allClasses = "btn-success btn-danger btn-gray m-progress";
    $(button).removeClass(allClasses).addClass('m-progress').prop('disabled', true)
    var form = this.getFormAction(button, true);
    var self = this;
    var ajaxProps = {
      url: API_LINK+"tacacs/device/ping/",
      type: "GET",
      data: {"ipaddr": $('form#'+form+'DeviceForm input[name="ipaddr"]').val()}
    }
    ajaxRequest.send(ajaxProps).then(function(resp) {
      if (self.checkResponse(resp.error, form)){
        $(button).removeClass(allClasses).addClass('btn-gray').text('Ping').prop('disabled', false);
        return;
      }
      var responses = resp.pingResponses;
			if(resp.pingResponses > 0)
			{
				$(button).removeClass(allClasses).text(resp.pingResponses+'/4').addClass('btn-success').prop('disabled', false);
			}
			else
			{
				$(button).removeClass(allClasses).text('0/4').addClass('btn-danger').prop('disabled', false);
			}
    }).fail(function(err){
      tgui_error.getStatus(err, ajaxProps)
    })
  }
}
