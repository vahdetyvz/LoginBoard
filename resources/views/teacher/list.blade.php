@extends('layout')

@section('content')
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0">{{ trans('trans.teachers') }}</h1>
				</div>
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="#">{{ trans('trans.home') }}</a></li>
						<li class="breadcrumb-item active">{{ trans('trans.teachers') }}</li>
					</ol>
				</div>
			</div>
		</div>
	</div>
	<section class="content">
		<div class="container-fluid">
			<div class="row">
				<div class="col-12">
					<div class="card">
						<div class="card-header">
							<h3 class="card-title">{{ trans('trans.teachers') }}</h3>
							@if(Session::get('jwt')->userData->auth_id == 1)
							<a href="{{ route('teacher.all') }}" class="btn btn-danger" style="float:right">{{ trans('trans.new_teacher') }}</a>
							@endif
							<a href="{{ route('teacher.add') }}" class="btn btn-danger" style="float:right; margin-right:10px;">{{ trans('trans.new_teacher') }}</a>
						</div>
						<div class="card-body table-responsive p-0">
							<table id="example1" class="table table-bordered table-striped">
								<thead>
									<tr>
										<th>{{ trans('trans.teacher_name') }}</th>
										@if(Session::get('jwt')->userData->auth_id == 1)
										<th>{{ trans('trans.school') }}</th>
										@endif
										<th>{{ trans('trans.board_save_count') }}</th>
										<th>{{ trans('trans.action') }}</th>
									</tr>
								</thead>
								<tbody>
									@foreach($response as $item)
										@php
											$count = count((array)$item->board_count);
										@endphp
										<tr>
											<td>{{ $item->fullname }}</td>
											@if(Session::get('jwt')->userData->auth_id == 1)
											<td>{{ $item->school_id }}</td>
											@endif
											<td>{{ $count }}</td>
											<td><a href="{{ route('teacher.edit',['id' => $item->id]) }}">{{ trans('trans.edit') }}</a> | <a href="{{ route('teacher.delete',['id' => $item->id]) }}">{{ trans('trans.delete') }}</a></td>
										</tr>
									@endforeach
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
@stop