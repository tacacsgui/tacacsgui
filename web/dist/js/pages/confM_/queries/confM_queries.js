var cm_queries = {
  formSelector_add: ' form#addQueryForm ',
  formSelector_edit: ' form#editQueryForm ',
  select_groups_add: ' form#addQueryForm ' + ' .select_groups.select2 ',
  select_groups_edit: ' form#editQueryForm ' + ' .select_groups.select2',
  select_models_add: ' form#addQueryForm ' + ' .select_models',
  select_models_edit: ' form#editQueryForm ' + ' .select_models',
  select_devices_add: ' form#addQueryForm ' + ' .select_devices',
  select_devices_edit: ' form#editQueryForm ' + ' .select_devices',
  select_creden_add: ' form#addQueryForm ' + ' .select_creden',
  select_creden_edit: ' form#editQueryForm ' + ' .select_creden',
  init: function() {
    var self = this;

    $('.modal-content .nav-tabs a.preview').on('show.bs.tab', function(event){
      var formId = '#' + $(event.target).closest( "form" ).attr('id') + ' ';
      //console.log( formId );
      self.preview.clear().info(formId);
      //console.log( $(event.relatedTarget).text() );  // previous tab
    });

    /*Select2 Credentials*/
    this.credenSelect2 = new tgui_select2({
      ajaxUrl : API_LINK+"confmanager/credentials/list/",
      template: this.selectionTemplate_groups,
      placeholder: "Select Credentials",
      allowClear: true,
      add: this.select_creden_add,
      edit: this.select_creden_edit,
    });
    $(this.select_creden_add).select2(this.credenSelect2.select2Data());
    $(this.select_creden_edit).select2(this.credenSelect2.select2Data());
    /*Select2 Credentials*///END
    /*Select2 Group*/
    this.groupsSelect2 = new tgui_select2({
      ajaxUrl : API_LINK+"confmanager/groups/list/",
      template: this.selectionTemplate_groups,
      placeholder: "Select Group",
      allowClear: true,
      add: this.select_groups_add,
      edit: this.select_groups_edit,
    });
    $(this.select_groups_add).select2(this.groupsSelect2.select2Data());
    $(this.select_groups_edit).select2(this.groupsSelect2.select2Data());
    /*Select2 Group*///END
    /*Select2 Models*/
    this.modelsSelect2 = new tgui_select2({
      ajaxUrl : API_LINK+"confmanager/models/list/",
      template: this.selectionTemplate_models,
      placeholder: "Select Model",
      add: this.select_models_add,
      edit: this.select_models_edit,
    });
    $(this.select_models_add).select2(this.modelsSelect2.select2Data());
    $(this.select_models_edit).select2(this.modelsSelect2.select2Data());
    /*Select2 Models*///END
    /*Select2 ACL*/
    this.devicesSelect2 = new tgui_select2({
      ajaxUrl : API_LINK + "confmanager/devices/list/",
      template: this.selectionTemplate_devices,
      placeholder: "Select Devices",
      divClass: 'devices',
      multiple: 1,
      add: this.select_devices_add,
      edit: this.select_devices_edit,
    });

    $(this.select_devices_add).select2(this.devicesSelect2.select2Data());
    $(this.select_devices_edit).select2(this.devicesSelect2.select2Data());
    /*Select2 ACL*///END

    /*cleare forms when modal is hided*/
    $('#addQuery').on('hidden.bs.modal', function(){
      self.clearForm();
    })
    $('#editQuery').on('hidden.bs.modal', function(){
      self.clearForm();
    })/*cleare forms*///end
  },
  add: function() {
    var self = this;
    var formData = tgui_supplier.getFormData(self.formSelector_add);
    formData.devices = self.devicesSelect2.getData(self.devicesSelect2.add, { formId: self.formSelector_add }).attr.id;
    formData.group = self.groupsSelect2.getData(self.groupsSelect2.add, { formId: self.formSelector_add }).attr.id;
    if ( !formData.group ) formData.group = '';
    var ajaxProps = {
      url: API_LINK+"confmanager/queries/add/",
      data: formData
    };//ajaxProps END
    // console.log(formData);
    // return false
    ajaxRequest.send(ajaxProps).then(function(resp) {
      if (tgui_supplier.checkResponse(resp.error, self.formSelector_add)){
        return;
      }
      tgui_error.local.show({type:'success', message: "Query "+ $(self.formSelector_add + ' input[name="name"]').val() +" was added"})
      $("#addQuery").modal("hide");

      self.clearForm();
      setTimeout( function () {dataTable.table.ajax.reload()}, 2000 );
    }).fail(function(err){
      tgui_error.getStatus(err, ajaxProps)
    })
    return this;
  },
  get: function(id, name) {
    var self = this;

    var ajaxProps = {
      url: API_LINK+"confmanager/queries/edit/",
      type: "GET",
      data: {
        "name": name,
        "id": id,
      }
    };//ajaxProps END

    ajaxRequest.send(ajaxProps).then(function(resp) {
      tgui_supplier.fulfillForm(resp.query, self.formSelector_edit);

      if (resp.query.model) self.modelsSelect2.preSelection(resp.query.model, 'edit');
      if (resp.query.devices) self.devicesSelect2.preSelection(resp.query.devices, 'edit');
      if (resp.query.f_group) self.groupsSelect2.preSelection(resp.query.f_group, 'edit');
      if (resp.query.creden) self.credenSelect2.preSelection(resp.query.creden, 'edit');

      if(resp.query.disabled == 1) tgui_supplier.toggle('disabled');

      $('#editQuery').modal('show')
    }).fail(function(err){
      tgui_error.getStatus(err, ajaxProps)
    })
  },//get edit device
  edit: function() {
    var self = this;
    var formData = tgui_supplier.getFormData(self.formSelector_edit, true);

    //Devices
    var dev_list_native = $(self.formSelector_edit + ' [name="devices_native"]').val()
    //console.log(dev_list_native);
    var dev_list = self.devicesSelect2.getData(self.devicesSelect2.edit, { formId: self.formSelector_edit });
    //console.log(dev_list);
    dev_list = ( dev_list.attr && dev_list.attr.id && dev_list.attr.id.length ) ? dev_list.attr.id.join(';;') : '';
    if ( dev_list != dev_list_native ) formData.devices = self.devicesSelect2.getData(self.devicesSelect2.edit, { formId: self.formSelector_edit }).attr.id;

    var ajaxProps = {
      url: API_LINK+"confmanager/queries/edit/",
      data: formData
    };//ajaxProps END

    // console.log(formData);
    // return false

    if ( ! tgui_supplier.checkChanges(ajaxProps.data, ['id']) ) return false;

    ajaxRequest.send(ajaxProps).then(function(resp) {
      if (tgui_supplier.checkResponse(resp.error, self.formSelector_edit)){
        return;
      }
      tgui_error.local.show({type:'success', message: "Query "+ $(self.formSelector_edit + ' input[name="name"]').val() +" was edited"})
      $("#editQuery").modal("hide");
      self.clearForm();
      setTimeout( function () {dataTable.table.ajax.reload()}, 2000 );
    }).fail(function(err){
      tgui_error.getStatus(err, ajaxProps)
    })
    return this;
  },
  del: function(id, name, flag) {
    id = id || 0;
    flag = (flag !== undefined) ? false : true;
    name = name || 'undefined';
    if (flag && !confirm("Do you want delete '"+name+"'?")) return;
    var ajaxProps = {
      url: API_LINK+"confmanager/queries/delete/",
      data: {
        "name": name,
        "id": id,
      }
    };//ajaxProps END
    ajaxRequest.send(ajaxProps).then(function(resp) {
      if( parseInt(resp.result) != 1) {
        tgui_error.local.show( {type:'error', message: "Oops! Unknown error appeared :("} ); return;
      }
      tgui_error.local.show({type:'success', message: "Query "+ name +" was deleted"})
      setTimeout( function () {dataTable.table.ajax.reload()}, 2000 );
    }).fail(function(err){
      tgui_error.getStatus(err, ajaxProps)
    })
    return this;
  },//delete device
  selectionTemplate_models: function(data){
    var output='<div class="selectModelOption">';
      output += '<text>'+data.text+'</text>';
      output += '</div>'
    return output;
  },
  selectionTemplate_devices: function(data){
    //console.log(data);
    var output='<div class="selectServiceOption">';
      output += '<text>'+data.text+'</text>';
      output += '<input class="item-attr" type="hidden" name="id" value="'+data.id+'">';
      output += '</div>'
    return output;
  },
  selectionTemplate_groups: function(data){
    //console.log(data);
    var output='<div class="selectServiceOption">';
      output += '<text>'+data.text+'</text>';
      output += '<input class="item-attr" type="hidden" name="id" value="'+data.id+'">';
      output += '</div>'
    return output;
  },
  clearForm: function() {
    tgui_supplier.clearForm();
    /*---*/
    this.preview.clear()
  },
  preview: {
    info: function(formId) {
      //model info
      if ( $( formId + '.select_models').select2('data') && $( formId + '.select_models').select2('data')[0] ){
        model_data = $( formId + '.select_models').select2('data')[0];
        $( formId + 'model').text(model_data.text).attr('data-id', model_data.id);
      } else {
        $( formId + 'model').text('Undefined');
      }
      //omit lines info
      $(formId + 'omitLines').text( $(formId + '[name="omit_lines"]').val() || 'Undefined' )
      //device info
      //console.log( !!$( formId + '.select_devices').select2('data').length );
      if ( $( formId + '.select_devices').select2('data') && !!$( formId + '.select_devices').select2('data').length ){
        for (var i = 0; i < $( formId + '.select_devices').select2('data').length; i++) {
          device_data = $( formId + '.select_devices').select2('data')[i]
          $(formId + '[name="device_preview"]').append( new Option(device_data.text, device_data.id, false, !!!i) ).trigger('change');
        }
      } else {
        $(formId + '[name="device_preview"]').append( new Option('Undefined', 0, true, true) ).trigger('change');
      }
    },
    run: function(o) {
      $('pre.preview_resp').empty().append('Loading...');
      var formId = '#' + $(o).closest( "form" ).attr('id') + ' ';
      //console.log(formId);
      var ajaxProps = {
        url: API_LINK+"confmanager/queries/preview/",
        data: {
          'device': $(formId + '[name="device_preview"]').val(),
          'model': $(formId + 'model').attr('data-id'),
          'credentials': $(formId + '[name="creden"]').val(),
          'omitLines': $(formId + '[name="omit_lines"]').val(),
          'debug': +$(formId + '[name="preview_debug"]').prop('checked'),
        }
      };//ajaxProps END
      ajaxRequest.send(ajaxProps).then(function(resp) {
        $('pre.preview_resp').empty();
        if (resp.error && resp.error.status){
          if (resp.error.validation && resp.error.validation.device){
            $(formId + 'pre.preview_resp').append('Selected Incorrect device.').append("\n");
          }
          if (resp.error.validation && resp.error.validation.model){
            $(formId + 'pre.preview_resp').append('Selected Incorrect model.').append("\n");
          }
          if (resp.error.validation && resp.error.validation.cm){
            $(formId + 'pre.preview_resp').append('Something wrong with Configuration Manager. It is missing or cannot be run.').append("\n");
          }
          return false;
        }

        if ( resp.preview ) {
          var lines = resp.preview.split("\n")
          var re = new RegExp("^___.*");
          var reST = new RegExp("(^START_ .*|^___START_ .*)");
          var reEN = new RegExp(".* END_$");
          var startNumbering = false;
          for (var i = 0; i < lines.length; i++) {
            if ( reST.test( lines[i] ) ) { startNumbering = true; }

            if ( startNumbering ) {
              if ( re.test( lines[i] ) ) {
                $(formId + 'pre.preview_resp').append('<span class="bg-red">' + lines[i].replace(/^___/, '').replace(/^START_\s|\sEND_$/, '') + "</span>")
              } else {
                $(formId + 'pre.preview_resp').append('<span>' + lines[i].replace(/^START_\s|\sEND_$/, '') + "</span>")
              }
            } else {
              $(formId + 'pre.preview_resp').append( lines[i] + "\n" )
            }
            if ( reEN.test( lines[i] ) ) { startNumbering = false; lines[i].replace(/END_$/, ''); }
          }
        }
        else  $(formId + 'pre.preview_resp').append('Error: Preview unavailable')
      }).fail(function(err){
        tgui_error.getStatus(err, ajaxProps)
      })
      return false;
    },
    clear: function() {
      $('model').text('');
      $('omitLines').text('');
      $('[name="device_preview"]').empty();
      $('pre.preview_resp').empty().append('Click Preview to get result...');
      return this;
    }
  }
}
