var tgui_device_patterns = {
  switch: function(o) {
    var formId = '#'+$($(o).closest('form')[0]).attr('id');
    //console.log( $($(o).closest('form')[0]).attr('id') );
    ( !!$(o).data('disabled') ) ? this.show(o, formId) : this.hide(o, formId);

    return false;
  },
  show: function(o, formId){
    $($(o).find('i')[0]).removeClass('fa-square-o').addClass('fa-check-square-o');
    $(o).data('disabled', 0)
    $(formId + ' li.device-pattern.' + $(o).data('pattern')).removeClass('device-pattern-hidden');
    //console.log( $(formId + ' .nav-tabs>li:eq( 1 ) a') );
  },
  hide: function(o, formId){
    $($(o).find('i')[0]).addClass('fa-square-o').removeClass('a-check-square-o');
    $(o).data('disabled', 1)
    $(formId + ' li.device-pattern.' + $(o).data('pattern')).addClass('device-pattern-hidden');
    if ($(formId + ' li.device-pattern.' + $(o).data('pattern')).hasClass('active')) $(formId + ' .nav-tabs>li:eq( 1 ) a').tab('show');
    //console.log('hide');
  },
  clear: function() {
    $('.device-pattern').addClass('device-pattern-hidden');
    $('.pattern-set a').data('disabled', 1)
    $('.pattern-set a > i').addClass('fa-square-o').removeClass('a-check-square-o');
    this.pattern.cisco.wlc.clear();
    this.pattern.cisco.rs.cmd.clear();
    this.pattern.cisco.rs.autocmd.clear();
  },
  fill: function(data,formId){
    data = data || {};
    if ( data.cisco_rs_enable ) this.show($(formId).find('[data-pattern="cisco-rs"]'), formId)
    if ( data.cisco_wlc_enable ) this.show($(formId).find('[data-pattern="cisco-wlc"]'), formId)
    if ( data.h3c_enable ) this.show($(formId).find('[data-pattern="h3c-general"]'), formId)
    if ( data.paloalto_enable ) this.show($(formId).find('[data-pattern="paloalto"]'), formId)
    if ( data.fortios_enable ) this.show($(formId).find('[data-pattern="fortios"]'), formId)
  },
  pattern: {
    cisco: {
      rs: {
        cmd: {
          get: function(formId) {
            var a = ( $(formId + ' [name="cisco_rs_cmd_list"]').val().length ) ? ( $(formId + ' [name="cisco_rs_cmd_list"]').val() ) : [];
            var b = [];
            console.log(a,b);
            a.forEach(function(el){
               b.push(el);
            });
            return b.join(';;');
          },
          diff: function(formId) {
            var a = ( $(formId + ' [name="cisco_rs_cmd"]').val() ) ? $(formId + ' [name="cisco_rs_cmd"]').val().split(';;') : [];
            var b = ( $(formId + ' [name="cisco_rs_cmd_list"]').val().length ) ? ( $(formId + ' [name="cisco_rs_cmd_list"]').val() ) : [];

            //console.log(a);console.log(b);
            //console.log( $(formId + ' [name="cisco_rs_cmd_list"]').val() );
            if (a.length != b.length) return true;
            //console.log(1);
            for (var i = 0; i < a.length; ++i) {
              if (! b.includes(a[i]) ) return true;
            }
            //console.log(2);
            return false;
          },
          fill: function(data,formId) {
            data = data.split(';;') || []
            console.log(data);
            var ajaxProps = {
              url: API_LINK+'tacacs/cmd/list/',
              type: "GET",
              data: { "byId": data }
            };

            ajaxRequest.send(ajaxProps).then(function(resp) {
              console.log(resp.item);
              if ( ! resp.item.length ) return false;
              for (var i = 0; i < resp.item.length; i++) {
                var option = new Option(tgui_service.selectionTemplate_cmd(resp.item[i]), resp.item[i].id, true, true);
                $(formId + ' [name="cisco_rs_cmd_list"]').append(option);
              }
              $(formId + ' [name="cisco_rs_cmd_list"]').trigger('change');
            })
            //var option = new Option('123', 1, true, true);
            //$(formId + ' [name="cisco_rs_cmd_list"]').append(option).trigger('change');
          },
          clear: function() {
            $('[name="cisco_rs_cmd_list"]').empty().trigger('change');
          }
        },
        autocmd: {
          append: function(o) {
            var list = $($(o).closest('div.tab-autocmd')).find('ul.tgui_sortable') ;
            $(o).closest('.form-group').removeClass('has-error').find('p.help-block.error').remove();
            var formId = '#'+$(o).closest('form').attr('id');
            var text = $( formId + ' .atocmd-creator' ).val();

            if (! text ){
              $(o).closest('.form-group').addClass('has-error').append('<p class="help-block error">cmd can\'t be empty</p>');
              return false;
            }

            var element = '<div data-autocmd="'+text+'"><span class="text-info text-muted">autocmd</span> <b>'+text+'</b></div>'
            var new_el = {
              class: 'info',
              formId : formId,
              element: element
            }

            if ( tgui_sortable.check(element, formId) ){
              $(o).closest('.form-group').addClass('has-error').append('<p class="help-block error">this command already added!</p>');
              return false;
            }

            tgui_sortable.add(new_el);

            $( formId + ' .atocmd-creator' ).val('');

            return false;
          },
          get: function(formId) {

          },
          fill: function(data, formId){
            data = data || '';
            formId = formId || '';
            if ( data == '' ) return false;
            var some_array = data.split(";;");
            console.log(some_array);
            var element = '';
            var new_el = {};
            for (var i = 0; i < some_array.length; i++) {
              element = '<div data-autocmd="'+ some_array[i] +'"><span class="text-info text-muted">autocmd</span> <b>'+ some_array[i] +'</b></div>'
              new_el = {
                class: 'info',
                formId : formId,
                element: element
              }

              tgui_sortable.add(new_el);
            }
          },
          diff: function(data, formId) {
            data = data || [];
            if ( $( formId + ' [name="cisco_rs_autocmd"]').val() == '' && !data.length ) return false;

            return !( $( formId + ' [name="cisco_rs_autocmd"]').val() == data.join(';;') );
          },
          clear: function() {
            $('.tab-autocmd .tgui_sortable').empty()
          }
        }
      },
      wlc: {
        right: function(o) {
          var formId = '#' + $($(o).closest('form')).attr('id');
          $(formId + ' [name="cisco_wlc_roles_selected"]').append($(formId + ' [name="cisco_wlc_roles_list"] option:selected'));
        },
        left: function(o) {
          var formId = '#' + $($(o).closest('form')).attr('id');
          $(formId + ' [name="cisco_wlc_roles_list"]').append($(formId + ' [name="cisco_wlc_roles_selected"] option:selected'));
        },
        clear: function() {
          $('[name="cisco_wlc_roles_selected"]').empty();
          $('[name="cisco_wlc_roles_list"]').empty().append('<option value="0">ALL (0)</option>' +
          '<option value="2">LOBBY (2)</option>'+
          '<option value="4">MONITOR (4)</option>'+
          '<option value="8">WLAN (8)</option>'+
          '<option value="10">CONTROLLER (10)</option>'+
          '<option value="20">WIRELESS (20)</option>'+
          '<option value="40">SECURITY (40)</option>'+
          '<option value="80">MANAGEMENT (80)</option>'+
          '<option value="100">COMMANDS (100)</option>');
        },
        get: function(formId) {
          var a = [];
          $(formId + ' [name="cisco_wlc_roles_selected"] > option ').each(function(){
             a.push(this.value);
          });
          return a.join(';;');
          //.join(;;)//
        },
        fill: function(data, formId) {
          var a = ( data ) ? data.split(';;') : [];
          for (var i = 0; i < a.length; i++) {
            $(formId + ' [name="cisco_wlc_roles_selected"]').append($(formId + ' [name="cisco_wlc_roles_list"] option[value="'+a[i]+'"]'));
          }
        },
        diff: function(formId) {
          var a = ( $(formId + ' [name="cisco_wlc_roles"]').val() ) ? $(formId + ' [name="cisco_wlc_roles"]').val().split(';;') : [];
          var b = [];
          $(formId + ' [name="cisco_wlc_roles_selected"] > option ').each(function(){
             b.push(this.value);
          });
          //console.log(a);console.log(b);
          if (a.length != b.length) return true;
          //console.log(1);
          for (var i = 0; i < a.length; ++i) {
            if (! b.includes(a[i]) ) return true;
          }
          //console.log(2);
          return false;
        }

      }
    },
    h3c: {
      general: {
        cmd: {
          get: function(formId) {
            var a = ( $(formId + ' [name="h3c_cmd_list"]').val().length ) ? ( $(formId + ' [name="h3c_cmd_list"]').val() ) : [];
            var b = [];
            console.log(a,b);
            a.forEach(function(el){
               b.push(el);
            });
            return b.join(';;');
          },
          diff: function(formId) {
            var a = ( $(formId + ' [name="h3c_cmd"]').val() ) ? $(formId + ' [name="h3c_cmd"]').val().split(';;') : [];
            var b = ( $(formId + ' [name="h3c_cmd_list"]').val().length ) ? ( $(formId + ' [name="h3c_cmd_list"]').val() ) : [];

            //console.log(a);console.log(b);
            //console.log( $(formId + ' [name="h3c_cmd_list"]').val() );
            if (a.length != b.length) return true;
            //console.log(1);
            for (var i = 0; i < a.length; ++i) {
              if (! b.includes(a[i]) ) return true;
            }
            //console.log(2);
            return false;
          },
          fill: function(data,formId) {
            data = data.split(';;') || []
            console.log(data);
            var ajaxProps = {
              url: API_LINK+'tacacs/cmd/list/',
              type: "GET",
              data: { "byId": data }
            };

            ajaxRequest.send(ajaxProps).then(function(resp) {
              console.log(resp.item);
              if ( ! resp.item.length ) return false;
              for (var i = 0; i < resp.item.length; i++) {
                var option = new Option(tgui_service.selectionTemplate_cmd(resp.item[i]), resp.item[i].id, true, true);
                $(formId + ' [name="h3c_cmd_list"]').append(option);
              }
              $(formId + ' [name="h3c_cmd_list"]').trigger('change');
            })
            //var option = new Option('123', 1, true, true);
            //$(formId + ' [name="h3c_cmd_list"]').append(option).trigger('change');
          },
          clear: function() {
            $('[name="h3c_cmd_list"]').empty().trigger('change');
          }
        }
      },
    }
  }
  // cisco_wlc_role: function(o){
  //   console.log( $(o).val() );
  //   if ($(o).val() == 'none') return false;
  //   console.log( $('select.role-section') );
  //   $( "div.role-section-clone" ).clone().appendTo( "div.cisco-wlc-role-list" );
  //   $( "div.cisco-wlc-role-list > div.role-section-clone" ).removeClass('role-section-clone').addClass('role-section').show();
  // }
}
