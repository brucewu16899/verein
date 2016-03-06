@extends('layouts.main')

@section('content')
	<section class="content-header">
		<h1>
			{{ trans('project.create.title') }}
			<small>{{ trans('project.create.subtitle') }}</small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> {{ trans('dashboard.breadcrumb') }}</a></li>
			<li><a href="{{ route('project.index') }}">{{ trans('project.breadcrumb') }}</a></li>
			<li class="active">{{ trans('project.create.breadcrumb') }}</li>
		</ol>
	</section>

	<div class="content body">
		<div class="box">
			<form role="form" method="post" action="{{ route('project.store') }}">
				<div class="box-body">
					@if (count($errors) > 0)
						<div class="alert alert-danger">
							{{ trans('project.create.errors') }}<br><br>
							<ul>
								@foreach ($errors->all() as $error)
									<li>{{ $error }}</li>
								@endforeach
							</ul>
						</div>
					@endif

					<input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">

					<div class="form-group form-required">
						<label class="control-label">{{ trans('project.create.company_id') }}</label>
						{!! Form::select('company_id', $companies, null, ['class' => 'form-control', 'required' => 'required']) !!}
					</div>

					<div class="form-group form-required">
						<label class="control-label">{{ trans('project.create.title') }}</label>
						<input type="text" class="form-control" name="title" required="required">
					</div>

					<div class="form-group">
						<label class="control-label">{{ trans('project.create.website') }}</label>
						<input type="url" class="form-control" name="website">
					</div>

					<div class="form-group">
						<label class="control-label">{{ trans('project.create.repository') }}</label>
						<input type="url" class="form-control" name="repository">
					</div>

					<div class="form-group">
						<label class="control-label">{{ trans('project.create.bugtracker') }}</label>
						<input type="url" class="form-control" name="bugtracker">
					</div>

					<div class="form-group">
						<label class="control-label">{{ trans('project.create.started_at') }}</label>
						<input type="date" class="form-control" name="started_at">
					</div>

					<div class="form-group">
						<label class="control-label">{{ trans('project.create.completed_at') }}</label>
						<input type="date" class="form-control" name="completed_at">
					</div>
				</div>

				<div class="box-footer clearfix">
					<a type="submit" href="{{ route('project.index') }}" class="btn btn-sm btn-default btn-flat pull-left">{{ trans('project.create.cancel') }}</a>

					<button type="submit" class="btn btn-sm btn-primary btn-flat pull-right">{{ trans('project.create.create') }}</button>
				</div>
			</form>
		</div>
	</div>
@endsection
