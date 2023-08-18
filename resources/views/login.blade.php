<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | Log in</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="/plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <link rel="stylesheet" href="/dist/css/adminlte.min.css">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <img src="/dist/img/logo.png" style="width:100%" />
  </div>
  <div class="card">
    <div class="card-body login-card-body">
		<p class="login-box-msg">Lütfen giriş yapınız.</p>
		<form action="/login" method="POST">
			@csrf
			@if($errors->any())
				<div class="alerts alert-danger" style="padding:10px;">
					{{ $errors->first() }}
				</div>
				<p>&nbsp;</p>
			@endif
			<div class="input-group mb-3">
				<input type="email" class="form-control" placeholder="Email" name="email">
				<div class="input-group-append">
					<div class="input-group-text">
						<span class="fas fa-envelope"></span>
					</div>
				</div>
			</div>
			<div class="input-group mb-3">
				<input type="password" class="form-control" placeholder="Şifre" name="password">
				<div class="input-group-append">
					<div class="input-group-text">
						<span class="fas fa-lock"></span>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-4">
					<button type="submit" class="btn btn-primary btn-block">Giriş</button>
				</div>
			</div>
		</form>
    </div>
  </div>
</div>
<script src="/plugins/jquery/jquery.min.js"></script>
<script src="/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="/dist/js/adminlte.min.js"></script>
</body>
</html>
