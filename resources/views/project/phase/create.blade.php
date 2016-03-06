@extends('layouts.main')

@section('content')
	<section class="content-header">
		<h1>
			{{ trans('project.phase.create.title') }}
			<small>{{ $project->title }}</small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> {{ trans('dashboard.breadcrumb') }}</a></li>
			<li><a href="{{ route('project.index') }}">{{ trans('project.breadcrumb') }}</a></li>
			<li><a href="{{ route('project.show', ['project' => $project->id]) }}">{{ $project->title }}</a></li>
			<li class="active">{{ trans('project.phase.create.breadcrumb') }}</li>
		</ol>
	</section>

	<div class="content body">
		<div class="box">
			{!! Form::model(null, ['route' => ['project.phase.store', 'project' => $project->id]]) !!}
				<div class="box-body">
					@if (count($errors) > 0)
						<div class="alert alert-danger">
							{{ trans('project.phase.create.errors') }}<br><br>
							<ul>
								@foreach ($errors->all() as $error)
									<li>{{ $error }}</li>
								@endforeach
							</ul>
						</div>
					@endif

					<input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">

					<div class="form-group form-required">
						<label class="control-label">{{ trans('project.phase.create.number') }}</label>
						{!! Form::select('number', $phases, null, ['class' => 'form-control', 'required' => 'required']) !!}
					</div>

					<div class="form-group form-required">
						<label class="control-label">{{ trans('project.phase.create.title') }}</label>
						{!! Form::text('title', null, ['class' => 'form-control', 'required' => 'required']) !!}
					</div>

					<div class="form-group">
						<label class="control-label">{{ trans('project.phase.create.description') }}</label>
						{!! Form::textarea('description', null, ['class' => 'form-control']) !!}
					</div>

					<div class="form-group">
						<label class="control-label">{{ trans('project.phase.create.started_at') }}</label>
						{!! Form::date('started_at', null, ['class' => 'form-control']) !!}
					</div>

					<div class="form-group">
						<label class="control-label">{{ trans('project.phase.create.completed_at') }}</label>
						{!! Form::date('completed_at', null, ['class' => 'form-control']) !!}
					</div>

					<div class="form-group">
						<label class="control-label">{{ trans('project.phase.create.planed_started_at') }}</label>
						{!! Form::date('planed_started_at', null, ['class' => 'form-control']) !!}
					</div>

					<div class="form-group">
						<label class="control-label">{{ trans('project.phase.create.planed_completed_at') }}</label>
						{!! Form::date('planed_completed_at', null, ['class' => 'form-control']) !!}
					</div>
				</div>

				<div class="box-footer clearfix">
					<a type="submit" href="{{ route('project.show', ['project' => $project->id]) }}" class="btn btn-sm btn-default btn-flat pull-left">{{ trans('project.phase.create.cancel') }}</a>

					<button type="submit" class="btn btn-sm btn-primary btn-flat pull-right">{{ trans('project.phase.create.create') }}</button>
				</div>
			{!! Form::close() !!}
		</div>
	</div>
@endsection
