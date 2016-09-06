(function($) {
	"use strict";

	$(function() {
		_customizeSettings['current'] = window.location.toString();
		
		parent.postMessage( JSON.stringify( {
			id: 'customizeSettings',
			settings: _customizeSettings
		} ) , "http://dev.linethemes");
	});
}).call(this, jQuery);