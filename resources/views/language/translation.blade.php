@extends('layout')

@section('content')
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0">{{ trans('trans.translation') }}</h1>
				</div>
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="#">{{ trans('trans.home') }}</a></li>
						<li class="breadcrumb-item active">{{ trans('trans.translation') }}</li>
					</ol>
				</div>
			</div>
		</div>
	</div>
	<section class="content">
		<div class="container-fluid">
			<form action="{{ route('language.translation.save',['code' => $code]) }}" method="POST">
				@csrf
				<div class="row">
					<div class="col-12">
						<div class="card">
							<div class="card-header">
								<h3 class="card-title">{{ trans('trans.translation') }} ({{ $translation['lang'] }})</h3>
							</div>
							<div class="card-body table-responsive p-0">
								<table id="example" class="table table-bordered table-striped">
									<thead>
										<tr>
											<th>{{ trans('trans.word') }} ({{ $copy['lang'] }})</th>
											<th>{{ trans('trans.translate') }}</th>
										</tr>
									</thead>
									<tbody>
										@foreach($copy as $k => $c)
											@if($k != 'copy_lang' && $k != 'lang')
												<tr>
													<td>{{ $c }}</td>
													<td><input type="text" name="translation[{{ $k }}]" value="{{ $translation[$k] }}" class="form-control" /></td>
												</tr>
											@endif
										@endforeach
									</tbody>
								</table>
								<button class="btn btn-success form-control">{{ trans('trans.save') }}</button>
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>
	</section>
@stop