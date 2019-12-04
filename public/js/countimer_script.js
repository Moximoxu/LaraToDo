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
   						$counter = '<div class="col timer" id="timer_div">'+
   						'<div class="container my-3 mx-3">'+
   						'		<div class="row">'+
   						'			<div class="col-sm-4 mx-2"><h2 class="text-center" id="c_title">Title</h2></div>'+
   						'			<p id="title_show" name="title_show" style="display:none"></p>'+
   						'			<h3 id="c_countDown" style="display:none"></h3>'+
   						'		</div>'+
   						'		<div class="row">'+
   						'			<div class="col-sm-1"><h3 class="text-center">Days</h3></div>'+
   						'			<div class="col-sm-1"><h3 class="text-center">Hours</h3></div>'+
   						'			<div class="col-sm-1"><h3 class="text-center">Minutes</h3></div>'+
   						'			<div class="col-sm-1"><h3 class="text-center">Seconds</h3></div>'+
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

              clicks++;
              console.log("Current number of clicks are = " + clicks);

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

 function setDate() {
   //Close the modal
   $("#setModal.close").click();

   //Variable for number of timers present in the editor
   var num_of_timers = $(".timer_div").length;

   console.log("Current number of clicks are = " + clicks);
   console.log("Current value of i is = " + i);

   //Loop for detecting multiple timers
   var i = 1;

   for(var j=1; j <= clicks; j++){
     console.log("Current number of clicks are = " + clicks);

     if(i == clicks){
         //Assign input elements based on ID
         var c_title_in = document.getElementById('c_title_in');
         console.log(c_title_in.value);
         var c_date = document.getElementById('c_date');
         var c_hour = document.getElementById('c_hour');
         var c_minute = document.getElementById('c_minute');
         var c_second = document.getElementById('c_second');

         $('#c_countDown').attr('id', 'c_countDown' + i);
         var c_countDown = document.getElementById('c_countDown' + i);

         $('#timer_div').attr('id', 'timer_div' + i);
         var timer_div = document.getElementById('timer_div' + i);

         $('#c_title').attr('id', 'c_title' + i);
         var c_title = document.getElementById('c_title' + i);

         $('#title_show').attr('id', 'title_show' + i);
         var title_show = document.getElementById('title_show' + i);

         $('#c_days').attr('id', 'c_days' + i);
         var c_days = document.getElementById('c_days' + i);

         $('#c_hours').attr('id', 'c_hours' + i);
         var c_hours = document.getElementById('c_hours' + i);

         $('#c_minutes').attr('id', 'c_minutes' + i);
         var c_minutes = document.getElementById('c_minutes' + i);

         $('#c_seconds').attr('id', 'c_seconds' + i);
         var c_seconds = document.getElementById('c_seconds' + i);

         //Set the title
         var title = c_title_in.value;
         // console.log("Successfully set title");
         // console.log(title);
         title_show.value = title;
         title_show.innerHTML = title;

         //Set date of the endpoint
         var countDownDate = new Date(c_date.value);

         //Set hour of the endpoint
         countDownDate.setHours(c_hour.value);

         //Set minute of the endpoint
         countDownDate.setMinutes(c_minute.value);

         //Set second of the endpoint
         countDownDate.setSeconds(c_second.value);

         //Insert into variable for calculation
         var countDown = countDownDate.getTime();
         // console.log("Successfully fetched set time which is " + countDown);
         c_countDown.innerHTML = countDown;
         // console.log(c_countDown.innerHTML);

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
           c_title.innerHTML = title;
           c_title.value = title

           c_days.innerHTML = days;
           c_hours.innerHTML = hours;
           c_minutes.innerHTML = minutes;
           c_seconds.innerHTML = seconds;

           //If the count down is over, write some text
           if (distance < 0) {
             c_title.innerHTML = "EXPIRED";
             c_days.innerHTML = "0";
             c_hours.innerHTML = "0";
             c_minutes.innerHTML = "0";
             c_seconds.innerHTML = "0";
           }

         // console.log("Counting down time");
         }, 1000);

         //Enters a whitespace into summernote editor
         $('#summernote').summernote('insertText', '');

     }
     i++;
   }

 };
