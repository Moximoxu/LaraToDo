/**
 *
 * copyright 2019, Mohd Ikhmal Hafiq Zubir.
 * email: ikhmal.zubir@gmail.com
 * license: -
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
   		'countimer' : function summernote_countimer_setTimer(context) {
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

      $.extend($.summernote.options, {
          countimer: {
            modalVer : 'bs4'
          }
        });

   			//Context for button in plugin toolbar
   			context.memo('button.countimer', function () {
   				var button = ui.button({
   					contents: '<i id="summernote_countimer_clock" class="fa fa-clock-o" aria-hidden="true"></i>',
   					tooltip: 'Insert Countimer',

   					//HTML that will be inserted into editor
   					click: function () {
   						$counter = '<div class="col summernote_countimer_timer" id="summernote_countimer_timerDiv">'+
              '<p id="summernote_countimer_timerNum" class="summernote_countimer_timerNum" style="display:none"></p>'+
   						'		<div class="row summernote_countimer_timer"><a id="summernote_countimer_btn_deleteTimer" class="summernote_countimer_close_timer" style="float:left"><i class="far fa-times-circle"></i></a>'+
   						'			<div class="col-sm-8 mx-2"><h1 class="text-center summernote_countimer_label_title" id="summernote_countimer_label_title">Title</h1></div>'+
   						'			<p id="summernote_countimer_titleShow" name="summernote_countimer_titleShow" style="display:none"></p>'+
   						'			<h3 id="summernote_countimer_countDown" style="display:none"></h3>'+
   						'		</div>'+
              '		<div class="row summernote_countimer_timer">'+
              '			<div class="col-sm-2"><h1 class="text-center summernote_countimer_value_days" id="summernote_countimer_days"></h1></div>'+
              '			<div class="col-sm-2"><h1 class="text-center summernote_countimer_value_hours" id="summernote_countimer_hours"></h1></div>'+
              '			<div class="col-sm-2"><h1 class="text-center summernote_countimer_value_minutes" id="summernote_countimer_minutes"></h1></div>'+
              '			<div class="col-sm-2"><h1 class="text-center summernote_countimer_value_seconds" id="summernote_countimer_seconds" style="color:red;"></h1></div>'+
              '		</div>'+
   						'		<div class="row summernote_countimer_timer">'+
   						'			<div class="col-sm-2"><h4 id="summernote_countimer_days_label" class="text-center summernote_countimer_label_days">Days</h4></div>'+
   						'			<div class="col-sm-2"><h4 id="summernote_countimer_hours_label" class="text-center summernote_countimer_label_hours">Hours</h4></div>'+
   						'			<div class="col-sm-2"><h4 id="summernote_countimer_minutes_label" class="text-center summernote_countimer_label_minutes">Minutes</h4></div>'+
   						'			<div class="col-sm-2"><h4 id="summernote_countimer_seconds_label" class="text-center summernote_countimer_label_seconds" style="color:red;">Seconds</h4></div>'+
   						'		</div>'+
     					'</div'+
     					'</div>';

              //Paste countimer into editor
   						context.invoke('editor.pasteHTML', $counter);

              clicks++;
              // console.log("Current number of clicks are = " + clicks);

   						//Automatically opens the modal once the button is pressed
              summernote_countimer_clearSelection(); // For clearing anything that is highlighted

              var options = context.options;

              // Choose between modal in BootStrap version 4 or version 3
              if(options.countimer.modalVer == 'bs4') {
                $("#summernote_countimer_setTimer_Modalbs3").remove();
                $('#summernote_countimer_setTimer_Modal').modal('show');
              }
              else if(options.countimer.modalVer == 'bs3'){
                $("#summernote_countimer_setTimer_Modalbs4").remove();
                $('#summernote_countimer_setTimer_Modal').modal('show');
              }
              else {
                $("#summernote_countimer_setTimer_Modalbs3").remove();
                $('#summernote_countimer_setTimer_Modal').modal('show');
              }

              // Remove timer when cancel button was pressed
              $("#summernote_countimer_close_modal").click(function(){
                $("#summernote_countimer_timerDiv").remove();
                summernote_countimer_resetTimerModal();
                $('#summernote_countimer_styliseTimer_check').prop('checked', false);
              });

              // Deletes timer when remove button was pressed
              $("#summernote_countimer_btn_deleteTimer").click(function(){
                $("#summernote_countimer_timerDiv").remove();
              });

              $("#summernote_countimer_modalFooter").tooltip('show');

              $('[data-toggle="tooltip"]').tooltip();

              $("#summernote_countimer_dateIn").change(function() {
                  summernote_countimer_undisableButton();
              });

   					}
   				});
   				//Render button
   				this.countimer = button.render();
   				return this.countimer;
   			});
   		}
   	});
   }));

// Clears any currently highlighted text which allows the modal to be interactable
function summernote_countimer_clearSelection(){
 if(document.selection && document.selection.empty) {
       document.selection.empty();
   }
   else if(window.getSelection) {
       var sel = window.getSelection();
       sel.removeAllRanges();
   }
};

// Sets the timer and runs the timer immediately
function summernote_countimer_setTimer() {
  $("#summernote_countimer_setTimer_Modal").modal('hide'); // Close the modal
  $('#summernote_countimer_styliseTimer_check').prop('checked', false);

  clicks = document.getElementsByClassName("col summernote_countimer_timer").length;
  console.log(clicks);
  // console.log("Current number of clicks are = " + clicks);
  // console.log("Current value of i is = " + i);

    //Loop for detecting multiple timers
    var i = 1;
    for(var j=1; j <= clicks; j++){
     // console.log("Current number of clicks are = " + clicks);

     if(i == clicks){
         // Assign input elements based on ID
         var summernote_countimer_titleIn = document.getElementById('summernote_countimer_titleIn');
         // console.log(c_title_in.value);
         var summernote_countimer_dateIn = document.getElementById('summernote_countimer_dateIn');
         var summernote_countimer_hourIn = document.getElementById('summernote_countimer_hourIn');
         var summernote_countimer_minuteIn = document.getElementById('summernote_countimer_minuteIn');
         var summernote_countimer_secondIn = document.getElementById('summernote_countimer_secondIn');
         var summernote_countimer_styleTimer_bgColor = document.getElementById('summernote_countimer_styleTimer_bgColor');
         var summernote_countimer_styleTimer_border = document.getElementById('summernote_countimer_styleTimer_border');

         $("#summernote_countimer_btn_deleteTimer").attr("data-id", i);
         $("#summernote_countimer_btn_deleteTimer").attr("id", "summernote_countimer_btn_deleteTimer" + i);
         console.log(document.getElementById("summernote_countimer_btn_deleteTimer" + i));
         $("#summernote_countimer_btn_deleteTimer" + i).click(function(){
           var data_id = $(this).data("id");
           console.log("Data id of this button is = " + data_id);
           var summernote_countimer_timerDiv = document.getElementById("summernote_countimer_timerDiv" + data_id);
           $(summernote_countimer_timerDiv).remove();
         });

         $("#summernote_countimer_timerNum").attr("id", "summernote_countimer_timerNum" + i);
         var summernote_countimer_timerNum = document.getElementById('summernote_countimer_timerNum' + i);

         $('#summernote_countimer_countDown').attr('id', 'summernote_countimer_countDown' + i);
         var summernote_countimer_countDown = document.getElementById('summernote_countimer_countDown' + i);

         $('#summernote_countimer_timerDiv').attr('id', 'summernote_countimer_timerDiv' + i);
         $('#summernote_countimer_timerDiv').attr('data-id', i);
         var summernote_countimer_timerDiv = document.getElementById('summernote_countimer_timerDiv' + i);

         $('#summernote_countimer_label_title').attr('id', 'summernote_countimer_label_title' + i);
         var summernote_countimer_label_title = document.getElementById('summernote_countimer_label_title' + i);

         $('#summernote_countimer_titleShow').attr('id', 'summernote_countimer_titleShow' + i);
         var summernote_countimer_titleShow = document.getElementById('summernote_countimer_titleShow' + i);

         $('#summernote_countimer_days').attr('id', 'summernote_countimer_days' + i);
         var summernote_countimer_days = document.getElementById('summernote_countimer_days' + i);
         $('#summernote_countimer_days_label').attr('id', 'summernote_countimer_days_label' + i);
         var summernote_countimer_label_days = document.getElementById('summernote_countimer_days_label' + i);

         $('#summernote_countimer_hours').attr('id', 'summernote_countimer_hours' + i);
         var summernote_countimer_hours = document.getElementById('summernote_countimer_hours' + i);
         $('#summernote_countimer_hours_label').attr('id', 'summernote_countimer_hours_label' + i);
         var summernote_countimer_label_hours = document.getElementById('summernote_countimer_hours_label' + i);

         $('#summernote_countimer_minutes').attr('id', 'summernote_countimer_minutes' + i);
         var summernote_countimer_minutes = document.getElementById('summernote_countimer_minutes' + i);
         $('#summernote_countimer_minutes_label').attr('id', 'summernote_countimer_minutes_label' + i);
         var summernote_countimer_label_minutes = document.getElementById('summernote_countimer_minutes_label' + i);

         $('#summernote_countimer_seconds').attr('id', 'summernote_countimer_seconds' + i);
         var summernote_countimer_seconds = document.getElementById('summernote_countimer_seconds' + i);
         $('#summernote_countimer_seconds_label').attr('id', 'summernote_countimer_seconds_label' + i);
         var summernote_countimer_label_seconds = document.getElementById('summernote_countimer_seconds_label' + i);

         //Set the title
         var title = summernote_countimer_titleIn.value;

         summernote_countimer_timerNum.innerHTML = i;
         summernote_countimer_timerNum.value = i;
         // console.log("Successfully set title");
         // console.log(title);
         summernote_countimer_titleShow.value = title;
         summernote_countimer_titleShow.innerHTML = title;

         //Set date of the endpoint
         var countDownDate = new Date(summernote_countimer_dateIn.value);

         //Set hour of the endpoint
         countDownDate.setHours(summernote_countimer_hourIn.value);

         //Set minute of the endpoint
         countDownDate.setMinutes(summernote_countimer_minuteIn.value);

         //Set second of the endpoint
         countDownDate.setSeconds(summernote_countimer_secondIn.value);

         //Insert into variable for calculation
         var countDown = countDownDate.getTime();
         // console.log("Successfully fetched set time which is " + countDown);
         summernote_countimer_countDown.innerHTML = countDown;
         // console.log(c_countDown.innerHTML);

         var summernote_countimer_btn_deleteTimer = document.getElementById("summernote_countimer_btn_deleteTimer" + i);

         // Set style of timer
         summernote_countimer_timerDiv.style.backgroundColor = summernote_countimer_styleTimer_bgColor.value;
         summernote_countimer_label_title.style.color = summernote_countimer_styleTimer_titleColor.value;
         summernote_countimer_btn_deleteTimer.style.color = summernote_countimer_styleTimer_titleColor.value;

         summernote_countimer_days.style.color = summernote_countimer_styleTimer_numbersColor.value;
         summernote_countimer_label_days.style.color = summernote_countimer_styleTimer_numbersColor.value;

         summernote_countimer_hours.style.color = summernote_countimer_styleTimer_numbersColor.value;
         summernote_countimer_label_hours.style.color = summernote_countimer_styleTimer_numbersColor.value;

         summernote_countimer_minutes.style.color = summernote_countimer_styleTimer_numbersColor.value;
         summernote_countimer_label_minutes.style.color = summernote_countimer_styleTimer_numbersColor.value;

         summernote_countimer_seconds.style.color = summernote_countimer_styleTimer_secondsColor.value;
         summernote_countimer_label_seconds.style.color = summernote_countimer_styleTimer_secondsColor.value;

         summernote_countimer_timerDiv.style.border = summernote_countimer_styleTimer_border.value + "px ";
         summernote_countimer_timerDiv.style.borderStyle = summernote_countimer_styleTimer_borderStyle.value;
         summernote_countimer_timerDiv.style.borderRadius = summernote_countimer_styleTimer_borderRadius.value + "px";
         summernote_countimer_timerDiv.style.borderColor = summernote_countimer_styleTimer_borderColor.value;

         // Reset timer modal
         document.getElementById("summernote_countimer_form").reset();

         // Rehide the optional attributes
         summernote_countimer_titleIn_div.style.display = "none";
         summernote_countimer_styleTimer_container.style.display = "none";

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
           summernote_countimer_label_title.innerHTML = title;
           summernote_countimer_label_title.value = title;
           summernote_countimer_days.innerHTML = days;
           summernote_countimer_hours.innerHTML = hours;
           summernote_countimer_minutes.innerHTML = minutes;
           summernote_countimer_seconds.innerHTML = seconds;

           //If the count down is over, write some text
           if (distance < 0) {
             summernote_countimer_label_title.innerHTML = "EXPIRED";
             summernote_countimer_days.innerHTML = "0";
             summernote_countimer_hours.innerHTML = "0";
             summernote_countimer_minutes.innerHTML = "0";
             summernote_countimer_seconds.innerHTML = "0";
           }

         // console.log("Counting down time");
         }, 1000);
         summernote_countimer_resetTimerModal(); // Resets modal and preview
     }
     i++;
    }

};

// Starts the timers that are present in the editor
function summernote_countimer_startTimer(i) {

  // Set delete Button
  $("#summernote_countimer_btn_deleteTimer" + i).click(function() {
    var data_id = $(this).data("id");
    console.log("Data id of this button is = " + data_id);
    var summernote_countimer_timerDiv = document.getElementById("summernote_countimer_timerDiv" + data_id);
    $(summernote_countimer_timerDiv).remove();
  });

  //Set the title
  var title = document.getElementById("summernote_countimer_titleShow" + i).innerHTML;
  // console.log("Successfully set title");

  //Insert into variable for calculation
  var countDown = document.getElementById("summernote_countimer_countDown" + i).innerHTML;
  // console.log("Successfully fetched set time");
  // console.log(countDown);

  //Get today's date and time
  var now = new Date().getTime();

  //Find the distance between now and the count down date
  var distance = countDown - now;

  //Time calculations for days, hours, minutes and seconds
  var days = Math.floor(distance / (1000 * 60 * 60 * 24));
  var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
  var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
  var seconds = Math.floor((distance % (1000 * 60)) / 1000);

  //Output the result into each element
  // console.log("Current title is " + title);
  document.getElementById("summernote_countimer_label_title" + i).innerHTML = title;
  document.getElementById("summernote_countimer_days" + i).innerHTML = days;
  document.getElementById("summernote_countimer_hours" + i).innerHTML = hours;
  document.getElementById("summernote_countimer_minutes" + i).innerHTML = minutes;
  document.getElementById("summernote_countimer_seconds" + i).innerHTML = seconds;

  //Update the count down every 1 second
  var x = setInterval(function() {

    //Get today's date and time
    now = new Date().getTime();

    //Find the distance between now and the count down date
    distance = countDown - now;

    //Time calculations for days, hours, minutes and seconds
    days = Math.floor(distance / (1000 * 60 * 60 * 24));
    hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    seconds = Math.floor((distance % (1000 * 60)) / 1000);

    //Output the result into each element
    document.getElementById("summernote_countimer_label_title" + i).innerHTML = title;
    document.getElementById("summernote_countimer_days" + i).innerHTML = days;
    document.getElementById("summernote_countimer_hours" + i).innerHTML = hours;
    document.getElementById("summernote_countimer_minutes" + i).innerHTML = minutes;
    document.getElementById("summernote_countimer_seconds" + i).innerHTML = seconds;

    //If the count down is over, write some text
    if (distance < 0) {
    	document.getElementById("summernote_countimer_label_title" + i).innerHTML = "EXPIRED";
    	document.getElementById("summernote_countimer_days" + i).innerHTML = "0";
    	document.getElementById("summernote_countimer_hours" + i).innerHTML = "0";
    	document.getElementById("summernote_countimer_minutes" + i).innerHTML = "0";
    	document.getElementById("summernote_countimer_seconds" + i).innerHTML = "0";
    }

    // console.log("Counting down time");
  }, 1000);

  // console.log("Current value of i = " + i);

};

// Reset all inputs and preview in modal
function summernote_countimer_resetTimerModal(){
  document.getElementById("summernote_countimer_btn_setTimer").disabled = true; // Redisable button

  summernote_countimer_styleTimer_bgColor.value = "#ffffff";
  summernote_countimer_styleTimer_titleColor.value = "#000000";
  summernote_countimer_styleTimer_numbersColor.value = "#000000";
  summernote_countimer_styleTimer_secondsColor.value = "#ff0000";
  summernote_countimer_styleTimer_border.value = "";
  summernote_countimer_styleTimer_borderRadius.value = "";
  summernote_countimer_styleTimer_borderStyle.value = "";
  summernote_countimer_styleTimer_borderColor.value = "";

  summernote_countimer_previewTimer_div.style.backgroundColor = "#ffffff";
  summernote_countimer_previewTimer_title.style.color = "#000000";
  summernote_countimer_previewTimer_seconds.style.color = "#ff0000";
  summernote_countimer_previewLabel_seconds.style.color = "#ff0000";
  summernote_countimer_previewTimer_div.style.borderStyle = "#000000";
  summernote_countimer_previewTimer_div.style.borderWidth = "0px";
  summernote_countimer_previewTimer_div.style.borderRadius = "0px";
  summernote_countimer_previewTimer_div.style.borderColor = "#000000";

  summernote_countimer_previewTimer_days.style.color = "#000000";
  summernote_countimer_previewTimer_hours.style.color = "#000000";
  summernote_countimer_previewTimer_minutes.style.color = "#000000";

  summernote_countimer_previewLabel_days.style.color = "#000000";
  summernote_countimer_previewLabel_hours.style.color = "#000000";
  summernote_countimer_previewLabel_minutes.style.color = "#000000";
};

function summernote_countimer_undisableButton(){
  document.getElementById("summernote_countimer_btn_setTimer").disabled = false;
  $("#summernote_countimer_modalFooter").tooltip('destroy');
};

$(document).ready(function() {
  // Function for executing the function after a certain period of time
  setTimeout(function(){
    //Fetch number of timers present
    var summernote_countimer_timerNum = document.getElementsByClassName("summernote_countimer_timerNum");
    console.log(summernote_countimer_timerNum);

    // Loop for running the timer(s) in the content where the function startTimer() runs in accordance to number of timers
    for(var i=0; i < summernote_countimer_timerNum.length; i++){
      var data_id = summernote_countimer_timerNum[i].innerHTML;
      console.log("Data-id of this timer is = " + data_id);
      summernote_countimer_startTimer(data_id);
    }
  }, 100);

  var summernote_countimer_modalbs4 = '<div id="summernote_countimer_setTimer_Modalbs4">'+
  '<div id="summernote_countimer_setTimer_Modal" class="modal fade" role="dialog">'+
  '<div class="modal-dialog">'+
  '	<div class="modal-content">'+
  '		<div class="modal-header">'+
  '     <div class="row" style="width:100%">'+
  '       <div class="col-sm-10">'+
  '			    <h4 class="modal-title" id="summernote_countimer_modal_title">Set Countimer</h4>'+
  '       </div>'+
  '       <div class="col-sm-2">'+
  '			    <button type="button" id="summernote_countimer_close_modal" class="btn btn-light summernote_countimer_close_modal" data-dismiss="modal" style="float:right"><i class="far fa-times-circle"></i></button>'+
  '       </div>'+
  '     </div>'+
  '		</div>'+
  '		<div class="modal-body" id="summernote_countimer_modal_container">'+
  '   <form id="summernote_countimer_form">'+
  '     <div class="row form-group">'+
  '				<div class="col-sm-5 form-check-inline">'+
  '         <label class="form-check-label">'+
  '           <input type="checkbox" class="form-check-input" name="summernote_countimer_includeTitle_check" id="summernote_countimer_includeTitle_check">Include title'+
  '         </label>'+
  '				</div>'+
  '			</div>'+
  '			<div id="summernote_countimer_titleIn_div" class="row form-group" style="display:none">'+
  '				<div class="col-sm-5">'+
  '					<label for="summernote_countimer_titleIn">Title of Countdown</label>'+
  '				</div>'+
  '				<div class="col">'+
  '					<input type="text" class="w3-input w3-animate-input form-control" id="summernote_countimer_titleIn" style="width:30%" value="">'+
  '				</div>'+
  '			</div>'+
  '			<div class="row form-group">'+
  '				<div class="col-sm-5">'+
  '					<label for="summernote_countimer_dateIn">Countdown Date</label>'+
  '				</div>'+
  '				<div class="col">'+
  '					<input class="w3-input w3-animate-input form-control" type="date" id="summernote_countimer_dateIn" style="width:65%">'+
  '				</div>'+
  '			</div>'+
  '			<div class="row form-group">'+
  '				<div class="col-sm-5">'+
  '					<label for="summernote_countimer_hourIn">Hour</label>'+
  '				</div>'+
  '				<div class="col">'+
  '					<input class="w3-input w3-animate-input form-control" type="number" id="summernote_countimer_hourIn" required value="00" min="0" step="1" max="23" style="width:30%">'+
  '				</div>'+
  '			</div>'+
  '			<div class="row form-group">'+
  '				<div class="col-sm-5">'+
  '					<label for="summernote_countimer_minuteIn">Minute</label>'+
  '				</div>'+
  '				<div class="col">'+
  '					<input class="w3-input w3-animate-input form-control" type="number" id="summernote_countimer_minuteIn" required value="00" min="0" step="1" max="59" style="width:30%">'+
  '				</div>'+
  '			</div>'+
  '			<div class="row form-group">'+
  '				<div class="col-sm-5">'+
  '					<label for="summernote_countimer_secondIn">Second</label>'+
  '				</div>'+
  '				<div class="col">'+
  '					<input class="w3-input w3-animate-input form-control" type="number" id="summernote_countimer_secondIn" required value="00" min="0" step="1" max="59" style="width:30%">'+
  '				</div>'+
  '			</div>'+

  '     <div class="row form-group">'+
  '				<div class="col-sm-5 form-check-inline">'+
  '         <label class="form-check-label">'+
  '           <input type="checkbox" class="form-check-input" name="stylise_timer" id="summernote_countimer_styliseTimer_check">Stylise Timer'+
  '         </label>'+
  '				</div>'+
  '			</div>'+

  '   <div id="summernote_countimer_styleTimer_container" style="display:none">'+

  '   <fieldset>'+
  '    <legend id="summernote_countimer_styliseLegend">Stylise Timer</legend>'+

  '<div class="col" id="summernote_countimer_previewTimer_div">'+
  '		<div class="row">'+
  '			<div class="col-sm-8 mx-auto">'+
  '       <h1 id="summernote_countimer_previewTimer_title" class="text-center" style="color:#000000;">Title</h1>'+
  '     </div>'+
  '		</div>'+
  '		<div class="row">'+
  '			<div class="col-sm-2 mx-auto"><h1 id="summernote_countimer_previewTimer_days" class="text-center" style="color:#000000;">31</h1></div>'+
  '			<div class="col-sm-2 mx-auto"><h1 id="summernote_countimer_previewTimer_hours" class="text-center" style="color:#000000;">08</h1></div>'+
  '			<div class="col-sm-2 mx-auto"><h1 id="summernote_countimer_previewTimer_minutes" class="text-center" style="color:#000000;">19</h1></div>'+
  '			<div class="col-sm-2 mx-auto"><h1 id="summernote_countimer_previewTimer_seconds" class="text-center" style="color:red;">57</h1></div>'+
  '		</div>'+
  '		<div class="row">'+
  '			<div class="col-sm-2 mx-auto"><h4 id="summernote_countimer_previewLabel_days" class="text-center" style="color:#000000;">Days</h4></div>'+
  '			<div class="col-sm-2 mx-auto"><h4 id="summernote_countimer_previewLabel_hours" class="text-center" style="color:#000000;">Hours</h4></div>'+
  '			<div class="col-sm-2 mx-auto"><h4 id="summernote_countimer_previewLabel_minutes" class="text-center" style="color:#000000;">Minutes</h4></div>'+
  '			<div class="col-sm-2 mx-auto"><h4 id="summernote_countimer_previewLabel_seconds" class="text-center" style="color:red;">Seconds</h4></div>'+
  '		</div>'+
  '</div><br>'+

  '     <div id="div_styleTimer_bgcolor" class="row form-group">'+
  '       <div class="col-sm-5">'+
  '         <label for="summernote_countimer_styleTimer_bgColor">Background Color</label>'+
  '       </div>'+
  '       <div class="col">'+
  '         <input type="color" id="summernote_countimer_styleTimer_bgColor" value="#ffffff">'+
  '       </div>'+
  '     </div>'+

  '     <div id="div_styleTimer_titlecolor" class="row form-group">'+
  '       <div class="col-sm-5">'+
  '         <label for="summernote_countimer_styleTimer_titleColor">Title Color</label>'+
  '       </div>'+
  '       <div class="col">'+
  '         <input type="color" id="summernote_countimer_styleTimer_titleColor" value="#000000">'+
  '       </div>'+
  '     </div>'+

  '     <div id="div_styleTimer_numberscolor" class="row form-group">'+
  '       <div class="col-sm-5">'+
  '         <label for="summernote_countimer_styleTimer_numbersColor">Numbers Color</label>'+
  '       </div>'+
  '       <div class="col">'+
  '         <input type="color" id="summernote_countimer_styleTimer_numbersColor" value="#000000">'+
  '       </div>'+
  '     </div>'+

  '     <div id="div_styleTimer_secondscolor" class="row form-group">'+
  '       <div class="col-sm-5">'+
  '         <label for="summernote_countimer_styleTimer_secondsColor">Seconds Color</label>'+
  '       </div>'+
  '       <div class="col">'+
  '         <input type="color" id="summernote_countimer_styleTimer_secondsColor" value="#ff0000">'+
  '       </div>'+
  '     </div>'+

  '     <div id="div_styleTimer_borderStyle" class="row form-group">'+
  '       <div class="col-sm-5">'+
  '         <label for="summernote_countimer_styleTimer_borderStyle">Border Style</label>'+
  '       </div>'+
  '       <div class="col">'+
  '         <select id="summernote_countimer_styleTimer_borderStyle">'+
  '           <option value="" selected="selected">None</option>'+
  '           <option value="solid">Solid</option>'+
  '           <option value="dotted">Dotted</option>'+
  '           <option value="dashed">Dashed</option>'+
  '           <option value="double">Double</option>'+
  '           <option value="groove">Groove</option>'+
  '           <option value="ridge">Ridge</option>'+
  '         </select>'+
  '       </div>'+
  '     </div>'+

  '     <div id="div_styleTimer_border" class="row form-group">'+
  '       <div class="col-sm-5">'+
  '         <label for="summernote_countimer_styleTimer_border">Border Width</label>'+
  '       </div>'+
  '       <div class="col">'+
  '         <input type="number" min="0" step="1" max="59" id="summernote_countimer_styleTimer_border"> px'+
  '       </div>'+
  '     </div>'+

  '     <div id="div_styleTimer_borderRadius" class="row form-group">'+
  '       <div class="col-sm-5">'+
  '         <label for="summernote_countimer_styleTimer_borderRadius">Border Radius</label>'+
  '       </div>'+
  '       <div class="col">'+
  '         <input type="number" min="0" step="1" max="59" id="summernote_countimer_styleTimer_borderRadius"> px'+
  '       </div>'+
  '     </div>'+

  '     <div id="div_styleTimer_bordercolor" class="row form-group">'+
  '       <div class="col-sm-5">'+
  '         <label for="summernote_countimer_styleTimer_borderColor">Border Color</label>'+
  '       </div>'+
  '       <div class="col">'+
  '         <input type="color" id="summernote_countimer_styleTimer_borderColor" value="#000000">'+
  '       </div>'+
  '     </div>'+

  '   </div>'+

  '	</div>'+

  ' </fieldset>'+

  '		  <div id="summernote_countimer_modalFooter" class="modal-footer" data-toggle="tooltip" title="Please choose a date" >'+
  '				<button type="submit" id="summernote_countimer_btn_setTimer" onclick="summernote_countimer_setTimer()" class="btn btn-info btn-block my-3" data-dismiss="modal" disabled>SET</button>'+
  '		  </div>'+
  '   </form>'+
  '	</div>'+
  '</div>'+
  '</div>'+
  '</div>';


  var summernote_countimer_modalbs3 = '<div id="summernote_countimer_setTimer_Modalbs3">'+
  '<div id="summernote_countimer_setTimer_Modal" class="modal fade" role="dialog">'+
  '	<div class="modal-dialog">'+
  '		<div class="modal-content">'+
  '			<div class="modal-header">'+
  '				<h4 class="modal-title" id="summernote_countimer_modal_title">Set Countimer</h4>'+
  '				<button type="button" id="summernote_countimer_close_modal" class="btn btn-light summernote_countimer_close_modal" data-dismiss="modal" style="float:right"><i class="fa fa-times-circle" aria-hidden="true"></i></button>'+
  '			</div>'+
  '			<div class="modal-body" id="summernote_countimer_modal_container">'+
  '   <form id="summernote_countimer_form">'+
  '       <div class="row form-group">'+
  '				 <div class="col-sm-5">'+
  '           <input type="checkbox" class="form-check-input" name="summernote_countimer_includeTitle_check" id="summernote_countimer_includeTitle_check"> Include title'+
  '				 </div>'+
  '			  </div>'+
  '				<div id="summernote_countimer_titleIn_div" class="row form-group" style="display:none">'+
  '					<div class="col-sm-5">'+
  '						<label for="summernote_countimer_titleIn">Title of Countdown</label>'+
  '					</div>'+
  '					<div class="col-sm-5">'+
  '						<input class="form-control" type="text" id="summernote_countimer_titleIn" placeholder="Insert a title" style="width:90%" value="">'+
  '					</div>'+
  '				</div>'+
  '				<div class="row form-group">'+
  '					<div class="col-sm-5">'+
  '						<label for="summernote_countimer_dateIn">Countdown Date</label>'+
  '					</div>'+
  '					<div class="col-sm-5">'+
  '						<input class="form-control" type="date" id="summernote_countimer_dateIn" style="width:80%">'+
  '					</div>'+
  '				</div>'+
  '				<div class="row form-group">'+
  '					<div class="col-sm-5">'+
  '						<label for="summernote_countimer_hourIn">Hour</label>'+
  '					</div>'+
  '					<div class="col-sm-5">'+
  '						<input class="form-control" type="number" id="summernote_countimer_hourIn" required value="00" min="0" step="1" max="23" style="width:30%">'+
  '					</div>'+
  '				</div>'+
  '				<div class="row form-group">'+
  '					<div class="col-sm-5">'+
  '						<label for="summernote_countimer_minuteIn">Minute</label>'+
  '					</div>'+
  '					<div class="col-sm-5">'+
  '						<input class="form-control" type="number" id="summernote_countimer_minuteIn" required value="00" min="0" step="1" max="59" style="width:30%">'+
  '					</div>'+
  '				</div>'+
  '				<div class="row form-group">'+
  '					<div class="col-sm-5">'+
  '						<label for="summernote_countimer_secondIn">Second</label>'+
  '					</div>'+
  '					<div class="col-sm-5">'+
  '						<input class="form-control" type="number" id="summernote_countimer_secondIn" required value="00" min="0" step="1" max="59" style="width:30%">'+
  '					</div>'+
  '				</div>'+

  '   <div id="summernote_countimer_styleTimer_container" style="display:none">'+

  '<div class="col" id="summernote_countimer_previewTimer_div">'+
  '		<div class="row">'+
  '			<div class="col-sm-8 mx-auto">'+
  '       <h1 id="summernote_countimer_previewTimer_title" class="text-center" style="color:#000000;">Title</h1>'+
  '     </div>'+
  '		</div>'+
  '		<div class="row">'+
  '			<div class="col-sm-2 mx-auto"><h1 id="summernote_countimer_previewTimer_days" class="text-center" style="color:#000000;">31</h1></div>'+
  '			<div class="col-sm-2 mx-auto"><h1 id="summernote_countimer_previewTimer_hours" class="text-center" style="color:#000000;">08</h1></div>'+
  '			<div class="col-sm-2 mx-auto"><h1 id="summernote_countimer_previewTimer_minutes" class="text-center" style="color:#000000;">19</h1></div>'+
  '			<div class="col-sm-2 mx-auto"><h1 id="summernote_countimer_previewTimer_seconds" class="text-center" style="color:red;">57</h1></div>'+
  '		</div>'+
  '		<div class="row">'+
  '			<div class="col-sm-2 mx-auto"><h4 id="summernote_countimer_previewLabel_days" class="text-center" style="color:#000000;">Days</h4></div>'+
  '			<div class="col-sm-2 mx-auto"><h4 id="summernote_countimer_previewLabel_hours" class="text-center" style="color:#000000;">Hours</h4></div>'+
  '			<div class="col-sm-2 mx-auto"><h4 id="summernote_countimer_previewLabel_minutes" class="text-center" style="color:#000000;">Minutes</h4></div>'+
  '			<div class="col-sm-2 mx-auto"><h4 id="summernote_countimer_previewLabel_seconds" class="text-center" style="color:red;">Seconds</h4></div>'+
  '		</div>'+
  '</div><br>'+

  '     <div id="div_styleTimer_bgcolor" class="row form-group">'+
  '       <div class="col-sm-5">'+
  '         <label for="summernote_countimer_styleTimer_bgColor">Background Color</label>'+
  '       </div>'+
  '       <div class="col">'+
  '         <input type="color" id="summernote_countimer_styleTimer_bgColor" value="#ffffff">'+
  '       </div>'+
  '     </div>'+

  '     <div id="div_styleTimer_titlecolor" class="row form-group">'+
  '       <div class="col-sm-5">'+
  '         <label for="summernote_countimer_styleTimer_titleColor">Title Color</label>'+
  '       </div>'+
  '       <div class="col">'+
  '         <input type="color" id="summernote_countimer_styleTimer_titleColor" value="#000000">'+
  '       </div>'+
  '     </div>'+

  '     <div id="div_styleTimer_numberscolor" class="row form-group">'+
  '       <div class="col-sm-5">'+
  '         <label for="summernote_countimer_styleTimer_numbersColor">Numbers Color</label>'+
  '       </div>'+
  '       <div class="col">'+
  '         <input type="color" id="summernote_countimer_styleTimer_numbersColor" value="#000000">'+
  '       </div>'+
  '     </div>'+

  '     <div id="div_styleTimer_secondscolor" class="row form-group">'+
  '       <div class="col-sm-5">'+
  '         <label for="summernote_countimer_styleTimer_secondsColor">Seconds Color</label>'+
  '       </div>'+
  '       <div class="col">'+
  '         <input type="color" id="summernote_countimer_styleTimer_secondsColor" value="#ff0000">'+
  '       </div>'+
  '     </div>'+

  '     <div id="div_styleTimer_borderStyle" class="row form-group">'+
  '       <div class="col-sm-5">'+
  '         <label for="summernote_countimer_styleTimer_borderStyle">Border Style</label>'+
  '       </div>'+
  '       <div class="col">'+
  '         <select id="summernote_countimer_styleTimer_borderStyle">'+
  '           <option value="" selected="selected">None</option>'+
  '           <option value="solid">Solid</option>'+
  '           <option value="dotted">Dotted</option>'+
  '           <option value="dashed">Dashed</option>'+
  '           <option value="double">Double</option>'+
  '           <option value="groove">Groove</option>'+
  '           <option value="ridge">Ridge</option>'+
  '         </select>'+
  '       </div>'+
  '     </div>'+

  '     <div id="div_styleTimer_border" class="row form-group">'+
  '       <div class="col-sm-5">'+
  '         <label for="summernote_countimer_styleTimer_border">Border Width</label>'+
  '       </div>'+
  '       <div class="col">'+
  '         <input type="number" min="0" step="1" max="59" id="summernote_countimer_styleTimer_border"> px'+
  '       </div>'+
  '     </div>'+

  '     <div id="div_styleTimer_borderRadius" class="row form-group">'+
  '       <div class="col-sm-5">'+
  '         <label for="summernote_countimer_styleTimer_borderRadius">Border Radius</label>'+
  '       </div>'+
  '       <div class="col">'+
  '         <input type="number" min="0" step="1" max="59" id="summernote_countimer_styleTimer_borderRadius"> px'+
  '       </div>'+
  '     </div>'+

  '     <div id="div_styleTimer_bordercolor" class="row form-group">'+
  '       <div class="col-sm-5">'+
  '         <label for="summernote_countimer_styleTimer_borderColor">Border Color</label>'+
  '       </div>'+
  '       <div class="col">'+
  '         <input type="color" id="summernote_countimer_styleTimer_borderColor" value="#000000">'+
  '       </div>'+
  '     </div>'+

  '   </div>'+
  '			  <div id="summernote_countimer_modalFooter" class="modal-footer" data-toggle="tooltip" title="Please choose a date">'+
  '					<button type="submit" id="summernote_countimer_btn_setTimer" onclick="summernote_countimer_setTimer()" class="btn btn-info btn-block my-3" data-dismiss="modal" disabled>SET</button>'+
  '			  </div>'+
  '   </form>'+
  '		</div>'+
  '	</div>'+
  '</div>'+
  '</div>';

  $("body").append(summernote_countimer_modalbs4);
  $("body").append(summernote_countimer_modalbs3);

  var confirm = document.getElementById("summernote_countimer_dateIn");
   confirm.addEventListener("keyup", function(event) {
     if (event.keyCode === 13) {
      event.preventDefault();
      document.getElementById("summernote_countimer_btn_setTimer").click();
     }
   });

  $('input[name="summernote_countimer_includeTitle_check"]').click(function(){
    var title_div = document.getElementById("summernote_countimer_titleIn_div");

      if($(this).prop("checked") == true){
          title_div.style.display = "";
      }
      else if($(this).prop("checked") == false){
          title_div.style.display = "none";
          summernote_countimer_titleIn.value = "";
      }
  });

  $('#summernote_countimer_styliseTimer_check').click(function(){

      if($(this).prop("checked") == true){
          summernote_countimer_styleTimer_container.style.display = "";
      }
      else if($(this).prop("checked") == false){
          summernote_countimer_styleTimer_container.style.display = "none";
          summernote_countimer_resetTimerModal();
      }
  });

  $( "#summernote_countimer_styleTimer_bgColor").change(function() {
    summernote_countimer_previewTimer_div.style.backgroundColor = summernote_countimer_styleTimer_bgColor.value;
  });

  $( "#summernote_countimer_styleTimer_titleColor").change(function() {
    summernote_countimer_previewTimer_title.style.color = summernote_countimer_styleTimer_titleColor.value;
  });

  $( "#summernote_countimer_styleTimer_numbersColor").change(function() {
    summernote_countimer_previewTimer_days.style.color = summernote_countimer_styleTimer_numbersColor.value;
    summernote_countimer_previewTimer_hours.style.color = summernote_countimer_styleTimer_numbersColor.value;
    summernote_countimer_previewTimer_minutes.style.color = summernote_countimer_styleTimer_numbersColor.value;

    summernote_countimer_previewLabel_days.style.color = summernote_countimer_styleTimer_numbersColor.value;
    summernote_countimer_previewLabel_hours.style.color = summernote_countimer_styleTimer_numbersColor.value;
    summernote_countimer_previewLabel_minutes.style.color = summernote_countimer_styleTimer_numbersColor.value;
  });

  $( "#summernote_countimer_styleTimer_secondsColor").change(function() {
    summernote_countimer_previewTimer_seconds.style.color = summernote_countimer_styleTimer_secondsColor.value;
    summernote_countimer_previewLabel_seconds.style.color = summernote_countimer_styleTimer_secondsColor.value;
  });

  $( "#summernote_countimer_styleTimer_borderStyle").click(function() {
    summernote_countimer_previewTimer_div.style.borderStyle = summernote_countimer_styleTimer_borderStyle.value;
  });

  $( "#summernote_countimer_styleTimer_border").click(function() {
    summernote_countimer_previewTimer_div.style.borderWidth = summernote_countimer_styleTimer_border.value + "px";
  });

  $( "#summernote_countimer_styleTimer_borderRadius").click(function() {
    summernote_countimer_previewTimer_div.style.borderRadius = summernote_countimer_styleTimer_borderRadius.value + "px";
  });

  $( "#summernote_countimer_styleTimer_borderColor").change(function() {
    summernote_countimer_previewTimer_div.style.borderColor = summernote_countimer_styleTimer_borderColor.value;
  });

});
