@extends('layout')

@section('content')
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0">{{ trans('trans.closing_time') }}</h1>
				</div>
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="#">{{ trans('trans.home') }}</a></li>
						<li class="breadcrumb-item active">{{ trans('trans.closing_time') }}</li>
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
							<h3 class="card-title">{{ trans('trans.closing_time') }}</h3>
						</div>
						<div class="card-body table-responsive p-0">
							<form action="{{ route('group.saveHours') }}" method="POST">
								@csrf
								<input type="hidden" name="id" value="{{ $response->id }}" />
								<div class="row" style="padding:20px;">
									@php
										$bugun = date('l', strtotime(date("Y-m-d")));
										$i = 1;
									@endphp
									@foreach(json_decode($response->hours) as $key => $item)
										@php
											$s = 1;
										@endphp
										<div class="col-sm-12">
											<h4 style="background:#000; padding:10px; color:#fff">@if (App::isLocale('tr')) {{ tr_gun($key) }} @else {{ $key }} @endif</h4>
										</div>
										@foreach($item as $it)
											<div class="col-sm-3">
												<div class="form-group">
													<label>{{ trans('trans.board_close_time') }} ({{ $s }}):</label>
													<div class="input-group date" id="timepicker{{ $i }}" data-target-input="nearest">
														<input type="text" class="form-control datetimepicker-input" name="hours[{{ $key }}][]" value="{{ $it }}" data-target="#timepicker{{ $i }}" />
														<div class="input-group-append" data-target="#timepicker{{ $i }}" data-toggle="datetimepicker">
															<div class="input-group-text"><i class="far fa-clock"></i></div>
														</div>
													</div>
												</div>
											</div>
											<script>
												$('#timepicker{{ $i }}').datetimepicker({
												  format: 'HH:mm'
												});
											</script>
											@php
												$i++;
												$s++;
											@endphp
										@endforeach
									@endforeach
									<button class="form-control btn btn-danger">{{ trans('trans.save') }}</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
@stop