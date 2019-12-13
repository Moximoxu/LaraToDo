/**
 *
 * copyright 2019, Mohd Ikhmal Hafiq Zubir.
 * email: ikhmal.zubir@gmail.com
 * license: Your chosen license, or link to a license file.
 * @class plugin.countimer
 *
 * Countimer Plugin
*/

// Starts all of the timer(s) present in the content
function startTimer(i) {

	//Set the title
	var title = document.getElementById("title_show" + i).innerHTML;
	// console.log("Successfully set title");

	//Insert into variable for calculation
	var countDown = document.getElementById("c_countDown" + i).innerHTML;
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

  document.getElementById("c_title" + i).innerHTML = title;
  document.getElementById("c_days" + i).innerHTML = days;
  document.getElementById("c_hours" + i).innerHTML = hours;
  document.getElementById("c_minutes" + i).innerHTML = minutes;
  document.getElementById("c_seconds" + i).innerHTML = seconds;

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
	  document.getElementById("c_title" + i).innerHTML = title;
	  document.getElementById("c_days" + i).innerHTML = days;
	  document.getElementById("c_hours" + i).innerHTML = hours;
	  document.getElementById("c_minutes" + i).innerHTML = minutes;
	  document.getElementById("c_seconds" + i).innerHTML = seconds;

	  //If the count down is over, write some text
	  if (distance < 0) {
			document.getElementById("c_title" + i).innerHTML = "EXPIRED";
			document.getElementById("c_days" + i).innerHTML = "0";
			document.getElementById("c_hours" + i).innerHTML = "0";
			document.getElementById("c_minutes" + i).innerHTML = "0";
			document.getElementById("c_seconds" + i).innerHTML = "0";
	  }

	  // console.log("Counting down time");
	}, 1000);

	// console.log("Current value of i = " + i);

// }

};

$(document).ready(function() {

  //Fetch number of timers present
  var num_of_timers = document.getElementsByClassName("col timer").length;
  console.log("Number of col timer is = " + num_of_timers);

  // Loop for running the timer(s) in the content where the function startTimer() runs in accordance to number of timers
  for(var i=1; i <= num_of_timers; i++){
    startTimer(i);
  }

  // Button that deletes the currently displayed content
  $(document).on("click", "a.delete", function(){
		var dataId = $(this).data("id");
    var url_editor = "http://laratodo.test/editor";

		$.ajax({
		headers: {
	        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	    },
		url: "/summernote/" + dataId,
		type:"DELETE",
		success:function(){
	        window.location.assign(url_editor)
		}
		});
		// console.log("Ajax 'delete' successful");
	});
});
