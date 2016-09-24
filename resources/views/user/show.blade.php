@extends('layouts.main')

@section('content')
	<section class="content-header">
		<h1>{{ $theUser->name }}</h1>
		<ol class="breadcrumb">
			<li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> {{ trans('dashboard.breadcrumb') }}</a></li>
			<li><a href="{{ route('user.index') }}">{{ trans('user.index.breadcrumb') }}</a></li>
			<li class="active">{{{ $theUser->name }}}</li>
		</ol>
	</section>

	<div class="content body">
		<div class="box">
			<div class="box-body table-responsive no-padding">
				<table class="table table-hover">
					<tbody>
						<tr>
							<td>{{ trans('user.show.id') }}</td>
							<td>{{ $theUser->id }}</td>
						</tr>
						<tr>
							<td>{{ trans('user.show.name') }}</td>
							<td>{{ $theUser->name }}</td>
						</tr>
						<tr>
							<td>{{ trans('user.show.email') }}</td>
							<td><a href="mailto:{{ $theUser->email }}">{{ $theUser->email }}</a></td>
						</tr>
						<tr>
							<td>{{ trans('user.show.activated') }}</td>
							<td>
								@if ($theUser->isActivated)
									{{ trans('user.show.is-activated') }}
								@else
									{{ trans('user.show.is-not-activated') }}
								@endif
							</td>
						</tr>
						<tr>
							<td>{{ trans('user.show.activated_at') }}</td>
							<td>
								@if ($theUser->activatedAt !== null)
									{{ $theUser->activatedAt->timezone($theUser->timezone)->format(Config::get('app.format.dateTime')) }}
								@endif
							</td>
						</tr>
						<tr>
							<td>{{ trans('user.show.last_login') }}</td>
							<td>
								@if (isset($theUser->last_login))
									{{ $theUser->last_login->timezone($theUser->timezone)->format(Config::get('app.format.dateTime')) }}
								@endif
							</td>
						</tr>
					</tbody>
				</table>
			</div>

			<div class="box-footer clearfix">
				<div class="pull-left">
					@if (!$theUser->isActivated)
						<form method="post" action="{{ route('user.activate', ['user' => $theUser->id]) }}" class="form-inline">
							<input type="hidden" name="_token" value="{{ csrf_token() }}">
							<button type="submit" class="btn btn-sm btn-success btn-flat"><i class="fa fa-ban"></i> {{ trans('user.show.activate') }}</button>
						</form>
					@endif

					<form method="post" action="{{ $theUser->isBanned ? route('user.unban', ['user' => $theUser->id]) : route('user.ban', ['user' => $theUser->id]) }}" class="form-inline">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						@if ($theUser->isBanned)
							<button type="submit" class="btn btn-sm btn-success btn-flat"><i class="fa fa-ban"></i> {{ trans('user.show.unban') }}</button>
						@else
							<button type="submit" class="btn btn-sm btn-danger btn-flat"><i class="fa fa-ban"></i> {{ trans('user.show.ban') }}</button>
						@endif
					</form>
				</div>

				<div class="pull-right">
					<form method="post" action="{{ route('conversation.store') }}" class="form-inline">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<input type="hidden" name="to_user_id" value="{{ $theUser->id }}">
						<button type="submit" class="btn btn-sm btn-primary btn-flat"><i class="fa fa-envelope-o"></i> {{ trans('user.show.message') }}</button>
					</form>
				</div>
			</div>
		</div>
	</div>
@endsection
