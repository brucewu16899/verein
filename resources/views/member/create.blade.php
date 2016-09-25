@extends('layouts.main')

@section('content')
	<section class="content-header">
		<h1>
			{{ trans('member.create.title') }}
		</h1>
		<ol class="breadcrumb">
			<li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> {{ trans('dashboard.breadcrumb') }}</a></li>
			<li><a href="{{ route('member.index') }}">{{ trans('member.index.breadcrumb') }}</a></li>
			<li class="active">{{ trans('member.create.breadcrumb') }}</li>
		</ol>
	</section>

	<div class="content body">
		<div class="box">
			<form role="form" method="post" action="{{ route('member.store') }}">
				<div class="box-body">
					@if (count($errors) > 0)
						<div class="alert alert-danger">
							{{ trans('member.create.errors') }}<br><br>
							<ul>
								@foreach ($errors->all() as $error)
									<li>{{ $error }}</li>
								@endforeach
							</ul>
						</div>
					@endif

					<input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">

					<div class="form-group">
						<label class="control-label">{{ trans('member.create.first_name') }}</label>
						<input type="text" class="form-control" name="first_name" value="{{ old('first_name') }}">
					</div>

					<div class="form-group">
						<label class="control-label">{{ trans('member.create.last_name') }}</label>
						<input type="text" class="form-control" name="last_name" value="{{ old('last_name') }}">
					</div>

					<div class="form-group">
						<label class="control-label">{{ trans('member.create.form_of_address') }}</label>
						<input type="text" class="form-control" name="form_of_address" value="{{ old('form_of_address') }}">
					</div>

					<div class="form-group">
						<label class="control-label">{{ trans('member.create.email') }}</label>
						<input type="email" class="form-control" name="email" value="{{ old('email') }}">
					</div>

					<div class="form-group">
						<label class="control-label">{{ trans('member.create.sex') }}</label>
						{!! Form::select('sex', [
							'female' => 'female',
							'male' => 'male'
						], null, ['class' => 'form-control']) !!}
					</div>

					<div class="form-group">
						<label class="control-label">{{ trans('member.create.birthday') }}</label>
						<input type="date" class="form-control" name="birthday" value="{{ old('birthday') }}">
					</div>
				</div>

				<div class="box-footer clearfix">
					<a type="submit" href="{{ route('member.index') }}" class="btn btn-sm btn-default btn-flat pull-left">{{ trans('member.create.cancel') }}</a>

					<button type="submit" class="btn btn-sm btn-primary btn-flat pull-right">{{ trans('member.create.create') }}</button>
				</div>
			</form>
		</div>
	</div>
@endsection
