var tgui_cmd = {
  formSelector_add: 'form#addCMDForm',
  formSelector_edit: 'form#editCMDForm',
  init: function(){
    var self = this;

    tgui_sortable.init();

    this.csvParser = new tgui_csvParser(this.csv);
    /*cleare forms when modal is hided*/
    $('#addCMD').on('hidden.bs.modal', function(){
      self.clearForm();
    })
    $('#editCMD').on('hidden.bs.modal', function(){
      self.clearForm();
    })/*cleare forms*///end
  },
  add: function(){
    var self = this;
    var formData = tgui_supplier.getFormData(self.formSelector_add);
    var ajaxProps = {
      url: API_LINK+"tacacs/cmd/add/",
      data: formData
    };//ajaxProps END
    formData.cmd_attr = tgui_sortable.get(self.formSelector_add).text;
    console.log(formData);
    ajaxRequest.send(ajaxProps).then(function(resp) {
      if (tgui_supplier.checkResponse(resp.error, self.formSelector_add)){
        return;
      }
      tgui_error.local.show({type:'success', message: "CMD "+ $(self.formSelector_add + ' input[name="name"]').val() +" was added"})
      $("#addCMD").modal("hide");
      //tgui_status.changeStatus(resp.changeConfiguration)
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
      url: API_LINK+"tacacs/cmd/edit/",
      type: "GET",
      data: {
        "name": name,
        "id": id,
      }
    };//ajaxProps END

    ajaxRequest.send(ajaxProps).then(function(resp) {
      tgui_supplier.fulfillForm(resp.cmd, self.formSelector_edit);
      $(self.formSelector_edit + ' [name="cmd_attr"]').val(resp.cmd.cmd_attr);
      self.cmd_attr.fill(resp.cmd.cmd_attr, self.formSelector_edit);
      $('#editCMD').modal('show')
    }).fail(function(err){
      tgui_error.getStatus(err, ajaxProps)
    })
  },
  edit: function() {
    var self = this;
    var formData = tgui_supplier.getFormData(self.formSelector_edit, true);

    var ajaxProps = {
      url: API_LINK+"tacacs/cmd/edit/",
      data: formData
    };//ajaxProps END
    if ( ! self.cmd_attr.compare( tgui_sortable.get( self.formSelector_edit).text ) ) {
      formData.cmd_attr = tgui_sortable.get(self.formSelector_edit).text;
      formData.cmd_attr = ( formData.cmd_attr.length ) ? formData.cmd_attr : false;
    }

    // console.log(tgui_sortable.get(self.formSelector_edit));
    // return false;
    if ( ! tgui_supplier.checkChanges(ajaxProps.data, ['id']) ) return false;
    ajaxRequest.send(ajaxProps).then(function(resp) {
      if (tgui_supplier.checkResponse(resp.error, self.formSelector_edit)){
        return;
      }
      tgui_error.local.show({type:'success', message: "CMD "+ $(self.formSelector_edit + ' input[name="name"]').val() +" was changed"})
      $("#editCMD").modal("hide");
      //tgui_status.changeStatus(resp.changeConfiguration)
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
      url: API_LINK+"tacacs/cmd/delete/",
      data: {
        "name": name,
        "id": id,
      }
    };//ajaxProps END
    ajaxRequest.send(ajaxProps).then(function(resp) {
      if( parseInt(resp.result) != 1) {
        tgui_error.local.show( {type:'error', message: "Oops! Unknown error appeared :("} ); return;
      }
      tgui_error.local.show({type:'success', message: "CMD "+ name +" was deleted"});
      tgui_status.changeStatus(resp.changeConfiguration);
      setTimeout( function () {dataTable.table.ajax.reload()}, 2000 );
    }).fail(function(err){
      tgui_error.getStatus(err, ajaxProps)
    })
    return this;
  },
  cmd_attr: {
    add: function(o) {
      $(o).closest('.form-group').removeClass('has-error').find('p.help-block.error').remove();
      var formId = '#'+$(o).closest('form').attr('id');
      var text = $( formId + ' .cmd-attr-creator-val' ).val();
      var action = ($( formId + ' .cmd-attr-creator-action' ).prop('checked')) ? 'permit' : 'deny';

      if (! text ){
        $(o).closest('.form-group').addClass('has-error').append('<p class="help-block error">attribute can\'t be empty</p>');
        return false;
      }

      var element = '<div data-action="'+action+'" data-attr="'+text+'"><span class="text-'+ ( (action == 'permit') ? 'success' : 'danger' ) +' text-muted">' + action + '</span> <b>'+text+'</b></div>'
      var new_el = {
        class: action,
        formId : formId,
        element: element
      }

      if ( tgui_sortable.check(element, formId) ){
        $(o).closest('.form-group').addClass('has-error').append('<p class="help-block error">this attribute already added!</p>');
        return false;
      }

      tgui_sortable.add(new_el);

      $( formId + ' .cmd-attr-creator-val' ).val('');

      return false;
    },
    del: function(o) {
      var formId = '#'+$(o).closest('form').attr('id');
      $($(o).closest('div.cmd-attr-item')).remove()
      //if (! $( formId + ' div.cmd-attr-item').length ) $( formId + ' .cmd-attr-list').append( '<div class="text-center"><p class="text-muted">list of attributes</p></div>' );

      return false;
    },
    template: function(o){
      o = o || {};
      o.name = o.name || undefined;
      o.action = o.action || '';
      var output = '<div class="cmd-attr-item '+o.action+'">'+
        '<div class="cmd-attr-string"><text data-action="'+o.action+'">'+o.name+'</text></div><div class="cmd-delete pull-right"><a href="#" onclick="tgui_cmd.cmd_attr.del(this);"><i class="fa fa-close"></i></a></div>'+
      '</div>';
      return output;
    },
    check: function(cmd) {
      for (var i = 0; i < $( cmd.formId + ' div.cmd-attr-item').length; i++) {
        if ( $($( cmd.formId + ' div.cmd-attr-item')[i]).find('text').text() == cmd.name) return false;
      }
      return true;
    },
    fill: function(data, formId){
      data = data || '';
      formId = formId || '';
      if ( data == '' ) return false;
      var some_array = data.split(";;");
      console.log(some_array);
      var element = '';
      var action = '';
      var new_el = {};
      for (var i = 0; i < some_array.length; i++) {
        action = ( some_array[i].includes("permit ") ) ? 'permit' : 'deny';
        element = '<div data-action="'+action+'" data-attr="'+ some_array[i].replace( action + " ", "" ) +'"><span class="text-'+ ( (action == 'permit') ? 'success' : 'danger' ) +' text-muted">' + action + '</span> <b>'+some_array[i].replace( action + " ", "" )+'</b></div>'
        new_el = {
          class: action,
          formId : formId,
          element: element
        }

        tgui_sortable.add(new_el);
        //$( tgui_cmd.formSelector_edit + ' .cmd-attr-list').append( this.template( { action: action, name: some_array[i].replace( action + " ", "" ) } ) );
      }
    },
    compare: function(data) {
      data = data || [];
      if ( $( tgui_cmd.formSelector_edit + ' [name="cmd_attr"]').val() == '' && !data.length ) return true;

      return $( tgui_cmd.formSelector_edit + ' [name="cmd_attr"]').val() == data.join(';;');
    },
    clear: function() {
      tgui_sortable.clear();
      //$('.cmd-attr-list').append( '<div class="text-center"><p class="text-muted">list of attributes</p></div>' );
    },
    collect: function(formId) {
      formId = formId || 'form#addCMDForm';
      var output = [];
      for (var i = 0; i < $( formId + ' div.cmd-attr-item').length; i++) {
        output[output.length]=$($( formId + ' div.cmd-attr-item')[i]).find('text').data('action')+' '+$($( formId + ' div.cmd-attr-item')[i]).find('text').text();
      }
      return output;
    }
  },
  csv: {
    columnsRequired: ['name'],
    fileInputId: '#csv-file',
    ajaxLink: 'tacacs/cmd/add/',
    ajaxItem: 'cmd',
    outputId: '#csvParserOutput',
    ajaxHandler: function(resp,index){
      var item = 'cmd';
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
        this.csvParserOutput({tag: '<p class="text-success">Service <b>'+ resp[item].name + '</b> was added!</p>', response: index});
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
    /*---*/
    this.cmd_attr.clear();
    $('.nav.nav-tabs a[href="#general_info"]').tab('show');//select first tab
    $('.nav.nav-tabs a[href="#general_info_edit"]').tab('show');//select first tab
  }
}
