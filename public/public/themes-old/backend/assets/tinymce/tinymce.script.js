tinymce.init({
        selector: "textarea.editor",
        forced_root_block : "",
        height : "300",
        theme: "modern",
        plugins: [
        "advlist link image lists charmap print preview hr anchor pagebreak spellchecker",
        "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
        "save table contextmenu directionality emoticons template paste textcolor"
        ],  
     //content_css: "css/editor-tinymc.css",
     style_formats: [
     {title: 'Headers', items: [
     {title: 'Header 1', format: 'h1'},
     {title: 'Header 2', format: 'h2'},
     {title: 'Header 3', format: 'h3'},
     {title: 'Header 4', format: 'h4'},
     {title: 'Header 5', format: 'h5'},
     {title: 'Header 6', format: 'h6'}
     ]},
     {title: 'Inline', items: [
     {title: 'Bold', icon: 'bold', format: 'bold'},
     {title: 'Italic', icon: 'italic', format: 'italic'},
     {title: 'Underline', icon: 'underline', format: 'underline'},
     {title: 'Strikethrough', icon: 'strikethrough', format: 'strikethrough'},
     {title: 'Superscript', icon: 'superscript', format: 'superscript'},
     {title: 'Subscript', icon: 'subscript', format: 'subscript'},
     {title: 'Code', icon: 'code', format: 'code'}
     ]},
     {title: 'Blocks', items: [
     {title: 'Paragraph', format: 'p'},
     {title: 'Blockquote', format: 'blockquote'},
     {title: 'Div', format: 'div'},
     {title: 'Pre', format: 'pre'}
     ]},
     {title: 'Alignment', items: [
     {title: 'Left', icon: 'alignleft', format: 'alignleft'},
     {title: 'Center', icon: 'aligncenter', format: 'aligncenter'},
     {title: 'Right', icon: 'alignright', format: 'alignright'},
     {title: 'Justify', icon: 'alignjustify', format: 'alignjustify'}
     ]}
     ],
     formats: {
      alignleft: {selector: 'p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li,table,img', classes: 'left'},
      aligncenter: {selector: 'p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li,table,img', classes: 'center'},
      alignright: {selector: 'p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li,table,img', classes: 'right'},
      alignfull: {selector: 'p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li,table,img', classes: 'full'},
      bold: {inline: 'span', 'classes': 'bold'},
      italic: {inline: 'span', 'classes': 'italic'},
      underline: {inline: 'span', 'classes': 'underline', exact: true},
      strikethrough: {inline: 'del'},
      customformat: {inline: 'span', styles: {color: '#00ff00', fontSize: '20px'}, attributes: {title: 'My custom format'}}
  },
  add_unload_trigger: false,   
  relative_urls: false,
  remove_script_host: false,
  valid_elements : "@[id|class|style|title|dir<ltr?rtl|lang|xml::lang|onclick|ondblclick|"
  + "onmousedown|onmouseup|onmouseover|onmousemove|onmouseout|onkeypress|"
  + "onkeydown|onkeyup],a[rel|rev|charset|hreflang|tabindex|accesskey|type|"
  + "name|href|target|title|class|onfocus|onblur],strike,u,"
  + "#p[align],-ol[type|compact],-ul[type|compact],-li,br,img[longdesc|usemap|"
  + "src|border|alt=|title|hspace|vspace|width|height|align],-sub,-sup,"
  + "-blockquote,-table[border=0|cellspacing|cellpadding|width|frame|rules|"
  + "height|align|summary|bgcolor|background|bordercolor],-tr[rowspan|width|"
  + "height|align|valign|bgcolor|background|bordercolor],tbody,thead,tfoot,"
  + "#td[colspan|rowspan|width|height|align|valign|bgcolor|background|bordercolor"
  + "|scope],#th[colspan|rowspan|width|height|align|valign|scope],caption,-div,"
  + "-span,-code,-pre,address,-h1,-h2,-h3,-h4,-h5,-h6,hr[size|noshade],-font[face"
  + "|size|color],dd,dl,dt,cite,abbr,acronym,del[datetime|cite],ins[datetime|cite],"
  + "object[classid|width|height|codebase|*],param[name|value|_value],embed[type|width"
  + "|height|src|*],script[src|type],map[name],area[shape|coords|href|alt|target],bdo,"
  + "button,col[align|char|charoff|span|valign|width],colgroup[align|char|charoff|span|"
  + "valign|width],dfn,fieldset,form[action|accept|accept-charset|enctype|method],"
  + "input[accept|alt|checked|disabled|maxlength|name|readonly|size|src|type|value],"
  + "kbd,label[for],legend,noscript,optgroup[label|disabled],option[disabled|label|selected|value],"
  + "q[cite],samp,select[disabled|multiple|name|size],small,"
  + "textarea[cols|rows|disabled|name|readonly],tt,var,big",

  extended_valid_elements : "em,"
  +"i,"
  +"b,"
  +"strong,"
  +"area[accesskey|alt|class|coords|dir<ltr?rtl|href|id|lang|nohref<nohref"
  +"|onblur|onclick|ondblclick|onfocus|onkeydown|onkeypress|onkeyup"
  +"|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup"
  +"|shape<circle?default?poly?rect|style|tabindex|title|target],",
  toolbar1: "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media fullpage | forecolor backcolor emoticons table",
  image_advtab: true,    
  spellchecker_callback: function(method, words, callback) {
      if (method == "spellcheck") {
        var suggestions = {};

        for (var i = 0; i < words.length; i++) {
          suggestions[words[i]] = ["First", "second"];
      }    
      callback(suggestions);
  }
}
});
tinymce.init({
        selector: "textarea.editor2",
        forced_root_block : "",
        height : "200",
        theme: "modern",
        plugins: [
        "advlist link image lists charmap print preview hr anchor pagebreak spellchecker",
        "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
        "save table contextmenu directionality emoticons template paste textcolor"
        ],  
     //content_css: "css/editor-tinymc.css",
     style_formats: [
     {title: 'Headers', items: [
     {title: 'Header 1', format: 'h1'},
     {title: 'Header 2', format: 'h2'},
     {title: 'Header 3', format: 'h3'},
     {title: 'Header 4', format: 'h4'},
     {title: 'Header 5', format: 'h5'},
     {title: 'Header 6', format: 'h6'}
     ]},
     {title: 'Inline', items: [
     {title: 'Bold', icon: 'bold', format: 'bold'},
     {title: 'Italic', icon: 'italic', format: 'italic'},
     {title: 'Underline', icon: 'underline', format: 'underline'},
     {title: 'Strikethrough', icon: 'strikethrough', format: 'strikethrough'},
     {title: 'Superscript', icon: 'superscript', format: 'superscript'},
     {title: 'Subscript', icon: 'subscript', format: 'subscript'},
     {title: 'Code', icon: 'code', format: 'code'}
     ]},
     {title: 'Blocks', items: [
     {title: 'Paragraph', format: 'p'},
     {title: 'Blockquote', format: 'blockquote'},
     {title: 'Div', format: 'div'},
     {title: 'Pre', format: 'pre'}
     ]},
     {title: 'Alignment', items: [
     {title: 'Left', icon: 'alignleft', format: 'alignleft'},
     {title: 'Center', icon: 'aligncenter', format: 'aligncenter'},
     {title: 'Right', icon: 'alignright', format: 'alignright'},
     {title: 'Justify', icon: 'alignjustify', format: 'alignjustify'}
     ]}
     ],
     formats: {
      alignleft: {selector: 'p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li,table,img', classes: 'left'},
      aligncenter: {selector: 'p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li,table,img', classes: 'center'},
      alignright: {selector: 'p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li,table,img', classes: 'right'},
      alignfull: {selector: 'p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li,table,img', classes: 'full'},
      bold: {inline: 'span', 'classes': 'bold'},
      italic: {inline: 'span', 'classes': 'italic'},
      underline: {inline: 'span', 'classes': 'underline', exact: true},
      strikethrough: {inline: 'del'},
      customformat: {inline: 'span', styles: {color: '#00ff00', fontSize: '20px'}, attributes: {title: 'My custom format'}}
  },
  add_unload_trigger: false,   
  relative_urls: false,
  remove_script_host: false,
  valid_elements : "@[id|class|style|title|dir<ltr?rtl|lang|xml::lang|onclick|ondblclick|"
  + "onmousedown|onmouseup|onmouseover|onmousemove|onmouseout|onkeypress|"
  + "onkeydown|onkeyup],a[rel|rev|charset|hreflang|tabindex|accesskey|type|"
  + "name|href|target|title|class|onfocus|onblur],strike,u,"
  + "#p[align],-ol[type|compact],-ul[type|compact],-li,br,img[longdesc|usemap|"
  + "src|border|alt=|title|hspace|vspace|width|height|align],-sub,-sup,"
  + "-blockquote,-table[border=0|cellspacing|cellpadding|width|frame|rules|"
  + "height|align|summary|bgcolor|background|bordercolor],-tr[rowspan|width|"
  + "height|align|valign|bgcolor|background|bordercolor],tbody,thead,tfoot,"
  + "#td[colspan|rowspan|width|height|align|valign|bgcolor|background|bordercolor"
  + "|scope],#th[colspan|rowspan|width|height|align|valign|scope],caption,-div,"
  + "-span,-code,-pre,address,-h1,-h2,-h3,-h4,-h5,-h6,hr[size|noshade],-font[face"
  + "|size|color],dd,dl,dt,cite,abbr,acronym,del[datetime|cite],ins[datetime|cite],"
  + "object[classid|width|height|codebase|*],param[name|value|_value],embed[type|width"
  + "|height|src|*],script[src|type],map[name],area[shape|coords|href|alt|target],bdo,"
  + "button,col[align|char|charoff|span|valign|width],colgroup[align|char|charoff|span|"
  + "valign|width],dfn,fieldset,form[action|accept|accept-charset|enctype|method],"
  + "input[accept|alt|checked|disabled|maxlength|name|readonly|size|src|type|value],"
  + "kbd,label[for],legend,noscript,optgroup[label|disabled],option[disabled|label|selected|value],"
  + "q[cite],samp,select[disabled|multiple|name|size],small,"
  + "textarea[cols|rows|disabled|name|readonly],tt,var,big",

  extended_valid_elements : "em,"
  +"i,"
  +"b,"
  +"strong,"
  +"area[accesskey|alt|class|coords|dir<ltr?rtl|href|id|lang|nohref<nohref"
  +"|onblur|onclick|ondblclick|onfocus|onkeydown|onkeypress|onkeyup"
  +"|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup"
  +"|shape<circle?default?poly?rect|style|tabindex|title|target],",
  toolbar1: "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media fullpage | forecolor backcolor emoticons table",
  image_advtab: true,    
  spellchecker_callback: function(method, words, callback) {
      if (method == "spellcheck") {
        var suggestions = {};

        for (var i = 0; i < words.length; i++) {
          suggestions[words[i]] = ["First", "second"];
      }    
      callback(suggestions);
  }
}
});
tinymce.init({
        selector: "textarea.editor3",
        forced_root_block : "",
        height : "100",
        theme: "modern",
        plugins: [
        "advlist link image lists charmap print preview hr anchor pagebreak spellchecker",
        "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
        "save table contextmenu directionality emoticons template paste textcolor"
        ],  
     //content_css: "css/editor-tinymc.css",
     style_formats: [
     {title: 'Headers', items: [
     {title: 'Header 1', format: 'h1'},
     {title: 'Header 2', format: 'h2'},
     {title: 'Header 3', format: 'h3'},
     {title: 'Header 4', format: 'h4'},
     {title: 'Header 5', format: 'h5'},
     {title: 'Header 6', format: 'h6'}
     ]},
     {title: 'Inline', items: [
     {title: 'Bold', icon: 'bold', format: 'bold'},
     {title: 'Italic', icon: 'italic', format: 'italic'},
     {title: 'Underline', icon: 'underline', format: 'underline'},
     {title: 'Strikethrough', icon: 'strikethrough', format: 'strikethrough'},
     {title: 'Superscript', icon: 'superscript', format: 'superscript'},
     {title: 'Subscript', icon: 'subscript', format: 'subscript'},
     {title: 'Code', icon: 'code', format: 'code'}
     ]},
     {title: 'Blocks', items: [
     {title: 'Paragraph', format: 'p'},
     {title: 'Blockquote', format: 'blockquote'},
     {title: 'Div', format: 'div'},
     {title: 'Pre', format: 'pre'}
     ]},
     {title: 'Alignment', items: [
     {title: 'Left', icon: 'alignleft', format: 'alignleft'},
     {title: 'Center', icon: 'aligncenter', format: 'aligncenter'},
     {title: 'Right', icon: 'alignright', format: 'alignright'},
     {title: 'Justify', icon: 'alignjustify', format: 'alignjustify'}
     ]}
     ],
     formats: {
      alignleft: {selector: 'p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li,table,img', classes: 'left'},
      aligncenter: {selector: 'p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li,table,img', classes: 'center'},
      alignright: {selector: 'p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li,table,img', classes: 'right'},
      alignfull: {selector: 'p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li,table,img', classes: 'full'},
      bold: {inline: 'span', 'classes': 'bold'},
      italic: {inline: 'span', 'classes': 'italic'},
      underline: {inline: 'span', 'classes': 'underline', exact: true},
      strikethrough: {inline: 'del'},
      customformat: {inline: 'span', styles: {color: '#00ff00', fontSize: '20px'}, attributes: {title: 'My custom format'}}
  },
  add_unload_trigger: false,   
  relative_urls: false,
  remove_script_host: false,
  valid_elements : "@[id|class|style|title|dir<ltr?rtl|lang|xml::lang|onclick|ondblclick|"
  + "onmousedown|onmouseup|onmouseover|onmousemove|onmouseout|onkeypress|"
  + "onkeydown|onkeyup],a[rel|rev|charset|hreflang|tabindex|accesskey|type|"
  + "name|href|target|title|class|onfocus|onblur],strike,u,"
  + "#p[align],-ol[type|compact],-ul[type|compact],-li,br,img[longdesc|usemap|"
  + "src|border|alt=|title|hspace|vspace|width|height|align],-sub,-sup,"
  + "-blockquote,-table[border=0|cellspacing|cellpadding|width|frame|rules|"
  + "height|align|summary|bgcolor|background|bordercolor],-tr[rowspan|width|"
  + "height|align|valign|bgcolor|background|bordercolor],tbody,thead,tfoot,"
  + "#td[colspan|rowspan|width|height|align|valign|bgcolor|background|bordercolor"
  + "|scope],#th[colspan|rowspan|width|height|align|valign|scope],caption,-div,"
  + "-span,-code,-pre,address,-h1,-h2,-h3,-h4,-h5,-h6,hr[size|noshade],-font[face"
  + "|size|color],dd,dl,dt,cite,abbr,acronym,del[datetime|cite],ins[datetime|cite],"
  + "object[classid|width|height|codebase|*],param[name|value|_value],embed[type|width"
  + "|height|src|*],script[src|type],map[name],area[shape|coords|href|alt|target],bdo,"
  + "button,col[align|char|charoff|span|valign|width],colgroup[align|char|charoff|span|"
  + "valign|width],dfn,fieldset,form[action|accept|accept-charset|enctype|method],"
  + "input[accept|alt|checked|disabled|maxlength|name|readonly|size|src|type|value],"
  + "kbd,label[for],legend,noscript,optgroup[label|disabled],option[disabled|label|selected|value],"
  + "q[cite],samp,select[disabled|multiple|name|size],small,"
  + "textarea[cols|rows|disabled|name|readonly],tt,var,big",

  extended_valid_elements : "em,"
  +"i,"
  +"b,"
  +"strong,"
  +"area[accesskey|alt|class|coords|dir<ltr?rtl|href|id|lang|nohref<nohref"
  +"|onblur|onclick|ondblclick|onfocus|onkeydown|onkeypress|onkeyup"
  +"|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup"
  +"|shape<circle?default?poly?rect|style|tabindex|title|target],",
  toolbar1: "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media fullpage | forecolor backcolor emoticons table",
  image_advtab: true,    
  spellchecker_callback: function(method, words, callback) {
      if (method == "spellcheck") {
        var suggestions = {};

        for (var i = 0; i < words.length; i++) {
          suggestions[words[i]] = ["First", "second"];
      }    
      callback(suggestions);
  }
}
});