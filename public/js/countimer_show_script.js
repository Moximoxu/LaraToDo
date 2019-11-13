/**
 * 
 * copyright 2019, Mohd Ikhmal Hafiq Zubir.
 * email: ikhmal.zubir@gmail.com
 * license: Your chosen license, or link to a license file.
 * @class plugin.countimer
 *
 * Countimer Plugin
*/
$(document).ready(function() {
	//Set the title
	var title = document.getElementById("title_show").innerHTML;
	console.log("Successfully set title");
	console.log("Current title is " + title);
	
	//Insert into variable for calculation
	var countDown = document.getElementById("c_countDown").innerHTML;
	console.log("Successfully fetched set time");
	
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
	  var countimer = document.getElementById("timer");
	  document.getElementById("c_title").innerHTML = title;
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


	$(document).on("click", "button.delete", function(){
		var dataId = $(this).data("id");

		$.ajax({
		headers: {
	        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	    },
		url: "/summernote/" + dataId,
		type:"DELETE",
		success:function(){
	          window.location.href='editor';
		}
		});
		console.log("Ajax 'delete' successful");
	});
});