@extends('layouts.main')

@section('content')
	<section class="content-header">
		<h1>{{ trans('conversation.index.title') }}</h1>
		<ol class="breadcrumb">
			<li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> {{ trans('dashboard.breadcrumb') }}</a></li>
			<li class="active">{{ trans('conversation.index.breadcrumb') }}</li>
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
							<th>{{ trans('conversation.index.abstract') }}</th>
							<th>{{ trans('conversation.index.actions') }}</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($conversations as $conversation)
							<tr>
								<td>{{ $conversation->id }}</td>
								<td>
									@if ($conversation->sender->id === $user->id)
										<a href="{{ route('member.show', ['member' => $conversation->receiver->user_id]) }}">{{ $conversation->receiver->name }}</a>
									@else
										<a href="{{ route('member.show', ['member' => $conversation->sender->user_id]) }}">{{ $conversation->sender->name }}</a>
									@endif
								</td>
								<td>
									@if (!empty($conversation->updated_at))
										{{ $conversation->updated_at->timezone($user->timezone)->format(Config::get('app.format.dateTime')) }}
									@endif
								</td>
								<td>
									@if (isset($conversation->lastMessage))
										<a href="{{ route('conversation.show', ['conversation' => $conversation->from_user_id, '#message-' . $conversation->lastMessage->id]) }}">{{ $conversation->abstract }}</a>
									@endif
								</td>
								<td class="actions">
									<a href="{{ route('conversation.show', ['user' => $conversation->id]) }}"><i class="fa fa-search"></i></a>
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>

			<div class="box-footer clearfix">
				{!! $conversations->render() !!}
			</div>
		</div>
	</div>
@endsection
