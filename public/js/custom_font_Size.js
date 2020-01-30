/**
 *
 * copyright 2019, Mohd Ikhmal Hafiq Zubir.
 * email: ikhmal.zubir@gmail.com
 * license: Your chosen license, or link to a license file.
 *
 */
 var clicks = 0;

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
					contents: '<i class="fas fa-font"></i> <i id="summernote_customFS_logo_fontSize_dot" class="fas fa-circle"></i><i id="summernote_customFS_logo_fontSize_ast" class="fas fa-asterisk"></i>',
					tooltip: 'Decimal Font Size',

					// Changes the font size according to the input in #fontSize
					click: function(){
            $('#summernote_customFS_setFontSize_modal').modal('show');

            // Acquiring the selected text that is needed to have different font size
              // Variable for acquiring the selected text, specifically the p element of the text
              clicks++;
              console.log("Clicks = " + clicks);

              const summernote_customFS_sel = getSelection().getRangeAt(0); //Contains the raw text of the selected text
              const nNd = document.createElement("span");
              $(nNd).attr({"id" : "summernote_customFS_span" + clicks, "style": "font-size:", "class" : "summernote_customFS_font_span"});
              summernote_customFS_sel.surroundContents(nNd);
              nNd.insertAdjacentHTML('afterend', "&nbsp;");
              var closest = $(summernote_customFS_sel).closest('span');
              console.log(closest);
              // if(closest){
              //
              // }

               console.log("summernote_customFS_sel = " + summernote_customFS_sel);
               summernote_customFS_getFontSize();
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
function summernote_customFS_getFontSize() {

  var summernote_customFS_font_size = document.getElementById("summernote_customFS_font_size_in");

  // Acquiring the font size of selected text
  var summernote_customFS_selected_span = $(summernote_customFS_sel).closest(".summernote_customFS_font_span");
  var current_fSize = summernote_customFS_selected_span.style.fontSize;

  console.log("Current font size is " + current_fSize);
  var fSize_val = Number(current_fSize.replace(/[^0-9\.]+/g,""));
  if(fSize_val > 0){
    summernote_customFS_font_size_in.value = fSize_val;
  }
  else if(fSize_val == 0){
    summernote_customFS_font_size_in.value = "";
  }
};

// For clearing highlighted text
function summernote_customFS_clearSelection(){
  if(document.selection && document.selection.empty) {
        document.selection.empty();
    } else if(window.getSelection) {
        summernote_customFS_sel = window.getSelection();
        summernote_customFS_sel.removeAllRanges();
    }
};

// Set font size according to value of input space #fontSize
function summernote_customFS_setFontSize() {
  var in_font_size = document.getElementById("summernote_customFS_font_size_in").value;
  // console.log("Current font size is " + in_font_size);

  console.log("Selected span = " + document.getElementById("summernote_customFS_span" + clicks));
  // $(sel).css("font-size", in_font_size + "px");
  $("#summernote_customFS_span" + clicks).css("font-size", in_font_size + "px");
};

function selectHTML() {
    try {
        if (window.ActiveXObject) {
            var c = document.selection.createRange();
            return c.htmlText;
        }

        clicks++;
        console.log("In selectHTML() Clicks = " + clicks);

        var nNd = document.createElement("span");
        $(nNd).attr({"id" : "summernote_customFS_span" + clicks, "style": "font-size: 14px"});
        var w = getSelection().getRangeAt(0);
        w.surroundContents(nNd);
        // console.log("Ran selectHTML");
        // return nNd.innerHTML;
    } catch (e) {
        if (window.ActiveXObject) {
            return document.selection.createRange();
        } else {
            return getSelection();
        }
    }
};

// Contains the functions that runs immediately after the page is fully loaded
$(document).ready(function() {
  var summernote_customFS_font_modal = '<div id="summernote_customFS_setFontSize_modal" class="modal fade" role="dialog">'+
  '<div class="modal-dialog modal-sm">'+
  '	<div class="modal-content">'+
  '		<div class="modal-header">'+
  '			<h4 class="modal-title" id="summernote_customFS_font_modal_title">Set Font Size</h4>'+
  '			<button type="button" class="close" data-dismiss="modal"><i class="far fa-times-circle"></i></button>'+
  '		</div>'+
  '		<div class="modal-body" id="summernote_customFS_font_size">'+
  '			<label for="summernote_customFS_font_size_in">Font size</label>'+
  '			<input id="summernote_customFS_font_size_in" name="summernote_customFS_font_size_in" type="number" max="120" min="8" step="0.1" value="14" style="width:25%"> px<br>'+
  '			</div>'+
  '			<div class="modal-footer">'+
  '				<button type="button" id="summernote_customFS_submit_fontSize" class="btn btn-info btn-block my-3" data-dismiss="modal">SET</button>'+
  '			</div>'+
  '	</div>'+
  '</div>'+
  '</div>';

  $("body").append(summernote_customFS_font_modal);

   var container = document.getElementById("summernote_container")

   clicks = container.getElementsByClassName("summernote_customFS_font_span").length;

   var confirm = document.getElementById("summernote_customFS_font_size_in");
    confirm.addEventListener("keyup", function(event) {
      if (event.keyCode === 13) {
       event.preventDefault();
       document.getElementById("summernote_customFS_submit_fontSize").click();
      }
    });

   $("#summernote_customFS_submit_fontSize").click(function(){
     summernote_customFS_setFontSize();
     summernote_customFS_clearSelection();
   });

   $("#summernote_customFS_cancel_fontSize").click(function(){
     summernote_customFS_clearSelection();
   });

});
