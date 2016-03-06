@extends('layouts.main')

@section('content')
	<section class="content-header">
		<h1>
			{{ trans('project.phase.document.create.title') }}
			<small>{{ $project->title }}</small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> {{ trans('dashboard.breadcrumb') }}</a></li>
			<li><a href="{{ route('project.index') }}">{{ trans('project.breadcrumb') }}</a></li>
			<li><a href="{{ route('project.show', ['project' => $project->id]) }}">{{ $project->title }}</a></li>
			<li><a href="{{ route('project.phase.show', ['project' => $project->id, 'phase' => $projectPhase->id]) }}">{{ $projectPhase->title }}</a></li>
			<li class="active">{{ trans('project.phase.document.create.breadcrumb') }}</li>
		</ol>
	</section>

	<div class="content body">
		<div class="box">
			{!! Form::model(null, ['route' => ['project.phase.document.store', 'project' => $project->id, 'projectPhase' => $projectPhase->id]]) !!}
				<div class="box-body">
					@if (count($errors) > 0)
						<div class="alert alert-danger">
							{{ trans('project.phase.document.create.errors') }}<br><br>
							<ul>
								@foreach ($errors->all() as $error)
									<li>{{ $error }}</li>
								@endforeach
							</ul>
						</div>
					@endif

					<input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">

					<div class="form-group form-required">
						<label class="control-label">{{ trans('project.phase.document.create.title') }}</label>
						{!! Form::text('title', null, ['class' => 'form-control', 'required' => 'required']) !!}
					</div>

					<div class="form-group form-required">
						<label class="control-label">{{ trans('project.phase.document.create.content') }}</label>
						{!! Form::textarea('content', null, ['class' => 'form-control', 'required' => 'required']) !!}
					</div>

					<div class="form-group form-required">
						<label class="control-label">{{ trans('project.phase.document.create.type') }}</label>
						{!! Form::select('type', ['published' => 'project.phase.document.published', 'revision' => 'project.phase.document.revision'], null, ['class' => 'form-control', 'required' => 'required']) !!}
					</div>
				</div>

				<div class="box-footer clearfix">
					<a type="submit" href="{{ route('project.phase.show', ['project' => $project->id, 'phase' => $projectPhase->id]) }}" class="btn btn-sm btn-default btn-flat pull-left">{{ trans('project.phase.document.create.cancel') }}</a>

					<button type="submit" class="btn btn-sm btn-primary btn-flat pull-right">{{ trans('project.phase.document.create.create') }}</button>
				</div>
			{!! Form::close() !!}
		</div>
	</div>
@endsection
