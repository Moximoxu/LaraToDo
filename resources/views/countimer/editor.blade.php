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
	<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">

	<!--Image attributes plugin-->
	<script type="text/javascript" src="{{URL::asset('js/summernote-image-attributes.js')}}"></script>

	<!-- Email template plugin -->
	<script type="text/javascript" src="{{URL::asset('js/email_templates.js')}}"></script>

	<style>
		body{
			width:80%;
			margin: 20px auto 0;
		}

		.summernote_countimer_value_days, .summernote_countimer_value_hours, .summernote_countimer_value_minutes, .summernote_countimer_value_seconds{
			font-size:70px;
		}

		.summernote_countimer_label_title{
			font-size:50px;
		}
	</style>

</head>

<body>
	<div class="row">
		<div class="col-lg-12 mx-auto">

			@if(isset($summernote_content))
			<form method="POST" action="{{ url('save/summernote') }}" id="summernote_container">
	    	@csrf
		    <textarea name="summernoteUpdate" class="summernote" id="summernote">
	       {{$summernote_content}}
	      </textarea>
	        <input id="content_id" name="content_id" value="{{$summernote_id}}" style="display:none" readonly>
	        <br>
        	<button class="btn btn-success my-3" type="submit">Save Changes <i class="fas fa-save"></i></button>
        	<a class="btn btn-danger my-3" href="/get/{{$summernote_id}}/summernote" id="get_Content">Cancel</a>
      </form>
    	@endif

	    @if(!isset($summernote_content))
	    <form action="{{route('summernotePersist')}}" method="POST" id="summernote_container">
	        @csrf
	        <textarea name="summernoteInput" class="summernote" id="summernote"></textarea>
	        <br>

					<button class="btn btn-success" type="submit">Store <i class="fas fa-save"></i></button>

					<div class="dropdown float-right mr-auto">
				    <button type="button" class="btn btn-info mt-3 dropdown-toggle" data-toggle="dropdown">
				      Show content
				    </button>
				    <div class="dropdown-menu">
							@foreach ($summernotes as $summernote)
								<a class="dropdown-item" href="/get/{{$summernote->id}}/summernote" id="get_Content">Content #{{$summernote->id}}</a>
							@endforeach
				    </div>
				  </div>

					<br><a class="btn btn-dark my-3" href="/"><i class="fas fa-chevron-circle-left"></i> Menu</a>
	    </form>
      @endif

		</div>
	</div>
</body>

<script type="text/javascript">
	$(document).ready(function() {
		$('#summernote').summernote({
			width: 1000,
			height: 600,
			focus: true,
			toolbar:[
				['insert', ['countimer', 'emailTemplates', 'picture']],
				['font', ['fontname', 'customFontSize']],
				['tool', ['undo', 'redo', 'codeview']],
				['style', ['style']],
			],
			countimer:{
				modalVer : 'bs4' // Or bs3. Default is bs4
			},
			popover:{
				image:[
					['custom', ['imageAttributes']],
					['imagesize', ['imageSize100', 'imageSize50', 'imageSize25']],
	        ['float', ['floatLeft', 'floatRight', 'floatNone']],
	        ['remove', ['removeMedia']]
				],
			}
		});
	});
</script>

<!--Custom Font Size plugin-->
<script type="text/javascript" src="{{URL::asset('js/custom_font_Size.js')}}"></script>

</html>
