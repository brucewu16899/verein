@extends('layouts.auth')

@section('content')
	<div class="col-md-8 col-md-offset-2">
		<div class="panel panel-default">
			<div class="panel-heading">{{ trans('auth.password.headline') }}</div>
			<div class="panel-body">
				@include('layouts._errors')

				<form class="form-horizontal" role="form" method="POST" action="/password/email">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">

					<div class="form-group">
						<label class="col-md-4 control-label">{{ trans('auth.password.email') }}</label>
						<div class="col-md-6">
							<input type="email" class="form-control" name="email" value="{{ old('email') }}">
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-6 col-md-offset-4">
							<button type="submit" class="btn btn-primary">{{ trans('auth.password.reset') }}</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
@endsection
