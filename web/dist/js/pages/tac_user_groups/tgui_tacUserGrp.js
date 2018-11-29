
var tgui_tacUserGrp = {
  formSelector_add: 'form#addGroupForm',
  formSelector_edit: 'form#editGroupForm',
  select_acl_add: '#addGroupForm .select_acl',
  select_acl_edit: '#editGroupForm .select_acl',
  select_service_add: '#addGroupForm .select_service',
  select_service_edit: '#editGroupForm .select_service',
  select_ldap_add: '#addGroupForm .select_ldap_groups',
  select_ldap_edit: '#editGroupForm .select_ldap_groups',
  select_devg_add: '#addGroupForm .select_device_group_list',
  select_devg_edit: '#editGroupForm .select_device_group_list',
  select_dev_add: '#addGroupForm .select_device_list',
  select_dev_edit: '#editGroupForm .select_device_list',
  init: function() {
    var self = this;

    this.csvParser = new tgui_csvParser(this.csv);
    /*cleare forms when modal is hided*/
    $('#addGroup').on('hidden.bs.modal', function(){
    	self.clearForm();
    })
    $('#editGroup').on('hidden.bs.modal', function(){
    	self.clearForm();
    })/*cleare forms*///end
    $('[name="device_list_action"]').on('change', function(){
      var formId = '#'+$($(this).closest('form')).attr('id')
      if ( ! $(this).prop('checked') ) $(formId + ' div.device_action_change').removeClass('allow').addClass('deny');
      else $(formId + ' div.device_action_change').removeClass('deny').addClass('allow');
    	//console.log(this);
    })

    $('select[data-objtype="password"]').change(function(){
      tgui_supplier.selector({select: this});
    })

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
    /*Select2 LDAP Group*/
    this.ldapSelect2 = new tgui_select2({
      ajaxUrl : API_LINK+"tacacs/user/group/ldap/list/",
      template: this.selectionTemplate_ldap,
      divClass: 'ldap_groups',
      add: this.select_ldap_add,
      edit: this.select_ldap_edit,
    });
    $(this.select_ldap_add).select2(this.ldapSelect2.select2Data());
    $(this.select_ldap_edit).select2(this.ldapSelect2.select2Data());
    /*Select2 LDAP Group*///end
    /*Select2 Device Group*/
    this.devgSelect2 = new tgui_select2({
      ajaxUrl : API_LINK+"tacacs/device/group/list/",
      template: this.selectionTemplate_devg,
      divClass: 'device_group_list',
      add: this.select_devg_add,
      edit: this.select_devg_edit,
    });
    $(this.select_devg_add).select2(this.devgSelect2.select2Data());
    $(this.select_devg_edit).select2(this.devgSelect2.select2Data());
    /*Select2 Device Group*///end
    /*Select2 Device*/
    this.devSelect2 = new tgui_select2({
      ajaxUrl : API_LINK+"tacacs/device/list/",
      template: this.selectionTemplate_dev,
      divClass: 'device_list',
      add: this.select_dev_add,
      edit: this.select_dev_edit,
    });
    $(this.select_dev_add).select2(this.devSelect2.select2Data());
    $(this.select_dev_edit).select2(this.devSelect2.select2Data());
    /*Select2 Device*///end
    $('#addGroup').on('show.bs.modal', function(){
      self.aclSelect2.preSelection(0, 'add');
      self.serviceSelect2.preSelection(0, 'add');
    })
  },
  add: function() {
    console.log('Adding new group');
    var self = this;
    var formData = tgui_supplier.getFormData(self.formSelector_add);
    formData.acl = ($(this.select_acl_add).select2('data').length) ? $(this.select_acl_add).select2('data')[0].id : 0;
    formData.service = ($(this.select_service_add).select2('data')) ? $(this.select_service_add).select2('data')[0].id : 0;
    //LDAP Groups
    formData.ldap_groups = '';
    if ( $(this.select_ldap_add).select2('data') ) for (var i = 0; i < $(this.select_ldap_add).select2('data').length; i++) {
      if (i == 0) { formData.ldap_groups += $(this.select_ldap_add).select2('data')[i].id; continue; }
      formData.ldap_groups += ';;' + $(this.select_ldap_add).select2('data')[i].id;
    }
    //Device List
    formData.device_list = '';
    if ( $(this.select_dev_add).select2('data') ) for (var i = 0; i < $(this.select_dev_add).select2('data').length; i++) {
      if (i == 0) { formData.device_list += $(this.select_dev_add).select2('data')[i].id; continue; }
      formData.device_list += ';;' + $(this.select_dev_add).select2('data')[i].id;
    }
    //Device Groups List
    formData.device_group_list = '';
    if ( $(this.select_devg_add).select2('data') ) for (var i = 0; i < $(this.select_devg_add).select2('data').length; i++) {
      if (i == 0) { formData.device_group_list += $(this.select_devg_add).select2('data')[i].id; continue; }
      formData.device_group_list += ';;' + $(this.select_devg_add).select2('data')[i].id;
    }

    var ajaxProps = {
      url: API_LINK+"tacacs/user/group/add/",
      data: formData
    };//ajaxProps END

    // console.log(formData);
    // return false;
    ajaxRequest.send(ajaxProps).then(function(resp) {
      if (tgui_supplier.checkResponse(resp.error, self.formSelector_add)){
        return;
      }
      tgui_error.local.show({type:'success', message: "User Group"+ $(self.formSelector_add + ' input[name="name"]').val() +" was added"})
      $("#addGroup").modal("hide");
      tgui_status.changeStatus(resp.changeConfiguration)
      self.clearForm();
      setTimeout( function () {dataTable.table.ajax.reload()}, 2000 );
    }).fail(function(err){
      tgui_error.getStatus(err, ajaxProps)
    })
    return this;
  },
  getUserGrp: function(id, name){
    var self = this;
    var ajaxProps = {
      url: API_LINK+"tacacs/user/group/edit/",
      type: "GET",
      data: {
        "name": name,
        "id": id,
      }
    };//ajaxProps END
    var el = {}, el_n = {};
    ajaxRequest.send(ajaxProps).then(function(resp) {
      tgui_supplier.fulfillForm(resp.group, self.formSelector_edit);

      tgui_supplier.selector( {select: self.formSelector_edit + ' select[name="enable_flag"]', flag: resp.group.enable_flag } )

      var ldap_groups = {};
      var ldap_groups_temp = (resp.group.ldap_groups) ? resp.group.ldap_groups.split(';;') : [];
      for (var i = 0; i < ldap_groups_temp.length; i++) {
        ldap_groups = {
          id: ldap_groups_temp[i],
          text: ldap_groups_temp[i].split(',')[0].match( new RegExp("^CN=(.*)$") )[1],
          dn: ldap_groups_temp[i],
        }
        var option = new Option('', ldap_groups_temp[i], true, true);
        $(option).data( { data: ldap_groups } );
        $(self.select_ldap_edit).append( option )
      }
      self.ldapSelect2.init_sortable('ldap_groups');

      if (resp.group.device_group_list) self.devgSelect2.preSelection(resp.group.device_group_list.split(';;'), 'edit');
      if (resp.group.device_list) self.devSelect2.preSelection(resp.group.device_list.split(';;'), 'edit');

      self.aclSelect2.preSelection(resp.group.acl, 'edit');
      self.serviceSelect2.preSelection(resp.group.service, 'edit');

      $(self.formSelector_edit + ' input[name="priv-lvl-preview"]').val( ( parseInt(resp.group['priv-lvl']) > -1) ? resp.group['priv-lvl'] :  "Undefined");

      $(self.formSelector_edit + ' input[name="acl_native"]').val(resp.group.acl);
      $(self.formSelector_edit + ' input[name="service_native"]').val(resp.group.service);

      $('#editGroup').modal('show')
    }).fail(function(err){
      tgui_error.getStatus(err, ajaxProps)
    })
  },
  edit: function() {
    console.log('Edit group');
    var self = this;
    var formData = tgui_supplier.getFormData(self.formSelector_edit, true);
    //LDAP Groups//
    var ldap_groups_data_all = self.ldapSelect2.getData(self.ldapSelect2.edit, {formId: self.formSelector_edit});
    var ldap_groups_data = (ldap_groups_data_all.attr.dn) ? ldap_groups_data_all.attr.dn.join(';;') : '';
    //console.log($(self.formSelector_edit + ' [name="ldap_groups_native"]').val());
    if ( ldap_groups_data != $(self.formSelector_edit + ' [name="ldap_groups_native"]').val() ) formData.ldap_groups = ldap_groups_data;

    //Device Groups
    var dev_grp_list_native = $(self.formSelector_edit + ' [name="device_group_list_native"]').val()
    console.log($(self.formSelector_edit + ' [name="device_group_list_native"]').val());
    var dev_grp_list = self.devgSelect2.getData(self.devgSelect2.edit, {formId: self.formSelector_edit});
    dev_grp_list = ( dev_grp_list.attr && dev_grp_list.attr.id && dev_grp_list.attr.id.length ) ? dev_grp_list.attr.id.join(';;') : '';
    if ( dev_grp_list != dev_grp_list_native ) formData.device_group_list = dev_grp_list;
    //Device
    var dev_list_native = $(self.formSelector_edit + ' [name="device_list_native"]').val()
    console.log($(self.formSelector_edit + ' [name="device_list_native"]').val());
    var dev_list = self.devSelect2.getData(self.devSelect2.edit, {formId: self.formSelector_edit});
    dev_list = ( dev_list.attr && dev_list.attr.id && dev_list.attr.id.length ) ? dev_list.attr.id.join(';;') : '';
    if ( dev_list != dev_list_native ) formData.device_list = dev_list;

    var ajaxProps = {
      url: API_LINK+"tacacs/user/group/edit/",
      type: 'POST',
      data: formData
    };//ajaxProps END

    // console.log(formData);
    // return false;
    if ( ! tgui_supplier.checkChanges(ajaxProps.data, ['id']) ) return false;

    if ( formData.enable ) {
      formData.enable_flag = $(this.formSelector_edit+' select[name="enable_flag"]').val()
      formData.enable_encrypt = ( $(this.formSelector_edit+' input[name="enable_encrypt"]').prop('checked') ) ? 1 : 0
    }

    ajaxRequest.send(ajaxProps).then(function(resp) {
      if (tgui_supplier.checkResponse(resp.error, self.formSelector_edit)){
        return;
      }
      tgui_error.local.show({type:'success', message: "User Group"+ $(self.formSelector_edit + ' input[name="name"]').val() +" was edited"})
      $("#editGroup").modal("hide");
      tgui_status.changeStatus(resp.changeConfiguration)
      self.clearForm();
      setTimeout( function () {dataTable.table.ajax.reload()}, 2000 );
    }).fail(function(err){
      tgui_error.getStatus(err, ajaxProps)
    })
    return this;
  },
  delete: function(id, name, flag) {
    id = id || 0;
    flag = (flag !== undefined) ? false : true;
    name = name || 'undefined';
    console.log('Deleting UserGroupID:'+id+' with name '+name)
    if (flag && !confirm("Do you want delete '"+ name +"'?")) return;
    var ajaxProps = {
      url: API_LINK+"tacacs/user/group/delete/",
      data: {
        "name": name,
        "id": id,
      }
    };//ajaxProps END
    ajaxRequest.send(ajaxProps).then(function(resp) {
      if(resp.result != 1) {
        tgui_error.local.show( {type:'error', message: "Oops! Unknown error appeared :("} ); return;
      }
      tgui_error.local.show({type:'success', message: "User "+ name +" was deleted"})
      tgui_status.changeStatus(resp.changeConfiguration)
      setTimeout( function () {dataTable.table.ajax.reload()}, 2000 );
    }).fail(function(err){
      tgui_error.getStatus(err, ajaxProps)
    })
    return this;
  },
  csv: {
    columnsRequired: ['name'],
    fileInputId: '#csv-file',
    ajaxLink: 'tacacs/user/group/add/',
    ajaxItem: 'user/group',
    outputId: '#csvParserOutput',
    ajaxHandler: function(resp,index){
      var item = 'group';
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
      if (resp[item] && resp[item].name) {
        this.csvParserOutput({tag: '<p class="text-success">Device <b>'+ resp[item].name + '</b> was added!</p>', response: index});
        tgui_status.changeStatus(resp.changeConfiguration)
      }
      this.csvParserOutput({tag: '<hr>'});
    },
    finalAnswer: function() {
      this.csvParserOutput({message: 'End of CSV file. Reload database.'})
      setTimeout( function () {dataTable.table.ajax.reload()}, 2000 );
    }
  },
  clearForm: function(){
    tgui_supplier.clearForm();
  	$('.nav.nav-tabs a[href="#general_info"]').tab('show');//select first tab
  	$('.nav.nav-tabs a[href="#general_info_edit"]').tab('show');//select first tab
    //$('.select_ldap_groups').val(null).trigger("change");
  },
  selectionTemplate_service: function(data) {
    //console.log(data);
    var output='<div class="selectServiceOption">';
      output += '<text>'+data.text+'</text>';
      output += '</div>'
    return output;
  },
  selectionTemplate_devg: function(data) {
    //console.log(data);
    var output='<div class="selectServiceOption">';
      output += '<text>'+data.text+'</text>';
      output += '<input class="item-attr" type="hidden" name="id" value="'+data.id+'">';
      output += '</div>'
    return output;
  },
  selectionTemplate_dev: function(data) {
    //console.log(data);
    var output='<div class="selectServiceOption">';
      output += '<text>'+data.text+'</text>';
      output += '<input class="item-attr" type="hidden" name="id" value="'+data.id+'">';
      output += '</div>'
    return output;
  },
  selectionTemplate_ldap: function(data) {
    data = data || {}
    //console.log($(data.element).data());
    if ( data.element && $(data.element).data() ) data = $(data.element).data().data;
  //  console.log(data);
    data.text = data.text || ''
    data.dn = data.dn || ''

    if ( data.loading || data.error ) return '<text>'+data.text+'</text>';
    var output='<div class="selectServiceOption">';
      output += '<p style="margin:0px"> CN="'+data.text+'"</p>';
      output += '<p style="margin:0px"><small>'+data.dn+'</small></p>';
      output += '<textarea class="item-attr" style="display: none;" name="dn">'+data.dn+'</textarea>';
      output += '<textarea class="item-attr" style="display: none;" name="cn">'+data.text+'</textarea>';
      output += '</div>'
    return output;
  },
  selectionTemplate_acl: function(data) {
    var output='<div class="selectAclOption">';
      output += '<text>'+data.text+'</text>';
      output += '</div>'
    return output;
  }
}
