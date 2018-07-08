
function tgui_csvParser(csv) {
  csv = csv || {};
  csv.outputId = csv.outputId || '#csvParserOutput';
  csv.fileInputId = csv.fileInputId || '#csv-file';
  csv.ajaxLink = csv.ajaxLink || 'tacacs/device/add/';
  csv.columnsRequired = csv.columnsRequired || [];
  csv.ajaxHandler = csv.ajaxHandler || function(){ return false};
  csv.finalAnswer = csv.finalAnswer || function(){ return false};
  return {
    fileInputId: csv.fileInputId,
    csvOutputId: csv.outputId,
    required: csv.columnsRequired,
    ajaxHandler: csv.ajaxHandler,
    finalAnswer: csv.finalAnswer,
    data: [],
    read: function() {
      var self = this;
      if (!$(this.fileInputId)[0].files) {
        tgui_error.local.show( {type:'error', message: "Choose file to upload"} ); return;
      }
      var file = $(this.fileInputId)[0].files[0] || undefined;
      if (!file) {
        tgui_error.local.show( {type:'error', message: "Choose file to upload"} ); return;
      }

      var regex = /^([a-zA-Z0-9\s_\\.\-:])+(.csv|.txt)$/;

      if ( !regex.test( file.name.toLowerCase() ) ) { tgui_error.local.show( {type:'error', message: "Incorrect File Format"} ); return; }

      if (typeof (FileReader) == "undefined") { tgui_error.local.show( {type:'error', message: "Browser Unsupported"} ); return;}

      var reader = new FileReader();
      reader.onload = function(e){
        if (!e.target.result) { tgui_error.local.show( {type:'error', message: "Empty file!"} ); return; }
        $(self.fileInputId).val('');
        var o = [];
        var separator = ( $('[name="separator"]:checked').length ) ? $('[name="separator"]:checked').val() : ',';
        console.log(separator);
        try {
          o = $.csv.toObjects(e.target.result, { "separator": separator});
        } catch (e) {
          tgui_error.getStatus(e, {})
        }
        self.parser(o);
      }
      reader.readAsText(file);
    },
    parser: function(o) {
      var promises = [];
      var self = this;
      if ( o.length == 0 ) { tgui_error.local.show( {type:'error', message: "Empty file!"} ); return;}
      $(this.csvOutputId).empty().append('Parsing csv file...');
      var index = 0;
      var parser = function(o, index){
        Promise.resolve( self.parserPromise(o, index) ).then(function(resp){
          self.finalAnswer();
        }).catch(function(err) {
          if (!err) { $(this.csvOutputId).empty().append('Parsing csv file...'); return; }
          parser(err.o,err.index);
        })
      }
      parser(o, index);
    },
    parserPromise: function(o, index){
      var self = this;
      o = o || [];
      index = index || 0;
      row = o[index] || {};
      //console.log(row, index);
      return new Promise(
        function (resolve, reject) {
          self.csvParserOutput({message: 'Check line number '+ index})
          var o_keys = Object.keys(row);
          var error_flag = false;
          //check required fields
          for (var j = 0, r_len = self.required.length; j < r_len; j++) {
            if ( ! o_keys.includes(self.required[j]) ) {
              self.csvParserOutput({message: 'Error. The feild <b>'+ self.required[j] + '</b> not found! Stop Parser!', class: 'text-danger'});
              self.csvParserOutput({tag: '<hr>'});
              error_flag = true;
              break;
            }
          }//check required fields end

          if (error_flag) { reject(false); return;}
          var name = row.name || row.username
          self.csvParserOutput({message:'Adding '+name+'. Send to server...'});
          var ajaxProps = {
              url: API_LINK+csv.ajaxLink,
              data: row
            };//ajaxProps END

          self.csvParserOutput({message: 'Server response: <div class="server_response_'+index+'">'+tgui_supplier.loadElement()+'</div>'});
          ajaxRequest.send(ajaxProps).then(function(resp) {
            self.ajaxHandler(resp,index);
            index++;
            if (o.length != index){
              reject({index: index, o: o});
            }
            else resolve(true);
          }).fail(function(err){
            tgui_error.getStatus(err, ajaxProps)
          })
      }/*end of promise function*/)
    },
    csvParserOutput: function(o){
      o = o || { };
      if (o.response != undefined) {$('div.server_response_' + o.response).empty().append(o.tag); return; }
      if (o.message) { $(this.csvOutputId).append('<p class="'+ ( (o.class) ? o.class : '' ) +'">'+ o.message +'</p>'); return; }
      if (o.tag) { $(this.csvOutputId).append(o.tag); return; }
    }
  } //end of return
} //end of construct
