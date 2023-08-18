@extends('layout')

@section('content')
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0">{{ trans('trans.users') }}</h1>
				</div>
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="#">{{ trans('trans.home') }}</a></li>
						<li class="breadcrumb-item active">{{ trans('trans.users') }}</li>
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
							<h3 class="card-title">{{ trans('trans.users') }}</h3>
							<a href="{{ route('users.add') }}" class="btn btn-danger" style="float:right">{{ trans('trans.new_user') }}</a>
						</div>
						<div class="card-body table-responsive p-0">
							<table id="example1" class="table table-bordered table-striped">
								<thead>
									<tr>
										<th>{{ trans('trans.username') }}</th>
										<th>{{ trans('trans.email') }}</th>
										<th>{{ trans('trans.action') }}</th>
									</tr>
								</thead>
								<tbody>
									@foreach($response as $item)
										<tr>
											<td>{{ $item->fullname }}</td>
											<td>{{ $item->email }}</td>
											<td><a href="{{ route('users.edit',['id' => $item->id]) }}">{{ trans('trans.edit') }}</a> | <a href="{{ route('users.delete',['id' => $item->id]) }}">{{ trans('trans.delete') }}</a></td>
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