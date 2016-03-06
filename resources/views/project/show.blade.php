@extends('layouts.main')

@section('content')
	<section class="content-header">
		<h1>
			{{ $project->title }}
		</h1>
		<ol class="breadcrumb">
			<li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> {{ trans('dashboard.breadcrumb') }}</a></li>
			<li><a href="{{ route('project.index') }}">{{ trans('project.breadcrumb') }}</a></li>
			<li class="active">{{ $project->title }}</li>
		</ol>
	</section>

	<div class="content body">
		@if (count($project->phases) > 0)
			<div class="box">
				<div class="box-body">
					<div class="clearfix">
						<div class="project-progress">
							<ol class="project-phase-bar">
								@foreach ($project->phases as $phase)
									<li class="{{ $phase->progressClasses($project->currentPhase) }}">
										<a href="{{ route('project.phase.show', [
											'project' => $project->id,
											'phase' => $phase->id,
										]) }}">{{ $phase->title }}</a>
									</li>
								@endforeach
							</ol>
						</div>
					</div>
				</div>

				<div class="box-footer clearfix">
					<a href="{{ route('project.phase.create', ['project' => $project->id]) }}" class="btn btn-sm btn-default btn-flat pull-right"><i class="fa fa-plus"></i> {{ trans('project.show.phase.create') }}</a>
				</div>
			</div>
		@endif

		<div class="row">
			<div class="col-lg-6">
				<div class="box">
					<div class="box-header">
						<h3 class="box-title">{{ trans('project.show.data') }}</h3>
					</div>
					<div class="box-body table-responsive no-padding">
						<table class="table table-hover">
							<tbody>
								<tr>
									<td>{{ trans('project.show.id') }}</td>
									<td>{{ $project->id }}</td>
								</tr>
								<tr>
									<td>{{ trans('project.show.title') }}</td>
									<td>{{ $project->title }}</td>
								</tr>
								<tr>
									<td>{{ trans('project.show.phone') }}</td>
									<td>{{ $project->phone }}</td>
								</tr>
								<tr>
									<td>{{ trans('project.show.fax') }}</td>
									<td>{{ $project->fax }}</td>
								</tr>
								<tr>
									<td>{{ trans('project.show.email') }}</td>
									<td>{{ $project->email }}</td>
								</tr>
								<tr>
									<td>{{ trans('project.show.website') }}</td>
									<td>{{ $project->website }}</td>
								</tr>
								<tr>
									<td>{{ trans('project.show.budget') }}</td>
									<td>{{ $project->budget }}</td>
								</tr>
								@if (isset($project->started_at))
									<tr>
										<td>{{ trans('project.show.started_at') }}</td>
										<td>{{ $project->started_at->timezone($user->timezone)->format(Config::get('app.format.date')) }}</td>
									</tr>
								@endif
								@if (isset($project->completed_at))
									<tr>
										<td>{{ trans('project.show.completed_at') }}</td>
										<td>{{ $project->completed_at->timezone($user->timezone)->format(Config::get('app.format.date')) }}</td>
									</tr>
								@endif
								<tr>
									<td>{{ trans('project.show.created_at') }}</td>
									<td>{{ $project->created_at->timezone($user->timezone)->format(Config::get('app.format.date')) }}</td>
								</tr>
								<tr>
									<td>{{ trans('project.show.updated_at') }}</td>
									<td>{{ $project->updated_at->timezone($user->timezone)->format(Config::get('app.format.date')) }}</td>
								</tr>
							</tbody>
						</table>
					</div>
					<div class="box-footer clearfix">
						<a href="{{ route('project.edit', ['project' => $project->id]) }}" class="btn btn-sm btn-default btn-flat pull-right"><i class="fa fa-pencil"></i> {{ trans('project.show.edit') }}</a>

						<form action="{{ route('project.destroy', ['project' => $project->id]) }}" method="post" class="form-inline pull-right">
							<input type="hidden" name="_method" value="delete">
							<input type="hidden" name="_token" value="{{ csrf_token() }}">
							<button type="submit" class="btn btn-sm btn-flat btn-danger"><i class="fa fa-trash-o"></i> {{ trans('project.show.destroy') }}</button>
						</form>
					</div>
				</div>
			</div>

			<div class="col-lg-6">
				<div class="box">
					<div class="box-header">
						<h3 class="box-title">{{ trans('project.show.profile') }}</h3>
					</div>
					<div class="box-body table-responsive no-padding">
						<table class="table table-hover">
							<tbody>
								@foreach ($project->profiles as $profile)
									<tr>
										<td>{{ $profile->translatedTitle }}</td>
										<td>{{ $profile->translatedValue }}</td>
										<td class="actions">
											<a href="{{ route('project.profile.edit', ['project' => $project->id, 'profile' => $profile->id]) }}"><i class="fa fa-pencil"></i></a>
											<form action="{{ route('project.profile.destroy', ['project' => $project->id, 'profile' => $profile->id]) }}" method="post" class="form-inline">
												<input type="hidden" name="_method" value="delete">
												<input type="hidden" name="_token" value="{{ csrf_token() }}">
												<button type="submit" class="no-style btn-sm"><i class="fa fa-trash-o"></i></button>
											</form>
										</td>
									</tr>
								@endforeach
							</tbody>
						</table>
					</div>
					<div class="box-footer clearfix">
						<a href="{{ route('project.profile.create', ['project' => $project->id]) }}" class="btn btn-sm btn-default btn-flat pull-right"><i class="fa fa-plus"></i> {{ trans('project.show.add-profile') }}</a>
					</div>
				</div>

				<div class="box">
					<div class="box-header">
						<h3 class="box-title">{{ trans('project.show.department') }}</h3>
					</div>
					<div class="box-body table-responsive no-padding">
						<table class="table table-hover">
							<tbody>
								@foreach ($project->departments as $department)
									<tr>
										<td><a href="{{ route('company.department.show', ['company' => $department->company->id, 'department' => $department->id]) }}">{{ $department->name }}</a></td>
										<td>{{ $department->phone }}</td>
										<td>
											@if (!empty($department->email))
												<a href="mailto:{{ $department->email }}">{{ $department->email }}</a>
											@endif
										</td>
										<td class="actions">
											<form action="{{ route('project.department.destroy', ['project' => $project->id, 'department' => $department->id]) }}" method="post" class="form-inline">
												<input type="hidden" name="_method" value="delete">
												<input type="hidden" name="_token" value="{{ csrf_token() }}">
												<button type="submit" class="no-style btn-sm"><i class="fa fa-trash-o"></i></button>
											</form>
										</td>
									</tr>
								@endforeach
							</tbody>
						</table>
					</div>
					<div class="box-footer clearfix">
						<a href="{{ route('project.department.create', ['project' => $project->id]) }}" class="btn btn-sm btn-default btn-flat pull-right"><i class="fa fa-plus"></i> {{ trans('project.show.add-department') }}</a>
					</div>
				</div>

				<div class="box">
					<div class="box-header">
						<h3 class="box-title">{{ trans('project.show.client') }}</h3>
					</div>
					<div class="box-body table-responsive no-padding">
						<table class="table table-hover">
							<tbody>
								@foreach ($project->clients as $client)
									<tr>
										<td>{{ $client->name }}</td>
										<td><a href="mailto:{{ $client->email }}">{{ $client->email }}</a></td>
										<td class="actions">
											<form action="{{ route('project.client.destroy', ['project' => $project->id, 'client' => $client->id]) }}" method="post" class="form-inline">
												<input type="hidden" name="_method" value="delete">
												<input type="hidden" name="_token" value="{{ csrf_token() }}">
												<button type="submit" class="no-style btn-sm"><i class="fa fa-trash-o"></i></button>
											</form>
										</td>
									</tr>
								@endforeach
							</tbody>
						</table>
					</div>
					<div class="box-footer clearfix">
						<a href="{{ route('project.client.create', ['project' => $project->id]) }}" class="btn btn-sm btn-default btn-flat pull-right"><i class="fa fa-plus"></i> {{ trans('project.show.add-client') }}</a>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
