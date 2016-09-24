<header class="main-header">
	<a href="{{ route('dashboard') }}" class="logo"><strong>{{ Config::get('app.title') }}</strong></a>

	<nav class="navbar navbar-static-top" role="navigation">
		<a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
			<span class="sr-only">Toggle navigation</span>
		</a>

		<div class="navbar-custom-menu">
			<ul class="nav navbar-nav">
				<!-- Message Menu -->
				<li class="dropdown messages-menu">
					<!-- Menu toggle button -->
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<i class="fa fa-envelope-o"></i>
						@if ($user->unreadMessages()->count() > 0)
							<span class="label label-success">{{ $user->unreadMessages()->count() }}</span>
						@endif
					</a>
					<ul class="dropdown-menu">
						<li class="header">{{ trans('core.nav.messages.unread', [':count' => $user->unreadMessages()->count()]) }}</li>
						<li>
							<!-- inner menu: contains the messages -->
							<ul class="menu">
								@foreach ($user->recentMessages as $message)
									<li><!-- start message -->
										<a href="{{ route('conversation.show', ['conversation' => $message->conversation_id, '#message-' . $message->id]) }}">
											<div class="pull-left">
												<!-- User Image -->
												<img src="{{ $message->sender->avatarUrl }}" class="img-circle" alt="{{{ $message->sender->name }}}">
											</div>
											<!-- Message title and timestamp -->
											<h4>
												{{{ $message->sender->name }}}
												<small><i class="fa fa-clock-o"></i> {{{ $message->humanDiff }}}</small>
											</h4>
											<!-- The message -->
											<p>
												{{{ $message->abstract }}}
											</p>
										</a>
									</li><!-- end message -->
								@endforeach
							</ul><!-- /.menu -->
						</li>
						<li class="footer"><a href="{{ route('conversation.index') }}">{{ trans('core.nav.messages.all') }}</a></li>
					</ul>
				</li>
				<!-- /.messages-menu -->

				<!-- Notifications Menu -->
				<li class="dropdown notifications-menu">
					<!-- Menu toggle button -->
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<i class="fa fa-bell-o"></i>
						@if ($user->unreadNotifications()->count() > 0)
							<span class="label label-warning">{{ $user->unreadNotifications()->count() }}</span>
						@endif
					</a>
					<ul class="dropdown-menu">
						<li class="header">{{ trans('core.nav.notifications.unread', [':count' => $user->unreadNotifications()->count()]) }}</li>
						<li>
							<ul class="menu">
								@foreach ($user->recentNotifications as $notification)
									<li><!-- start notification -->
										<a href="#">
											<i class="fa fa-{{ $notification->icon }} text-aqua"></i> {{{ $notification->message }}}
										</a>

										<small>
											@if ($notification->read)
												<a href="{{ route('notification.unread', ['notification' => $notification->id]) }}">
													<i class="fa fa-circle"></i>
												</a>
											@else
												<a href="{{ route('notification.read', ['notification' => $notification->id]) }}">
													<i class="fa fa-check-circle"></i>
												</a>
											@endif
										</small>
									</li><!-- end notification -->
								@endforeach
							</ul>
						</li>
						<li class="footer"><a href="#">{{ trans('core.nav.notifications.all') }}</a></li>
					</ul>
				</li>
				<!-- /.notifications-menu -->

				<!-- User Account Menu -->
				<li class="dropdown user user-menu">
					<!-- Menu Toggle Button -->
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<!-- The user image in the navbar-->
						<img src="{{ $user->avatarUrl }}" class="user-image" alt="{{ $user->name }}">
						<!-- hidden-xs hides the username on small devices so only the image appears. -->
						<span class="hidden-xs">{{ $user->name }}</span>
					</a>
					<ul class="dropdown-menu">
						<!-- The user image in the menu -->
						<li class="user-header">
							<img src="{{ $user->avatarUrl }}" class="img-circle" alt="{{ $user->name }}">
							<p>
								@if ($user->hasCurrentCompany)
									{{ $user->name }} - {{ $user->currentCompany->name }}
								@else
									{{ $user->name }}
								@endif
							</p>
						</li>
						<!-- /.user-header -->

						<!-- Menu Footer-->
						<li class="user-footer">
							<div class="pull-left">
								<a href="{{ route('user.profile') }}" class="btn btn-default btn-flat">{{ trans('core.nav.user.profile') }}</a>
							</div>
							<div class="pull-right">
								<a href="{{ route('account.logout') }}" class="btn btn-default btn-flat">{{ trans('core.nav.user.logout') }}</a>
							</div>
						</li>
						<!-- /.user-footer -->
					</ul>
				</li>
				<!-- /.user-menu -->
			</ul>
		</div>
	</nav>
</header>
