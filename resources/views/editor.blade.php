<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	<title>Countimer</title>
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
	<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js" charset="utf-8"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
	<script src="https://jqueryvalidation.org/files/lib/jquery.js"></script>
	<script src="https://jqueryvalidation.org/files/dist/jquery.validate.js"></script>
	<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
	<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
	<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
	
	<!--Summernote sources-->
	<!-- include libraries(jQuery, bootstrap, fontawesome) -->
	<link href="http://netdna.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.css" rel="stylesheet">
	<script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.js"></script> 
	<script src="http://netdna.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.js"></script>
	<link rel='stylesheet' 
		href='https://use.fontawesome.com/releases/v5.7.0/css/all.css' integrity='sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ' crossorigin='anonymous'> 

	<!-- include summernote css/js -->
	<link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote.css" rel="stylesheet">
	<script type="text/javascript" src="{{URL::asset('js/summernote.min.js')}}"></script> 
	
	<!--Countimer plugin-->
	<script type="text/javascript" src="{{URL::asset('js/countimer_script.js')}}"></script>
	<link rel="stylesheet" type="text/css" href="{{ url('/css/countimer.css') }}" />
	
	<style>
		body{
			width:80%;
			margin: 20px auto 0;
		}
	</style>
</head>

<body>
	<div class="row">
		<div class="col-lg-12">
					<div class="row">
					<div>

						@if(isset($summernote_content))
						<form method="POST" action="{{ url('save/summernote') }}">
					    	@csrf
						    <textarea name="summernoteUpdate" class="summernote" id="summernote">
					        	{{$summernote_content}}
					        </textarea>
					        <input id="content_id" value="{{$summernote_id}}" style="display:none" readonly>
					        <br>
				        	<button class="btn btn-success" type="submit">Save Changes <i class="fas fa-save"></i></button>
				        </form>
			        	@endif

					    @if(!isset($summernote_content))
					    <form action="{{route('summernotePersist')}}" method="POST">
					        @csrf
					        <textarea name="summernoteInput" class="summernote" id="summernote"></textarea>
					        <br>
					        <button class="btn btn-success" type="submit">Store <i class="fas fa-save"></i></button>
					        @foreach ($summernotes as $summernote)
								<a class="btn btn-info my-3" href="/get/{{$summernote->id}}/summernote" id="get_Content" target="_blank">Content #{{$summernote->id}}</a>
							@endforeach
					    </form>
				        @endif

						<a class="btn btn-danger" href="/">Back To Menu</a>
					</div>
						
					</div>
			</div>
		</div>
	</div>
</body>

<script type="text/javascript">
	$(document).ready(function() {
		$('#summernote').summernote({
			width: 600,
			height: 400,
			focus: true,
			toolbar:[
				['insert', ['countimer']],
				['font', ['fontname', 'fontsize']],
				['tool', ['undo', 'redo', 'codeview']],
				['style',['style']],
			],
		});
	});
</script>

</html>