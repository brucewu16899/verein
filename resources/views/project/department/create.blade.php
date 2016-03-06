@extends('layouts.main')

@section('content')
	<section class="content-header">
		<h1>
			{{ trans('project.department.create.title') }}
			<small>{{ $project->title }}</small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> {{ trans('dashboard.breadcrumb') }}</a></li>
			<li><a href="{{ route('project.index') }}">{{ trans('project.breadcrumb') }}</a></li>
			<li><a href="{{ route('project.show', ['project' => $project->id]) }}">{{ $project->title }}</a></li>
			<li class="active">{{ trans('project.department.create.breadcrumb') }}</li>
		</ol>
	</section>

	<div class="content body">
		<div class="box">
			<form role="form" method="post" action="{{ route('project.department.store', ['project' => $project->id]) }}">
				<div class="box-body">
					@if (count($errors) > 0)
						<div class="alert alert-danger">
							{{ trans('project.department.create.errors') }}<br><br>
							<ul>
								@foreach ($errors->all() as $error)
									<li>{{ $error }}</li>
								@endforeach
							</ul>
						</div>
					@endif

					<input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">

					<div class="form-group form-required">
						<label class="control-label">{{ trans('project.department.create.company_department_id') }}</label>
						{!! Form::select('company_department_id', $departments, null, [
							'class' => 'form-control',
							'required' => 'required',
						]) !!}
					</div>
				</div>

				<div class="box-footer clearfix">
					<a type="submit" href="{{ route('project.show', ['project' => $project->id]) }}" class="btn btn-sm btn-default btn-flat pull-left">{{ trans('project.department.create.cancel') }}</a>

					<button type="submit" class="btn btn-sm btn-primary btn-flat pull-right">{{ trans('project.department.create.create') }}</button>
				</div>
			</form>
		</div>
	</div>
@endsection
