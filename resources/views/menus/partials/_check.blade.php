@if($errors->any())
	<ul style="padding-left: 30px;" class="alert alert-danger" role="alert">
		@foreach($errors->all() as $error)
			<li>{!! $error !!}</li>
		@endforeach
	</ul>
@endif

@if(Session::has('message-success'))
	<div class="alert alert-success" role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
		<h4 class="alert-heading"><strong>Sucesso!</strong></h4>
		<p>{{ Session::get('message-success') }}</p>
	</div>
@endif