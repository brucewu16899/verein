@extends('layouts.main')

@section('content')
	<section class="content-header">
		<h1>
			{{ trans('project.profile.create.title') }}
			<small>{{ $project->title }}</small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> {{ trans('dashboard.breadcrumb') }}</a></li>
			<li><a href="{{ route('project.index') }}">{{ trans('project.breadcrumb') }}</a></li>
			<li><a href="{{ route('project.show', ['project' => $project->id]) }}">{{ $project->title }}</a></li>
			<li class="active">{{ trans('project.profile.create.breadcrumb') }}</li>
		</ol>
	</section>

	<div class="content body">
		<div class="box">
			<form role="form" method="post" action="{{ route('project.profile.store', ['project' => $project->id]) }}">
				<div class="box-body">
					@if (count($errors) > 0)
						<div class="alert alert-danger">
							{{ trans('project.profile.create.errors') }}<br><br>
							<ul>
								@foreach ($errors->all() as $error)
									<li>{{ $error }}</li>
								@endforeach
							</ul>
						</div>
					@endif

					<input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">

					<div class="form-group form-required">
						<label class="control-label">{{ trans('project.profile.create.title') }}</label>
						<input type="text" class="form-control" name="title" value="{{ old('title') }}" required="required">
					</div>

					<div class="form-group form-required">
						<label class="control-label">{{ trans('project.profile.create.value') }}</label>
						<input type="text" class="form-control" name="value" value="{{ old('value') }}" required="required">
					</div>

					<div class="checkbox">
						<label>
							<input type="checkbox" name="translatable" value="{{ old('translatable') }}">
							{{ trans('project.profile.create.translatable') }}
						</label>
					</div>
				</div>

				<div class="box-footer clearfix">
					<a type="submit" href="{{ route('project.show', ['project' => $project->id]) }}" class="btn btn-sm btn-default btn-flat pull-left">{{ trans('project.profile.create.cancel') }}</a>

					<button type="submit" class="btn btn-sm btn-primary btn-flat pull-right">{{ trans('project.profile.create.create') }}</button>
				</div>
			</form>
		</div>
	</div>
@endsection
