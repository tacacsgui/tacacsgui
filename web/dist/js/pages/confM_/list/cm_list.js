var cm_list = {
  init: function() {

  },

  del: function(group, name, flag) {
    group = group || 0;
    flag = (flag !== undefined) ? false : true;
    name = name || 'undefined';
    if (flag && !confirm("Do you want delete '"+name+"'?")) return;
    var ajaxProps = {
      url: API_LINK+"confmanager/file/delete/",
      data: {
        "name": name,
        "group": group,
      }
    };//ajaxProps END
    ajaxRequest.send(ajaxProps).then(function(resp) {
      if( parseInt(resp.result) != 1) {
        tgui_error.local.show( {type:'error', message: "Oops! Unknown error appeared :("} ); return;
      }
      tgui_error.local.show({type:'success', message: "File "+ name +" was deleted"})
      setTimeout( function () {dataTable.table.ajax.reload()}, 2000 );
    }).fail(function(err){
      tgui_error.getStatus(err, ajaxProps)
    })
    return this;
  },//delete device

  getMore: function() {
    var self = this
    var index = 0
    var parser = function(index){
      Promise.resolve( self.getInfo(index) ).then(function(resp){
        console.log('Done');
      }).catch(function(err) {
        //console.log(index);
        if (!err || index > 3000) return
        parser(++index);
        //console.log('Next Request');
      })
    }
    parser(index);
  },
  getInfo: function(index){
    var self = this;
    index = index || 0;
    //console.log(row, index);
    return new Promise(
      function (resolve, reject) {
        var ajaxProps = {
          url: API_LINK+"confmanager/get/more/",
          data: { rowId: index, name: dataTable.table.row(index).data()['name'], group: dataTable.table.row(index).data()['group']}
        };//ajaxProps END

        ajaxRequest.send(ajaxProps).then(function(resp) {
          //console.log(resp);
          var temp = dataTable.table.row(resp.rowId).data();
          temp['commits'] = ( resp.info.length > 1 ) ? resp.info[0] : 'Waiting git commit...';
          temp['date_commit'] = ( resp.info.length > 1 ) ? resp.info[1] : 'Waiting git commit...';
          dataTable.table.row(resp.rowId).data(temp).invalidate();
          if ( index > 100 ) reject(false);
          if ( dataTable.table.rows().eq(0).length == (index + 1) ) resolve(true); else reject(true);
        }).fail(function(err){
          reject(false);
          // temp['commits'] = 'Error appeared...';
          // temp['date_commit'] = 'Error appeared...';
          // dataTable.table.row(resp.rowId).data(temp).invalidate();
          // if ( dataTable.table.rows().eq(0).length == (index + 1) ) resolve(true); else reject(true);
        })
    }/*end of promise function*/)
  },
}
