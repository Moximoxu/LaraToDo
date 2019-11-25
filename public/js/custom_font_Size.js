/**
 *
 * copyright 2019, Mohd Ikhmal Hafiq Zubir.
 * email: ikhmal.zubir@gmail.com
 * license: Your chosen license, or link to a license file.
 *
 */
(function (factory) {
  /* Global define */
  if (typeof define === 'function' && define.amd) {
    // AMD. Register as an anonymous module.
    define(['jquery'], factory);
  } else if (typeof module === 'object' && module.exports) {
    // Node/CommonJS
    module.exports = factory(require('jquery'));
  } else {
    // Browser globals
    factory(window.jQuery);
  }
}

/**
 * @class plugin.countimer
 *
 * Countimer Plugin
*/
(function ($) {
	$.extend($.summernote.plugins, {
		'custom_fontSize' : function custom_Fontsize(context) {
			var ui = $.summernote.ui;
			var self = this;
			var KEY_ESC = 27;
			var KEY_TAB = 9;
			var editorId = 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
				var r = Math.random() * 16 | 0, v = c == 'x' ? r : (r & 0x3 | 0x8);
				return v.toString(16);
			});
			var chunk = function (val, chunkSize) {
				var R = [];
				for (var i = 0; i < val.length; i += chunkSize)
					R.push(val.slice(i, i + chunkSize));
				return R;
			};

		/*IE polyfill*/
		if (!Array.prototype.filter) {
			Array.prototype.filter = function (fun /*, thisp*/) {
				var len = this.length >>> 0;
				if (typeof fun != "function")
					throw new TypeError();

				var res = [];
				var thisp = arguments[1];
				for (var i = 0; i < len; i++) {
					if (i in this) {
						var val = this[i];
						if (fun.call(thisp, val, i, this))
							res.push(val);
					}
				}
				return res;
			};
		}

			//Context for button in plugin toolbar
			context.memo('button.customFontSize', function () {
				var button = ui.button({
					contents: '<i class="fas fa-font"></i> <input id="fontSize" name="fontSize" type="number" max="80" min="8" step="0.1">',
					tooltip: 'Change font size',

					//HTML that will be inserted into editor
					click: function () {
            var in_font_size = document.getElementById("fontSize").value;

            var selectedText = "";
            if(window.getSelection()){
              selectedText = window.getSelection();
            }
            else if(document.getSelection()){
              selectedText = document.getSelection();
            }
            else if(document.selection()){
              selectedText = document.selection.createRange().text;
            }

            selectedText.style.fontSize = in_font_size;
					}
				});
				//Render button
				this.customFontSize = button.render();
				return this.customFontSize;
			});
		}
	});
}));
