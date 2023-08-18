@extends('layout')
@section('content')
<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0">{{ trans('trans.product_promotion') }}</h1>
				</div>
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="#">{{ trans('trans.home') }}</a></li>
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
							<h3 class="card-title">{{ trans('trans.product_promotion') }}</h3>
						</div>
						<div class="card-body">
							<div class="row">
								@if(Session::get('me')->auth_id == 1)
									<div class="col-sm-12">
										<form action="{{ route('urunTanitimiKaydet') }}" method="POST" enctype="multipart/form-data">
											@csrf
											<div class="row">
												<div class="col-sm-4">
													<div class="form-group">
														<label for="pdf1">PDF 1</label>
														<input type="file" name="pdf1" class="form-control" />
													</div>
												</div>
												<div class="col-sm-4">
													<div class="form-group">
														<label for="pdf2">PDF 2</label>
														<input type="file" name="pdf2" class="form-control" />
													</div>
												</div>
												<div class="col-sm-4">
													<div class="form-group">
														<label for="pdf3">PDF 3</label>
														<input type="file" name="pdf3" class="form-control" />
													</div>
												</div>
												<div class="col-sm-4">
													<div class="form-group">
														<label for="video1">Video 1</label>
														<textarea name="video1" class="form-control"></textarea>
													</div>
												</div>
												<div class="col-sm-4">
													<div class="form-group">
														<label for="video2">Video 2</label>
														<textarea name="video2" class="form-control"></textarea>
													</div>
												</div>
												<div class="col-sm-4">
													<div class="form-group">
														<label for="video3">Video 3</label>
														<textarea name="video3" class="form-control"></textarea>
													</div>
												</div>
												<div class="col-sm-12"><button class="form-control btn btn-danger">{{ trans('trans.save') }}</button></div>
											</div>
										</form>
									</div>
								@endif
								<div class="col-sm-12">
									<h5>{{ trans('trans.product_promotion') }} PDF</h5>
									<div class="row">
										<div class="col-sm-4">
											<a href="/storage/{{ $getSchool->pdf1 }}">
												{{ trans('trans.product_promotion') }} 1 İndir<br />
												<img src="https://www.iconpacks.net/icons/2/free-pdf-download-icon-2617-thumb.png" width="50px" height="50px" />
											</a>
										</div>
										<div class="col-sm-4">
											<a href="/storage/{{ $getSchool->pdf2 }}">
												{{ trans('trans.product_promotion') }} 2 İndir<br />
												<img src="https://www.iconpacks.net/icons/2/free-pdf-download-icon-2617-thumb.png" width="50px" height="50px" />
											</a>
										</div>
										<div class="col-sm-4">
											<a href="/storage/{{ $getSchool->pdf3 }}">
												{{ trans('trans.product_promotion') }} 3 İndir<br />
												<img src="https://www.iconpacks.net/icons/2/free-pdf-download-icon-2617-thumb.png" width="50px" height="50px" />
											</a>
										</div>
									</div>
								</div>
								<div class="col-sm-12">
									<p>&nbsp;</p>
									<h5>{{ trans('trans.product_promotion') }} Video</h5>
									<div class="row">
										<div class="col-sm-4">
											{!! $getSchool->video1 !!}
										</div>
										<div class="col-sm-4">
											{!! $getSchool->video2 !!}
										</div>
										<div class="col-sm-4">
											{!! $getSchool->video3 !!}
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
@stop