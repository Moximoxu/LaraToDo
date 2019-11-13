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
						'<h2 class="header" style="text-align:center;font-size:40px" id="c_title">Title</h2>'+
						'<h2 id="title_show" style="display:none"></h2>'+
						'<h3 id="c_countDown" style="display:none"></h3>'+
						'<table style="text-align:center" class="table table-hover my-3 mx-3">'+
						'	<thead>'+
						'		<tr>'+
						'			<td><h3 style="font-size:20px">Days</h3></td>'+
						'			<td><h3 style="font-size:20px">Hours</h3></td>'+
						'			<td><h3 style="font-size:20px">Minutes</h3></td>'+
						'			<td><h3 style="font-size:20px">Seconds</h3></td>'+
						'		</tr>'+
						'	</thead>'+
						'	<tbody>'+
						'		<tr>'+
						'			<td><h3 id="c_days" style="font-size:40px"></h3></td>'+
						'			<td><h3 id="c_hours" style="font-size:40px"></h3></td>'+
						'			<td><h3 id="c_minutes" style="font-size:40px"></h3></td>'+
						'			<td><h3 id="c_seconds" style="color:red;font-size:40px"></h3></td>'+
						'		</tr>'+
						'	</tbody>'+
						'</table>'+
					'</div>'+
					
					'<div id="setModal" class="modal fade" role="dialog" style="display: none;">'+
					'  <div class="modal-dialog">'+ 
					'	<div class="modal-content">'+
					'	  <div class="modal-header">'+
					'		<button type="button" class="close" data-dismiss="modal">&times;</button>'+
					'		<h4 class="modal-title">Set Countimer</h4>'+
					'	  </div>'+
					'	  <div class="modal-body" id="timer">'+
					'			<label for="c_title_in">Title of Countdown</label>'+
					'			<input type="text" id="c_title_in"><br>'+

					'			<label for="c_date">Countdown Date</label>'+
					'			<input type="date" id="c_date" placeholder="Countdown date"><br>'+

					'			<label for="c_hour">Hour</label>'+
					'			<input type="number" id="c_hour" required value="00" min="0" step="1" max="23">:'+

					'			<label for="c_minute">Minute</label>'+
					'			<input type="number" id="c_minute" required value="00" min="0" step="1" max="59">:'+

					'			<label for="c_second">Second</label>'+
					'			<input type="number" id="c_second" required value="00" min="0" step="1" max="59"><br>'+

					'			<button type="button" onclick="setDate()" class="btn btn-info my-3" data-dismiss="modal">Set</button>'+
					'	  </div>'+
					'	  <div class="modal-footer">'+
					'		<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>'+
					'	  </div>'+
					'	</div>'+

					'  </div>'+
					'</div>'+
					
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
		  document.getElementById("c_title").value = title;
		  document.getElementById("title_show").innerHTML = title;
		  console.log(document.getElementById("title_show").innerHTML);

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
		
		//Store the content in the editor
		$("#store_Content").click(function(){
			var textareaValue = $('#summernote').summernote('code');
			localStorage.setItem("content", textareaValue);
			$("#timer_div").remove();
			$('#summernote').summernote("code", "");
		});
	};