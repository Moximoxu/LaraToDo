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

			// Context for button in plugin toolbar
			context.memo('button.customFontSize', function () {
				var button = ui.button({
					contents: '<i class="fas fa-font"></i> <input id="fontSize" name="fontSize" type="number" max="80" min="8" step="0.1" value="14"> px',
					tooltip: 'Change font size',

					// Changes the font size according to the input in #fontSize
					click: function () {
            var in_font_size = document.getElementById("fontSize").value;
            // console.log("Current font size is " + in_font_size);

            // Acquiring the selected text that is needed to have different font size
            if (document.getSelection) {
                var sel = document.getSelection(); //Contains the raw text of the selected text

                // Variable for acquiring the selected text, specifically the p element of the text
                var text = sel.anchorNode.parentNode;
                // console.log("sel.anchorNode.parentNode = " + sel.anchorNode.parentNode);

                // The range finder for the selected text
                if (sel.rangeCount) {
                    var range = sel.getRangeAt(0).cloneRange();
                    text.style.fontSize = in_font_size + "px";
                    sel.removeAllRanges();
                    sel.addRange(range);
                }
            }

            // var selectedText = "";
            // if(window.getSelection()){
            //   selectedText = window.getSelection();
            // }
            // else if(document.getSelection()){
            //   selectedText = document.getSelection();
            // }
            // else if(document.selection()){
            //   selectedText = document.selection.createRange().text;
            // }

            // console.log("Current selectedText is " + sel);
					}
				});
				//Render button
				this.customFontSize = button.render();
				return this.customFontSize;
			});
		}
	});
}));

function getFontSize() {

  var font_size = document.getElementById("fontSize");

  // Acquiring the selected text
  if (document.getSelection) {
      var sel = document.getSelection(); // Contains the raw text of the selected text
      console.log("The selected text is " + sel);

      // Variable for acquiring the selected text, specifically the p element of the text
      var text = sel.anchorNode.parentNode;
      // console.log("sel.anchorNode.parentNode = " + sel.anchorNode.parentNode);

      // The range finder for the selected text
      var range = sel.getRangeAt(0).cloneRange();
      var current_fSize = text.style.fontSize;
      console.log("Current font size is " + current_fSize);
      var fSize_val = Number(current_fSize.replace(/[^0-9\.]+/g,""));
      if(fSize_val > 0){
        font_size.value = fSize_val;
      }
      else if(fSize_val == 0){
        font_size.value = "";
      }
      sel.removeAllRanges();
      sel.addRange(range);
  }
};

$(document).ready(function() {
   var container = document.getElementById("summernote_container");
   var text = container.getElementsByTagName('p')[1];
   console.log(text);

   // container.getElementsByClassName("note-editable").firstChild;
   // container.getElementsByTagName("p");

   text.style.fontSize = 14 + "px";
   container.addEventListener("click", getFontSize);
   container.addEventListener("select", getFontSize);
 });
