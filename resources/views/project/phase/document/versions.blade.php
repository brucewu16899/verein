@extends('layouts.main')

@section('content')
	<section class="content-header">
		<h1>
			{{ $projectPhaseDocument->title }}
			<small>{{ trans('project.phase.document.versions.subtitle') }}</small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> {{ trans('dashboard.breadcrumb') }}</a></li>
			<li><a href="{{ route('project.index') }}">{{ trans('project.breadcrumb') }}</a></li>
			<li><a href="{{ route('project.show', ['project' => $project->id]) }}">{{ $project->title }}</a></li>
			<li><a href="{{ route('project.phase.show', ['project' => $project->id, 'phase' => $projectPhase->id]) }}">{{ $projectPhase->title }}</a></li>
			<li><a href="{{ route('project.phase.document.show', ['project' => $project->id, 'phase' => $projectPhase->id, 'document' => $projectPhaseDocument->id]) }}">{{ $projectPhaseDocument->title }}</a></li>
			<li class="active">{{ trans('project.phase.document.versions.breadcrumb') }}</li>
		</ol>
	</section>

	<div class="content body">
		<div class="box">
			<form method="post" action="{{ route('project.phase.document.compare', ['project' => $project->id, 'phase' => $projectPhase->id, 'document' => $projectPhaseDocument->id]) }}">
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
				<div class="box-body table-responsive no-padding">
					<table class="table table-hover">
						<thead>
							<tr>
								<th>{{ trans('project.phase.document.versions.id') }}</th>
								<th>{{ trans('project.phase.document.versions.date') }}</th>
								<th>{{ trans('project.phase.document.versions.old') }}</th>
								<th>{{ trans('project.phase.document.versions.new') }}</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>{{ $projectPhaseDocument->id }}</td>
								<td>{{ $projectPhaseDocument->created_at->timezone($user->timezone)->format(Config::get('app.format.dateTime')) }}</td>
								<td><input type="radio" name="old" value="{{ $projectPhaseDocument->id }}"></td>
								<td><input type="radio" name="new" value="{{ $projectPhaseDocument->id }}"></td>
							</tr>
							@foreach ($projectPhaseDocument->history as $document)
								<tr>
									<td>{{ $document->id }}</td>
									<td>{{ $document->created_at->timezone($user->timezone)->format(Config::get('app.format.dateTime')) }}</td>
									<td><input type="radio" name="old" value="{{ $document->id }}"></td>
									<td><input type="radio" name="new" value="{{ $document->id }}"></td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
				<div class="box-footer">
					<div class="clearfix">
						<button type="submit" class="btn btn-sm btn-flat btn-primary pull-new"><i class="fa fa-exchange"></i> {{ trans('project.phase.document.show.compare') }}</button>
					</form>
					</div>
				</div>
			</div>
		</form>
	</div>
@endsection
