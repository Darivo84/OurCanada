window.PR_SHOULD_USE_CONTINUATION=!0,function(){var e=["break,continue,do,else,for,if,return,while"],n=[[e,"auto,case,char,const,default,double,enum,extern,float,goto,int,long,register,short,signed,sizeof,static,struct,switch,typedef,union,unsigned,void,volatile"],"catch,class,delete,false,import,new,operator,private,protected,public,this,throw,true,try,typeof"],t=[n,"alignof,align_union,asm,axiom,bool,concept,concept_map,const_cast,constexpr,decltype,dynamic_cast,explicit,export,friend,inline,late_check,mutable,namespace,nullptr,reinterpret_cast,static_assert,static_cast,template,typeid,typename,using,virtual,where"],r=[n,"abstract,boolean,byte,extends,final,finally,implements,import,instanceof,null,native,package,strictfp,super,synchronized,throws,transient"],a=[r,"as,base,by,checked,decimal,delegate,descending,dynamic,event,fixed,foreach,from,group,implicit,in,interface,internal,into,is,lock,object,out,override,orderby,params,partial,readonly,ref,sbyte,sealed,stackalloc,string,select,uint,ulong,unchecked,unsafe,ushort,var"],s=[n,"debugger,eval,export,function,get,null,set,undefined,var,with,Infinity,NaN"],i="caller,delete,die,do,dump,elsif,eval,exit,foreach,for,goto,if,import,last,local,my,next,no,our,print,package,redo,require,sub,undef,unless,until,use,wantarray,while,BEGIN,END",l=[e,"and,as,assert,class,def,del,elif,except,exec,finally,from,global,import,in,is,lambda,nonlocal,not,or,pass,print,raise,try,with,yield,False,True,None"],o=[e,"alias,and,begin,case,class,def,defined,elsif,end,ensure,false,in,module,next,nil,not,or,redo,rescue,retry,self,super,then,true,undef,unless,until,when,yield,BEGIN,END"],u=[e,"case,done,elif,esac,eval,fi,function,in,local,set,then,until"],c=/^(DIR|FILE|vector|(de|priority_)?queue|list|stack|(const_)?iterator|(multi)?(set|map)|bitset|u?(int|float)\d*)/,d="str",f="kwd",p="com",h="typ",g="lit",m="pun",v="pln",y="src",w="(?:^^\\.?|[+-]|\\!|\\!=|\\!==|\\#|\\%|\\%=|&|&&|&&=|&=|\\(|\\*|\\*=|\\+=|\\,|\\-=|\\->|\\/|\\/=|:|::|\\;|<|<<|<<=|<=|=|==|===|>|>=|>>|>>=|>>>|>>>=|\\?|\\@|\\[|\\^|\\^=|\\^\\^|\\^\\^=|\\{|\\||\\|=|\\|\\||\\|\\|=|\\~|break|case|continue|delete|do|else|finally|instanceof|return|throw|try|typeof)\\s*";function x(e,n,t,r){if(n){var a={sourceCode:n,basePos:e};t(a),r.push.apply(r,a.decorations)}}var b=/\S/;function S(e){for(var n=void 0,t=e.firstChild;t;t=t.nextSibling){var r=t.nodeType;n=1===r?n?e:t:3===r&&b.test(t.nodeValue)?e:n}return n===e?void 0:n}function C(e,n){var t,r={};!function(){for(var a=e.concat(n),s=[],i={},l=0,o=a.length;l<o;++l){var u=a[l],c=u[3];if(c)for(var d=c.length;--d>=0;)r[c.charAt(d)]=u;var f=u[1],p=""+f;i.hasOwnProperty(p)||(s.push(f),i[p]=null)}s.push(/[\0-\uffff]/),t=function(e){for(var n=0,t=!1,r=!1,a=0,s=e.length;a<s;++a)if((f=e[a]).ignoreCase)r=!0;else if(/[a-z]/i.test(f.source.replace(/\\u[0-9a-f]{4}|\\x[0-9a-f]{2}|\\[^ux]/gi,""))){t=!0,r=!1;break}var i={b:8,t:9,n:10,v:11,f:12,r:13};function l(e){var n=e.charCodeAt(0);if(92!==n)return n;var t=e.charAt(1);return(n=i[t])||("0"<=t&&t<="7"?parseInt(e.substring(1),8):"u"===t||"x"===t?parseInt(e.substring(2),16):e.charCodeAt(1))}function o(e){if(e<32)return(e<16?"\\x0":"\\x")+e.toString(16);var n=String.fromCharCode(e);return"\\"!==n&&"-"!==n&&"["!==n&&"]"!==n||(n="\\"+n),n}function u(e){for(var n=e.substring(1,e.length-1).match(new RegExp("\\\\u[0-9A-Fa-f]{4}|\\\\x[0-9A-Fa-f]{2}|\\\\[0-3][0-7]{0,2}|\\\\[0-7]{1,2}|\\\\[\\s\\S]|-|[^-\\\\]","g")),t=[],r=[],a="^"===n[0],s=a?1:0,i=n.length;s<i;++s){var u=n[s];if(/\\[bdsw]/i.test(u))t.push(u);else{var c,d=l(u);s+2<i&&"-"===n[s+1]?(c=l(n[s+2]),s+=2):c=d,r.push([d,c]),c<65||d>122||(c<65||d>90||r.push([32|Math.max(65,d),32|Math.min(c,90)]),c<97||d>122||r.push([-33&Math.max(97,d),-33&Math.min(c,122)]))}}r.sort(function(e,n){return e[0]-n[0]||n[1]-e[1]});var f=[],p=[NaN,NaN];for(s=0;s<r.length;++s)(g=r[s])[0]<=p[1]+1?p[1]=Math.max(p[1],g[1]):f.push(p=g);var h=["["];for(a&&h.push("^"),h.push.apply(h,t),s=0;s<f.length;++s){var g=f[s];h.push(o(g[0])),g[1]>g[0]&&(g[1]+1>g[0]&&h.push("-"),h.push(o(g[1])))}return h.push("]"),h.join("")}function c(e){for(var r=e.source.match(new RegExp("(?:\\[(?:[^\\x5C\\x5D]|\\\\[\\s\\S])*\\]|\\\\u[A-Fa-f0-9]{4}|\\\\x[A-Fa-f0-9]{2}|\\\\[0-9]+|\\\\[^ux0-9]|\\(\\?[:!=]|[\\(\\)\\^]|[^\\x5B\\x5C\\(\\)\\^]+)","g")),a=r.length,s=[],i=0,l=0;i<a;++i)"("===(c=r[i])?++l:"\\"===c.charAt(0)&&(o=+c.substring(1))&&o<=l&&(s[o]=-1);for(i=1;i<s.length;++i)-1===s[i]&&(s[i]=++n);for(i=0,l=0;i<a;++i)if("("===(c=r[i]))void 0===s[++l]&&(r[i]="(?:");else if("\\"===c.charAt(0)){var o;(o=+c.substring(1))&&o<=l&&(r[i]="\\"+s[l])}for(i=0,l=0;i<a;++i)"^"===r[i]&&"^"!==r[i+1]&&(r[i]="");if(e.ignoreCase&&t)for(i=0;i<a;++i){var c,d=(c=r[i]).charAt(0);c.length>=2&&"["===d?r[i]=u(c):"\\"!==d&&(r[i]=c.replace(/[a-zA-Z]/g,function(e){var n=e.charCodeAt(0);return"["+String.fromCharCode(-33&n,32|n)+"]"}))}return r.join("")}var d=[];for(a=0,s=e.length;a<s;++a){var f;if((f=e[a]).global||f.multiline)throw new Error(""+f);d.push("(?:"+c(f)+")")}return new RegExp(d.join("|"),r?"gi":"g")}(s)}();var a=n.length,s=function(e){for(var i=e.sourceCode,l=e.basePos,o=[l,v],u=0,c=i.match(t)||[],d={},f=0,p=c.length;f<p;++f){var h,g=c[f],m=d[g],w=void 0;if("string"==typeof m)h=!1;else{var b=r[g.charAt(0)];if(b)w=g.match(b[1]),m=b[0];else{for(var S=0;S<a;++S)if(b=n[S],w=g.match(b[1])){m=b[0];break}w||(m=v)}!(h=m.length>=5&&"lang-"===m.substring(0,5))||w&&"string"==typeof w[1]||(h=!1,m=y),h||(d[g]=m)}var C=u;if(u+=g.length,h){var N=w[1],_=g.indexOf(N),E=_+N.length;w[2]&&(_=(E=g.length-w[2].length)-N.length);var k=m.substring(5);x(l+C,g.substring(0,_),s,o),x(l+C+_,N,A(k,N),o),x(l+C+E,g.substring(E),s,o)}else o.push(l+C,m)}e.decorations=o};return s}function N(e){var n=[],t=[];e.tripleQuotedStrings?n.push([d,/^(?:\'\'\'(?:[^\'\\]|\\[\s\S]|\'{1,2}(?=[^\']))*(?:\'\'\'|$)|\"\"\"(?:[^\"\\]|\\[\s\S]|\"{1,2}(?=[^\"]))*(?:\"\"\"|$)|\'(?:[^\\\']|\\[\s\S])*(?:\'|$)|\"(?:[^\\\"]|\\[\s\S])*(?:\"|$))/,null,"'\""]):e.multiLineStrings?n.push([d,/^(?:\'(?:[^\\\']|\\[\s\S])*(?:\'|$)|\"(?:[^\\\"]|\\[\s\S])*(?:\"|$)|\`(?:[^\\\`]|\\[\s\S])*(?:\`|$))/,null,"'\"`"]):n.push([d,/^(?:\'(?:[^\\\'\r\n]|\\.)*(?:\'|$)|\"(?:[^\\\"\r\n]|\\.)*(?:\"|$))/,null,"\"'"]),e.verbatimStrings&&t.push([d,/^@\"(?:[^\"]|\"\")*(?:\"|$)/,null]);var r=e.hashComments;if(r&&(e.cStyleComments?(r>1?n.push([p,/^#(?:##(?:[^#]|#(?!##))*(?:###|$)|.*)/,null,"#"]):n.push([p,/^#(?:(?:define|elif|else|endif|error|ifdef|include|ifndef|line|pragma|undef|warning)\b|[^\r\n]*)/,null,"#"]),t.push([d,/^<(?:(?:(?:\.\.\/)*|\/?)(?:[\w-]+(?:\/[\w-]+)+)?[\w-]+\.h|[a-z]\w*)>/,null])):n.push([p,/^#[^\r\n]*/,null,"#"])),e.cStyleComments&&(t.push([p,/^\/\/[^\r\n]*/,null]),t.push([p,/^\/\*[\s\S]*?(?:\*\/|$)/,null])),e.regexLiterals){t.push(["lang-regex",new RegExp("^"+w+"(/(?=[^/*])(?:[^/\\x5B\\x5C]|\\x5C[\\s\\S]|\\x5B(?:[^\\x5C\\x5D]|\\x5C[\\s\\S])*(?:\\x5D|$))+/)")])}var a=e.types;a&&t.push([h,a]);var s=(""+e.keywords).replace(/^ | $/g,"");return s.length&&t.push([f,new RegExp("^(?:"+s.replace(/[\s,]+/g,"|")+")\\b"),null]),n.push([v,/^\s+/,null," \r\n\t "]),t.push([g,/^@[a-z_$][a-z_$@0-9]*/i,null],[h,/^(?:[@_]?[A-Z]+[a-z][A-Za-z_$@0-9]*|\w+_t\b)/,null],[v,/^[a-z_$][a-z_$@0-9]*/i,null],[g,new RegExp("^(?:0x[a-f0-9]+|(?:\\d(?:_\\d+)*\\d*(?:\\.\\d*)?|\\.\\d\\+)(?:e[+\\-]?\\d+)?)[a-z]*","i"),null,"0123456789"],[v,/^\\[\s\S]?/,null],[m,/^.[^\s\w\.$@\'\"\`\/\#\\]*/,null]),C(n,t)}var _=N({keywords:[t,a,s,i+l,o,u],hashComments:!0,cStyleComments:!0,multiLineStrings:!0,regexLiterals:!0});function E(e,n){var t,r=/(?:^|\s)nocode(?:\s|$)/,a=/\r\n?|\n/,s=e.ownerDocument;e.currentStyle?t=e.currentStyle.whiteSpace:window.getComputedStyle&&(t=s.defaultView.getComputedStyle(e,null).getPropertyValue("white-space"));for(var i=t&&"pre"===t.substring(0,3),l=s.createElement("LI");e.firstChild;)l.appendChild(e.firstChild);var o=[l];function u(e){switch(e.nodeType){case 1:if(r.test(e.className))break;if("BR"===e.nodeName)c(e),e.parentNode&&e.parentNode.removeChild(e);else for(var n=e.firstChild;n;n=n.nextSibling)u(n);break;case 3:case 4:if(i){var t=e.nodeValue,l=t.match(a);if(l){var o=t.substring(0,l.index);e.nodeValue=o;var d=t.substring(l.index+l[0].length);if(d)e.parentNode.insertBefore(s.createTextNode(d),e.nextSibling);c(e),o||e.parentNode.removeChild(e)}}}}function c(e){for(;!e.nextSibling;)if(!(e=e.parentNode))return;for(var n,t=function e(n,t){var r=t?n.cloneNode(!1):n,a=n.parentNode;if(a){var s=e(a,1),i=n.nextSibling;s.appendChild(r);for(var l=i;l;l=i)i=l.nextSibling,s.appendChild(l)}return r}(e.nextSibling,0);(n=t.parentNode)&&1===n.nodeType;)t=n;o.push(t)}for(var d=0;d<o.length;++d)u(o[d]);n===(0|n)&&o[0].setAttribute("value",n);var f=s.createElement("OL");f.className="linenums";for(var p=Math.max(0,n-1|0)||0,h=(d=0,o.length);d<h;++d)(l=o[d]).className="L"+(d+p)%10,l.firstChild||l.appendChild(s.createTextNode(" ")),f.appendChild(l);e.appendChild(f)}var k={};function R(e,n){for(var t=n.length;--t>=0;){var r=n[t];k.hasOwnProperty(r)?window.console&&console.warn("cannot override language handler %s",r):k[r]=e}}function A(e,n){return e&&k.hasOwnProperty(e)||(e=/^\s*</.test(n)?"default-markup":"default-code"),k[e]}function P(e){var n=e.langExtension;try{var t=function(e){var n,t=/(?:^|\s)nocode(?:\s|$)/,r=[],a=0,s=[],i=0;e.currentStyle?n=e.currentStyle.whiteSpace:window.getComputedStyle&&(n=document.defaultView.getComputedStyle(e,null).getPropertyValue("white-space"));var l=n&&"pre"===n.substring(0,3);return function e(n){switch(n.nodeType){case 1:if(t.test(n.className))return;for(var o=n.firstChild;o;o=o.nextSibling)e(o);var u=n.nodeName;"BR"!==u&&"LI"!==u||(r[i]="\n",s[i<<1]=a++,s[i++<<1|1]=n);break;case 3:case 4:var c=n.nodeValue;c.length&&(c=l?c.replace(/\r\n?/g,"\n"):c.replace(/[ \t\r\n]+/g," "),r[i]=c,s[i<<1]=a,a+=c.length,s[i++<<1|1]=n)}}(e),{sourceCode:r.join("").replace(/\n$/,""),spans:s}}(e.sourceNode),r=t.sourceCode;e.sourceCode=r,e.spans=t.spans,e.basePos=0,A(n,r)(e),function(e){var n,t,r=/\bMSIE\b/.test(navigator.userAgent),a=/\n/g,s=e.sourceCode,i=s.length,l=0,o=e.spans,u=o.length,c=0,d=e.decorations,f=d.length,p=0;for(d[f]=i,t=n=0;t<f;)d[t]!==d[t+2]?(d[n++]=d[t++],d[n++]=d[t++]):t+=2;for(f=n,t=n=0;t<f;){for(var h=d[t],g=d[t+1],m=t+2;m+2<=f&&d[m+1]===g;)m+=2;d[n++]=h,d[n++]=g,t=m}for(f=d.length=n;c<u;){o[c];var v,y=o[c+2]||i,w=(d[p],d[p+2]||i),x=(m=Math.min(y,w),o[c+1]);if(1!==x.nodeType&&(v=s.substring(l,m))){r&&(v=v.replace(a,"\r")),x.nodeValue=v;var b=x.ownerDocument,S=b.createElement("SPAN");S.className=d[p+1];var C=x.parentNode;C.replaceChild(S,x),S.appendChild(x),l<y&&(o[c+1]=x=b.createTextNode(s.substring(m,y)),C.insertBefore(x,S.nextSibling))}(l=m)>=y&&(c+=2),l>=w&&(p+=2)}}(e)}catch(e){"console"in window&&console.log(e&&e.stack?e.stack:e)}}R(_,["default-code"]),R(C([],[[v,/^[^<?]+/],["dec",/^<!\w[^>]*(?:>|$)/],[p,/^<\!--[\s\S]*?(?:-\->|$)/],["lang-",/^<\?([\s\S]+?)(?:\?>|$)/],["lang-",/^<%([\s\S]+?)(?:%>|$)/],[m,/^(?:<[%?]|[%?]>)/],["lang-",/^<xmp\b[^>]*>([\s\S]+?)<\/xmp\b[^>]*>/i],["lang-js",/^<script\b[^>]*>([\s\S]*?)(<\/script\b[^>]*>)/i],["lang-css",/^<style\b[^>]*>([\s\S]*?)(<\/style\b[^>]*>)/i],["lang-in.tag",/^(<\/?[a-z][^<>]*>)/i]]),["default-markup","htm","html","mxml","xhtml","xml","xsl"]),R(C([[v,/^[\s]+/,null," \t\r\n"],["atv",/^(?:\"[^\"]*\"?|\'[^\']*\'?)/,null,"\"'"]],[["tag",/^^<\/?[a-z](?:[\w.:-]*\w)?|\/?>$/i],["atn",/^(?!style[\s=]|on)[a-z](?:[\w:-]*\w)?/i],["lang-uq.val",/^=\s*([^>\'\"\s]*(?:[^>\'\"\s\/]|\/(?=\s)))/],[m,/^[=<>\/]+/],["lang-js",/^on\w+\s*=\s*\"([^\"]+)\"/i],["lang-js",/^on\w+\s*=\s*\'([^\']+)\'/i],["lang-js",/^on\w+\s*=\s*([^\"\'>\s]+)/i],["lang-css",/^style\s*=\s*\"([^\"]+)\"/i],["lang-css",/^style\s*=\s*\'([^\']+)\'/i],["lang-css",/^style\s*=\s*([^\"\'>\s]+)/i]]),["in.tag"]),R(C([],[["atv",/^[\s\S]+/]]),["uq.val"]),R(N({keywords:t,hashComments:!0,cStyleComments:!0,types:c}),["c","cc","cpp","cxx","cyc","m"]),R(N({keywords:"null,true,false"}),["json"]),R(N({keywords:a,hashComments:!0,cStyleComments:!0,verbatimStrings:!0,types:c}),["cs"]),R(N({keywords:r,cStyleComments:!0}),["java"]),R(N({keywords:u,hashComments:!0,multiLineStrings:!0}),["bsh","csh","sh"]),R(N({keywords:l,hashComments:!0,multiLineStrings:!0,tripleQuotedStrings:!0}),["cv","py"]),R(N({keywords:i,hashComments:!0,multiLineStrings:!0,regexLiterals:!0}),["perl","pl","pm"]),R(N({keywords:o,hashComments:!0,multiLineStrings:!0,regexLiterals:!0}),["rb"]),R(N({keywords:s,cStyleComments:!0,regexLiterals:!0}),["js"]),R(N({keywords:"all,and,by,catch,class,else,extends,false,finally,for,if,in,is,isnt,loop,new,no,not,null,of,off,on,or,return,super,then,true,try,unless,until,when,while,yes",hashComments:3,cStyleComments:!0,multilineStrings:!0,tripleQuotedStrings:!0,regexLiterals:!0}),["coffee"]),R(C([],[[d,/^[\s\S]+/]]),["regex"]),window.prettyPrintOne=function(e,n,t){var r=document.createElement("PRE");return r.innerHTML=e,t&&E(r,t),P({langExtension:n,numberLines:t,sourceNode:r}),r.innerHTML},window.prettyPrint=function(e){function n(e){return document.getElementsByTagName(e)}for(var t=[n("pre"),n("code"),n("xmp")],r=[],a=0;a<t.length;++a)for(var s=0,i=t[a].length;s<i;++s)r.push(t[a][s]);t=null;var l=Date;l.now||(l={now:function(){return+new Date}});var o=0,u=/\blang(?:uage)?-([\w.]+)(?!\S)/;!function n(){for(var t=window.PR_SHOULD_USE_CONTINUATION?l.now()+250:1/0;o<r.length&&l.now()<t;o++){var a=r[o],s=a.className;if(s.indexOf("prettyprint")>=0){var i,c=s.match(u);!c&&(i=S(a))&&"CODE"===i.tagName&&(c=i.className.match(u)),c&&(c=c[1]);for(var d=!1,f=a.parentNode;f;f=f.parentNode)if(("pre"===f.tagName||"code"===f.tagName||"xmp"===f.tagName)&&f.className&&f.className.indexOf("prettyprint")>=0){d=!0;break}if(!d){var p=a.className.match(/\blinenums\b(?::(\d+))?/);(p=!!p&&(!p[1]||!p[1].length||+p[1]))&&E(a,p),P({langExtension:c,sourceNode:a,numberLines:p})}}}o<r.length?setTimeout(n,250):e&&e()}()},window.PR={createSimpleLexer:C,registerLangHandler:R,sourceDecorator:N,PR_ATTRIB_NAME:"atn",PR_ATTRIB_VALUE:"atv",PR_COMMENT:p,PR_DECLARATION:"dec",PR_KEYWORD:f,PR_LITERAL:g,PR_NOCODE:"nocode",PR_PLAIN:v,PR_PUNCTUATION:m,PR_SOURCE:y,PR_STRING:d,PR_TAG:"tag",PR_TYPE:h}}();