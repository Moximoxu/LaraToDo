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
                <a class="nav-link text-white" id="navLogo" href="{{ url('/') }}"><b>WhatToDo</b></a>
            </li>
            <li class="nav-item" style="margin-top:30px">
                <a class="nav-link" style="font-family:Georgia;font-size:14px;">To-Do Web Application</a>
            </li>
        </ul>
    </nav>
</head>

<body>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ url('/register/create') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" required>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="gender" class="col-md-4 col-form-label text-md-right">{{ __('Gender') }}</label>

                            <div class="col-md-6">
                                <select class="form-control" id="gender" name="gender" required>
                                    <option>Male</option>
                                    <option>Female</option>
                                </select>

                                @error('gender')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="birthdate" class="col-md-4 col-form-label text-md-right">{{ __('Birthdate') }}</label>

                            <div class="col-md-6">
                                <input id="birthdate" type="date" class="form-control @error('birthdate') is-invalid @enderror" name="birthdate" required autofocus>

                                @error('birthdate')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password"><a onmouseover="showpsswrd()" onmouseout="hidepsswrd()"><i class="fas fa-eye"></i></a>

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password"><a onmouseover="showcpsswrd()" onmouseout="hidecpsswrd()"><i class="fas fa-eye"></i></a>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function showpsswrd() {
        var x = document.getElementById("password");
        if (x.type === "password") {
            x.type = "text";
        }
    };

    function hidepsswrd(){
        var x = document.getElementById("password");
        if (x.type === "text"){
            x.type = "password";
        }
    };

    function showcpsswrd() {
        var x = document.getElementById("password-confirm");
        if (x.type === "password") {
            x.type = "text";
        }
    };

    function hidecpsswrd(){
        var x = document.getElementById("password-confirm");
        if (x.type === "text"){
            x.type = "password";
        }
    };
</script>

</body>

</html>