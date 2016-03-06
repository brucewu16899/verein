@extends('layouts.main')

@section('content')
	Logged in: <?php echo (string) !Sentinel::guest(); ?>
@endsection
