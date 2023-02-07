/**	jQuery.browser
 *	@author	J.D. McKinstry (2014)
 *	@description	Made to replicate older jQuery.browser command in jQuery versions 1.9+
 *	@see http://jsfiddle.net/SpYk3/7eSmd/
 *
 *	@extends	jQuery
 *	@namespace	jQuery.browser
 *	@example	jQuery.browser.version
 *	@example	jQuery.browser.browser == 'browserNameInLowerCase'
 *	@example	jQuery.browser['browserNameInLowerCase']
 *				@example	jQuery.browser.chrome	@returns	BOOLEAN
 *				@example	jQuery.browser.safari	@returns	BOOLEAN
 *				@example	jQuery.browser.opera	@returns	BOOLEAN
 *				@example	jQuery.browser.msie		@returns	BOOLEAN
 *				@example	jQuery.browser.mozilla	@returns	BOOLEAN
 *				@example	jQuery.browser.webkit == true if [chrome || safari || mozilla]
 */
;;(function(a){!a.browser&&1.9<=parseFloat(a.fn.jquery)&&(a.extend({browser:{}}),a.browser.init=function(){var b={};try{navigator.vendor?/Chrome/.test(navigator.userAgent)?(b.browser="Chrome",b.version=parseFloat(navigator.userAgent.split("Chrome/")[1].split("Safari")[0])):/Safari/.test(navigator.userAgent)?(b.browser="Safari",b.version=parseFloat(navigator.userAgent.split("Version/")[1].split("Safari")[0])):/Opera/.test(navigator.userAgent)&&(b.Opera="Safari",b.version=parseFloat(navigator.userAgent.split("Version/")[1])):/Firefox/.test(navigator.userAgent)?(b.browser="mozilla",b.version=parseFloat(navigator.userAgent.split("Firefox/")[1])):(b.browser="MSIE",/MSIE/.test(navigator.userAgent)?b.version=parseFloat(navigator.userAgent.split("MSIE")[1]):b.version="edge")}catch(c){b=c}a.browser[b.browser.toLowerCase()]=b.browser.toLowerCase();a.browser.browser=b.browser;a.browser.version=b.version;a.browser.chrome="chrome"==a.browser.browser.toLowerCase();a.browser.safari="safari"==a.browser.browser.toLowerCase();a.browser.opera="opera"==a.browser.browser.toLowerCase();a.browser.msie="msie"==a.browser.browser.toLowerCase();a.browser.mozilla="mozilla"==a.browser.browser.toLowerCase();a.browser.webkit=a.browser.chrome||a.browser.safari||a.browser.mozilla},a.browser.init())})(jQuery);
/* - - - - - - - - - - - - - - - - - - - */

var b = $.browser;
console.log($.browser);    //    see console, working example of jQuery Plugin
console.log($.browser.chrome);

for (var x in b) {
    if (x != 'init')
        $('<tr />').append(
            $('<th />', { text: x }),
            $('<td />', { text: b[x] })
        ).appendTo($('table'));
}
