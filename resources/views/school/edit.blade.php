@extends('layout')

@section('content')
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0">{{ trans('trans.schools') }}</h1>
				</div>
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="#">{{ trans('trans.home') }}</a></li>
						<li class="breadcrumb-item active">{{ trans('trans.schools') }}</li>
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
							<h3 class="card-title">{{ trans('trans.new_school') }}</h3>
						</div>
						<div class="card-body">
							<form action="{{ route('school.update',['id' => $school->id]) }}" method="POST">
								@csrf
								@if($errors->any())
									<div class="alerts alert-danger" style="padding:10px;">
										{!! $errors->first() !!}
									</div>
									<p>&nbsp;</p>
								@endif
								<div class="form-group">
									<input type="text" name="name" class="form-control" placeholder="{{ trans('trans.school_name') }}" value="{{ $school->name }}" />
								</div>
								<div class="form-group">
									<input type="text" name="device" class="form-control" placeholder="{{ trans('trans.device_count') }}" value="{{ $school->device }}" />
								</div>
								<div class="form-group">
									<select name="auth" class="form-control">
										<option value="">{{ trans('trans.user_select') }}</option>
										@foreach($users as $item)
											<option value="{{ $item->id }}" @if($school->auth == $item->id) selected @endif>{{ $item->fullname }}</option>
										@endforeach
									</select>
								</div>
								<div class="form-group">
									<div class="form-group">
										<div class="input-group date" id="reservationdate" data-target-input="nearest">
											<input type="text" name="license_date" class="form-control datetimepicker-input" data-target="#reservationdate" value="{{ $school->license_date }}"/>
											<div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
												<div class="input-group-text"><i class="fa fa-calendar"></i></div>
											</div>
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