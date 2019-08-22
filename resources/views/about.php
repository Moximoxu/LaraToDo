<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
		
		<link rel="stylesheet" 
		href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
		
		<!--Sources-->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

        <title>LaraToDo</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <style>
            html, body {
                background-color:#aeeaae;
                color: #000000;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }
			
			.header{
				text-align: center;
			}
			
			.card{
				color: #000000;
				background-color: #66ff66;
				font-family: 'Helvetica';
				width:100%;
				max-width:500px;
				padding:20px;
				border-radius:7px;
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
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            <div class="content">
				<div class="card mx-auto">
					<div class="card-header">
						<h2 class="header">About LaraToDo</h2>
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
						</div>
					</div>
				</div>
            </div>
        </div>
    </body>
</html>
