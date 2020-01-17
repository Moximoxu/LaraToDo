<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	<title>Countimer BootStrap 3</title>
	<meta charset="utf-8">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<meta name="viewport" content="width=device-width, intial-scale=1">

	<!--Link-->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
	<link rel='stylesheet'
		href='https://use.fontawesome.com/releases/v5.7.0/css/all.css' integrity='sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ' crossorigin='anonymous'>
	<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

	<!--Script sources-->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js" charset="utf-8"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
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
	<script src="https://use.fontawesome.com/2d7486ccbf.js"></script>

	<!-- include summernote css/js -->
	<link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote.css" rel="stylesheet">
	<script type="text/javascript" src="{{URL::asset('js/summernote.min.js')}}"></script>

	<!--Countimer plugin-->
	<script type="text/javascript" src="{{URL::asset('js/countimer_script.js')}}"></script>
	<link rel="stylesheet" type="text/css" href="{{ url('/css/countimer.css') }}" />
	<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">

	<!--Image attributes plugin-->
	<script type="text/javascript" src="{{URL::asset('js/summernote-image-attributes.js')}}"></script>

	<style>
		body{
			width: 80%;
			margin: 20px auto 20px;
		}
    .col.summernote_countimer_timer{
      width: 80%;
      margin: auto;
    }
    .summernote_countimer_close_timer{
      float: left;
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
        	<button class="btn btn-success my-3" type="submit">Save Changes <i class="fa fa-save" aria-hidden="true"></i></button>
        	<a class="btn btn-danger my-3" href="/get/{{$summernote_id}}/summernote" id="get_Content">Cancel</a>
      </form>
    	@endif

	    @if(!isset($summernote_content))
	    <form action="{{route('summernotePersist')}}" method="POST" id="summernote_container">
	        @csrf
	        <textarea name="summernoteInput" class="summernote" id="summernote"></textarea>
	        <br>

					<button class="btn btn-success" type="submit">Store <i class="fa fa-save" aria-hidden="true"></i></button>

					<div class="dropup">
				    <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">Dropup Example
				    <span class="caret"></span></button>
				    <ul class="dropdown-menu">
							@foreach ($summernotes as $summernote)
								<li><a href="/get/{{$summernote->id}}/summernote" id="get_Content">Content #{{$summernote->id}}</a></li>
							@endforeach
				    </ul>
				  </div>

					<br><a class="btn btn-default mb-3" href="/"><i class="fa fa-chevron-circle-left" aria-hidden="true"></i> Menu</a>
	    </form>
      @endif

		</div>
	</div>
</body>

<script type="text/javascript">
	$(document).ready(function() {
		$('#summernote').summernote({
			width: 1000,
			height: 400,
			focus: true,
			toolbar:[
				['insert', ['countimer', 'picture']],
				['font', ['fontname', 'customFontSize']],
				['tool', ['undo', 'redo', 'codeview']],
				['style',['style']],
			],
      countimer:{
				modalVer : 'bs3' // Or bs4. Default is bs4
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
