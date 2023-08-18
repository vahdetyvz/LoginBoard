@extends('layout')
@section('content')
<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0">Şifre Sıfırlama</h1>
				</div>
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="#">Anasayfa</a></li>
						<li class="breadcrumb-item active">Şifre Sıfırlama</li>
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
							<h3 class="card-title">Şifre Değiştir</h3>
						</div>
						<div class="card-body">
							<form action="{{ route('password_reset') }}" method="POST">
								@csrf
								@if($errors->any())
									<div class="alerts alert-danger" style="padding:10px;">
										{!! $errors->first() !!}
									</div>
									<p>&nbsp;</p>
								@endif
								<div class="form-group">
									<input type="password" name="new_password" placeholder="Şifreniz" class="form-control" />
								</div>
								<div class="form-group">
									<input type="password" name="repeat_password" placeholder="Şifre Tekrar" class="form-control" />
								</div>
								<div class="form-group">
									<button class="form-control btn btn-danger">Kaydet</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
@stop