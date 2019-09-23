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
			max-width: 1150px;
        	float: none;
        	margin-bottom: 30px;
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
		
		.form-control{
			width:70%;
		}
		
		.buttontd {
			width:200px;
			text-align: center;
		}
		
		.Submit{
			padding:5px 10px;
			width:100%;
			margin-top; 10px;
			box-shadow: 3px 3px 0 #ddd;
		}

		.number{
			padding:4px;
		}

		.fa-user-edit{
			color: #ffffff;
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
			<button type="button" class="btn btn-warning" id="btnedit" onclick="location.href='{{ url('/edit') }}'"><i class="fas fa-user-edit" style="color:#000000"></i></button>
			<button type="button" class="btn btn-danger" id="btnlogout" onclick="location.href='{{ url('/logout') }}'"><i class="fas fa-door-open"></i></button>
		</div>
	</nav>
	
</head>

<body>
	<div class="row">
		<div class="col-lg-12">
			<div class="card my-3">
				<div class="card-header">
					<h2 class="header">Admin {{Auth::user()->name}}'s View</h2>
				</div>
				<div class="card-body" id="tasklist">
					<form action="/search" method="POST" role="search">
				    {{ csrf_field() }}
				    <div class="input-group">
				        <input type="text" class="form-control" name="q"
				            placeholder="Search users"> <span class="input-group-btn">
				            <button type="submit" class="btn btn-primary">
				                <i class="fas fa-search"></i>
				            </button>
					        </span>
					    </div>
					</form>
					@if(isset($message))
                            <h3>
                                <div class="alert alert-danger success-block"><strong>{{ $message }}</strong>
                                </div>
                            </h3>
                    @endif

                    @if(isset($users))
					<table class='table-striped table-hover' id='tasktable'>
						<thead style='text-align:center'>
							<tr><th>ID</th><th>Name</th><th>Email</th><th>Gender</th><th>Birthdate</th><th>Created At</th><th>Updated At</th><th>Email Verified At</th><th>Role</th><th>Actions</th></tr>
						</thead>
						<tbody id='tasks_name'>
							@foreach ($users as $user)
							<tr class='listoftasks' data-id='{{$user->id}}' id='tasktr{{$user->id}}'>
								<td class='number' id='number{{$user->id}}'><span class='{{$user->id}}'>{{$user->id}}</span>
								</td>

								<td id='tasktxt{{$user->id}}'>
								{{$user->name}}
								</td>

								<td id='tasktxt{{$user->id}}'>
								{{$user->email}}
								</td>

								<td id='tasktxt{{$user->id}}'>
								{{$user->gender}}
								</td>

								<td id='tasktxt{{$user->id}}'>
								{{$user->birthdate}}
								</td>

								<td id='tasktxt{{$user->id}}'>
								{{$user->created_at}}
								</td>

								<td id='tasktxt{{$user->id}}'>
								{{$user->updated_at}}
								</td>

								<td id='tasktxt{{$user->id}}'>
								{{$user->email_verified_at}}
								</td>

								<td id='tasktxt{{$user->id}}'>
								{{$user->roles}}
								</td>

								<td class='buttontd'>
								<button class='btn btn-success'><a href='/admin/{{$user->id}}/edituser'><i class='fas fa-user-edit user'></i></a></button>
								<button type='button' class='btn btn-danger delete' id='btndelete' data-id='{{$user->id}}' data-toggle='modal' data-target='#taskModal' ><i class='fas fa-trash-alt'></i></button>
								</td>
							</tr>
							@endforeach
						</tbody>
					</table>
					{{ $users->links() }}
					@endif
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
		
		$(document).on("click", "button.delete", function(){
			var dataId = $(this).data("id");
			console.log("Current data-id is "+dataId);
			$("#modaltitle").text("Deleting user");
			$("#modalmessage").show("400");
			$("#modalmessage").text("Are you sure you want to delete this user?");
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
				url:"/admin/" + dataId,
				type:"DELETE",
				success:function(){
					$("tr").remove("#tasktr"+dataId);
				}
				});
				$("#btnconfirm").hide("400");
				$("#btncancel").hide("400");
				getalertmodal("User deleted", "User successfully deleted");
				console.log("Ajax 'delete' successful");
			});
			
			$(document).on("click", "button.cancel", function(){
				console.log(dataId);
				dataId = 0;
			});
		});
		
		function getalertmodal(title, message){
			$("#modaltitle").text(title);
			$("#modalmessage").show("400");
			$("#modalmessage").text(message);
			$("#editTasktxt").hide("400");
			$("#btnok").show("400");
			$("#btnsavechanges").hide("400");
		};
	});

</script>
	
</body>

</html>