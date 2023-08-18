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
							<h3 class="card-title">{{ trans('trans.new_category') }}</h3>
						</div>
						<div class="card-body">
							<form action="{{ route('category.save') }}" method="POST">
								@csrf
								@if($errors->any())
									<div class="alerts alert-danger" style="padding:10px;">
										{!! $errors->first() !!}
									</div>
									<p>&nbsp;</p>
								@endif
								<div class="card card-primary card-outline card-outline-tabs">
									<div class="card-header p-0 border-bottom-0">
										<ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
											@foreach($lang as $l)
												<li class="nav-item">
													<a class="nav-link" id="custom-tabs-four-{{ $l->code }}-tab" data-toggle="pill" href="#custom-tabs-four-{{ $l->code }}" role="tab" aria-controls="custom-tabs-four-{{ $l->code }}" aria-selected="true">{{ $l->name }}</a>
												</li>
											@endforeach
										</ul>
									</div>
									<div class="card-body">
										<div class="tab-content" id="custom-tabs-four-tabContent">
											@foreach($lang as $l)
												<div class="tab-pane fade" id="custom-tabs-four-{{ $l->code }}" role="tabpanel" aria-labelledby="custom-tabs-four-{{ $l->code }}-tab">
													<div class="form-group">
														<input type="text" name="name[{{ $l->code }}]" class="form-control" placeholder="{{ trans('trans.category_name') }} {{ $l->name }}" />
													</div>
												</div>
											@endforeach
										</div>
									</div>
								</div>
								<div class="form-group">
									<button class="btn btn-success">{{ trans('trans.save') }}</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
@stop