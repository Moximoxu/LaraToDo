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
		'countimer' : function setDate(context) {
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
			context.memo('button.countimer', function () {
				var button = ui.button({
					contents: '<i class="far fa-clock"></i>',
					tooltip: 'Insert Countimer',

					//HTML that will be inserted into editor
					click: function () {
						$counter = '<div class="col" id="timer_div">'+
						'<div class="container my-3 mx-3">'+
						'		<div class="row">'+
						'			<div class="col-sm-4 mx-2"><h2 class="text-center" id="c_title">Title</h2></div>'+
						'			<p id="title_show" name="title_show" style="display:none"></p>'+
						'			<h3 id="c_countDown" style="display:none"></h3>'+
						'		</div>'+
						'		<div class="row">'+
						'			<div class="col-sm-1"><h3 class="text-center" id="c_days_label">Days</h3></div>'+
						'			<div class="col-sm-1"><h3 class="text-center" id="c_hours_label">Hours</h3></div>'+
						'			<div class="col-sm-1"><h3 class="text-center" id="c_minutes_label">Minutes</h3></div>'+
						'			<div class="col-sm-1"><h3 class="text-center" id="c_seconds_label">Seconds</h3></div>'+
						'		</div>'+
						'		<div class="row">'+
						'			<div class="col-sm-1"><h3 class="text-center" id="c_days"></h3></div>'+
						'			<div class="col-sm-1"><h3 class="text-center" id="c_hours"></h3></div>'+
						'			<div class="col-sm-1"><h3 class="text-center" id="c_minutes"></h3></div>'+
						'			<div class="col-sm-1"><h3 class="text-center" id="c_seconds" style="color:red;"></h3></div>'+
						'		</div>'+
						'</div'+
					'</div'+

					'</div>';

						//Paste countimer into editor
						context.invoke('editor.pasteHTML', $counter);

						//Automatically opens the modal once the button is pressed
						$('#setModal').modal('show');

					}
				});
				//Render button
				this.countimer = button.render();
				return this.countimer;
			});
		}
	});
}));

	// Set the date we're counting down to
	function setDate(){
		//Close the modal
		$("#setModal.close").click();

		//Set the title
		var title = document.getElementById("c_title_in").value;
		console.log("Successfully set title");
    document.getElementById("title_show").innerHTML = title;
    console.log(document.getElementById("title_show").innerHTML);

		//Set date of the endpoint
		var date =  document.getElementById("c_date").value;
		var countDownDate = new Date(date);

		//Set hour of the endpoint
		var hour =  document.getElementById("c_hour").value;
		countDownDate.setHours(hour);

		//Set minute of the endpoint
		var minute =  document.getElementById("c_minute").value;
		countDownDate.setMinutes(minute);

		//Set second of the endpoint
		var second = document.getElementById("c_second").value;
		countDownDate.setSeconds(second);

		//Insert into variable for calculation
		var countDown = countDownDate.getTime();
		console.log("Successfully fetched set time");
		document.getElementById("c_countDown").innerHTML = countDown;
		console.log(document.getElementById("c_countDown").innerHTML);

		//Update the count down every 1 second
		var x = setInterval(function() {

		  //Get today's date and time
		  var now = new Date().getTime();

		  //Find the distance between now and the count down date
		  var distance = countDown - now;

		  //Time calculations for days, hours, minutes and seconds
		  var days = Math.floor(distance / (1000 * 60 * 60 * 24));
		  var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
		  var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
		  var seconds = Math.floor((distance % (1000 * 60)) / 1000);

		  //Output the result in an element with id="timer"
		  document.getElementById("c_title").innerHTML = title;
		  document.getElementById("c_title").value = title

		  document.getElementById("c_days").innerHTML = days;
		  document.getElementById("c_hours").innerHTML = hours;
		  document.getElementById("c_minutes").innerHTML = minutes;
		  document.getElementById("c_seconds").innerHTML = seconds;

		  //If the count down is over, write some text
		  if (distance < 0) {
			document.getElementById("c_title").innerHTML = "EXPIRED";
			document.getElementById("c_days").innerHTML = "0";
			document.getElementById("c_hours").innerHTML = "0";
			document.getElementById("c_minutes").innerHTML = "0";
			document.getElementById("c_seconds").innerHTML = "0";
		  }

		console.log("Counting down time");
		}, 1000);

    //Enters a whitespace into summernote editor
    $('#summernote').summernote('insertText', '');
	};
