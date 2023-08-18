@extends('layout')

@section('content')
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0">{{ trans('trans.schools') }}</h1>
				</div>
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="#">{{ trans('trans.home') }}</a></li>
						<li class="breadcrumb-item active">{{ trans('trans.schools') }}</li>
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
							<a href="{{ route('school.add') }}" class="btn btn-danger" style="float:right">{{ trans('trans.schools') }}</a>
						</div>
						<div class="card-body table-responsive p-0">
							<table id="example1" class="table table-bordered table-striped">
								<thead>
									<tr>
										<th>{{ trans('trans.school_name') }}</th>
										<th>{{ trans('trans.school_number') }}</th>
										<th>{{ trans('trans.device_count') }}</th>
										<th>{{ trans('trans.schools') }}</th>
										<th>{{ trans('trans.remaining_license_term') }}</th>
										<th>{{ trans('trans.action') }}</th>
									</tr>
								</thead>
								<tbody>
									@foreach($response as $item)
										<tr>
											<td>{{ $item->name }}</td>
											<td>{{ $item->number }}</td>
											<td>{{ $item->device }}</td>
											<td>{{ count((array)$item->board_count) }}</td>
											<td>{{ $item->license_date }}</td>
											<td><a href="{{ route('school.edit',['id' => $item->id]) }}">{{ trans('trans.edit') }}</a> | <a href="{{ route('school.delete',['id' => $item->id]) }}">{{ trans('trans.delete') }}</a></td>
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