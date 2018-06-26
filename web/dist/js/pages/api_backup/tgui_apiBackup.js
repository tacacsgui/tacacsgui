
var tgui_apiBackup = {
  init: function() {

  },
  delete: function(name) {
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
      setTimeout( function () {dataTable.ajax.reload()}, 2000 );
    }).fail(function(err){
      tgui_error.getStatus(err, ajaxProps)
    })
    return this;
  },
  restore: function(name) {
    if ( !confirm("Do you want restore '"+name+"'?") ) return;
    var self = this;
    var ajaxProps = {
      url: API_LINK+"backup/restore/",
      data: {name: name}
    };//ajaxProps END
    ajaxRequest.send(ajaxProps).then(function(resp) {
      if(resp.result != 1) {
        tgui_error.local.show( {type:'error', message: "Oops! Unknown error appeared :("} ); return;
      }
      tgui_error.local.show({type:'success', message: "Backup "+ name +" was restored"})
      tgui_status.changeStatus(resp.changeConfiguration)
      setTimeout( function () {dataTable.ajax.reload()}, 2000 );
    }).fail(function(err){
      tgui_error.getStatus(err, ajaxProps)
    })
    return this;
  }
}
