@extends('layout')

@section('content')
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0">{{ trans('trans.apps') }}</h1>
				</div>
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="#">{{ trans('trans.home') }}</a></li>
						<li class="breadcrumb-item active">{{ trans('trans.apps') }}</li>
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
							<h3 class="card-title">{{ trans('trans.edit_app') }}</h3>
						</div>
						<div class="card-body">
							<form action="{{ route('uygulamalar.update',['id' => $detailApp->id]) }}" method="POST" enctype="multipart/form-data">
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
											@foreach($detailAppLang as $l)
												<div class="tab-pane fade" id="custom-tabs-four-{{ $l->lang }}" role="tabpanel" aria-labelledby="custom-tabs-four-{{ $l->lang }}-tab">
													<div class="form-group">
														<input type="text" name="name[{{ $l->lang }}]" class="form-control" value="{{ $l->name }}" placeholder="{{ trans('trans.app_name') }}" />
													</div>
													<div class="form-group">
														<input type="text" name="desc[{{ $l->lang }}]" class="form-control" value="{{ $l->desc }}" placeholder="{{ trans('trans.description') }}" />
													</div>
												</div>
											@endforeach
										</div>
									</div>
								</div>
								<div class="form-group">
									<input type="text" name="packName" value="{{ $detailApp->packName }}" class="form-control" placeholder="{{ trans('trans.package_name') }}" />
								</div>
								<div class="form-group">
									<label>{{ trans('trans.app') }}</label>
									<input type="file" name="app" class="form-control" />
									<a href="https://emkologin.com/public/storage/{{ $detailApp->url }}">{{ $detailApp->url }}</a>
								</div>
								<div class="form-group">
									<label>{{ trans('trans.image') }} 1</label>
									<input type="file" name="file1" class="form-control" />
									<img src="https://emkologin.com/public/storage/{{ $detailApp->images1 }}" width="100px" />
								</div>
								<div class="form-group">
									<label>{{ trans('trans.image') }} 2</label>
									<input type="file" name="file2" class="form-control" />
									<img src="https://emkologin.com/public/storage/{{ $detailApp->images2 }}" width="100px" />
								</div>
								<div class="form-group">
									<label>{{ trans('trans.image') }} 3</label>
									<input type="file" name="file3" class="form-control" />
									<img src="https://emkologin.com/public/storage/{{ $detailApp->images3 }}" width="100px" />
								</div>
								<div class="form-group">
									<label>Icon</label>
									<input type="file" name="icon" class="form-control" />
									<img src="https://emkologin.com/public/storage/{{ $detailApp->icon }}" width="100px" />
								</div>
								<div class="form-group">
									<select name="category_id" class="form-control">
										<option value="">{{ trans('trans.category_select') }}</option>
										@foreach($category as $item)
											<option value="{{ $item->id }}" @if($detailApp->category_id == $item->id) selected @endif>{{ $item->name }}</option>
										@endforeach
									</select>
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