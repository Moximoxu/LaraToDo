<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
		
		<link rel="stylesheet" 
		href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
		<link rel='stylesheet' 
		href='https://use.fontawesome.com/releases/v5.7.0/css/all.css' integrity='sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ' crossorigin='anonymous'>
		
		<!--Sources-->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

        <title>LaraToDo</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <style>
            #navLogo {
				font-family:Georgia;
				font-size:40px;
			}

            body {
            	background-color:#aeeaae;
            }

            .full-height {
                height: 100vh;
            }
			
			.header{
				text-align: center;
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
			
			.card-header{
				background-color: #66ff66;
			}
			
			.card-body{
				background-color: #d6f5d6;
				border-radius:7px;
			}
			
			.ol li{
				text-align: left;
			}
			
            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .title {
                font-size: 84px;
            }

            .m-b-md {
                margin-bottom: 30px;
            }

        </style>

        <nav class="navbar navbar-expand-sm navbar-dark" style="background-color:#33cc33">
			<ul class="navbar-nav">
				<li class="nav-item">
					<a class="nav-link text-white" id="navLogo"><b>LaraToDo</b></a>
				</li>
				<li class="nav-item" style="margin-top:30px">
					<a class="nav-link" style="font-family:Georgia;font-size:14px;">To-Do Web Application</a>
				</li>
			</ul>
		</nav>

    </head>
    <body>
        <div class="flex-center position-ref full-height">
            <div class="content">
				<div class="card mx-auto">
					<div class="card-header" style="background-color:#33cc33">
						<h2 class="header" style="color:#ffffff">About LaraToDo</h2>
					</div>
					<div class="card-body my-3" id="aboutcontent">
						<div class="row">
							<div class="col-sm-12 mx-auto">
								<ol>
									<li><p>LaraToDo is a To-Do list web application that implements Laravel where tasks can be added and checked as done and undone.</p></li>
									<li><p>This web application also has the following features: </p></li>
								</ol>
							</div>
							<div class="col-sm-12 mx-auto">
								<ul>
									<li>Edit tasks</li>
									<li>View tasks based on the user that is logged in</li>
								</ul>
							</div>
							<div class="col-sm-12 mx-auto">
								<a href='/'><i class="far fa-hand-point-left"></i></a>
							</div>
						</div>
					</div>
				</div>
            </div>
        </div>
    </body>
</html>
