@extends('layout')

@section('content')
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0">{{ trans('trans.categories') }}</h1>
				</div>
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="#">{{ trans('trans.home') }}</a></li>
						<li class="breadcrumb-item active">{{ trans('trans.categories') }}</li>
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
							<h3 class="card-title">{{ trans('trans.categories') }}</h3>
							<a href="{{ route('category.add') }}" class="btn btn-danger" style="float:right">{{ trans('trans.new_category') }}</a>
						</div>
						<div class="card-body table-responsive p-0">
							<table id="example1" class="table table-bordered table-striped">
								<thead>
									<tr>
										<th>{{ trans('trans.category_name') }}</th>
										<th>{{ trans('trans.action') }}</th>
									</tr>
								</thead>
								<tbody>
									@foreach($response as $item)
										<tr>
											<td>{{ $item->name }}</td>
											<td><a href="{{ route('category.edit',['id' => $item->id]) }}">{{ trans('trans.edit') }}</a> | <a href="{{ route('category.delete',['id' => $item->id]) }}">{{ trans('trans.delete') }}</a></td>
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