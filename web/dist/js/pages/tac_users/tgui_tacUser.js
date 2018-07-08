/*
  tgui_tacUser
    init:
    add:
    getUserInfo:
    edit:
    delete:
    clearForm:
 */
var tgui_tacUser = {
  formSelector_add: 'form#addUserForm',
  formSelector_edit: 'form#editUserForm',
  select_group_add: '#addUserForm .select_group',
  select_group_edit: '#editUserForm .select_group',
  select_acl_add: '#addUserForm .select_acl',
  select_acl_edit: '#editUserForm .select_acl',
  select_service_add: '#addUserForm .select_service',
  select_service_edit: '#editUserForm .select_service',
  init: function(){
    var self = this;

    this.csvParser = new tgui_csvParser(this.csv);
    /*cleare forms when modal is hided*/
    $('#addUser').on('hidden.bs.modal', function(){
    	self.clearForm();
    })
    $('#editUser').on('hidden.bs.modal', function(){
    	self.clearForm();
    })/*cleare forms*///end

    $('input[name="pap_clone"]').on('ifToggled', function(event){
    	if ( $(this).prop('checked') ) {
        $('input[name="pap"] , select[name="pap_flag"]').prop('disabled',true);
        return;
      }
      $('input[name="pap"] , select[name="pap_flag"]').prop('disabled',false);

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

    $(self.formSelector_add + ' select[name="login_flag"]').change(function(){
    	var en_encr = self.formSelector_add + ' div.login_encrypt_section';
    	if ($(this).val() == 1 || $(this).val() == 2){
    		$(en_encr).show()
    	} else {
    		$(en_encr).hide()
    	}
    })
    $(self.formSelector_edit + ' select[name="login_flag"]').change(function(){
      var en_encr = self.formSelector_edit + ' div.login_encrypt_section';
      if ($(this).val() == 1 || $(this).val() == 2){
    		$(en_encr).show()
    	} else {
    		$(en_encr).hide()
    	}
    })

    $(self.formSelector_add + ' select[name="pap_flag"]').change(function(){
    	var en_encr = self.formSelector_add + ' div.pap_encrypt_section';
    	if ($(this).val() == 1 || $(this).val() == 2){
    		$(en_encr).show()
    	} else {
    		$(en_encr).hide()
    	}
    })
    $(self.formSelector_edit + ' select[name="pap_flag"]').change(function(){
      var en_encr = self.formSelector_edit + ' div.pap_encrypt_section';
      if ($(this).val() == 1 || $(this).val() == 2){
    		$(en_encr).show()
    	} else {
    		$(en_encr).hide()
    	}
    })

    $('.nav-tabs a[href="#otp_edit"]').on('shown.bs.tab', function(event){
      var tab_event_status = parseInt($('[name="tab_event_status"]').val())
      self.getTime();
      if ( tab_event_status ) return;
      self.getOtpUrl();
      $('[name="tab_event_status"]').val(1)

    });
    $('.nav-tabs a[href="#sms_edit"]').on('shown.bs.tab', function(event){
      //console.log(event); /*do nothing!*/
    });

    /*Select2 Group*/
    this.userGrpSelect2 = new tgui_select2({
      ajaxUrl : API_LINK+"tacacs/user/group/list/",
      template: this.selectionTemplate_grp,
      add: this.select_group_add,
      edit: this.select_group_edit,
    });
    $(this.select_group_add).select2(this.userGrpSelect2.select2Data());
    $(this.select_group_edit).select2(this.userGrpSelect2.select2Data());
    /*Select2 Group*///END
    /*Select2 ACL*/
    this.aclSelect2 = new tgui_select2({
      ajaxUrl : API_LINK + "tacacs/acl/list/",
      template: this.selectionTemplate_acl,
      add: this.select_acl_add,
      edit: this.select_acl_edit,
    });

    $(this.select_acl_add).select2(this.aclSelect2.select2Data());
    $(this.select_acl_edit).select2(this.aclSelect2.select2Data());
    /*Select2 ACL*///END
    /*Select2 Service*/
    this.serviceSelect2 = new tgui_select2({
      ajaxUrl : API_LINK+"tacacs/services/list/",
      template: this.selectionTemplate_service,
      add: this.select_service_add,
      edit: this.select_service_edit,
    });
    $(this.select_service_add).select2(this.serviceSelect2.select2Data());
    $(this.select_service_edit).select2(this.serviceSelect2.select2Data());
    /*Select2 Service*///end
    $('#addUser').on('show.bs.modal', function(){
    	self.userGrpSelect2.preSelection(0, 'add');
    	self.aclSelect2.preSelection(0, 'add');
    	self.serviceSelect2.preSelection(0, 'add');
    })
  },
  add: function(){
    console.log('Adding new user');
    var self = this;
    var formData = tgui_supplier.getFormData(self.formSelector_add);
    formData.group = $(this.select_group_add).select2('data')[0].id;
		formData.acl = $(this.select_acl_add).select2('data')[0].id;
		formData.service = $(this.select_service_add).select2('data')[0].id;

    var ajaxProps = {
      url: API_LINK+"tacacs/user/add/",
      data: formData
    };//ajaxProps END
    ajaxRequest.send(ajaxProps).then(function(resp) {
      if (tgui_supplier.checkResponse(resp.error, self.formSelector_add)){
        return;
      }
      tgui_error.local.show({type:'success', message: "User "+ $(self.formSelector_add + ' input[name="username"]').val() +" was added"})
      $("#addUser").modal("hide");
      tgui_status.changeStatus(resp.changeConfiguration)
      self.clearForm();
      setTimeout( function () {dataTable.table.ajax.reload()}, 2000 );
    }).fail(function(err){
      tgui_error.getStatus(err, ajaxProps)
    })
    return this;
  },
  getUserInfo: function(id, username){
    var self = this;
    var ajaxProps = {
      url: API_LINK+"tacacs/user/edit/",
      type: "GET",
      data: {
        "username": username,
        "id": id,
      }
    };//ajaxProps END
    var el = {}, el_n = {};
    ajaxRequest.send(ajaxProps).then(function(resp) {
      tgui_supplier.fulfillForm(resp.user, self.formSelector_edit);

      var enable_encryption = (resp.user.enable_flag == 1 || resp.user.enable_flag == 2) ? 'uncheck' : 'check';
      $(self.formSelector_edit + ' input[name="enable_encrypt"]').iCheck(enable_encryption)
      if (enable_encryption == 'check') {$(self.formSelector_edit + ' div.enable_encrypt_section').hide()}
      else ($(self.formSelector_edit + ' div.enable_encrypt_section').show())

      var login_encryption = (resp.user.login_flag == 1 || resp.user.login_flag == 2) ? 'uncheck' : 'check';
      $(self.formSelector_edit + ' input[name="login_encrypt"]').iCheck(login_encryption)
      if (login_encryption == 'check') {$(self.formSelector_edit + ' div.login_encrypt_section').hide()}
      else ($(self.formSelector_edit + ' div.login_encrypt_section').show())

      var pap_encryption = (resp.user.pap_flag == 1 || resp.user.pap_flag == 2) ? 'uncheck' : 'check';
      $(self.formSelector_edit + ' input[name="pap_encrypt"]').iCheck(pap_encryption)
      if (pap_encryption == 'check') {$(self.formSelector_edit + ' div.pap_encrypt_section').hide()}
      else ($(self.formSelector_edit + ' div.pap_encrypt_section').show())

      self.userGrpSelect2.preSelection(resp.user.group, 'edit');
    	self.aclSelect2.preSelection(resp.user.acl, 'edit');
    	self.serviceSelect2.preSelection(resp.user.service, 'edit');

      $(self.formSelector_edit + ' input[name="priv-lvl-preview"]').val( ( parseInt(resp.user['priv-lvl']) > -1) ? resp.user['priv-lvl'] :  "Undefined");

      (resp.user.pap_clone == 1) ? $('input[name="pap"] , select[name="pap_flag"]').prop('disabled',true) : $('input[name="pap"] , select[name="pap_flag"]').prop('disabled',false);


      $(self.formSelector_edit + ' input[name="group_native"]').val(resp.user.group);
      $(self.formSelector_edit + ' input[name="acl_native"]').val(resp.user.acl);
      $(self.formSelector_edit + ' input[name="service_native"]').val(resp.user.service);

      if(resp.user.disabled == 1) tgui_supplier.toggle('disabled');

      $('div.global_status p b').text( (resp.otp_status) ? 'Enabled' : 'Disabled')
      $('div.global_status_sms p b').text( (resp.sms_status) ? 'Enabled' : 'Disabled')
      //$('div#qrcode').empty().append((resp.otp_status) ? 'Enabled' : 'Disabled')

      $('#editUser').modal('show')
    }).fail(function(err){
      tgui_error.getStatus(err, ajaxProps)
    })
  },/*get info user end*/
  edit: function() {
    console.log('Edit user');
    var self = this;
    var formData = tgui_supplier.getFormData(self.formSelector_edit, true);

    if ($(this.select_group_edit).select2('data')[0].id != $(self.formSelector_edit + ' [name="group_native"]').val()) { formData.group = $(this.select_group_edit).select2('data')[0].id;}

    if ($(this.select_acl_edit).select2('data')[0].id != $(self.formSelector_edit + ' [name="acl_native"]').val()) { formData.acl = $(this.select_acl_edit).select2('data')[0].id;}

    if ($(this.select_service_edit).select2('data')[0].id != $(self.formSelector_edit + ' [name="service_native"]').val()) { formData.service = $(this.select_service_edit).select2('data')[0].id; }

    var enable_encrypt = formData.enable_encrypt;
    delete formData.enable_encrypt;
    var login_encrypt = formData.login_encrypt;
    delete formData.login_encrypt;
    var pap_encrypt = formData.pap_encrypt;
    delete formData.pap_encrypt;

    if ( formData.enable ) { formData.enable_encrypt = enable_encrypt; formData.enable_flag = $(self.formSelector_edit + ' select[name="enable_flag"]').val(); }
    if ( formData.enable_flag && formData.enable_flag > 0) { formData.enable_encrypt = enable_encrypt; formData.enable = $(self.formSelector_edit + ' input[name="enable"]').val();}
    if ( formData.login ) { formData.login_encrypt = login_encrypt; formData.login_flag = $(self.formSelector_edit + ' select[name="login_flag"]').val(); }
    if ( formData.login_flag && formData.login_flag > 0) { formData.login_encrypt = login_encrypt; formData.login = $(self.formSelector_edit + ' input[name="login"]').val();}
    if ( formData.pap ) { formData.pap_encrypt = pap_encrypt; formData.pap_flag = $(self.formSelector_edit + ' select[name="pap_flag"]').val(); }
    if ( formData.pap_flag && formData.pap_flag > 0) { formData.pap_encrypt = pap_encrypt; formData.pap = $(self.formSelector_edit + ' input[name="pap"]').val();}

    var ajaxProps = {
      url: API_LINK+"tacacs/user/edit/",
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
      tgui_error.local.show({type:'success', message: "User "+ $(self.formSelector_edit + ' input[name="username"]').val() +" was edited"})
      $("#editUser").modal("hide");
			tgui_status.changeStatus(resp.changeConfiguration)
			self.clearForm();
			setTimeout( function () {dataTable.table.ajax.reload()}, 2000 );
    }).fail(function(err){
      tgui_error.getStatus(err, ajaxProps)
    })
    return this;
  },
  delete: function(id, username, flag) {
    id = id || 0;
    flag = (flag !== undefined) ? false : true;
    username = username || 'undefined';
    console.log('Deleting UserID:'+id+' with username '+username)
    if (flag && !confirm("Do you want delete '"+ username +"'?")) return;
    var ajaxProps = {
      url: API_LINK+"tacacs/user/delete/",
      data: {
        "username": username,
        "id": id,
      }
    };//ajaxProps END
    ajaxRequest.send(ajaxProps).then(function(resp) {
      if(resp.result != 1) {
        tgui_error.local.show( {type:'error', message: "Oops! Unknown error appeared :("} ); return;
      }
      tgui_error.local.show({type:'success', message: "User "+ username +" was deleted"})
      tgui_status.changeStatus(resp.changeConfiguration)
      setTimeout( function () {dataTable.table.ajax.reload()}, 2000 );
    }).fail(function(err){
      tgui_error.getStatus(err, ajaxProps)
    })
    return this;
  },
  csvDownload: function(idList) {
    idList = idList || [];
  if (! idList.length ) $('div.csv-link').empty().append(tgui_supplier.loadElement());
  else { $('#exportLink').removeClass('m-progress').addClass('m-progress').attr('href', 'javascript: void(0)').show(); }
  var ajaxProps = {
    url: API_LINK+"tacacs/user/csv/",
    data: {idList: idList}
  };//ajaxProps END
  ajaxRequest.send(ajaxProps).then(function(resp) {
    if(!resp.filename) {
      tgui_error.local.show( {type:'error', message: "Oops! Unknown error appeared :("} ); return;
    }
    if (! idList.length ) { $('div.csv-link').empty().append('<a href="/api/download/csv/?file=' + resp.filename + '" target="_blank">Download</a><p><small class="text-muted">Link will be valid within 15 minutes</small></p>') }
    else {
      $('#exportLink').removeClass('m-progress').attr('href', '/api/download/csv/?file=' + resp.filename);
    }
  }).fail(function(err){
    tgui_error.getStatus(err, ajaxProps)
  })
  },
  csv: {
    columnsRequired: ['username','login'],
    fileInputId: '#csv-file',
    ajaxLink: 'tacacs/user/add/',
    outputId: '#csvParserOutput',
    ajaxHandler: function(resp,index){
      var item = 'user';
      if (resp.error && resp.error.status){
        var error_message = '';
        for (v in resp.error.validation){
          if (!(resp.error.validation[v] == null)){
            for (num in resp.error.validation[v]){
              error_message+='<p class="text-danger">'+resp.error.validation[v][num]+'</p>';
            }
            this.csvParserOutput({tag: error_message, response: index});
          }
        }
      }
      if (resp[item] && resp[item].username) {
        this.csvParserOutput({tag: '<p class="text-success">User <b>'+ resp[item].username + '</b> was added!</p>', response: index});
        tgui_status.changeStatus(resp.changeConfiguration)
      }
      this.csvParserOutput({tag: '<hr>'});
    },
    finalAnswer: function() {
      this.csvParserOutput({message: 'End of CSV file. Reload database.'})
      setTimeout( function () {dataTable.table.ajax.reload()}, 2000 );
    }
  },
  clearForm: function() {
    tgui_supplier.clearForm();
  	$('.nav.nav-tabs a[href="#general_info"]').tab('show');//select first tab
  	$('.nav.nav-tabs a[href="#general_info_edit"]').tab('show');//select first tab
    $('input[name="pap"] , select[name="pap_flag"]').prop('disabled',false);
  },
  selectionTemplate_grp: function(data){
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
  selectionTemplate_acl: function(data){
    var output='<div class="selectAclOption">';
  		output += '<text>'+data.text+'</text>';
  		output += '</div>'
  	return output;
  },
  selectionTemplate_service: function(data){
    var output='<div class="selectServiceOption">';
  		output += '<text>'+data.text+'</text>';
  		output += '</div>'
  	return output;
  },
  getTime: function(){
    tgui_status.time().then(function(resp){
      $('time.current-time').text(resp.time);
    }).fail(function(err){
      tgui_error.getStatus(err, ajaxProps)
    });
  },
  getOtpUrl: function(secret) {
    var self = this;
    var ajaxProps = {
      url: API_LINK+"mavis/otp/generate/secret/",
      data: {
        "id": $(self.formSelector_edit + ' input[name="id"]').val(),
    		"secret": secret || $(self.formSelector_edit + ' input[name="mavis_otp_secret"]').val(),
    		"digits": $(self.formSelector_edit + ' input[name="mavis_otp_digits"]').val(),
    		"digest": $(self.formSelector_edit + ' select[name="mavis_otp_digest"]').val(),
    		"period": $(self.formSelector_edit + ' input[name="mavis_otp_period"]').val(),
      }
    };

    ajaxRequest.send(ajaxProps).then(function(resp){
      $(self.formSelector_edit + ' #qrcode').empty();
			$(self.formSelector_edit + ' input.otp_secret').val(resp.secret);
			$(self.formSelector_edit + ' #qrcode').qrcode(resp.url);
    }).fail(function(err){
      tgui_error.getStatus(err, ajaxProps)
    });
  }
};
