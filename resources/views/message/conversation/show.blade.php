@extends('layouts.main')

@section('content')
	<section class="content-header">
		<h1>{{ $conversation->title }}</h1>
		<ol class="breadcrumb">
			<li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> {{ trans('dashboard.breadcrumb') }}</a></li>
			<li><a href="{{ route('conversation.index') }}"><i class="fa fa-envelope-o"></i> {{ trans('message.breadcrumb') }}</a></li>
			<li class="active">{{ $conversation->title }}</li>
		</ol>
	</section>

	<div class="content body">
		<div class="box">
			<div class="box-body">
				<ul class="list-unstyled conversation">
					@foreach ($conversation->messages as $message)
						<li class="clearfix message-wrapper">
							<h3 id="message-{{ $message->id }}"></h3>
							<div class="message-profile message-profile-{{ ($message->from_user_id == $user->id) ? 'own' : 'opponent' }}">
								<img src="{{ $message->sender->avatarUrl }}" alt="{{ $message->sender->name }}" title="{{ trans('conversation.sender', ['from' => $message->sender->name]) }}" class="img-circle">
							</div>

							<div class="message-content">
								<div class="message-header message-header-{{ ($message->from_user_id == $user->id) ? 'own' : 'opponent' }}">
									<p class="text-muted">{{ $message->created_at->timezone($user->timezone)->format(\Config::get('app.format.dateTime')) }}</p>
								</div>

								<div class="message message-{{ ($message->from_user_id == $user->id) ? 'own' : 'opponent' }}">
									{!! $message->message !!}
								</div>
							</div>
						</li>
					@endforeach
				</ul>
			</div>

			<div class="box-footer clearfix">
				@if (count($errors) > 0)
					<div class="alert alert-danger">
						{{ trans('conversation.message.create.errors') }}<br><br>
						<ul>
							@foreach ($errors->all() as $error)
								<li>{{ $error }}</li>
							@endforeach
						</ul>
					</div>
				@endif

				<form action="{{ route('conversation.message.store', ['conversation' => $conversation->id]) }}" method="post">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<div class="form-group">
						<textarea class="form-control" placeholder="{{ trans('conversation.show.reply-placeholder') }}" name="message"></textarea>
					</div>

					<div class="clearfix">
						<button type="submit" class="btn btn-flat btn-primary pull-right"><i class="fa fa-reply"></i> {{ trans('conversation.reply') }}</button>
					</div>
				</form>
			</div>
		</div>
	</div>
@endsection
