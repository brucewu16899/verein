@extends('layouts.main')

@section('content')
	<section class="content-header">
		<h1>
			{{ trans('project.client.create.title') }}
			<small>{{ $project->title }}</small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> {{ trans('dashboard.breadcrumb') }}</a></li>
			<li><a href="{{ route('project.index') }}">{{ trans('project.breadcrumb') }}</a></li>
			<li><a href="{{ route('project.show', ['project' => $project->id]) }}">{{ $project->title }}</a></li>
			<li class="active">{{ trans('project.client.create.breadcrumb') }}</li>
		</ol>
	</section>

	<div class="content body">
		<div class="box">
			<form role="form" method="post" action="{{ route('project.client.store', ['project' => $project->id]) }}">
				<div class="box-body">
					@if (count($errors) > 0)
						<div class="alert alert-danger">
							{{ trans('project.client.create.errors') }}<br><br>
							<ul>
								@foreach ($errors->all() as $error)
									<li>{{ $error }}</li>
								@endforeach
							</ul>
						</div>
					@endif

					<input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">

					<div class="form-group form-required">
						<label class="control-label">{{ trans('project.client.create.client_id') }}</label>
						{!! Form::select('client_id', $clients, null, [
							'class' => 'form-control',
							'required' => 'required',
						]) !!}
					</div>
				</div>

				<div class="box-footer clearfix">
					<a type="submit" href="{{ route('project.show', ['project' => $project->id]) }}" class="btn btn-sm btn-default btn-flat pull-left">{{ trans('project.client.create.cancel') }}</a>

					<button type="submit" class="btn btn-sm btn-primary btn-flat pull-right">{{ trans('project.client.create.create') }}</button>
				</div>
			</form>
		</div>
	</div>
@endsection
