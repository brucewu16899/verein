@extends('layouts.main')

@section('content')
	<section class="content-header">
		<h1>{{ trans('user.index.title') }}</h1>
		<ol class="breadcrumb">
			<li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> {{ trans('dashboard.breadcrumb') }}</a></li>
			<li class="active">{{ trans('user.breadcrumb') }}</li>
		</ol>
	</section>

	<div class="content body">
		<div class="box">
			<div class="box-body table-responsive no-padding">
				<table class="table table-hover">
					<thead>
						<tr>
							<th>{{ trans('user.index.id') }}</th>
							<th>{{ trans('user.index.name') }}</th>
							<th>{{ trans('user.index.email') }}</th>
							<th>{{ trans('user.index.last_login') }}</th>
							<th>{{ trans('user.index.activated') }}</th>
							<th>{{ trans('user.index.actions') }}</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($users as $u)
							<tr>
								<td>{{ $u->id }}</td>
								<td>{{ $u->name }}</td>
								<td><a href="mailto:{{ $u->email }}">{{ $u->email }}</a></td>
								<td>
									@if (!empty($u->last_login))
										{{ $u->last_login->timezone($user->timezone)->format(Config::get('app.format.dateTime')) }}
									@endif
								</td>
								<td>
									@if ($u->isActivated)
										{{ trans('user.index.activated') }}
									@else
										{{ trans('user.index.not-activated') }}
									@endif
								</td>
								<td class="actions">
									<a href="{{ route('user.show', ['user' => $u->id]) }}"><i class="fa fa-search"></i></a>

									<form method="post" action="{{ route('conversation.store') }}" class="form-inline">
										<input type="hidden" name="_token" value="{{ csrf_token() }}">
										<input type="hidden" name="to_user_id" value="{{ $u->id }}">
										<button type="submit" class="no-style btn-sm" title=" {{ trans('user.index.message') }}"><i class="fa fa-envelope-o"></i></button>
									</form>
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>

			<div class="box-footer clearfix">
				{!! $users->render() !!}
			</div>
		</div>

		<div class="box">
			<div class="box-header">
				<h3 class="box-title">{{ trans('user.index.not-activated-users') }}</h3>
			</div>
			@if (count($usersNotActivated))
				<div class="box-body table-responsive no-padding">
					<table class="table table-hover">
						<thead>
							<tr>
								<th>{{ trans('user.index.id') }}</th>
								<th>{{ trans('user.index.name') }}</th>
								<th>{{ trans('user.index.email') }}</th>
								<th>{{ trans('user.index.created_at') }}</th>
								<th>{{ trans('user.index.comment') }}</th>
								<th>{{ trans('user.index.actions') }}</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($usersNotActivated as $u)
								<tr>
									<td>{{ $u->id }}</td>
									<td>{{ $u->name }}</td>
									<td><a href="mailto:{{ $u->email }}">{{ $u->email }}</a></td>
									<td>
										@if (!empty($u->created_at))
											{{ $u->created_at->timezone($user->timezone)->format(Config::get('app.format.dateTime')) }}
										@endif
									</td>
									<td>{{ $u->comment }}</td>
									<td class="actions">
										<a href="{{ route('user.show', ['user' => $u->id]) }}"><i class="fa fa-search"></i></a>
									</td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>

				<div class="box-footer clearfix">
					{!! $users->render() !!}
				</div>
			@else
				<div class="box-body">
					<p class="text-muted">
						{{ trans('user.index.no-not-activated-users') }}
					</p>
				</div>
			@endif
		</div>
	</div>
@endsection
