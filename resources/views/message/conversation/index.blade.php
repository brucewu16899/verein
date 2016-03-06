@extends('layouts.main')

@section('content')
	<section class="content-header">
		<h1>{{ trans('conversation.index.title') }}</h1>
		<ol class="breadcrumb">
			<li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> {{ trans('dashboard.breadcrumb') }}</a></li>
			<li class="active">{{ trans('conversation.breadcrumb') }}</li>
		</ol>
	</section>

	<div class="content body">
		<div class="box">
			<div class="box-body table-responsive no-padding">
				<table class="table table-hover">
					<thead>
						<tr>
							<th>{{ trans('conversation.index.id') }}</th>
							<th>{{ trans('conversation.index.from_user_id') }}</th>
							<th>{{ trans('conversation.index.updated_at') }}</th>
							<th>{{ trans('conversation.index.plan_abstract') }}</th>
							<th>{{ trans('conversation.index.actions') }}</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($messages as $message)
							<tr>
								<td>{{ $message->id }}</td>
								<td>
									@if ($message->from_user_id != $user->id)
										<a href="{{ route('client.show', ['client' => $message->sender->client_id]) }}">{{ $message->sender->name }}</a>
									@else
										<a href="{{ route('client.show', ['client' => $message->receiver->client_id]) }}">{{ $message->receiver->name }}</a>
									@endif
								</td>
								<td>
									@if (!empty($message->updated_at))
										{{ $message->updated_at->timezone($user->timezone)->format(Config::get('app.format.dateTime')) }}
									@endif
								</td>
								<td><a href="{{ route('conversation.show', ['conversation' => $message->message_conversation_id, '#message-' . $message->id]) }}">{!! $message->abstract !!}</a></td>
								<td class="actions">
									<a href="{{ route('conversation.show', ['conversation' => $message->message_conversation_id]) }}"><i class="fa fa-search"></i></a>
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
