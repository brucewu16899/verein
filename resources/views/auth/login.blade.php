@extends('layouts.auth')

@section('content')
	<div class="col-md-8 col-md-offset-2">
		<div class="panel panel-default">
			<div class="panel-heading">{{ trans('auth.login.headline') }}</div>
			<div class="panel-body">
				@include('layouts._errors')

				{!! Form::open(['route' => 'account.doLogin']) !!}
					<div class="form-group form-required">
						<label class="control-label">{{ trans('auth.login.email') }}</label>
						<input type="email" class="form-control" name="email" value="{{ old('email') }}">
					</div>

					<div class="form-group form-required">
						<label class="control-label">{{ trans('auth.login.password') }}</label>
						<input type="password" class="form-control" name="password">
					</div>

					<div class="form-group">
						<div class="checkbox">
							<label>
								<input type="checkbox" name="remember"> {{ trans('auth.login.remember') }}
							</label>
						</div>
					</div>

					<div class="form-group">
						<button type="submit" class="btn btn-primary" style="margin-right: 15px;">
							{{ trans('auth.login.login')}}
						</button>

						<a href="#">{{ trans('auth.login.forget-password') }}</a>
					</div>
				{!! Form::close() !!}
			</div>
		</div>
	</div>
@endsection
