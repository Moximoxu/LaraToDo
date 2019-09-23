<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <title>LaraToDo</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, intial-scale=1">

    <!--Link-->
    <link rel="stylesheet" href="https://jqueryvalidation.org/files/demo/site-demos.css">
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
        
        .th{
            margin: 2px 0;
        }
        
        .input_wrapper{
            display:inline-block;
        }
        
        .clearbtn, .clearbtn2 {
            cursor:pointer;
            color:red;
            visibility:hidden;
            right:0px;
        }
        
        body{
            background-color:#aeeaae;
        }
    
        .card{
            background-color:#d6f5d6;
            margin:20px auto;
            width:100%;
            max-width:500px;
            padding:20px;
            border-radius:5px;
            box-shadow:20px 20px 0 rgba(0, 0, 0, .1);
            box-sizing:border-box;
        }
        
        .input{
            width:100%;
        }
        
        .done_bttn{
            display:inline-block;
            background-color:#85e085;
            color:#e67300;
            padding:3px 6px;
            border:0;
            opacity:0.5;
        }
        
        .Login{
            padding:5px 10px;
            width:100%;
            margin-top; 10px;
            box-shadow: 3px 3px 0 #ddd;
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
    </nav>
</head>

<body>

<div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h2 class="header">Welcome to LaraToDo</h2>
                </div>
                <form class="form-action" method="post" action="{{ url('/checklogin') }}" id="check_login">
                    {{ csrf_field() }}
                <div class="card-body" id="logininfo">
                    <table class='table-hover' id='tasktable'>
                        <tbody>
                            @if(isset(Auth::user()->email))
                            <tr>
                                <div class="alert alert-danger success-block"><strong>Welcome {{ Auth::user()->name }}</strong>
                                </div>
                            </tr>
                            @endif
                            <tr><th>Email</th><td><span class="input_wrapper"><input type="email" id="emailtxt" name="email" class="form-control" onfocus="this.value=''" autocomplete="off" placeholder="Enter your email" required></span><span id="cleartbtnid1" class="clearbtn" name="clearbtn" title="Clear" style="display:none;cursor:pointer;color:red;right:0px;">&times;</span></td></tr>
                            <tr><th>Password</th><td><span class="input_wrapper"><input type="password" id="passtxt" name="password" class="form-control" onfocus="this.value=''" autocomplete="off" placeholder="Enter your password" required></span></td><td><span><a onmouseover="showpsswrd()" onmouseout="hidepsswrd()"><i class="fas fa-eye"></i></a></span><span id="clearbtnid2" class="clearbtn2" name="clearbtn2" title="Clear" style="display:none;cursor:pointer;color:red;right:0px;">&times;</span></td>
                                    @if ($message = Session::get('error'))
                                    <td>
                                       <div class="alert alert-danger alert-block">
                                       <button type="button" class="close" data-dismiss="alert">x</button> </div>
                                    </td>
                                    @endif
                                
                            </tr>
                        </tbody>
                    </table>
                </div>
                    <button type="submit" class="Login btn btn-info" id="btnLogin" name="login">Login</button>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="loginModal">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title" id="modaltitle">Edit task</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <p id="modalmessage"></p>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-info" id="btnok" data-dismiss="modal">Okay</button>
                </div>

            </div>
        </div>
    </div>

<script>

    clearinput();
    
    function clearinput(){
        
        $("#emailtxt").keyup(function(){
            $("#cleartbtnid1").show("400");
            console.log("You are typing into emailtxt");
        });
        
        $("#passtxt").keyup(function(){
            $("#clearbtnid2").show("400");
        });
        
        $("#cleartbtnid1").click(function(){
            $("#cleartbtnid1").hide("400");
            $("#usernametxt")[0].reset();
        });
        
        $("#clearbtnid2").click(function(){
            $("#clearbtnid2").hide("400");
            $("#passtxt")[0].reset();
        });
    };

    function showpsswrd() {
        var x = document.getElementById("passtxt");
        if (x.type === "password") {
            x.type = "text";
        }
    };

    function hidepsswrd(){
        var x= document.getElementById("passtxt");
        if (x.type === "text"){
            x.type = "password";
        }
    };
        
</script>

</body>

</html>