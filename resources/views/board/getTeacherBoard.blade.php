@extends('layout')

@section('content')
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0">{{ trans('trans.teacher_boards') }}</h1>
				</div>
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="#">{{ trans('trans.home') }}</a></li>
						<li class="breadcrumb-item active">{{ trans('trans.teacher_boards') }}</li>
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
							<h3 class="card-title">{{ trans('trans.teacher_boards') }}</h3>
							<a href="{{ route('userboard.add') }}" class="btn btn-danger" style="float:right">{{ trans('trans.new_teacher_board') }}</a>
						</div>
						<div class="card-body table-responsive p-0">
							<table class="table table-hover text-nowrap">
								<thead>
									<tr>
										<th>{{ trans('trans.board_address') }}</th>
										<th>{{ trans('trans.teacher') }}</th>
										<th>{{ trans('trans.action') }}</th>
									</tr>
								</thead>
								<tbody>
									@foreach($response as $item)
										<tr>
											<td>{{ $item->mac_address }}</td>
											<td>{{ $item->user }}</td>
											<td><a href="{{ route('userboard.edit',['id' => $item->id]) }}">{{ trans('trans.edit') }}</a> | <a href="{{ route('userboard.delete',['id' => $item->id]) }}">{{ trans('trans.delete') }}</a></td>
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