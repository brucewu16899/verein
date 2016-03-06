@extends('layouts.main')

@section('content')
	<section class="content-header">
		<h1>
			{{ $projectPhaseDocument->title }}
			<small>{{ $project->title }}</small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> {{ trans('dashboard.breadcrumb') }}</a></li>
			<li><a href="{{ route('project.index') }}">{{ trans('project.breadcrumb') }}</a></li>
			<li><a href="{{ route('project.show', ['project' => $project->id]) }}">{{ $project->title }}</a></li>
			<li><a href="{{ route('project.phase.show', ['project' => $project->id, 'phase' => $projectPhase->id]) }}">{{ $projectPhase->title }}</a></li>
			<li><a href="{{ route('project.phase.document.show', ['project' => $project->id, 'phase' => $projectPhase->id, 'document' => $projectPhaseDocument->id]) }}">{{ $projectPhaseDocument->title }}</a></li>
			<li class="active">{{ trans('project.phase.document.edit.breadcrumb') }}</li>
		</ol>
	</section>

	<div class="content body">
		<div class="box">
			{!! Form::model($projectPhaseDocument, ['route' => ['project.phase.document.update', 'project' => $project->id, 'phase' => $projectPhase->id, 'document' => $projectPhaseDocument->id], 'method' => 'put']) !!}
				<div class="box-body">
					@if (count($errors) > 0)
						<div class="alert alert-danger">
							{{ trans('project.phase.document.edit.errors') }}<br><br>
							<ul>
								@foreach ($errors->all() as $error)
									<li>{{ $error }}</li>
								@endforeach
							</ul>
						</div>
					@endif

					<div class="form-group form-required">
						<label class="control-label">{{ trans('project.phase.document.edit.title') }}</label>
						{!! Form::text('title', null, ['class' => 'form-control', 'required' => 'required']) !!}
					</div>

					<div class="form-group form-required">
						<label class="control-label">{{ trans('project.phase.document.edit.content') }}</label>
						{!! Form::textarea('content', null, ['class' => 'form-control', 'required' => 'required']) !!}
					</div>

					<div class="form-group form-required">
						<label class="control-label">{{ trans('project.phase.document.edit.type') }}</label>
						{!! Form::select('type', ['published' => 'project.phase.document.published', 'revision' => 'project.phase.document.revision'], null, ['class' => 'form-control', 'required' => 'required']) !!}
					</div>
				</div>

				<div class="box-footer clearfix">
					<a href="{{ route('project.phase.document.show', ['project' => $project->id, 'phase' => $projectPhase->id, 'document' => $projectPhaseDocument->id]) }}" class="btn btn-sm btn-default btn-flat pull-left">{{ trans('project.phase.document.edit.cancel') }}</a>

					<button type="submit" class="btn btn-sm btn-primary btn-flat pull-right">{{ trans('project.phase.document.edit.save') }}</button>
				</div>
			{!! Form::close() !!}
		</div>
	</div>
@endsection
