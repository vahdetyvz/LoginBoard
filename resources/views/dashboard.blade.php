@extends('layout')
@section('content')
<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0">{{ trans('trans.dashboard') }}</h1>
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
				@if(@Session::get('jwt')->userData->auth_id == 1)
				<div class="col-lg-3 col-6">
					<div class="small-box bg-info">
						<div class="inner">
							<h3>{{ count($toplamKullanici) }}</h3>
							<p>{{ trans('trans.all_users') }}</p>
						</div>
						<div class="icon">
							<i class="fa fa-users"></i>
						</div>
						<a href="{{ route('users') }}" class="small-box-footer">{{ trans('trans.users') }} <i class="fas fa-arrow-circle-right"></i></a>
					</div>
				</div>
				@endif
				
				<div class="col-lg-3 col-6">
					<div class="small-box bg-success">
						<div class="inner">
							<h3>{{ count($onlineTahta) }}</h3>
							<p>{{ trans('trans.online_boards') }}</p>
						</div>
						<div class="icon">
							<i class="fa-solid fa-chalkboard"></i>
						</div>
						<a href="{{ route('boards') }}" class="small-box-footer">{{ trans('trans.boards') }} <i class="fas fa-arrow-circle-right"></i></a>
					</div>
				</div>

				<div class="col-lg-3 col-6">
					<div class="small-box bg-danger">
						<div class="inner">
							<h3>{{ count($offlineTahta) }}</h3>
							<p>{{ trans('trans.offline_boards') }}</p>
						</div>
						<div class="icon">
							<i class="fa-solid fa-chalkboard"></i>
						</div>
						<a href="{{ route('boards') }}" class="small-box-footer">{{ trans('trans.boards') }} <i class="fas fa-arrow-circle-right"></i></a>
					</div>
				</div>

				<div class="col-lg-3 col-6">
					<div class="small-box bg-warning">
						<div class="inner">
							<h3>{{ count($toplamTahtalar) }}</h3>
							<p>{{ trans('trans.all_boards') }}</p>
						</div>
						<div class="icon">
							<i class="fa-solid fa-chalkboard"></i>
						</div>
						<a href="{{ route('boards') }}" class="small-box-footer">{{ trans('trans.boards') }} <i class="fas fa-arrow-circle-right"></i></a>
					</div>
				</div>
				@if(@Session::get('jwt')->userData->auth_id == 1)
				<div class="col-lg-3 col-6">
					<div class="small-box bg-vanger">
						<div class="inner">
							<h3>{{ count($toplamOkullar) }}</h3>
							<p>{{ trans('trans.all_schools') }}</p>
						</div>
						<div class="icon">
							<i class="fa-solid fa-solid fa-school"></i>
						</div>
						<a href="{{ route('school.list') }}" class="small-box-footer">{{ trans('trans.schools') }} <i class="fas fa-arrow-circle-right"></i></a>
					</div>
				</div>
				@endif
				@if(@Session::get('jwt')->userData->auth_id == 1)
				<div class="col-lg-3 col-6">
					<div class="small-box bg-danger" style="background:#2c3e50 !important;">
						<div class="inner">
							<h3>{{ $toplamLisansAdet }}</h3>
							<p>{{ trans('trans.all_license') }}</p>
						</div>
						<div class="icon">
							<i class="fa-solid fa-id-card"></i>
						</div>
						<a href="#" class="small-box-footer">{{ trans('trans.licenses') }} <i class="fas fa-arrow-circle-right"></i></a>
					</div>
				</div>
				@endif
				@if(@Session::get('jwt')->userData->auth_id != 1)
				<div class="col-12">
					<div class="card">
						<div class="card-header">
							<h3 class="card-title">{{ trans('trans.information') }}</h3>
						</div>
						<div class="card-body table-responsive p-0">
							<table class="table table-bordered table-striped">
								<thead>
									<tr>
										@if(@Session::get('jwt')->userData->auth_id == 2)
										<th>{{ trans('trans.remaining_license_term') }}</th>
										@endif
										<th>{{ trans('trans.school_name') }}</th>
										<th>{{ trans('trans.school_number') }}</th>
										<th>{{ trans('trans.email') }}</th>
										@if(@Session::get('jwt')->userData->auth_id == 2)
										<th>{{ trans('trans.product_count') }}</th>
										@endif
									</tr>
								</thead>
								<tbody>
									<tr>
										@php
											$tarih1 = strtotime(date('Y-m-d'));
											$tarih2 = strtotime(date('Y-m-d',strtotime($getSchool->license_date)));
										@endphp
										@if(@Session::get('jwt')->userData->auth_id == 2)
										<td>@if(($tarih2 - $tarih1) / (60*60*24) < 0) {{ trans('trans.license_term_end') }} @else {{ ($tarih2 - $tarih1) / (60*60*24) }} @endif</td>
										@endif
										<td>{{ $getSchool->name }}</td>
										<td>{{ $getSchool->number }}</td>
										<td>{{ Session::get('jwt')->userData->email }}</td>
										@if(@Session::get('jwt')->userData->auth_id == 2)
										<td>{{ $getSchool->device }}</td>
										@endif
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
				@endif
				
				@if(@Session::get('jwt')->userData->auth_id == 1)
				<div class="col-12">
					<div class="card">
						<div class="card-header">
							<h3 class="card-title">{{ trans('trans.information') }}</h3>
						</div>
						<div class="card-body table-responsive p-0">
							<table class="table table-bordered table-striped">
								<thead>
									<tr>
										<th>{{ trans('trans.remaining_license_term') }}</th>
										<th>{{ trans('trans.school_name') }}</th>
										<th>{{ trans('trans.school_number') }}</th>
										<th>{{ trans('trans.email') }}</th>
										<th>{{ trans('trans.product_count') }}</th>
									</tr>
								</thead>
								<tbody>
									@foreach($getSchool as $gs)
										<tr>
											@php
												$tarih1 = strtotime(date('Y-m-d'));
												$tarih2 = strtotime(date('Y-m-d',strtotime($gs->license_date)));
											@endphp
											<td>@if(($tarih2 - $tarih1) / (60*60*24) < 0) {{ trans('trans.license_term_end') }} @else {{ ($tarih2 - $tarih1) / (60*60*24) }} @endif</td>
											<td>{{ $gs->name }}</td>
											<td>{{ $gs->number }}</td>
											<td>{{ getUserData($gs->id) }}</td>
											<td>{{ $gs->device }}</td>
										</tr>
									@endforeach
								</tbody>
							</table>
						</div>
					</div>
				</div>
				@endif
			</div>
		</div>
	</section>
@stop