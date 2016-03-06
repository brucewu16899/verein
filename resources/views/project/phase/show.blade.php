@extends('layouts.main')

@section('content')
	<section class="content-header">
		<h1>
			{{ $projectPhase->title }}
			<small>{{ $project->title }}</small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> {{ trans('dashboard.breadcrumb') }}</a></li>
			<li><a href="{{ route('project.index') }}">{{ trans('project.breadcrumb') }}</a></li>
			<li><a href="{{ route('project.show', ['project' => $project->id]) }}">{{ $project->title }}</a></li>
			<li class="active">{{{ $projectPhase->title }}}</li>
		</ol>
	</section>

	<div class="content body">
		<div class="row">
			<div class="col-lg-6">
				<div class="box">
					<div class="box-header">
						<h3 class="box-title">{{ trans('project.phase.show.data') }}</h3>
					</div>
					<div class="box-body table-responsive no-padding">
						<table class="table table-hover">
							<tbody>
								<tr>
									<td>{{ trans('project.phase.show.id') }}</td>
									<td>{{ $projectPhase->id }}</td>
								</tr>
								<tr>
									<td>{{ trans('project.phase.show.title') }}</td>
									<td>{{ $projectPhase->title }}</td>
								</tr>
								<tr>
									<td>{{ trans('project.phase.show.description') }}</td>
									<td>{{ $projectPhase->description }}</td>
								</tr>
								@if (isset($projectPhase->started_at))
									<tr>
										<td>{{ trans('project.phase.show.started_at') }}</td>
										<td>{{ $projectPhase->started_at->timezone($user->timezone)->format(Config::get('app.format.date')) }}</td>
									</tr>
								@endif
								@if (isset($projectPhase->completed_at))
									<tr>
										<td>{{ trans('project.phase.show.completed_at') }}</td>
										<td>{{ $projectPhase->completed_at->timezone($user->timezone)->format(Config::get('app.format.date')) }}</td>
									</tr>
								@endif
								@if (isset($projectPhase->planed_started_at))
									<tr>
										<td>{{ trans('project.phase.show.planed_started_at') }}</td>
										<td>{{ $projectPhase->planed_started_at->timezone($user->timezone)->format(Config::get('app.format.date')) }}</td>
									</tr>
								@endif
								@if (isset($projectPhase->planed_completed_at))
									<tr>
										<td>{{ trans('project.phase.show.planed_completed_at') }}</td>
										<td>{{ $projectPhase->planed_completed_at->timezone($user->timezone)->format(Config::get('app.format.date')) }}</td>
									</tr>
								@endif
								<tr>
									<td>{{ trans('project.phase.show.created_at') }}</td>
									<td>{{ $projectPhase->created_at->timezone($user->timezone)->format(Config::get('app.format.date')) }}</td>
								</tr>
								<tr>
									<td>{{ trans('project.phase.show.updated_at') }}</td>
									<td>{{ $projectPhase->updated_at->timezone($user->timezone)->format(Config::get('app.format.date')) }}</td>
								</tr>
							</tbody>
						</table>
					</div>
					<div class="box-footer clearfix">
						<a href="{{ route('project.phase.edit', ['project' => $project->id, 'phase' => $projectPhase->id]) }}" class="btn btn-sm btn-default btn-flat pull-right"><i class="fa fa-pencil"></i> {{ trans('project.phase.show.edit') }}</a>

						<form action="{{ route('project.phase.destroy', ['project' => $project->id, 'phase' => $projectPhase->id]) }}" method="post" class="form-inline pull-right">
							<input type="hidden" name="_method" value="delete">
							<input type="hidden" name="_token" value="{{ csrf_token() }}">
							<button type="submit" class="btn btn-sm btn-flat btn-danger"><i class="fa fa-trash-o"></i> {{ trans('project.phase.show.destroy') }}</button>
						</form>
					</div>
				</div>
			</div>

			<div class="col-lg-6">
				<div class="box">
					<div class="box-header">
						<h3 class="box-title">{{ trans('project.phase.show.documents') }}</h3>
					</div>
					<div class="box-body table-responsive no-padding">
						<table class="table table-hover">
							<tbody>
								@foreach ($projectPhase->documents as $document)
									<tr>
										<td><a href="{{ route('project.phase.document.show', ['project' => $project->id, 'phase' => $projectPhase->id, 'document' => $document->id]) }}">{{ $document->title }}</a></td>
										<td>{{ $document->updated_at->timezone($user->timezone)->format(Config::get('app.format.date')) }}</td>
									</tr>
								@endforeach
							</tbody>
						</table>
					</div>
					<div class="box-footer clearfix">
						<a href="{{ route('project.phase.document.create', ['project' => $project->id, 'phase' => $projectPhase->id]) }}" class="btn btn-sm btn-default btn-flat pull-right"><i class="fa fa-plus"></i> {{ trans('project.phase.show.add-document') }}</a>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
