(function($) {
	"use strict";
	$(document).ready(function() {
		var _height = $(window).height();
        var _list_height = _height - $('.top-left').height() - $('#header').height();
        $('.equal-height').css('height', _list_height);
        var mes_height = _list_height - $('.message-container .action').height() -50;
        $('.post-mes').css('max-height', mes_height);
	});
})(jQuery);