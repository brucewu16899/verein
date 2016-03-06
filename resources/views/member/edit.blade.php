@extends('layouts.main')

@section('content')
	<section class="content-header">
		<h1>
			{{ trans('member.create.title') }}
			<small>{{ trans('member.create.subtitle') }}</small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> {{ trans('dashboard.breadcrumb') }}</a></li>
			<li><a href="{{ route('member.index') }}">{{ trans('member.breadcrumb') }}</a></li>
			<li><a href="{{ route('member.show', ['member' => $member->id]) }}">{{ $member->name }}</a></li>
			<li class="active">{{ trans('member.edit.breadcrumb') }}</li>
		</ol>
	</section>

	<div class="content body">
		<div class="box">
			{!! Form::model($member, ['route' => ['member.update', 'member' => $member->id], 'method' => 'put']) !!}
				<div class="box-body">
					@if (count($errors) > 0)
						<div class="alert alert-danger">
							{{ trans('member.edit.errors') }}<br><br>
							<ul>
								@foreach ($errors->all() as $error)
									<li>{{ $error }}</li>
								@endforeach
							</ul>
						</div>
					@endif

					<div class="form-group">
						<label class="control-label">{{ trans('member.edit.first_name') }}</label>
						{!! Form::text('first_name', null, ['class' => 'form-control']) !!}
					</div>

					<div class="form-group">
						<label class="control-label">{{ trans('member.edit.last_name') }}</label>
						{!! Form::text('last_name', null, ['class' => 'form-control']) !!}
					</div>

					<div class="form-group">
						<label class="control-label">{{ trans('member.edit.form_of_address') }}</label>
						{!! Form::text('form_of_address', null, ['class' => 'form-control']) !!}
					</div>

					<div class="form-group">
						<label class="control-label">{{ trans('member.edit.email') }}</label>
						{!! Form::email('email', null, ['class' => 'form-control']) !!}
					</div>

					<div class="form-group">
						<label class="control-label">{{ trans('member.edit.website') }}</label>
						{!! Form::url('website', null, ['class' => 'form-control']) !!}
					</div>

					<div class="form-group">
						<label class="control-label">{{ trans('member.edit.sex') }}</label>
						{!! Form::select('sex', [
							'female' => 'female',
							'male' => 'male'
						], null, ['class' => 'form-control']) !!}
					</div>

					<div class="form-group">
						<label class="control-label">{{ trans('member.edit.birthday') }}</label>
						{!! Form::date('birthday', $member->birthday, ['class' => 'form-control']) !!}
					</div>
				</div>

				<div class="box-footer clearfix">
					<a type="submit" href="{{ route('member.show', ['member' => $member->id]) }}" class="btn btn-sm btn-default btn-flat pull-left">{{ trans('member.edit.cancel') }}</a>

					<button type="submit" class="btn btn-sm btn-primary btn-flat pull-right">{{ trans('member.edit.save') }}</button>
				</div>
			{!! Form::close() !!}
		</div>
	</div>
@endsection
