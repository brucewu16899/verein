@extends('layouts.main')

@section('content')
	<section class="content-header">
		<h1>
			{{ $member->name }}
			<small>{{ trans('member.date.create.subtitle') }}</small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> {{ trans('dashboard.breadcrumb') }}</a></li>
			<li><a href="{{ route('member.index') }}">{{ trans('member.index.breadcrumb') }}</a></li>
			<li><a href="{{ route('member.show', ['member' => $member->id]) }}">{{ $member->name }}</a></li>
			<li class="active">{{ trans('member.date.create.breadcrumb') }}</li>
		</ol>
	</section>

	<div class="content body">
		<div class="box">
			<form action="{{ route('member.date.store', [$member->id]) }}" method="POST">
    			<input type="hidden" name="_token" value="{{ csrf_token() }}">

				<div class="box-body">
					@if (count($errors) > 0)
						<div class="alert alert-danger">
							{{ trans('member.date.create.errors') }}<br><br>
							<ul>
								@foreach ($errors->all() as $error)
									<li>{{ $error }}</li>
								@endforeach
							</ul>
						</div>
					@endif

					<div class="form-group form-required">
						<label class="control-label">{{ trans('member.date.create.type') }}</label>
						{!! Form::select('type', $types, null, ['class' => 'form-control', 'required' => 'required']) !!}
					</div>

					<div class="form-group form-required">
						<label class="control-label">{{ trans('member.date.create.value') }}</label>
						{!! Form::textarea('value', null, ['class' => 'form-control', 'required' => 'required']) !!}
					</div>
				</div>

				<div class="box-footer clearfix">
					<a type="submit" href="{{ route('member.show', ['member' => $member->id]) }}" class="btn btn-sm btn-default btn-flat pull-left">{{ trans('member.date.create.cancel') }}</a>

					<button type="submit" class="btn btn-sm btn-primary btn-flat pull-right">{{ trans('member.date.create.add') }}</button>
				</div>
			{!! Form::close() !!}
		</div>
	</div>
@endsection
