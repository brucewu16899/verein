@extends('layouts.main')

@section('content')
	<section class="content-header">
		<h1>{{ trans('member.index.title') }}</h1>
		<ol class="breadcrumb">
			<li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> {{ trans('dashboard.breadcrumb') }}</a></li>
			<li class="active">{{ trans('member.breadcrumb') }}</li>
		</ol>
	</section>

	<div class="content body">
		<div class="box">
			<div class="box-body table-responsive no-padding">
				<table class="table table-hover">
					<thead>
						<tr>
							<th>{{ trans('member.index.id') }}</th>
							<th>{{ trans('member.index.name') }}</th>
							<th>{{ trans('member.index.email') }}</th>
							<th>{{ trans('member.index.birthday') }}</th>
							<th>{{ trans('member.index.actions') }}</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($members as $member)
							<tr>
								<td>{{ $member->id }}</td>
								<td><a href="{{ route('member.show', ['member' => $member->id]) }}">{{ $member->name }}</a></td>
								<td><a href="mailto:{{ $member->email }}">{{ $member->email }}</a></td>
								<td>
									@if (!empty($member->birthday))
										{{ $member->birthday->timezone($user->timezone)->format(Config::get('app.format.date')) }}
									@endif
								</td>
								<td class="actions">
									<a href="{{ route('member.show', ['member' => $member->id]) }}"><i class="fa fa-search"></i></a>
									<a href="{{ route('member.edit', ['member' => $member->id]) }}"><i class="fa fa-pencil"></i></a>
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>

			<div class="box-footer clearfix">
				<div class="clearfix">
					<a href="{{ route('member.create') }}" class="btn btn-sm btn-default btn-flat pull-right"><i class="fa fa-plus"></i> {{ trans('member.index.add-member') }}</a>
				</div>

				{!! $members->render() !!}
			</div>
		</div>
	</div>
@endsection
