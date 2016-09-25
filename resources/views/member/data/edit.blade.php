@extends('layouts.main')

@section('content')
	<section class="content-header">
		<h1>
			{{ $member->name }}
			<small>{{ trans('member.date.edit.subtitle') }}</small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> {{ trans('dashboard.breadcrumb') }}</a></li>
			<li><a href="{{ route('member.index') }}">{{ trans('member.breadcrumb') }}</a></li>
			<li><a href="{{ route('member.show', ['member' => $member->id]) }}">{{ $member->name }}</a></li>
			<li class="active">{{ trans('member.date.edit.breadcrumb') }}</li>
		</ol>
	</section>

	<div class="content body">
		<div class="box">
			{!! Form::model($date, ['route' => ['member.date.update', 'member' => $member->id, 'date' => $date->id], 'method' => 'put']) !!}
				<div class="box-body">
					@if (count($errors) > 0)
						<div class="alert alert-danger">
							{{ trans('member.edit.errors') }}<br><br>
							<ul>
								@foreach ($errors->all() as $error)
									<li>{{ $error }}</li>
								@endforeach
							</ul>
						</div>
					@endif

					<div class="form-group form-required">
						<label class="control-label">{{ trans('member.date.edit.type') }}</label>
						{!! Form::select('type', $types, null, ['class' => 'form-control', 'required' => 'required']) !!}
					</div>

					<div class="form-group form-required">
						<label class="control-label">{{ trans('member.date.edit.value') }}</label>
						{!! Form::textarea('value', null, ['class' => 'form-control', 'required' => 'required']) !!}
					</div>
				</div>

				<div class="box-footer clearfix">
					<a type="submit" href="{{ route('member.show', ['member' => $member->id]) }}" class="btn btn-sm btn-default btn-flat pull-left">{{ trans('member.edit.cancel') }}</a>

					<button type="submit" class="btn btn-sm btn-primary btn-flat pull-right">{{ trans('member.date.edit.save') }}</button>
				</div>
			{!! Form::close() !!}
		</div>
	</div>
@endsection
