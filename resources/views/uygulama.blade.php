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
							<h3 class="card-title">{{ trans('trans.information') }}</h3>
						</div>
						<div class="card-body table-responsive p-0">
							<table class="table table-bordered table-striped">
								<thead>
									<tr>
										@if(Session::get('me')->auth_id == 1)
										<th>{{ trans('trans.install') }}</th>
										@endif
										<th>{{ trans('trans.board_app') }}</th>
										<th>IOS {{ trans('trans.app') }}</th>
										<th>Android {{ trans('trans.app') }}</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										@if(Session::get('me')->auth_id == 1)
											<td><form action="/tahtauygulamasi" method="post" enctype="multipart/form-data">@csrf <input type="file" name="file1" class="form-control" /><button class="form-control btn btn-danger">Kaydet</button></form></td>
										@endif
										<td><a href="/storage/{{ $getSchool->tahta_app }}">{{ trans('trans.board_app_download') }}</a></td>
										<td><a href="{{ $getSchool->ios_app }}"><img src="/ios.svg" width="150px" /></a></td>
										<td><a href="{{ $getSchool->android_app }}"><img src="/android.svg" width="150px" /></a></td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
@stop