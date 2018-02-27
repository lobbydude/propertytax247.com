$.extend(!0,$.fn.dataTable.defaults,{dom:"<'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>",language:{lengthMenu:" _MENU_ records ",paginate:{previous:'<i class="fa fa-angle-left"></i>',next:'<i class="fa fa-angle-right"></i>'}}}),$.extend($.fn.dataTableExt.oStdClasses,{sWrapper:"dataTables_wrapper",sFilterInput:"form-control input-small input-inline",sLengthSelect:"form-control input-xsmall input-inline"}),$.fn.dataTable.defaults.renderer="bootstrap",$.fn.dataTable.ext.renderer.pageButton.bootstrap=function(a,e,i,t,n,l){var s,o,r=new $.fn.dataTable.Api(a),d=a.oClasses,g=a.oLanguage.oPaginate,p=function(e,t){var f,c,b,T,u=function(a){a.preventDefault(),"ellipsis"!==a.data.action&&r.page(a.data.action).draw(!1)};for(f=0,c=t.length;c>f;f++)if(T=t[f],$.isArray(T))p(e,T);else{switch(s="",o="",T){case"ellipsis":s="&hellip;",o="disabled";break;case"first":s=g.sFirst,o=T+(n>0?"":" disabled");break;case"previous":s=g.sPrevious,o=T+(n>0?"":" disabled");break;case"next":s=g.sNext,o=T+(l-1>n?"":" disabled");break;case"last":s=g.sLast,o=T+(l-1>n?"":" disabled");break;default:s=T+1,o=n===T?"active":""}s&&(b=$("<li>",{"class":d.sPageButton+" "+o,"aria-controls":a.sTableId,tabindex:a.iTabIndex,id:0===i&&"string"==typeof T?a.sTableId+"_"+T:null}).append($("<a>",{href:"#"}).html(s)).appendTo(e),a.oApi._fnBindAction(b,{action:T},u))}};p($(e).empty().html('<ul class="pagination"/>').children("ul"),t)},$.fn.DataTable.TableTools&&($.extend(!0,$.fn.DataTable.TableTools.classes,{container:"DTTT btn-group",buttons:{normal:"btn btn-default",disabled:"disabled"},collection:{container:"DTTT_dropdown dropdown-menu",buttons:{normal:"",disabled:"disabled"}},print:{info:"DTTT_Print_Info"},select:{row:"active"}}),$.extend(!0,$.fn.DataTable.TableTools.DEFAULTS.oTags,{collection:{container:"ul",button:"li",liner:"a"}})),$.fn.dataTableExt.oApi.fnPagingInfo=function(a){return{iStart:a._iDisplayStart,iEnd:a.fnDisplayEnd(),iLength:a._iDisplayLength,iTotal:a.fnRecordsTotal(),iFilteredTotal:a.fnRecordsDisplay(),iPage:-1===a._iDisplayLength?0:Math.ceil(a._iDisplayStart/a._iDisplayLength),iTotalPages:-1===a._iDisplayLength?0:Math.ceil(a.fnRecordsDisplay()/a._iDisplayLength)}},$.extend($.fn.dataTableExt.oPagination,{bootstrap_full_number:{fnInit:function(a,e,i){var t=a.oLanguage.oPaginate,n=function(e){e.preventDefault(),a.oApi._fnPageChange(a,e.data.action)&&i(a)};$(e).append('<ul class="pagination"><li class="prev disabled"><a href="#" title="'+t.sFirst+'"><i class="fa fa-angle-double-left"></i></a></li><li class="prev disabled"><a href="#" title="'+t.sPrevious+'"><i class="fa fa-angle-left"></i></a></li><li class="next disabled"><a href="#" title="'+t.sNext+'"><i class="fa fa-angle-right"></i></a></li><li class="next disabled"><a href="#" title="'+t.sLast+'"><i class="fa fa-angle-double-right"></i></a></li></ul>');var l=$("a",e);$(l[0]).bind("click.DT",{action:"first"},n),$(l[1]).bind("click.DT",{action:"previous"},n),$(l[2]).bind("click.DT",{action:"next"},n),$(l[3]).bind("click.DT",{action:"last"},n)},fnUpdate:function(a,e){var i,t,n,l,s,o=5,r=a.oInstance.fnPagingInfo(),d=a.aanFeatures.p,g=Math.floor(o/2);for(r.iTotalPages<o?(l=1,s=r.iTotalPages):r.iPage<=g?(l=1,s=o):r.iPage>=r.iTotalPages-g?(l=r.iTotalPages-o+1,s=r.iTotalPages):(l=r.iPage-g+1,s=l+o-1),i=0,iLen=d.length;i<iLen;i++){for(r.iTotalPages<=0?$(".pagination",d[i]).css("visibility","hidden"):$(".pagination",d[i]).css("visibility","visible"),$("li:gt(1)",d[i]).filter(":not(.next)").remove(),t=l;s>=t;t++)n=t==r.iPage+1?'class="active"':"",$("<li "+n+'><a href="#">'+t+"</a></li>").insertBefore($("li.next:first",d[i])[0]).bind("click",function(i){i.preventDefault(),a._iDisplayStart=(parseInt($("a",this).text(),10)-1)*r.iLength,e(a)});0===r.iPage?$("li.prev",d[i]).addClass("disabled"):$("li.prev",d[i]).removeClass("disabled"),r.iPage===r.iTotalPages-1||0===r.iTotalPages?$("li.next",d[i]).addClass("disabled"):$("li.next",d[i]).removeClass("disabled")}}}}),$.extend($.fn.dataTableExt.oPagination,{bootstrap_extended:{fnInit:function(a,e,i){var t=a.oLanguage.oPaginate,n=(a.oInstance.fnPagingInfo(),function(e){e.preventDefault(),a.oApi._fnPageChange(a,e.data.action)&&i(a)});$(e).append('<div class="pagination-panel"> '+t.page+' <a href="#" class="btn btn-sm default prev disabled" title="'+t.previous+'"><i class="fa fa-angle-left"></i></a><input type="text" class="pagination-panel-input form-control input-mini input-inline input-sm" maxlenght="5" style="text-align:center; margin: 0 5px;"><a href="#" class="btn btn-sm default next disabled" title="'+t.next+'"><i class="fa fa-angle-right"></i></a> '+t.pageOf+' <span class="pagination-panel-total"></span></div>');var l=$("a",e);$(l[0]).bind("click.DT",{action:"previous"},n),$(l[1]).bind("click.DT",{action:"next"},n),$(".pagination-panel-input",e).bind("change.DT",function(e){var t=a.oInstance.fnPagingInfo();e.preventDefault();var n=parseInt($(this).val());n>0&&n<=t.iTotalPages?a.oApi._fnPageChange(a,n-1)&&i(a):$(this).val(t.iPage+1)}),$(".pagination-panel-input",e).bind("keypress.DT",function(e){var t=a.oInstance.fnPagingInfo();if(13==e.which){var n=parseInt($(this).val());n>0&&n<=a.oInstance.fnPagingInfo().iTotalPages?a.oApi._fnPageChange(a,n-1)&&i(a):$(this).val(t.iPage+1),e.preventDefault()}})},fnUpdate:function(a,e){var i,t,n,l,s,o=5,r=a.oInstance.fnPagingInfo(),d=a.aanFeatures.p,g=Math.floor(o/2);for(r.iTotalPages<o?(l=1,s=r.iTotalPages):r.iPage<=g?(l=1,s=o):r.iPage>=r.iTotalPages-g?(l=r.iTotalPages-o+1,s=r.iTotalPages):(l=r.iPage-g+1,s=l+o-1),i=0,iLen=d.length;i<iLen;i++){var p=$(d[i]).parents(".dataTables_wrapper");for(r.iTotal<=0?$(".dataTables_paginate, .dataTables_length",p).hide():$(".dataTables_paginate, .dataTables_length",p).show(),r.iTotalPages<=0?$(".dataTables_paginate, .dataTables_length .seperator",p).hide():$(".dataTables_paginate, .dataTables_length .seperator",p).show(),$(".pagination-panel-total",d[i]).html(r.iTotalPages),$(".pagination-panel-input",d[i]).val(r.iPage+1),$("li:gt(1)",d[i]).filter(":not(.next)").remove(),t=l;s>=t;t++)n=t==r.iPage+1?'class="active"':"",$("<li "+n+'><a href="#">'+t+"</a></li>").insertBefore($("li.next:first",d[i])[0]).bind("click",function(i){i.preventDefault(),a._iDisplayStart=(parseInt($("a",this).text(),10)-1)*r.iLength,e(a)});0===r.iPage?$("a.prev",d[i]).addClass("disabled"):$("a.prev",d[i]).removeClass("disabled"),r.iPage===r.iTotalPages-1||0===r.iTotalPages?$("a.next",d[i]).addClass("disabled"):$("a.next",d[i]).removeClass("disabled")}}}});