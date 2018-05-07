<div class="row">
	<div class="col-md-12 col-xs-12">
		@if ($message = Session::get('success'))
		<div class="alert alert-success alert-block">
			<button type="button" class="close" data-dismiss="alert">×</button>	
		        <strong>{{ $message }}</strong>
		</div>
		@endif

		@if ($message = Session::get('danger'))
		<div class="alert alert-danger alert-block">
			<button type="button" class="close" data-dismiss="alert">×</button>	
		        <strong>{{ $message }}</strong>
		</div>
		@endif

		@if ($message = Session::get('warning'))
		<div class="alert alert-warning alert-block">
			<button type="button" class="close" data-dismiss="alert">×</button>	
			<strong>{{ $message }}</strong>
		</div>
		@endif

		@if ($message = Session::get('info'))
		<div class="alert alert-info alert-block">
			<button type="button" class="close" data-dismiss="alert">×</button>	
			<strong>{{ $message }}</strong>
		</div>
		@endif

		@if ($errors->any())
		<div class="alert alert-danger">
			<button type="button" class="close" data-dismiss="alert">×</button>	
			Mohon cek ulang informasi yang Anda masukkan
		</div>
		@endif
	</div>
</div>

@php
	session()->forget('success');
	session()->forget('danger');
	session()->forget('warning');
	session()->forget('info');
@endphp