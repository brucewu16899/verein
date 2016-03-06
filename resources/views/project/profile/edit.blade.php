@extends('layouts.main')

@section('content')
	<section class="content-header">
		<h1>
			{{ $profile->translatedTitle }}
			<small>{{ $project->title }}</small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> {{ trans('dashboard.breadcrumb') }}</a></li>
			<li><a href="{{ route('project.index') }}">{{ trans('project.breadcrumb') }}</a></li>
			<li><a href="{{ route('project.show', ['project' => $project->id]) }}">{{ $project->title }}</a></li>
			<li class="active">{{ $profile->translatedTitle }}</li>
		</ol>
	</section>

	<div class="content body">
		<div class="box">
			{!! Form::model($profile, ['route' => ['project.profile.update', 'project' => $project->id, 'profile' => $profile->id], 'method' => 'put']) !!}
				<div class="box-body">
					@if (count($errors) > 0)
						<div class="alert alert-danger">
							{{ trans('project.profile.edit.errors') }}<br><br>
							<ul>
								@foreach ($errors->all() as $error)
									<li>{{ $error }}</li>
								@endforeach
							</ul>
						</div>
					@endif

					<input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">

					<div class="form-group form-required">
						<label class="control-label">{{ trans('project.profile.edit.title') }}</label>
						{!! Form::text('title', null, ['class' => 'form-control', 'required' => 'required']) !!}
					</div>

					<div class="form-group">
						<label class="control-label">{{ trans('project.profile.edit.value') }}</label>
						{!! Form::text('value', null, ['class' => 'form-control', 'required' => 'required']) !!}
					</div>

					<div class="checkbox">
						<label>
							{!! Form::checkbox('translatable') !!}
							{{ trans('project.profile.edit.translatable') }}
						</label>
					</div>
				</div>

				<div class="box-footer clearfix">
					<a type="submit" href="{{ route('project.show', ['project' => $project->id]) }}" class="btn btn-sm btn-default btn-flat pull-left">{{ trans('project.profile.edit.cancel') }}</a>

					<button type="submit" class="btn btn-sm btn-primary btn-flat pull-right">{{ trans('project.profile.edit.save') }}</button>
				</div>
			</form>
		</div>
	</div>
@endsection
