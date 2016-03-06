@extends('layouts.main')

@section('content')
	<section class="content-header">
		<h1>{{ trans('project.index.title') }}</h1>
		<ol class="breadcrumb">
			<li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> {{ trans('dashboard.breadcrumb') }}</a></li>
			<li class="active">{{ trans('project.breadcrumb') }}</li>
		</ol>
	</section>

	<div class="content body">
		<div class="box">
			<div class="box-body table-responsive no-padding">
				<table class="table table-hover">
					<thead>
						<tr>
							<th>{{ trans('project.index.id') }}</th>
							<th>{{ trans('project.index.title') }}</th>
							<th>{{ trans('project.index.company') }}</th>
							<th>{{ trans('project.index.current-phase') }}</th>
							<th>{{ trans('project.index.website') }}</th>
							<th>{{ trans('project.index.actions') }}</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($projects as $project)
							<tr>
								<td>{{ $project->id }}</td>
								<td>
									<a href="{{ route('project.show', ['project' => $project->id]) }}">{{ $project->title }}</a>
								</td>
								<td>
									@if (isset($project->company->name))
										{{ $project->company->name }}
									@endif
								</td>
								<td>
									@if (isset($project->currentPhase->title))
										<a href="{{ route('project.phase.show', ['project' => $project->id, 'phase' => $project->currentPhase->number]) }}">
											{{ $project->currentPhase->title }}
										</a>
									@endif
								</td>
								<td>
									@if (!empty($project->website))
										<a href="{{ $project->website }}">{{ $project->website }}</a>
									@endif
								</td>
								<td class="actions">
									<a href="{{ route('project.show', ['project' => $project->id]) }}"><i class="fa fa-search"></i></a>
									<a href="{{ route('project.edit', ['project' => $project->id]) }}"><i class="fa fa-pencil"></i></a>
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>

			<div class="box-footer clearfix">
				<div class="clearfix">
					<a href="{{ route('project.create') }}" class="btn btn-sm btn-default btn-flat pull-right"><i class="fa fa-plus"></i> {{ trans('project.index.add-project') }}</a>
				</div>

				{!! $projects->render() !!}
			</div>
		</div>
	</div>
@endsection
