<!-- Sidebar -->
<aside class="main-sidebar">
	<section class="sidebar">
		<!-- Sidebar user panel (optional) -->
		<div class="user-panel">
			<div class="pull-left image">
				<img src="{{ $user->avatarUrl }}" class="img-circle" alt="{{ $user->name }}">
			</div>
			<div class="pull-left info">
				<p>{{ $user->name }}</p>
				<!-- Status -->
				<a href="#"><i class="fa fa-circle text-success"></i> Online</a>
			</div>
		</div>

		<!-- search form -->
		<form action="#" method="get" class="sidebar-form">
			<div class="input-group">
				<input type="text" name="q" class="form-control" placeholder="Search...">
				<span class="input-group-btn">
					<button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i></button>
				</span>
			</div>
		</form>
		<!-- /.search form -->

		<!-- Sidebar Menu -->
		<ul class="sidebar-menu">
			<li class="header">{{ trans('core.sidebar.crm.header') }}</li>
			<li class="<?php echo \Config::get('app.active', '') == 'member' ? 'active' : ''; ?>"><a href="{{ route('member.index') }}"><span>{{ trans('core.sidebar.crm.members') }}</span></a></li>
			<li class="header">{{ trans('core.sidebar.finance.header') }}</li>
			<li class="<?php echo \Config::get('app.active', '') == 'finance' ? 'active' : ''; ?>"><a href="#"><span>{{ trans('core.sidebar.finance.index') }}</span></a></li>
			<li class="header">{{ trans('core.sidebar.system.header') }}</li>
			<li class="<?php echo \Config::get('app.active', '') == 'user' ? 'active' : ''; ?>"><a href="{{ route('user.index') }}"><span>{{ trans('core.sidebar.system.users') }}</span></a></li>
		</ul>
		<!-- /.sidebar-menu -->
	</section>
</aside>
<!-- /.main-sidebar -->
