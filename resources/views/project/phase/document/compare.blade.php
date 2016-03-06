@extends('layouts.main')

@section('content')
	<section class="content-header">
		<h1>
			{{ $projectPhaseDocument->title }}
			<small>{{ trans('project.phase.document.compare.subtitle') }}</small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> {{ trans('dashboard.breadcrumb') }}</a></li>
			<li><a href="{{ route('project.index') }}">{{ trans('project.breadcrumb') }}</a></li>
			<li><a href="{{ route('project.show', ['project' => $project->id]) }}">{{ $project->title }}</a></li>
			<li><a href="{{ route('project.phase.show', ['project' => $project->id, 'phase' => $projectPhase->id]) }}">{{ $projectPhase->title }}</a></li>
			<li><a href="{{ route('project.phase.document.show', ['project' => $project->id, 'phase' => $projectPhase->id, 'document' => $projectPhaseDocument->id]) }}">{{ $projectPhaseDocument->title }}</a></li>
			<li class="active">{{ trans('project.phase.document.compare.breadcrumb') }}</li>
		</ol>
	</section>

	<div class="content body">
		<div class="box table-responsive no-padding">
			<div class="box-body">
				{!! $render !!}
			</div>
		</div>
	</div>
@endsection
