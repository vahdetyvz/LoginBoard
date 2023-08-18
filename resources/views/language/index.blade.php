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
							<h3 class="card-title">{{ trans('trans.language') }}</h3>
							<a href="{{ route('language.create') }}" class="btn btn-danger" style="float:right">{{ trans('trans.new_language') }}</a>
						</div>
						<div class="card-body table-responsive p-0">
							<table id="example1" class="table table-bordered table-striped">
								<thead>
									<tr>
										<th>{{ trans('trans.language_name') }}</th>
										<th>{{ trans('trans.language_code') }}</th>
										<th>{{ trans('trans.action') }}</th>
									</tr>
								</thead>
								<tbody>
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
										<tr>
											<td>
												@if(\Illuminate\Support\Facades\File::exists($transFilePath))
													@php
														$translationx = include($transFilePath);
														echo $translationx['lang'];
													@endphp
												@endif
											</td>
											<td>{{ $languageCode }}</td>
											<td><a href="{{ route('language.translation',['code' => $languageCode]) }}">{{ trans('trans.translation') }}</a> | <a href="{{ route('language.edit',['code' => $languageCode]) }}">{{ trans('trans.edit') }}</a> | <a href="{{ route('language.delete',['code' => $languageCode]) }}">{{ trans('trans.delete') }}</a></td>
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