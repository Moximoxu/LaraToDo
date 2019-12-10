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

	<!--Image attributes plugin-->
	<script type="text/javascript" src="{{URL::asset('js/summernote-image-attributes.js')}}"></script>

	<style>
		body{
			width:80%;
			margin: 20px auto 0;
		}
	</style>

	<div id="setModal" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="c_modal_title">Set Countimer</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<div class="modal-body" id="timer">
				<label for="c_title_in">Title of Countdown</label>
				<input type="text" id="c_title_in"><br>

					<label for="c_date">Countdown Date</label>
					<input type="date" id="c_date"><br>

				<label for="c_hour">Hour</label>
					<input type="number" id="c_hour" required value="00" min="0" step="1" max="23">:

					<label for="c_minute">Minute</label>
					<input type="number" id="c_minute" required value="00" min="0" step="1" max="59">:

					<label for="c_second">Second</label>
				<input type="number" id="c_second" required value="00" min="0" step="1" max="59"><br>

					<button type="button" onclick="setTimer()" class="btn btn-info my-3" data-dismiss="modal">Set</button>
			  </div>
			  <div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			  </div>
		</div>
	</div>
</div>

<!-- Modal for setting font size -->
<div id="setFontSizeModal" class="modal fade" role="dialog">
<div class="modal-dialog modal-sm">
	<div class="modal-content">
		<div class="modal-header">
			<h4 class="modal-title" id="font_modal_title">Set Font Size</h4>
			<button type="button" class="close" data-dismiss="modal">&times;</button>
		</div>
		<div class="modal-body" id="font_size">
			<label for="font_size_in">Font size</label>
			<input id="font_size_in" name="font_size_in" type="number" max="120" min="8" step="0.1" value="14"> px<br>

				<button type="button" id="submit_fontSize" class="btn btn-info my-3" data-dismiss="modal">Set</button>
			</div>
			<div class="modal-footer">
				<button type="button" id="cancel_fontSize" class="btn btn-danger" data-dismiss="modal">Close</button>
			</div>
	</div>
</div>
</div>

</head>

<body>
	<div class="row">
		<div class="col-lg-12">
			<div class="row">
				<div class="col">

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
			        @foreach ($summernotes as $summernote)
								<a class="btn btn-info my-3" href="/get/{{$summernote->id}}/summernote" id="get_Content" target="_blank">Content #{{$summernote->id}}</a>
							@endforeach
			    </form>
		      @endif

					<a class="btn btn-dark" href="/"><i class="fas fa-chevron-circle-left"></i> Menu</a>
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
				['insert', ['countimer', 'picture']],
				['font', ['fontname', 'customFontSize']],
				['tool', ['undo', 'redo', 'codeview']],
				['style',['style']],
			],
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
