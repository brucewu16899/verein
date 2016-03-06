@extends('layouts.main')

@section('content')
	<section class="content-header">
		<h1>
			{{ $projectPhaseDocument->title }}
			<small>{{ $projectPhase->title }}</small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> {{ trans('dashboard.breadcrumb') }}</a></li>
			<li><a href="{{ route('project.index') }}">{{ trans('project.breadcrumb') }}</a></li>
			<li><a href="{{ route('project.show', ['project' => $project->id]) }}">{{ $project->title }}</a></li>
			<li><a href="{{ route('project.phase.show', ['project' => $project->id, 'phase' => $projectPhase->id]) }}">{{ $projectPhase->title }}</a></li>
			<li class="active">{{{ $projectPhaseDocument->title }}}</li>
		</ol>
	</section>

	<div class="content body">
		<div class="row">
			<div class="col-lg-8">
				<div class="box">
					<div class="box-body">
						{!! $projectPhaseDocument->htmlContent !!}
					</div>
					<div class="box-footer clearfix">
						<a href="{{ route('project.phase.document.edit', ['project' => $project->id, 'phase' => $projectPhase->id, 'document' => $projectPhaseDocument->id]) }}" class="btn btn-sm btn-default btn-flat pull-right"><i class="fa fa-pencil"></i> {{ trans('project.phase.document.show.edit') }}</a>

						@if (count($projectPhaseDocument->history) > 0)
							<a href="{{ route('project.phase.document.versions', ['project' => $project->id, 'phase' => $projectPhase->id, 'document' => $projectPhaseDocument->id]) }}" class="btn btn-sm btn-default btn-flat pull-right"><i class="fa fa-exchange"></i> {{ trans('project.phase.document.show.versions') }}</a>
						@endif

						<form action="{{ route('project.phase.document.destroy', ['project' => $project->id, 'phase' => $projectPhase->id, 'document' => $projectPhaseDocument->id]) }}" method="post" class="form-inline pull-right">
							<input type="hidden" name="_method" value="delete">
							<input type="hidden" name="_token" value="{{ csrf_token() }}">
							<button type="submit" class="btn btn-sm btn-flat btn-danger"><i class="fa fa-trash-o"></i> {{ trans('project.phase.document.show.destroy') }}</button>
						</form>
					</div>
				</div>
			</div>

			<div class="col-lg-4">
				<div class="box">
					<div class="box-header">
						<h3 class="box-title">{{ trans('project.phase.document.show.data') }}</h3>
					</div>
					<div class="box-body table-responsive no-padding">
						<table class="table table-hover">
							<tbody>
								<tr>
									<td>{{ trans('project.phase.document.show.created_at') }}</td>
									<td>{{ $projectPhaseDocument->created_at->timezone($user->timezone)->format(Config::get('app.format.date')) }}</td>
								</tr>
								<tr>
									<td>{{ trans('project.phase.document.show.updated_at') }}</td>
									<td>{{ $projectPhaseDocument->updated_at->timezone($user->timezone)->format(Config::get('app.format.date')) }}</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>

				<div class="box">
					<div class="box-header">
						<h3 class="box-title">{{ trans('project.phase.document.show.comments') }}</h3>
					</div>
					<div class="box-body">
						<div class="comments">
							@foreach ($projectPhaseDocument->comments as $comment)
								<div class="comment">
									<div class="clearfix">
										<div class="pull-left">
											<small class="text-muted">{{ isset($comment->creator->name) ? $comment->creator->name : trans('main.unknown-user') }}</small>
										</div>

										<div class="pull-right">
											<small class="text-muted">
												{{ $comment->created_at->timezone($user->timezone)->format(Config::get('app.format.dateTime')) }}
												@if ($comment->user_id == $user->id)
													<a href="{{ route('project.phase.document.comment.edit', [
														'project' => $project->id,
														'phase' => $projectPhase->id,
														'document' => $projectPhaseDocument->id,
														'comment' => $comment->id,
													]) }}"><i class="fa fa-pencil"></i></a>

													<form action="{{ route('project.phase.document.comment.destroy', ['project' => $project->id, 'phase' => $projectPhase->id, 'document' => $projectPhaseDocument->id, 'comment' => $comment->id]) }}" method="post" class="form-inline">
														<input type="hidden" name="_method" value="delete">
														<input type="hidden" name="_token" value="{{ csrf_token() }}">
														<button type="submit" class="no-style"><i class="fa fa-trash-o"></i></button>
													</form>
												@endif
											</small>
										</div>
									</div>
									<div>
										{!! $comment->htmlContent !!}
									</div>
								</div>
							@endforeach
						</div>
					</div>
					<div class="box-footer">
						{!! Form::model(null, ['route' => ['project.phase.document.comment.store', 'project' => $project->id, 'projectPhase' => $projectPhase->id, 'document' => $projectPhaseDocument->id]]) !!}
							<div class="form-group form-required">
								{!! Form::textarea('content', null, ['class' => 'form-control', 'required' => 'required', 'rows' => '2']) !!}
							</div>

							<button type="submit" class="btn btn-sm btn-default btn-flat"><i class="fa fa-plus"></i> {{ trans('project.phase.document.add-comment') }}</button>
						{!! Form::close() !!}
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
