!function(e,t){"function"==typeof define&&define.amd?define(t):"object"==typeof exports?module.exports=t:e.fluidvids=t()}(this,function(){"use strict";var e={selector:"iframe",players:["www.youtube.com","player.vimeo.com"]},t=document.head||document.getElementsByTagName("head")[0],i=function(t){return new RegExp("^(https?:)?//(?:"+e.players.join("|")+").*$","i").test(t)},n=function(e){if(!e.getAttribute("data-fluidvids")){var t=document.createElement("div"),i=parseInt(e.height?e.height:e.offsetHeight,10)/parseInt(e.width?e.width:e.offsetWidth,10)*100;e.parentNode.insertBefore(t,e),e.setAttribute("data-fluidvids","loaded"),t.className+="fluidvids",t.style.paddingTop=i+"%",t.appendChild(e)}},d=function(){var e=document.createElement("div");e.innerHTML="<p>x</p><style>.fluidvids{width:100%;position:relative;}.fluidvids iframe{position:absolute;top:0px;left:0px;width:100%;height:100%;}</style>",t.appendChild(e.childNodes[1])};return e.apply=function(){for(var t=document.querySelectorAll(e.selector),d=0;d<t.length;d++){var o=t[d];i(o.src)&&n(o)}},e.init=function(t){for(var i in t)e[i]=t[i];e.apply(),d()},e});