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
					contents: '<i class="fas fa-font"></i> <i id="logo_fontSize_dot" class="fas fa-circle"></i><i id="logo_fontSize_ast" class="fas fa-asterisk"></i>',
					tooltip: 'Decimal Font Size',

					// Changes the font size according to the input in #fontSize
					click: function(){
            $('#setFontSizeModal').modal('show');
          }
				});
				//Render button
				this.customFontSize = button.render();
				return this.customFontSize;
			});
		}
	});
}));

// Fetch current font size of selected text and throw the value into input space of "#fontSize"
function getFontSize() {

  var font_size = document.getElementById("font_size_in");

  // Acquiring the selected text
  if (document.getSelection) {
      var sel = document.getSelection(); // Contains the raw text of the selected text
      // console.log("The selected text is " + sel);

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
        sel.removeAllRanges();
        sel.addRange(range);
      }
      else if(fSize_val == 0){
        font_size.value = "";
        sel.removeAllRanges();
        sel.addRange(range);
      }
  }
};

// For clearing highlighted text
function clearSelection(){
  if(document.selection && document.selection.empty) {
        document.selection.empty();
    } else if(window.getSelection) {
        var sel = window.getSelection();
        sel.removeAllRanges();
    }
};

// Set font size according to value of input space #fontSize
function setFontSize() {
 var in_font_size = document.getElementById("font_size_in").value;
 // console.log("Current font size is " + in_font_size);

  // Acquiring the selected text that is needed to have different font size
  if (document.getSelection) {
     var sel = document.getSelection(); //Contains the raw text of the selected text

     // Insert new method of acquiring selected text here

     // Variable for acquiring the selected text, specifically the p element of the text
     // var text = sel.anchorNode.parentNode;
     console.log("sel = " + sel);

     // The range finder for the selected text
     if (sel.rangeCount) {
         var range = sel.getRangeAt(0).cloneRange();
         text.style.fontSize = in_font_size + "px";
         sel.removeAllRanges();
         sel.addRange(range);
     }

  }
};

// Contains the functions that runs immediately after the page is fully loaded
$(document).ready(function() {
   // Fetch the summernote container that wraps around the editable space
   var container = document.getElementById("summernote_container");
   var text = container.getElementsByTagName('p')[1];
   // console.log(text);

   // container.getElementsByClassName("note-editable").firstChild;
   // container.getElementsByTagName("p");

   // Sets the intial value of input space #fontSize
   text.style.fontSize = 14 + "px";

   // "Click" event in editable space
   $(".note-editable").click(function(){
     getFontSize();
   });

   // Runs when the editable space is blurred (out of focus)
   $(".note-editable").blur(function(){
       // console.log("Unfocused from summernote_container");
       setFontSize();
   });

   $("#submit_fontSize").click(function(){
     setFontSize();
     clearSelection();
   });

   $("#cancel_fontSize").click(function(){
     clearSelection();
   });

});
