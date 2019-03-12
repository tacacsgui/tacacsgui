var cm_models = {
  formSelector_add: ' form#addModelForm ',
  formSelector_edit: ' form#editModelForm ',
  init: function() {
    var self = this;
    $('input[name="hidden"]').change('checked', function(e){
      if ( $(this).prop('checked') ){
        $( $(this).closest('div').find('input[name="send"]')[0] ).attr('type', 'password');
      }
      else {
        if ( $(this).data('edit') ) $( $(this).closest('div').find('input[name="send"]')[0] ).val('')
        $( $(this).closest('div').find('input[name="send"]')[0] ).attr('type', 'text');
      }
      return true;
    })

    $('.modal-content .nav-tabs a.export_tab').on('show.bs.tab', function(event){
      var formId = '#' + $(event.target).closest( "form" ).attr('id') + ' ';
      //console.log( formId );         // active tab
      $(formId + 'pre.yaml-export')
        .empty()
        .append( jsyaml.dump( self.expect.collect( formId ) ) )
      //console.log( $(event.relatedTarget).text() );  // previous tab
    });

    /*cleare forms when modal is hided*/
    $('#addModel').on('hidden.bs.modal', function(){
      self.clearForm();
    })
    $('#editModel').on('hidden.bs.modal', function(){
      self.clearForm();
    })/*cleare forms*///end
  }, //end of init
  add: function() {
    var self = this;
    var formData = tgui_supplier.getFormData(self.formSelector_add);
    formData.expectations = this.expect.collect(self.formSelector_add).expectations
    var ajaxProps = {
      url: API_LINK+"confmanager/models/add/",
      data: formData
    };//ajaxProps END
    ajaxRequest.send(ajaxProps).then(function(resp) {
      if (tgui_supplier.checkResponse(resp.error, self.formSelector_add)){
        return;
      }
      tgui_error.local.show({type:'success', message: "Model "+ $(self.formSelector_add + ' input[name="name"]').val() +" was added"})
      $("#addModel").modal("hide");

      self.clearForm();
      setTimeout( function () {dataTable.table.ajax.reload()}, 2000 );
    }).fail(function(err){
      tgui_error.getStatus(err, ajaxProps)
    })
    return this;
  },//add model
  get: function(id, name) {
    var self = this;

    var ajaxProps = {
      url: API_LINK+"confmanager/models/edit/",
      type: "GET",
      data: {
        "name": name,
        "id": id,
      }
    };//ajaxProps END

    ajaxRequest.send(ajaxProps).then(function(resp) {
      tgui_supplier.fulfillForm(resp.model, self.formSelector_edit);
      self.expect.fill(resp.model, self.formSelector_edit)
      $('textarea[name="native_settings"]').val( jsyaml.dump( self.expect.collect( self.formSelector_edit ).expectations ) );
      $('#editModel').modal('show')
    }).fail(function(err){
      tgui_error.getStatus(err, ajaxProps)
    })
  },//get edit model

  edit: function() {
    var self = this;

    var formData = tgui_supplier.getFormData(self.formSelector_edit, true);
    if ( jsyaml.dump( this.expect.collect(self.formSelector_edit).expectations ) != $(self.formSelector_edit + 'textarea[name="native_settings"]').val() ) {
      formData.expectations = this.expect.collect(self.formSelector_edit).expectations
    }
    console.log(formData);
    var ajaxProps = {
      url: API_LINK+"confmanager/models/edit/",
      data: formData
    };//ajaxProps END

    if ( ! tgui_supplier.checkChanges(ajaxProps.data, ['id']) ) return false;

    ajaxRequest.send(ajaxProps).then(function(resp) {
      if (tgui_supplier.checkResponse(resp.error, self.formSelector_edit)){
        return;
      }
      tgui_error.local.show({type:'success', message: "Model "+ $(self.formSelector_edit + ' input[name="name"]').val() +" was edited"})
      self.clearForm();
      setTimeout( function () {dataTable.table.ajax.reload()}, 2000 );
      $('#editModel').modal('hide')
    }).fail(function(err){
      tgui_error.getStatus(err, ajaxProps)
    })
  },//post edit model

  del: function(id, name, flag) {
    id = id || 0;
    flag = (flag !== undefined) ? false : true;
    name = name || 'undefined';
    if (flag && !confirm("Do you want delete '"+name+"'?")) return;
    var ajaxProps = {
      url: API_LINK+"confmanager/models/delete/",
      data: {
        "name": name,
        "id": id,
      }
    };//ajaxProps END
    ajaxRequest.send(ajaxProps).then(function(resp) {
      if( parseInt(resp.result) != 1) {
        tgui_error.local.show( {type:'error', message: "Oops! Unknown error appeared :("} ); return;
      }
      tgui_error.local.show({type:'success', message: "Model "+ name +" was deleted"})
      setTimeout( function () {dataTable.table.ajax.reload()}, 2000 );
    }).fail(function(err){
      tgui_error.getStatus(err, ajaxProps)
    })
    return this;
  },//delete model




  clearForm: function() {
    tgui_supplier.clearForm();
    /*---*/
    this.expect.clear();
    $('textarea[name="native_settings"]').val('');
  },
  expect: {
    add: function(o, direction){
      $('div.has-error').removeClass('has-error');
      $('p.error').remove();
      $('p.help-block').show();
      var formId = '#' + $(o).closest( "form" ).attr('id') + ' ';
      var data = {
        send: $(formId + 'input[name="send"]').val(),
        expect: $(formId + 'input[name="expect"]').val(),
        write: $(formId + 'input[name="write"]').prop('checked'),
        hidden: $(formId + 'input[name="hidden"]').prop('checked'),
      }
      if ( ! data.send ) {
        $(formId + 'div.send p.help-block').hide();
        $(formId + 'div.send').append('<p class="error help-block">Send can not be empty!</p>').addClass('has-error');

        return false;
      }
      if (direction == 'up') $(formId + 'ul.expectations').prepend(this.template(data))
      else $(formId + 'ul.expectations').append(this.template(data))
      this.clear(true);
      return true;
      //console.log( formId );
    },
    move: function(o, direction) {
      //console.log(o);
      var li = $(o).closest( "li" );
      //console.log(li);
      var index = $(li).index();  // Index of clicked item
      var temp = $(li);    // Contents of clicked item
      //console.log(temp);
      var partner;                  // The paired element
      if(direction == 'up') { // Even
        $before = temp.prev();
        temp.insertBefore($before);
      }else { // Odd
        $after = temp.next();
        temp.insertAfter($after);
      }
    },//end of move expect
    get: function(o) {
      var formId = '#' + $(o).closest( "form" ).attr('id') + ' ';
      var data = $(o).closest( "li" ).data();
      this.clear(true);
      $(formId + 'div.addNewLine').hide();
      $(formId + 'div.editLine').show();

      $(formId + 'div.expectation-form').addClass('edit-mode');
      $(formId + 'input[name="ex_id"]').val( $(o).closest( "li" ).attr('id') );
      $(formId + 'input[name="send"]').val(data.send);
      $(formId + 'input[name="expect"]').val(data.expect);
      $(formId + 'input[name="write"]').prop('checked', data.write);
      $(formId + 'input[name="hidden"]').attr('data-edit', data.hidden).data('edit', data.hidden).prop('checked', data.hidden).trigger("change");
    },
    edit: function(o) {
      var formId = '#' + $(o).closest( "form" ).attr('id') + ' ';
      var liId = '#' + $(formId + 'input[name="ex_id"]').val() + ' ';
      var data = {
        send: $(formId + 'input[name="send"]').val(),
        expect: $(formId + 'input[name="expect"]').val(),
        write: $(formId + 'input[name="write"]').prop('checked'),
        hidden: $(formId + 'input[name="hidden"]').prop('checked'),
      }
      if ( ! data.send ) {
        $(formId + 'div.send p.help-block').hide();
        $(formId + 'div.send').append('<p class="error help-block">Send can not be empty!</p>').addClass('has-error');

        return false;
      }
      $(formId + 'ul.expectations li'+liId).replaceWith(this.template(data))
      this.clear(true);
      return true;
    },
    del: function(o) {
      !confirm('Do you want to delete expect line?') || $(o).closest( "li" ).remove();
      return true;
    },
    collect: function(formId) {
      var data = {
        name: $(formId + 'input[name="name"]').val(),
        prompt: $(formId + 'input[name="prompt"]').val(),
        expectations : []
      }
      //console.log( $(formId + 'ul.expectations') );
      for (var i = 0; i < $(formId + 'ul.expectations li').length; i++) {
        data.expectations[data.expectations.length] = $( $(formId + 'ul.expectations li')[i] ).data();
      }
      //console.log(data);
      return data;
    },
    copyExport: function(o) {
      var formId = '#' + $(o).closest( "form" ).attr('id') + ' ';
      var $temp = $('<textarea type="hidden"></textarea>');
      $("body").append($temp);
      //console.log( jsyaml.dump( this.collect( formId ) ) );
      $temp.val( jsyaml.dump( this.collect( formId ) ) ).select();
      document.execCommand("copy");
      $temp.remove();
      tgui_error.local.show({type:'success', message: "You have copied model settings"})
      return false;
    },
    upload: function(o) {
        var formId = '#' + $(o).closest( "form" ).attr('id') + ' ';
        $(formId + '.import-yaml').click();
    },
    import: function(o) {

      if (!window.File || !window.FileReader || !window.FileList || !window.Blob) {
        tgui_error.local.show({type:'error', message: "You browser does not support FileRader!"})
        return;
      }
      if ( !$(o)[0] || !$(o)[0].files[0] ){
        tgui_error.local.show({type:'error', message: "File not found!"})
        return;
      }
      var file = $(o)[0].files[0];
      //console.log($(o)[0].files[0]);
      if (file.type != 'text/plain') {
        tgui_error.local.show({type:'error', message: "File must be plain text file!"})
        return;
      }
      var formId = '#' + $(o).closest( "form" ).attr('id') + ' ';
      var self = this;
      var reader = new FileReader();
      reader.onload = function(e){
        if (!e.target.result) { tgui_error.local.show( {type:'error', message: "Empty file!"} ); return; }
        $('.import-yaml').val('');
        var o = [];
        try {
          var data = jsyaml.load(e.target.result)
          self.fill(data, formId);
        } catch (e) {
          tgui_error.local.show({type:'error', message: "Incorrect file content!"})
        }
      }
      reader.readAsText(file);

      return true;
    },
    fill: function( data, formId ) {
      data = data || {}
      data.name && $(formId + 'input[name="name"]').val(data.name);
      data.prompt && $(formId + 'input[name="prompt"]').val(data.prompt);
      if ( data.expectations ) {
        $(formId + 'ul.expectations').empty()
        for (var i = 0; i < data.expectations.length; i++) {
          $(formId + 'ul.expectations').append( this.template( data.expectations[i] ) )
        }
      }
      return true;
    },
    clear: function( form ) {
      $('div.has-error').removeClass('has-error');
      $('p.error').remove();
      $('p.help-block').show();
      $('input[name="send"]').val('');
      $('input[name="expect"]').val('');
      $('input[name="ex_id"]').val('');
      $('input[name="write"]').prop('checked', true);
      $('input[name="hidden"]').attr('data-edit',false).data('edit', false).prop('checked', false).trigger("change");
      $('div.expectation-form').removeClass('edit-mode');
      $('div.addNewLine').show();
      $('div.editLine').hide();

      if ( form ) return false;

      $('ul.expectations').empty();

    },
    template: function(o) {
      //console.log(o);
      return '<li data-send="'+ o.send +'" data-expect="'+ o.expect +'" data-write="'+ +o.write +'" data-hidden="'+ +o.hidden +'" id="'+this.setIndex()+'">'+
        '<div class="expe-value">'+
          '<span>Expect: </span><span class="value" title="' + ( o.expect || '_default_' ) + '">' + ( o.expect || '_default_' ) + '</span>'+
        '</div>'+
        '<div class="expe-value">'+
          '<span>Send: </span><span class="value '+ !!+o.hidden+'" title="' + ( !!+o.hidden ? '*********' : o.send ) + '">' + ( !!+o.hidden ? '*********' : o.send ) + '</span>'+
        '</div>'+
        '<div class="expe-write">'+
          '<span>' + ( !!+o.write ? 'Write' : '' ) + '</span>'+
        '</div>'+
        '<div class="expe-action text-center">'+
          '<a class="btn btn-default btn-flat" onclick="cm_models.expect.move(this, \'up\')"><i class="fa fa-sort-up"></i></a>'+
          '<a class="btn btn-default btn-flat" onclick="cm_models.expect.move(this, \'down\')"><i class="fa fa-sort-down"></i></a>'+
          '<a class="btn btn-warning btn-flat text-black" onclick="cm_models.expect.get(this)"><i class="fa fa-edit"></i></a>'+
          '<a class="btn btn-danger btn-flat text-black" onclick="cm_models.expect.del(this)"><i class="fa fa-trash-o"></i></a>'+
        '</div>'+
      '</li>'
    },
    setIndex: function() {
      var uid = tgui_supplier.random(8);
      while (true) {
        if ( ! $('#eli_'+uid).length ) break;
      }
      return 'eli_'+uid;
    },
  }
}
