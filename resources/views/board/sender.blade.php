@extends('layout')

@section('content')
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0">{{ trans('trans.requests') }}</h1>
				</div>
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="#">{{ trans('trans.home') }}</a></li>
						<li class="breadcrumb-item active">{{ trans('trans.requests') }}</li>
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
							<h3 class="card-title">{{ trans('trans.requests') }}</h3>
						</div>
						<div class="card-body table-responsive p-0">
							<table class="table table-bordered table-striped">
								<thead>
									<tr>
										<th>{{ trans('trans.date') }}</th>
										<th>{{ trans('trans.request') }}</th>
										<th>{{ trans('trans.description') }}</th>
										<th>{{ trans('trans.action') }}</th>
									</tr>
								</thead>
								<tbody>
									@foreach($response as $item)
										<tr>
											<td>{{ date('d/m/Y',strtotime($item->created_at)) }}</td>
											<td>{{ $item->subject }}</td>
											<td>{{ $item->message }}</td>
											<td><a href="/sender/delete/{{ $item->id }}">{{ trans('trans.delete') }}</a></td>
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