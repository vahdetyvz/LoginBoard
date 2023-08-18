@extends('layout')

@section('content')
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0">{{ trans('trans.teacher_board_add') }}</h1>
				</div>
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="#">{{ trans('trans.home') }}</a></li>
						<li class="breadcrumb-item active">{{ trans('trans.teacher_board_add') }}</li>
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
							<h3 class="card-title">{{ trans('trans.teacher_board_add') }}</h3>
						</div>
						<div class="card-body">
							<form action="{{ route('userboard.save') }}" method="POST">
								@csrf
								@if($errors->any())
									<div class="alerts alert-danger" style="padding:10px;">
										{!! $errors->first() !!}
									</div>
									<p>&nbsp;</p>
								@endif
								<div class="form-group">
									<select name="user_id" class="user_id form-control">
										<option value="">{{ trans('trans.teacher_select') }}</option>
										@foreach($teachers as $item)
											<option value="{{ $item->id }}">{{ $item->fullname }}</option>
										@endforeach
									</select>
								</div>
								<div class="form-group">
									<select name="board_id" class="board_id form-control">
										<option value="">{{ trans('trans.board_select') }}</option>
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