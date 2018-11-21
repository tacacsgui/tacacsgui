var tgui_sortable = {
  init: function() {
    $( ".tgui_sortable" ).sortable();
    $( ".tgui_sortable" ).disableSelection();
  },

  add: function(o) {
    o = o || {}
    o.element = o.element || '';
    o.formId = o.formId || '';
    o.class = o.class || '';
    $( o.formId + " .tgui_sortable" ).append('<li ' + ( ( o.class ) ? 'class="'+o.class+'"' : '' ) +
    '><div class="el-text">'+  ( ( o.element ) ? o.element : '' )  +'</div><div class="el-close"><span onclick="tgui_sortable.del(this)"><i class="fa fa-close"></i></span></div></li>');
  },

  fill: function(data, formId) {
    console.log(data);
  },

  get: function(formId) {
    formId = formId || '';
    var list = $( formId + " .tgui_sortable div.el-text div:first-child" );
    var output = { data: [], text: [], separate: {} };
    if (! list.length) return output;
    for (var i = 0; i < list.length; i++) {
      output.data[output.data.length] = $(list[i]).data();
      output.text[output.text.length] = $(list[i]).text();
      for( var key in $(list[i]).data() ){
        if ( ! output.separate.hasOwnProperty(key)) output.separate[key] = [];
        output.separate[key][output.separate[key].length] = $(list[i]).data()[key]
      }
    }
    //console.log(output);
    return output;
  },

  check: function(o, formId) {
    formId = formId || '';
    var data_text ='';
    for(var key in $($(o).first('div')).data()){
      data_text+='[data-'+key+'="'+$($(o).first('div')).data()[key]+'"]';
      //console.log(key);
    }

    return $( formId + " .tgui_sortable" ).find('div' + data_text).length;
  },

  del: function(o) {
    $($(o).closest('li')).remove();
  },

  clear: function(formId) {
    formId = formId || '';
    $( formId + " .tgui_sortable" ).empty();
  }

}
