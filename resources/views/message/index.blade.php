@extends('layouts.main')

@section('content')
	<section class="content-header">
		<h1>{{ trans('message.index.title') }}</h1>
		<ol class="breadcrumb">
			<li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> {{ trans('dashboard.breadcrumb') }}</a></li>
			<li class="active">{{ trans('message.breadcrumb') }}</li>
		</ol>
	</section>

	<div class="content body">
		<div class="box">
			<div class="box-body table-responsive no-padding">
				<table class="table table-hover">
					<thead>
						<tr>
							<th>{{ trans('message.index.id') }}</th>
							<th>{{ trans('message.index.from_user_id') }}</th>
							<th>{{ trans('message.index.created_at') }}</th>
							<th>{{ trans('message.index.plan_abstract') }}</th>
							<th>{{ trans('message.index.actions') }}</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($messages as $message)
							<tr>
								<td>{{ $message->id }}</td>
								<td><a href="{{ route('client.show', ['client' => $message->sender->client_id]) }}">{{ $message->sender->name }}</a></td>
								<td>
									@if (!empty($message->created_at))
										{{ $message->created_at->timezone($user->timezone)->format(Config::get('app.format.dateTime')) }}
									@endif
								</td>
								<td><a href="{{ route('message.show', ['message' => $message->from_user_id, '#message-' . $message->id]) }}">{{ $message->plainAbstract }}</a></td>
								<td class="actions">
									<a href="{{ route('message.show', ['user' => $message->id]) }}"><i class="fa fa-search"></i></a>
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>

			<div class="box-footer clearfix">
				{!! $messages->render() !!}
			</div>
		</div>
	</div>
@endsection
