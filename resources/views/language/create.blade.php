@extends('layout')

@section('content')
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0">{{ trans('trans.language') }}</h1>
				</div>
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="#">{{ trans('trans.home') }}</a></li>
						<li class="breadcrumb-item active">{{ trans('trans.language') }}</li>
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
							<h3 class="card-title">{{ trans('trans.new_language') }}</h3>
						</div>
						<div class="card-body">
							<form action="{{ route('language.store') }}" method="POST">
								@csrf
								@if($errors->any())
									<div class="alerts alert-danger" style="padding:10px;">
										{!! $errors->first() !!}
									</div>
									<p>&nbsp;</p>
								@endif
								<div class="form-group">
									<input type="text" name="language_name" class="form-control" placeholder="{{ trans('trans.language_name') }}" />
								</div>
								<div class="form-group">
									<input type="text" name="language_code" class="form-control" placeholder="{{ trans('trans.language_code') }}" />
								</div>
								<div class="form-group">
									<select name="copy_lang" class="form-control">
										<option value="0">{{ trans('trans.select_language') }}</option>
										@php
											$languagePath = resource_path('lang');
											$currentLanguage = app()->getLocale();
											
											$languageFolders = \Illuminate\Support\Facades\File::directories($languagePath);
										@endphp
										@foreach ($languageFolders as $languageFolder)
											@php
												$languageCode = basename($languageFolder);
												$transFilePath = $languageFolder . '/trans.php';
											@endphp
											<option value="{{ $languageCode }}">
												@if(\Illuminate\Support\Facades\File::exists($transFilePath))
													@php
														$translationx = include($transFilePath);
														echo $translationx['lang'];
													@endphp
												@endif
											</option>
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