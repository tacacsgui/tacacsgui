
var tgui_apiBackup = {
  init: function() {
    this.getSettings();
  },
  delete: function(name,type) {
    if ( !confirm("Do you want delete '"+name+"'?") ) return;
    var self = this;
    var ajaxProps = {
      url: API_LINK+"backup/delete/",
      data: {name: name}
    };//ajaxProps END
    ajaxRequest.send(ajaxProps).then(function(resp) {
      if(resp.result != 1) {
        tgui_error.local.show( {type:'error', message: "Oops! Unknown error appeared :("} ); return;
      }
      tgui_error.local.show({type:'success', message: "Backup "+ name +" was deleted"})
      setTimeout( function () {dataTables[type].ajax.reload()}, 2000 );
    }).fail(function(err){
      tgui_error.getStatus(err, ajaxProps)
    })
    return this;
  },
  getSettings: function() {
    var self = this;
    var ajaxProps = {
      url: API_LINK+"backup/settings/",
      type: "GET",
    };//ajaxProps END
    ajaxRequest.send(ajaxProps).then(function(resp) {
      tgui_supplier.fulfillForm(resp.settings, '#tcfg_backupForm');
      tgui_supplier.fulfillForm(resp.settings, '#apicfg_backupForm');
      $('[name="tcfgSet"]').on('ifChanged', function(){
        self.autoBackup('tcfgSet', ( ( $('[name="tcfgSet"]').prop('checked') ) ? 1 : 0 ) )
      })
      $('[name="apicfgSet"]').on('ifChanged', function(){
        self.autoBackup( 'apicfgSet', ( ( $('[name="apicfgSet"]').prop('checked') ) ? 1 : 0 ) )
      })
    }).fail(function(err){
      tgui_error.getStatus(err, ajaxProps)
    })
  },
  autoBackup: function(target, set) {
    var self = this;
    var ajaxProps = {
      url: API_LINK+"backup/settings/",
      data: {target: target || '', set: (set != undefined) ? set : '' }
    };//ajaxProps END
    ajaxRequest.send(ajaxProps).then(function(resp) {
      if(resp.result != 1) {
        tgui_error.local.show( {type:'error', message: "Oops! Unknown error appeared :("} ); return;
      }
      tgui_error.local.show({type:'success', message: "Backup settings was changed"})
    }).fail(function(err){
      tgui_error.getStatus(err, ajaxProps)
    })
  },
  restore: function(name,type) {
    if ( !confirm("Do you want restore '"+name+"'?") ) return;
    var self = this;
    var ajaxProps = {
      url: API_LINK+"backup/restore/",
      data: {name: name, type: type}
    };//ajaxProps END
    ajaxRequest.send(ajaxProps).then(function(resp) {
      if(resp.result != 1) {
        tgui_error.local.show( {type:'error', message: "Oops! Unknown error appeared :("} ); return;
      }
      tgui_error.local.show({type:'success', message: "Backup "+ name +" was restored"})
      tgui_status.changeStatus(resp.changeConfiguration)
      setTimeout( function () {dataTables[type].ajax.reload()}, 2000 );
    }).fail(function(err){
      tgui_error.getStatus(err, ajaxProps)
    })
    return this;
  },
  make: function(type){
    var self = this;
    var diff = 1;
    if ( $('#'+type+'_backupForm [name="diff"]').length ) {
      diff = ( $('#'+type+'_backupForm [name="diff"]').prop('checked') ) ? 1 : 0;
    }

    var ajaxProps = {
      url: API_LINK+"backup/make/",
      data: {type: type, diff: diff}
    };//ajaxProps END

    ajaxRequest.send(ajaxProps).then(function(resp) {
      if(!resp.result || !resp.result.status || !resp.result.message) {
        if (resp.result.message) tgui_error.local.show( {type:'error', message: resp.result.message} ); return;
        tgui_error.local.show( {type:'error', message: "Oops! Unknown error appeared :("} ); return;
      }
      tgui_error.local.show( {type:'success', message: resp.result.message} );
      setTimeout( function () { dataTables[type].ajax.reload(); }, 2000 );
    }).fail(function(err){
      tgui_error.getStatus(err, ajaxProps)
    })
  },
  upload: function(button) {

    var form = $(button).parents('form')[0];
    var formId = '#'+$(form).attr('id');
    var type = $(form).attr('data-comment');
    $(formId + ' [role="progressbar"]').attr('aria-valuenow', '0').css('width', '0%');
    $(formId + ' [name="file_status"]').text('').removeClass('text-red text-success');

    if (!$( formId + ' #file')[0].files) {
      this.error("Choose file to upload", formId); return;
    }
    var file = $(formId + ' #file')[0].files[0] || undefined;
    if (!file) {
      this.error("Choose file to upload", formId); return;
    }
    var data = new FormData();
    data.append(type, file);
    var self = this;

    var ajaxProps = {
      url: API_LINK+"backup/upload/",
      data: {action: 'check', name: file.name}
    };//ajaxProps END

    ajaxRequest.send(ajaxProps).then(function(resp) {
      if (resp.error.status) { self.error(resp.error.message, formId); return; }
      var ajaxProps = {
        url: API_LINK+"backup/upload/",
        cache: false,
        processData: false,
        contentType: false,
        data: data
      };//ajaxProps END

      ajaxProps.xhr = function() {
          var xhr = new window.XMLHttpRequest();
          xhr.upload.addEventListener("progress", function(evt) {
            var percent = Math.round( (evt.loaded / evt.total) * 100 );
            $(formId + ' [role="progressbar"]').attr('aria-valuenow', percent).css('width', percent+'%');
          }, false);

         return xhr;
      },
      ajaxRequest.send(ajaxProps).then(function(resp) {
        if (resp.error.status) { self.error(resp.error.message, formId); return; }
        if (resp.result) {
          tgui_error.local.show( {type:'success', message: resp.result} );
          $(formId + ' [name="file_status"]').text(resp.result).addClass('text-success');
          console.log(type);
          setTimeout( function () {dataTables[type].ajax.reload()}, 2000 );
        }
      }).fail(function(err){
        tgui_error.getStatus(err, ajaxProps)
      })

    }).fail(function(err){
      tgui_error.getStatus(err, ajaxProps)
    })
  },
  error: function(message, formId){
    message = message || 'Error';
    formId = formId || 'tcfg_backupForm';
    $(formId + ' [name="file_status"]').text('').removeClass('text-red');
    tgui_error.local.show( {type:'error', message: message} );
    $(formId + ' [name="file_status"]').text(message).addClass('text-red');
  }
}
