@extends('layouts.main')

@section('content')
	<section class="content-header">
		<h1>{{ $user->name }}</h1>
		<ol class="breadcrumb">
			<li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> {{ trans('dashboard.breadcrumb') }}</a></li>
			<li class="active">{{{ $user->name }}}</li>
		</ol>
	</section>

	<div class="content">
		<div class="box">
			<div class="box-body table-responsive no-padding">
				<table class="table table-hover">
					<tbody>
						<tr>
							<td>{{ trans('user.profile.name') }}</td>
							<td>{{ $user->name }}</td>
						</tr>
						<tr>
							<td>{{ trans('user.profile.email') }}</td>
							<td><a href="mailto:{{ $user->email }}">{{ $user->email }}</a></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>

		<div class="row">
			<div class="col-md-6">
				<div class="box">
					<div class="box-header with-border">
						<h3 class="box-title">{{ trans('user.profile.sessions') }}</h3>
					</div>
					<div class="box-body table-responsive no-padding">
						<table class="table table-hover">
							<tbody>
								@foreach ($user->sessions as $session)
									<tr>
										<td>{{ $session->ip_address }} <span class="flag-icon flag-icon-{{ $session->countryCode }}"></span></td>
										<td>{{ $session->platform }}</td>
										<td>{{ $session->browser }}</td>
										<td>{{ $session->version }}</td>
										<td>{{ $session->last_activity->timezone($user->timezone)->format(\Config::get('app.format.dateTime')) }}</td>
										<td><a href="{{ route('user.profile.logout', ['session' => $session->id]) }}" title="{{ trans('user.profile.logout-session') }}"><span class="fa fa-sign-out"></span></a></td>
									</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
