@extends('layouts.main')

@section('content')
	<section class="content-header">
		<h1>
			{{{ $member->name }}}
		</h1>
		<ol class="breadcrumb">
			<li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> {{ trans('dashboard.breadcrumb') }}</a></li>
			<li><a href="{{ route('member.index') }}">{{ trans('member.index.breadcrumb') }}</a></li>
			<li class="active">{{{ $member->name }}}</li>
		</ol>
	</section>

	<div class="content body">
		<div class="row">
			<div class="col-lg-12">
				<div class="box">
					<div class="box-header">
						<h3 class="box-title">{{ trans('member.show.details') }}</h3>
					</div>
					<div class="box-body table-responsive no-padding">
						<table class="table table-hover">
							<tbody>
								<tr>
									<td>{{ trans('member.show.id') }}</td>
									<td>{{ $member->id }}</td>
								</tr>
								<tr>
									<td>{{ trans('member.show.sex') }}</td>
									<td>{{ $member->sex }}</td>
								</tr>
								<tr>
									<td>{{ trans('member.show.form_of_address') }}</td>
									<td>{{ $member->form_of_address }}</td>
								</tr>
								<tr>
									<td>{{ trans('member.show.name') }}</td>
									<td>{{ trim($member->first_name . ' ' . $member->last_name) }}</td>
								</tr>
								<tr>
									<td>{{ trans('member.show.email') }}</td>
									<td><a href="mailt:{{ $member->email }}">{{ $member->email }}</a></td>
								</tr>
								<tr>
									<td>{{ trans('member.show.website') }}</td>
									<td><a href="{{ $member->website }}">{{ $member->website }}</a></td>
								</tr>
								<tr>
									<td>{{ trans('member.show.birthday') }}</td>
									<td>
										@if (isset($member->birthday))
											{{ $member->birthday->timezone($user->timezone)->format(Config::get('app.format.date')) }}
										@endif
									</td>
								</tr>
							</tbody>
						</table>
					</div>

					<div class="box-footer clearfix">
						<div class="pull-left">
							<form action="{{ route('member.destroy', ['member' => $member->id]) }}" method="post" class="form-inline pull-right">
								<input type="hidden" name="_method" value="delete">
								<input type="hidden" name="_token" value="{{ csrf_token() }}">
								<button type="submit" class="btn btn-flat btn-danger btn-sm"><i class="fa fa-trash-o"></i> {{ trans('member.show.destroy') }}</button>
							</form>
						</div>
						<div class="pull-right">
							<a href="{{ route('member.edit', ['member' => $member->id]) }}" class="btn btn-sm btn-default btn-flat pull-right"><i class="fa fa-pencil"></i> {{ trans('member.show.edit') }}</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
