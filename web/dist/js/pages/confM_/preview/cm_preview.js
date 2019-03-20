var cm_preview = {
  name: '',
  init: function() {
    var self = this;
    var folder = tgui_supplier.getUrlParameter('group');
    console.log(folder);
    this.name = ((folder && folder != '') ? folder+'/': '') + tgui_supplier.getUrlParameter('name');
    $('div.box div.box-header elName').text(this.name)

    /*Select2 List of Diffs*/
    this.file_aSelect2 = new tgui_select2({
      ajaxUrl : API_LINK+"confmanager/diff/list/",
      template: this.templateSelect2,
      extra: { filename: this.name},
      add: ".select2.select_a",
    });
    $(".select2.select_a").select2(this.file_aSelect2.select2Data());

    this.file_bSelect2 = new tgui_select2({
      ajaxUrl : API_LINK+"confmanager/diff/list/",
      template: this.templateSelect2,
      extra: { filename: this.name},
      add: ".select2.select_b",
    });
    $(".select2.select_b").select2(this.file_bSelect2.select2Data());

    Promise.resolve( this.get(this.name) ).then( function() {

      $('input[name="diffType"]').prop('disabled', false);
      $('input[name="context"]').on('change', function() {
        if ( $('input[name="diffType"]:checked').val() == 'brief'){
          self.diff.brief();
        } else $('input[name="diffType"][value="brief"]').click();
      });
      $('input[name="context_native"]').on('change', function() {
        //console.log($('input[name="diffType"]:checked').val());
        if ( $('input[name="diffType"]:checked').val() == 'native'){
          self.diff.brief('native');
        } else $('input[name="diffType"][value="native"]').click();
      });
      $('.select2.version_list').on('change', function (e) {
        self.diff[$('input[name="diffType"]:checked').val()]();

        if (!$(this).select2('data') || !$(this).select2('data')[0] || !$(this).select2('data')[0].hash) return false

        name = tgui_supplier.getUrlParameter('name');
        group = tgui_supplier.getUrlParameter('group');
        hash = $(this).select2('data')[0].hash;
        filename = $(this).select2('data')[0].filename;
        //console.log($(this).select2('data')[0]);
        file_link = 'file_a_download';
        if( $(this).hasClass('select_b') ) file_link = 'file_b_download';
        $('.'+file_link).attr("href","/api/confmanager/file/download/hash/?show="+filename+"&name="+name+'&hash='+hash)

        $('[name="tgui_date_a"]').val($(".select2.select_a").select2('data')[0].text)
        $('[name="tgui_date_b"]').val($(".select2.select_b").select2('data')[0].text)
        $('period').text($(".select2.select_a").select2('data')[0].text+' - '+$(".select2.select_b").select2('data')[0].text)
        //console.log( $('[name="tgui_date_a"]').val() , $('[name="tgui_date_b"]').val() );
        if ( $('[name="tgui_date_a"]').val() != $('[name="tgui_date_b"]').val() && $('input[name="diffType"]:checked').val() != 'preview'){
          cm_preview.tgui_log();
        } else {
          if ( $('input[name="diffType"]:checked').val() != 'preview') {
            cm_tgui.clear()
            $('div.message h3').show().text('Preview Mode');
          } else $('div.message h3').show().text('The same date used.');
        }

      });
      self.diff.brief();

    });

    $('input[name="diffType"]').on('change', function(e) {
      if ( $('input[name="diffType"]:checked').val() == 'preview' ){
        cm_tgui.clear()
        $('div.message h3').show().text('Preview Mode');
      }
      self.diff[$(this).val()]();
    })
  },
  get: function(name) {
    var self = this;

    var ajaxProps = {
      url: API_LINK+"confmanager/diff/info/",
      data: {
        "name": name,
        "shortname": tgui_supplier.getUrlParameter('name'),
      }
    };//ajaxProps END
    return new Promise(
      function (resolve, reject) {
        ajaxRequest.send(ajaxProps).then(function(resp) {
          console.log(resp);

          var option_a = new Option('', resp.list[0].id, true, true);
          var option_b = new Option('', resp.list[1].id, true, true);
          $(option_a).data(resp.list[0]);
          $(option_b).data(resp.list[1]);
          //console.log(temp);//
          $(".select2.select_a").append(option_a).trigger('change');
          $(".select2.select_b").append(option_b).trigger('change');
          $('.select2.select_a').select2('data')[0].hash = resp.list[0].hash;
          $('.select2.select_b').select2('data')[0].hash = resp.list[1].hash;
          $('.select2.select_a').select2('data')[0].filename = resp.list[0].filename;
          $('.select2.select_b').select2('data')[0].filename = resp.list[1].filename;
          $('.select2.select_a').select2('data')[0].text = resp.list[0].text;
          $('.select2.select_b').select2('data')[0].text = resp.list[1].text;

          if ( resp.list[1] && resp.list[1].id ) $(".select2.select_b").val(resp.list[1].id).trigger('change');

          name = tgui_supplier.getUrlParameter('name');
          group = tgui_supplier.getUrlParameter('group');
          hash_a = $(".select2.select_a").select2('data')[0].hash;
          hash_b = $(".select2.select_b").select2('data')[0].hash;
          filename_a = $(".select2.select_a").select2('data')[0].filename;
          filename_b = $(".select2.select_b").select2('data')[0].filename;

          $('.file_a_download').attr("href","/api/confmanager/file/download/hash/?show="+filename_a+"&name="+name+'&hash='+hash_a)
          $('.file_b_download').attr("href","/api/confmanager/file/download/hash/?show="+filename_b+"&name="+name+'&hash='+hash_b)

          $('.match-found').hide()
          $('[name="tgui_device_ip"]').val('')
          $('[name="tgui_device_id"]').val('')
          if (resp.device_info){
            $('.match-found').show()
            if (resp.device_info.d_name && resp.device_info.d_ip){
              $('deviceInfo').text(resp.device_info.d_name+' ('+resp.device_info.d_ip+')')
            } else {
              $('deviceInfo').text('not set')
            }

            $('[name="tgui_device_ip"]').val(resp.device_info.d_ip)
            $('[name="tgui_device_id"]').val(resp.device_info.d_id)
          }

          $('[name="tgui_date_a"]').val($(".select2.select_a").select2('data')[0].text)
          $('[name="tgui_date_b"]').val($(".select2.select_b").select2('data')[0].text)
          $('period').text($(".select2.select_a").select2('data')[0].text+' - '+$(".select2.select_b").select2('data')[0].text)
          if ( $('[name="tgui_date_a"]').val() != $('[name="tgui_date_b"]').val() )
            cm_preview.tgui_log();
          else $('div.message h3').show().text('The same date used.');

          resolve(true)

        }).fail(function(err){
          tgui_error.getStatus(err, ajaxProps)
          reject(true)
        })
      }) //end of promise
  },
  diff: {
    brief: function(type){
      var self = this;
      type = type || 'brief',
      this.clear();
      var context = (type == 'native') ? $('[name="context_native"]').val() : $('[name="context"]').val();
      var ajaxProps = {
        url: API_LINK+"confmanager/diff/brief/",
        data: {
          //"file": cm_preview.name,
          "hash_a": $('.select2.select_a').select2('data')[0].hash,
          "hash_b": $('.select2.select_b').select2('data')[0].hash,
          "filename_a": $('.select2.select_a').select2('data')[0].filename,
          "filename_b": $('.select2.select_b').select2('data')[0].filename,
          "type": type,
          "context": context,
        }
      };//ajaxProps END

      ajaxRequest.send(ajaxProps).then(function(resp) {
        //console.log(resp);

        $('pre.preview.file_a').empty()
        $('pre.preview.file_b').empty()

        if (type == 'native'){
          $('div.file_b_column .preview').hide();
          $('div.file_a_column').removeClass('col-sm-6').addClass('col-sm-12');
          $('div.file_b_column').removeClass('col-sm-6').addClass('col-sm-12');
          $('pre.preview.file_b');
          if ( resp.native ) {
            $('pre.preview.file_a').append(resp.native);
          } else $('pre.preview.file_a').append('Not Found. Where is clear diff? I think these two versions just do not have difference, is it?');
          return
        }
        if (type == 'preview'){
          $('div.file_b_column').hide();
          $('div.file_a_column').removeClass('col-sm-6').addClass('col-sm-12');
          $('pre.preview.file_b');
          if ( resp.show ) {
            $('pre.preview.file_a').append(resp.show);
          } else $('pre.preview.file_a').append('Error. Where is show?');
          return
        }
        var header = self.makeHeader(resp.diff.header)
        if ( header != '')  {
          $('pre.preview.file_a').append(header);
          $('pre.preview.file_b').append(header);
        }

        if ( ! resp.diff.file_a ) {
          var attention = '<div class="alert alert-warning alert-dismissible">'+
                '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>'+
                '<h4><i class="icon fa fa-warning"></i> Oops!</h4>'+
                'No difference found'+
              '</div>';
          $('pre.preview.file_a').append(attention);
          $('pre.preview.file_b').append(attention);
          return
        }
        $('pre.preview.file_a').append(resp.diff.file_a);
        $('pre.preview.file_b').append(resp.diff.file_b);
        if (resp.diff.chunk_list.file_a) $('pre.preview.file_a').css('counter-reset', resp.diff.chunk_list.file_a.join(' '));
        if (resp.diff.chunk_list.file_b) $('pre.preview.file_b').css('counter-reset', resp.diff.chunk_list.file_b.join(' '));
        var head_style = ''
        for (var i = 0; i < resp.diff.chunk_list.counters.length; i++) {
          var temp = resp.diff.chunk_list.counters[i].split(' ');
          head_style +='span.'+temp[0]+':before{ counter-increment: '+temp[0]+'; content: counter('+temp[0]+');}'

        }
        $('head').append('<style id="please_deleteMe">'+head_style+'</style>');
      })
    },
    full: function(){
      //console.log('full');
      this.brief('full');
    },
    preview: function(){
      //console.log('full');
      this.brief('preview');
    },
    native: function() {
      this.brief('native');
    },
    tacgui: function() {

    },
    clear: function(){
      $('pre.preview').empty().append('Loading...').show();
      $('style#please_deleteMe').remove();
      $('div.file_b_column').show().removeClass('col-sm-12').addClass('col-sm-6');
      $('div.file_a_column').show().removeClass('col-sm-12').addClass('col-sm-6');
    },
    makeHeader: function(data) {
      data = data || { rename: {} , similarity: ''}
      var output = '';
      if (!!data.rename && !!data.rename.from) output += data.rename.from.charAt(0).toUpperCase()+data.rename.from.slice(1)+"\n";
      if (!!data.rename && !!data.rename.to) output += data.rename.to.charAt(0).toUpperCase()+data.rename.to.slice(1)+"\n";
      if (!!data.similarity) output += data.similarity.charAt(0).toUpperCase()+data.similarity.slice(1)+"\n";
      return output;
    }
  },
  tgui_log: function() {
    cm_tgui.get_user_list()
  },
  templateSelect2: function(data){
    text = data.text;
    hash = data.hash;
    filename = data.filename;
    //console.log(data);
    if (data.element){
      new_data = $(data.element).data();
      text = data.text || new_data.text;
      hash = data.hash || new_data.hash;
      filename = data.filename || new_data.filename;
    }
    var output='<div class="selectModelOption">';
      output += '<text>'+text+' <small class="text-muted">('+hash+','+filename+')</small></text>';
      output += '</div>'
    return output;
  },
}
