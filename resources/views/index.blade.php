<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	<title>LaraToDo</title>
	<meta charset="utf-8">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<meta name="viewport" content="width=device-width, intial-scale=1">

	<!--Link-->
	<link rel="stylesheet" 
		href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
	<link rel='stylesheet' 
		href='https://use.fontawesome.com/releases/v5.7.0/css/all.css' integrity='sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ' crossorigin='anonymous'>
	<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
	
	<!--Script sources-->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
	<script src="https://jqueryvalidation.org/files/lib/jquery.js"></script>
	<script src="https://jqueryvalidation.org/files/dist/jquery.validate.js"></script>
	<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
	<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
	<script src="https://code.jquery.com/jquery-1.12.4.js"></script>

	<!--Stylesheet-->
	<style>
		#navLogo {
			font-family:Georgia;
			font-size:40px;
		}
		
		body{
			background-color:#aeeaae;
		}
	
		.card{
			background-color:#d6f5d6;
			margin: 0 auto;
        	float: none;
        	margin-bottom: 30px;
			width:100%;
			max-width:600px;
			padding:20px;
			border-radius:5px;
			box-shadow:20px 20px 0 rgba(0, 0, 0, .1);
			box-sizing:border-box;
		}

		.topbtns{
			position: absolute;
            right: 10px;
            top: 18px;
		}
		
		.tasks{
			margin:0;
			padding:0;
		}
		
		.tasks li:hover .done_bttn{
			opacity:1;
		}
		
		.tasks li, task-add input{
			border:0;
			border-bottom:1px dashed #ccc;
			padding:15px 0;
		}
		
		.input{
			width:100%;
		}
		
		.buttontd {
			width:200px;
			text-align: center;
		}

		.done_bttn{
			display:inline-block;
			background-color:#85e085;
			color:#e67300;
			padding:3px 6px;
			border:0;
			opacity:0.5;
		}
		
		.Submit{
			padding:5px 10px;
			width:100%;
			margin-top; 10px;
			box-shadow: 3px 3px 0 #ddd;
		}
		.tdone, number.tdone{
			text-decoration:line-through;
			color: rgba(0, 0, 0, 0.25);
		}
		.tundone{
			text-decoration:none;
		}
		
	</style>
	
	<nav class="navbar navbar-expand-sm navbar-dark" style="background-color:#33cc33">
		<ul class="navbar-nav">
			<li class="nav-item">
				<a class="nav-link text-white" id="navLogo" href="{{ url('/') }}"><b>LaraToDo</b></a>
			</li>
			<li class="nav-item" style="margin-top:30px">
				<a class="nav-link" style="font-family:Georgia;font-size:14px;">To-Do Web Application</a>
			</li>
		</ul>
		<div class="topbtns">
			<button type="button" class="btn btn-warning" id="btnedit" onclick="location.href='{{ url('/edit') }}'"><i class="fas fa-user-edit"></i></button>
			<button type="button" class="btn btn-danger" id="btnlogout" onclick="location.href='{{ url('/logout') }}'"><i class="fas fa-door-open"></i></button>
		</div>
	</nav>
	
</head>

<body>
	<div class="row">
		<div class="col-lg-12">
			<div class="card my-3">
				<div class="card-header">
					<h2 class="header">{{Auth::user()->name}}'s Tasks</h2>
				</div>
				<form class="form-action" method="post" id="add_task">
					{{ csrf_field() }}
					<input type="text" id="addtasktxt" name="name" class="form-control" autocomplete="off" placeholder="Please enter your task" required>
					<button type="submit" class="Submit btn btn-info" id="btnAdd">Add</button>
				</form>
				<div class="card-body" id="tasklist">
					<table class='table-striped table-hover' id='tasktable'>
						<thead style='text-align:center'>
							<tr><th>No.</th><th>Task</th><th>Actions</th>
						</thead>
						<tbody id='tasks_name'>

						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="taskModal">
		<div class="modal-dialog">
			<div class="modal-content">

				<!-- Modal Header -->
				<div class="modal-header">
					<h4 class="modal-title" id="modaltitle">Edit task</h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>

				<!-- Modal body -->
				<div class="modal-body">
					<input type="text" class="form-control" id="editTasktxt" placeholder="Please enter a task">
					<p id="modalmessage" style="display:none"></p>
				</div>

				<!-- Modal footer -->
				<div class="modal-footer">
					<button type="button" class="btn btn-info" id="btnok" style="display:none" data-dismiss="modal">Okay</button>
					<button type="button" class="btn btn-primary save" id="btnsavechanges"><i class="fas fa-save"></i></button>
					<button type="button" class="btn btn-danger confirm" id="btnconfirm" style="display:none">Yes</button>
					<button type="button" class="btn btn-info cancel" id="btncancel" style="display:none" data-dismiss="modal">Cancel</button>
				</div>

			</div>
		</div>
	</div>
	
<script>
	$(document).ready(function(){
		fetch();

		function fetch(){
			var displaytasks = $("#tasks_name");
			var userid = {{Auth::user()->id}}
			
			$.ajax({
				headers: {
        		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        		},
				type:"GET",
				url:"/tasks/",
				dataType: "json",
				success: function(result){
					var output, count = 1;
					for (var i in result) {
						if (result[i].done == 0){output +=
							"<tr class='listoftasks' data-id='" + result[i].id + "' id='tasktr" + result[i].id + "'><td class='number' id='number" + result[i].id + "'><span class='"+count+"'></span>"+
							"</td><td id='tasktxt" + result[i].id + "'>" +
							result[i].name + 
							"</td><td class='buttontd'><button type='submit' class='btn btn-light done' id='btndone" + result[i].id + "' data-id='" + result[i].id + "'><i class='far fa-square'></i></button>"+
							"<button type='submit' class='btn btn-dark undone' id='btnundone" + result[i].id + "' data-id='" + result[i].id + "' style='display:none'><i class='fas fa-check-square'></i></button>" +
							"<button type='button' class='btn btn-success edit' data-toggle='modal' data-target='#taskModal' data-id='" + result[i].id + "'><i class='far fa-edit'></i></button>" +
							"<button type='button' class='btn btn-danger delete' id='btndelete' data-id='" + result[i].id + "' data-toggle='modal' data-target='#taskModal' ><i class='fas fa-trash-alt'></i></button>"+
							"</td></tr>";
						}	
						else {output +=
							"<tr class='listoftasks' data-id='" + result[i].id + "' id='tasktr" + result[i].id + "'><td class='number tdone' id='number" + result[i].id + "'><span class='"+count+"'></span>" +
							"</td><td class='tdone' id='tasktxt" + result[i].id + "'>" +
							result[i].name +
							"</td><td class='buttontd'><button type='submit' class='btn btn-dark undone' id='btnundone" + result[i].id + "' data-id='" + result[i].id + "'><i class='fas fa-check-square'></i></button>" +
							"<button type='submit' class='btn btn-light done' id='btndone" + result[i].id + "' data-id='" + result[i].id + "' style='display:none'><i class='far fa-square'></i></button>" +
							"<button type='button' class='btn btn-success edit' data-toggle='modal' data-target='#taskModal' data-id='" + result[i].id + "'><i class='far fa-edit'></i></button>" +
							"<button type='button' class='btn btn-danger delete' id='btndelete' data-id='" + result[i].id + "' data-toggle='modal' data-target='#taskModal' ><i class='fas fa-trash-alt'></i></button>"+
							"</td></tr>";
						}
						count++;
					}
					console.log(result);
					displaytasks.html(output);
					numarrange(0);
					$("table").addClass("table");
					console.log("Tasks fetched");
				}
			});
		};

		$(document).on("click", "button.done", function(){
			
			var dataId = $(this).data("id");
			console.log(dataId);
			var taskname = $("#tasktr" + dataId);
			console.log(taskname);
			var tasknum = $("#number" + dataId);
			var task = $("#tasktxt" + dataId);
			console.log(task);
			var bttnundone = $("#btnundone" + dataId);
			var bttndone = $("#btndone" + dataId);
			
			$.ajax({
				headers: {
			        	'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			    },
				url:"/tasks/"+ dataId +"/done",
				type:"POST",
				data: {
					"id": dataId,
				},
				success:function(){
					$(tasknum).toggleClass("tdone", true);
					$(taskname).toggleClass( "tdone", true);
					$(task).toggleClass("tdone", true);
					$(bttnundone).show("400");
					$(bttndone).hide("400");
				}
			});
			console.log("Ajax 'done' successful");
		});

		$(document).on("click", "button.undone", function(){
			
			var dataId = $(this).data("id");
			console.log(dataId);
			var taskname = $("#tasktr" + dataId);
			console.log(taskname);
			var tasknum = $("#number" + dataId);
			var task = $("#tasktxt" + dataId);
			console.log(task);
			var bttnundone = $("#btnundone" + dataId);
			var bttndone = $("#btndone" + dataId);
			
			$.ajax({
				headers: {
			        	'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			    },
				url:"/tasks/"+ dataId +"/undone",
				type:"POST",
				data: {
					"id": dataId,
				},
				success:function(){
					$(tasknum).toggleClass("tdone", false);
					$(taskname).toggleClass( "tdone", false);
					$(task).toggleClass("tdone", false);
					$(bttnundone).hide("400");
					$(bttndone).show("400");
				}
			});
			console.log("Ajax 'undone' successful");
		});
	});
		
		
		$(document).on("click", "button.edit", function(){
			
			$("#modaltitle").text("Editing task");
			$("#modalmessage").hide("400");
			$("#editTasktxt").show("400");
			$("#btnok").hide("400");
			$("#btnconfirm").hide("400");
			$("#btncancel").hide("400");
			$("#btnsavechanges").show("400");
			
			var dataId = $(this).data("id");
			console.log(dataId);
			var task = $("#tasktxt" + dataId).text();
			var att = $("#tasktxt" + dataId).attr("class");
			console.log(task);
			$("#editTasktxt").val(task);
			console.log(dataId);
			
			$(document).on("click", "button.save", function(){
			
				console.log(dataId);
				var change = $("#editTasktxt").val();
				console.log(change);
					
				$.ajax({
				headers: {
			        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			    },
				url:"/tasks/",
				type:"PUT",
				data: {
					"id" : dataId,
					"name": change,
				},
				success:function(){
					fetch();
					$("#tasktxt" + dataId).attr("class", att);
				}
				});
				getalertmodal("Task edited", "Task successfully edited");
				console.log("Ajax 'save' successful");
			});
		});
		
		$(document).on("click", "button.delete", function(){
			var dataId = $(this).data("id");
			console.log("Current data-id is "+dataId);
			$("#modaltitle").text("Deleting task");
			$("#modalmessage").show("400");
			$("#modalmessage").text("Are you sure you want to delete this task?");
			$("#editTasktxt").hide("400");
			$("#btnok").hide("400");
			$("#btnconfirm").show("400");
			$("#btncancel").show("400");
			$("#btnsavechanges").hide("400");
			
			$(document).on("click", "button.confirm", function(){
			
				console.log(dataId);
				
				$.ajax({
				headers: {
			        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			    },
				url:"/tasks/" + dataId,
				type:"DELETE",
				success:function(){
					$("tr").remove("#tasktr"+dataId);
					numarrange(0);
				}
				});
				$("#btnconfirm").hide("400");
				$("#btncancel").hide("400");
				getalertmodal("Task deleted", "Task successfully deleted");
				console.log("Ajax 'delete' successful");
			});
			
			$(document).on("click", "button.cancel", function(){
				console.log(dataId);
				dataId = 0;
			});
		});
		

		var count = 1;
		$("#add_task").on("submit", function(event){
			var num = $("#tasks_name tr").length;
			var name = $("#addtasktxt").val();
			event.preventDefault();
			console.log(name);
			check = true;

			$.ajax({
				headers: {
			        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			    },
				url: '/tasks',
				type:"POST",
				data: {
					"name" : name,
				},
				dataType:"json",
				success:function(result){
					var id = result.id;
					var html = '<tr class="listoftasks" data-id="' + id + '" id="tasktr' + id + '">';
					html += '<td class="number" id="number' + id + '"><span class="'+count+'"><p id="frstnum">1</p></span></td>';
					html += '<td id="tasktxt' + id + '">' + name;
					html += '<td class="buttontd"><button type="submit" class="btn btn-light done" id="btndone'+id+'" data-id="'+id+'"><i class="far fa-square"></i></button>';
					html += '<button type="submit" class="btn btn-dark undone" id="btnundone' + id + '" data-id="' + id + '" style="display:none"><i class="fas fa-check-square"></i></button>';
					html += '<button type="button" class="btn btn-success edit" data-toggle="modal" data-target="#taskModal" data-id="' + id + '"><i class="far fa-edit"></i></button>';
					html += '<button type="button" class="btn btn-danger delete" id="btndelete" data-id="' + id + '" data-toggle="modal" data-target="#taskModal"><i class="fas fa-trash-alt"></i></button>';
					html += '</td></tr>';
					console.log(id);
					$('#tasks_name').prepend(html);
					$('#add_task')[0].reset();
				}
			});
			getalertmodal("Task added", "Successfully added task");
			numarrange(count);
			count++;
			console.log("Current number of count= "+count);
			console.log("Current length of tasks name is= "+num);
			console.log("Ajax 'add' successful!");
		});
		
		function getalertmodal(title, message){
			$("#modaltitle").text(title);
			$("#modalmessage").show("400");
			$("#modalmessage").text(message);
			$("#editTasktxt").hide("400");
			$("#btnok").show("400");
			$("#btnsavechanges").hide("400");
		};
		
		function numarrange(start){
			if(start > 0 ){
				$("#frstnum").hide();
				$(".number").each(function(index){
					$(this).html(index+2);
				});	
			}
			else if(start < 1 ){
				$(".number").each(function(index){
					$(this).html(index+1);
				});	
			}
		};

</script>
	
</body>

</html>