@extends('layout')

@section('content')
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
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
						<div class="card-body table-responsive p-0">
							@if(@Session::get('jwt')->userData->auth_id == 1)
								<form action="{{ route('masterKeySave') }}" method="post" style="padding:25px">
									@csrf
									<div class="form-group">
										<input type="text" name="masterkey" class="form-control" value="{{ $users->masterkey }}" />
									</div>
									<div class="form-group">
										<button class="form-control btn btn-success">{{ trans('trans.save') }}</button>
									</div>
								</form>
							@else
								<p style="padding:25px; text-align:center; font-size:25px">MASTER KEY : {{ $users->masterkey }}</p>
							@endif
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
@stop