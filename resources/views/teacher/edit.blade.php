@extends('layout')

@section('content')
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0">{{ trans('trans.teachers') }}</h1>
				</div>
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="#">{{ trans('trans.home') }}</a></li>
						<li class="breadcrumb-item active">{{ trans('trans.teachers') }}</li>
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
							<h3 class="card-title">{{ trans('trans.teacher_edit') }}</h3>
						</div>
						<div class="card-body">
							<form action="{{ route('teacher.update',['id' => $teacher->id]) }}" method="POST">
								@csrf
								@if($errors->any())
									<div class="alerts alert-danger" style="padding:10px;">
										{!! $errors->first() !!}
									</div>
									<p>&nbsp;</p>
								@endif
								<div class="form-group">
									<input type="text" name="fullname" class="form-control" placeholder="{{ trans('trans.teacher_name') }}" value="{{ $teacher->fullname }}" />
								</div>
								<div class="form-group">
									<input type="password" name="password" class="form-control" placeholder="{{ trans('trans.password') }}" />
								</div>
								<div class="form-group">
									<input type="text" name="email" class="form-control" placeholder="{{ trans('trans.email') }}" value="{{ $teacher->email }}" />
								</div>
								<div class="form-group">
									<input type="text" name="phone" class="form-control" placeholder="{{ trans('trans.phone') }}" value="{{ $teacher->phone }}" />
								</div>
								@if(Session::get('me')->auth_id == 1)
								<div class="form-group">
									<select name="school_id" class="form-control">
										<option value="">{{ trans('trans.school_select') }}</option>
										@foreach($schools as $item)
											<option value="{{ $item->id }}" @if($teacher->school_id == $item->id) selected @endif>{{ $item->name }}</option>
										@endforeach
									</select>
								</div>
								@endif
								<div class="form-group checkboxlar">
									@foreach($board as $bor)
										<input type="checkbox" name="board[]" value="{{ $bor->id }}" @if(userBoardControl($bor->id,$teacher->id)) checked @endif> <span>@if($bor->school_description == ''){{ $bor->mac_address }}@else {{ $bor->school_description }}@endif</span><br />
									@endforeach
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