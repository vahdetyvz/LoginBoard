@extends('layout')

@section('content')
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0">{{ trans('trans.boards') }}</h1>
				</div>
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="#">{{ trans('trans.home') }}</a></li>
						<li class="breadcrumb-item active">{{ trans('trans.boards') }}</li>
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
							<h3 class="card-title">{{ trans('trans.boards') }}</h3>
						</div>
						<div class="card-body table-responsive p-0">
							<table id="example1" class="table table-bordered table-striped">
								<thead>
									<tr>
										@if(Session::get('jwt')->userData->auth_id == 1)
											<th>{{ trans('trans.school_name') }}</th>
										@endif
										<th>{{ trans('trans.board_address') }}</th>
										@if(Session::get('jwt')->userData->auth_id != 3)
										<th>{{ trans('trans.board_desc') }}</th>
										<th>{{ trans('trans.in_ip') }}</th>
										<th>{{ trans('trans.mac') }}</th>
										<th>{{ trans('trans.model') }}</th>
										<th>{{ trans('trans.product') }}</th>
										<th>{{ trans('trans.no') }}</th>
										<th>{{ trans('trans.out_ip') }}</th>
										@endif
										<th>{{ trans('trans.status') }}</th>
										<th>{{ trans('trans.action') }}</th>
									</tr>
								</thead>
								<tbody>
									@foreach($response as $item)
										@php
											$detay = json_decode($item->boardDetail);
										@endphp
										<tr>
											@if(Session::get('jwt')->userData->auth_id == 1)
												<td>{{ $item->school_id }}</td>
											@endif
											@if(Session::get('jwt')->userData->auth_id != 3)
												<td>{{ $item->mac_address }}</td>
												<td>{{ $item->school_description }}</td>
												@foreach($detay as $key => $det)
													<td>{{ $det }}</td>
												@endforeach
												@if($item->status == 1)
													<td><button type="button" onclick="tahtaDurum('{{ $item->mac_address }}',0)" class="btn btn-block btn-success btn-sm">{{ trans('trans.open') }}</button></td>
												@else
													<td><button type="button" onclick="tahtaDurum('{{ $item->mac_address }}',1)" class="btn btn-block btn-danger btn-sm">{{ trans('trans.close') }}</button></td>
												@endif
											@endif
											<td><a href="{{ route('board.geri_yukle',['id' => $item->id]) }}">{{ trans('trans.reload') }}</a></td>
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