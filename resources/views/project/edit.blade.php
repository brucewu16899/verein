@extends('layouts.main')

@section('content')
	<section class="content-header">
		<h1>
			{{ $project->title }}
			<small>{{ trans('project.edit.subtitle') }}</small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> {{ trans('dashboard.breadcrumb') }}</a></li>
			<li><a href="{{ route('project.index') }}">{{ trans('project.breadcrumb') }}</a></li>
			<li><a href="{{ route('project.show', ['project' => $project->id]) }}">{{ $project->title }}</a></li>
			<li class="active">{{ trans('project.edit.breadcrumb') }}</li>
		</ol>
	</section>

	<div class="content body">
		<div class="box">
			{!! Form::model($project, ['route' => ['project.update', 'project' => $project->id], 'method' => 'put']) !!}
				<div class="box-body">
					@if (count($errors) > 0)
						<div class="alert alert-danger">
							{{ trans('project.edit.errors') }}<br><br>
							<ul>
								@foreach ($errors->all() as $error)
									<li>{{ $error }}</li>
								@endforeach
							</ul>
						</div>
					@endif

					<input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">

					<div class="form-group form-required">
						<label class="control-label">{{ trans('project.edit.company_id') }}</label>
						{!! Form::select('company_id', $companies, null, ['class' => 'form-control', 'required' => 'required']) !!}
					</div>

					<div class="form-group form-required">
						<label class="control-label">{{ trans('project.edit.title') }}</label>
						{!! Form::text('title', null, ['class' => 'form-control', 'required' => 'required']) !!}
					</div>

					<div class="form-group">
						<label class="control-label">{{ trans('project.edit.website') }}</label>
						{!! Form::url('website', null, ['class' => 'form-control']) !!}
					</div>

					<div class="form-group">
						<label class="control-label">{{ trans('project.edit.repository') }}</label>
						{!! Form::url('repository', null, ['class' => 'form-control']) !!}
					</div>

					<div class="form-group">
						<label class="control-label">{{ trans('project.edit.bugtracker') }}</label>
						{!! Form::url('bugtracker', null, ['class' => 'form-control']) !!}
					</div>

					<div class="form-group">
						<label class="control-label">{{ trans('project.edit.started_at') }}</label>
						{!! Form::date('started_at', null, ['class' => 'form-control']) !!}
					</div>

					<div class="form-group">
						<label class="control-label">{{ trans('project.edit.completed_at') }}</label>
						{!! Form::date('completed_at', null, ['class' => 'form-control']) !!}
					</div>
				</div>

				<div class="box-footer clearfix">
					<a type="submit" href="{{ route('project.show', ['project' => $project->id]) }}" class="btn btn-sm btn-default btn-flat pull-left">{{ trans('project.edit.cancel') }}</a>

					<button type="submit" class="btn btn-sm btn-primary btn-flat pull-right">{{ trans('project.edit.save') }}</button>
				</div>
			{!! Form::close() !!}
		</div>
	</div>
@endsection
