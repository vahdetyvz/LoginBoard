<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Emko Akıllı Tahta Yönetim Uygulaması</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <link rel="stylesheet" href="/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <link rel="stylesheet" href="/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <link rel="stylesheet" href="/plugins/jqvmap/jqvmap.min.css">
  <link rel="stylesheet" href="/dist/css/adminlte.min.css">
	<link rel="stylesheet" href="/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <link rel="stylesheet" href="/plugins/daterangepicker/daterangepicker.css">
  <link rel="stylesheet" href="/plugins/summernote/summernote-bs4.min.css">
  <script src="/plugins/jquery/jquery.min.js"></script>
<script src="/plugins/jquery-ui/jquery-ui.min.js"></script>
<script src="/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="/plugins/daterangepicker/daterangepicker.js"></script>
<script src="/plugins/datatables/jquery.dataTables.min.js"></script>
	<script src="/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
	<script src="/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="/plugins/chart.js/Chart.min.js"></script>
<script src="/plugins/sparklines/sparkline.js"></script>
<script src="/plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="/plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<script src="/plugins/jquery-knob/jquery.knob.min.js"></script>
<script src="/plugins/moment/moment.min.js"></script>
<script src="/plugins/daterangepicker/daterangepicker.js"></script>
<script src="/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<script src="/plugins/summernote/summernote-bs4.min.js"></script>
<script src="/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<script src="/dist/js/adminlte.js"></script>
<script src="/dist/js/pages/dashboard.js"></script>
  <style>
	[class*=sidebar-dark-] {
		background:#24A2CE;
	}
	
	.brand-link {
		background: #fff;
		padding: 20px !important;
	}
	
	[class*=sidebar-dark] .brand-link {
		border:none;
	}
	
	.sidebar-dark-primary .nav-sidebar>.nav-item>.nav-link.active, .sidebar-light-primary .nav-sidebar>.nav-item>.nav-link.active {
		background: none;
		border: none;
		box-shadow: none;
		color:#FFBA49;
	}
	
	[class*=sidebar-dark-] .nav-sidebar>.nav-item.menu-open>.nav-link, [class*=sidebar-dark-] .nav-sidebar>.nav-item:hover>.nav-link, [class*=sidebar-dark-] .nav-sidebar>.nav-item>.nav-link:focus, [class*=sidebar-dark-] .nav-treeview>.nav-item>.nav-link:focus, [class*=sidebar-dark-] .nav-treeview>.nav-item>.nav-link:hover {
		background: none;
		color:#FFBA49;
	}
	
	[class*=sidebar-dark-] .sidebar a, [class*=sidebar-dark-] .nav-treeview>.nav-item>.nav-link {
		color:#fff;
	}
	
	.content-wrapper {
		background:#E6E7E8;
	}
	
	.card {
		border-radius:1.25rem;
	}
	
	.btn-danger {
		background:#FFBA49;
		border:none;
	}
	
	.btn-danger:not(:disabled):not(.disabled).active, .btn-danger:not(:disabled):not(.disabled):active, .show>.btn-danger.dropdown-toggle, .btn-danger:not(:disabled):not(.disabled).active, .btn-danger:not(:disabled):not(.disabled):active, .show>.btn-danger.dropdown-toggle {
		background:#d99932 !important;
	}
	
	#example1_filter {
		float:right;
	}
  </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
	<aside class="main-sidebar sidebar-dark-primary elevation-4">
		<a href="/" class="brand-link">
			<img src="/dist/img/logo.png" alt="AdminLTE Logo" class="brand-images" style="width:100%">
		</a>
		<div class="sidebar">
			<!--<div class="user-panel mt-3 pb-3 mb-3 d-flex">
				<div class="image">
					<img src="/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
				</div>
				<div class="info">
					<a href="#" class="d-block"><?php echo Session::get('me')->fullname; ?></a>
				</div>
			</div>-->
			<nav class="mt-2">
				<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
					<li class="nav-item">
						<a href="/" class="nav-link @if(getUrl() == 'https://emkologin.com') active @endif">
							<i class="nav-icon fa-solid fa-house"></i>
							<p>
								{{ trans('trans.dashboard') }}
							</p>
						</a>
					</li>
					@if(@Session::get('jwt')->yetkiler->{'Okullar'})
					<li class="nav-item">
						<a href="{{ route('school.list') }}" class="nav-link @if(getUrl() == 'https://emkologin.com/school') active @endif">
							<i class="nav-icon fa-solid fa-school"></i>
							<p>
								{{ trans('trans.schools') }}
							</p>
						</a>
					</li>
					@endif
					@if(@Session::get('jwt')->yetkiler->{'Öğretmenler'})
					<li class="nav-item">
						<a href="{{ route('teacher') }}" class="nav-link @if(getUrl() == 'https://emkologin.com/teacher') active @endif">
							<i class="nav-icon fa-solid fa-person-chalkboard"></i>
							<p>
								{{ trans('trans.teachers') }}
							</p>
						</a>
					</li>
					@endif
					@if(@Session::get('jwt')->yetkiler->{'Adminler'})
					<li class="nav-item">
						<a href="{{ route('users') }}" class="nav-link @if(getUrl() == 'https://emkologin.com/users') active @endif">
							<i class="nav-icon fa-solid fa-user"></i>
							<p>
								{{ trans('trans.admins') }}
							</p>
						</a>
					</li>
					@endif
					@if(@Session::get('jwt')->yetkiler->{'Gruplar'})
					<li class="nav-item">
						<a href="{{ route('group') }}" class="nav-link @if(getUrl() == 'https://emkologin.com/group') active @endif">
							<i class="nav-icon fa-solid fa-people-group"></i>
							<p>
								{{ trans('trans.groups') }}
							</p>
						</a>
					</li>
					@endif
					@if(@Session::get('jwt')->yetkiler->{'Tahtalar'} || @Session::get('jwt')->userData->auth_id == 3)
					<li class="nav-item">
						<a href="{{ route('boards') }}" class="nav-link @if(getUrl() == 'https://emkologin.com/board') active @endif">
							<i class="nav-icon fa-solid fa-chalkboard"></i>
							<p>
								{{ trans('trans.boards') }}
							</p>
						</a>
					</li>
					<li class="nav-item">
						<a href="{{ route('boardRemove') }}" class="nav-link @if(getUrl() == 'https://emkologin.com/boardRemove') active @endif">
							<i class="nav-icon fa-solid fa-chalkboard"></i>
							<p>
								{{ trans('trans.remove_boards') }}
							</p>
						</a>
					</li>
					@endif
					@if(@Session::get('jwt')->yetkiler->{'Duyurular'})
					<li class="nav-item">
						<a href="{{ route('announ') }}" class="nav-link @if(getUrl() == 'https://emkologin.com/announ') active @endif">
							<i class="nav-icon fa-solid fa-chalkboard-user"></i>
							<p>
								{{ trans('trans.announcements') }}
							</p>
						</a>
					</li>
					@endif
					@if(@Session::get('jwt')->userData->auth_id == 1)
					<li class="nav-item">
						<a href="#" class="nav-link">
							<i class="nav-icon fa-solid fa-store"></i>
							<p>
								{{ trans('trans.store') }}
								<i class="fas fa-angle-left right"></i>
							</p>
						</a>
						<ul class="nav nav-treeview">
							<li class="nav-item" style="padding-left: 35px;">
								<a href="{{ route('uygulamalar') }}" class="nav-link">
									<i class="fa-solid fa-copy"></i>
									<p>{{ trans('trans.apps') }}</p>
								</a>
							</li>
							<li class="nav-item" style="padding-left: 35px;">
								<a href="{{ route('categories') }}" class="nav-link">
									<i class="fa-solid fa-list-ul"></i>
									<p>{{ trans('trans.categories') }}</p>
								</a>
							</li>
						</ul>
					</li>
					@endif
					@if(@Session::get('jwt')->userData->auth_id == 1)
						<li class="nav-item">
							<a href="{{ route('getSendersList') }}" class="nav-link @if(getUrl() == 'https://emkologin.com/getSendersList') active @endif">
								<i class="nav-icon fa-solid fa-chalkboard-user"></i>
								<p>
									{{ trans('trans.send_tickets') }}
								</p>
							</a>
						</li>
					@endif
					<li class="nav-item">
						<a href="{{ route('uygulamaIndirme') }}" class="nav-link @if(getUrl() == 'https://emkologin.com/uygulamaIndirme') active @endif">
							<i class="nav-icon fa-solid fa-chalkboard-user"></i>
							<p>
								{{ trans('trans.app_download') }}
							</p>
						</a>
					</li>
					<li class="nav-item">
						<a href="{{ route('urunTanitimi') }}" class="nav-link @if(getUrl() == 'https://emkologin.com/urunTanitimi') active @endif">
							<i class="nav-icon fa-solid fa-chalkboard-user"></i>
							<p>
								{{ trans('trans.product_promotion') }}
							</p>
						</a>
					</li>
					@if(@Session::get('jwt')->userData->auth_id == 1 || @Session::get('jwt')->userData->auth_id == 2)
						<li class="nav-item">
							<a href="{{ route('masterKey') }}" class="nav-link @if(getUrl() == 'https://emkologin.com/masterKeys') active @endif">
								<i class="nav-icon fa-solid fa-chalkboard-user"></i>
								<p>
									{{ trans('trans.master_key') }}
								</p>
							</a>
						</li>
					@endif
					<li class="nav-item">
						<a href="{{ route('password') }}" class="nav-link">
							<i class="nav-icon fa-solid fa-lock"></i>
							<p>
								{{ trans('trans.change_password') }}
							</p>
						</a>
					</li>
					@if(@Session::get('jwt')->userData->auth_id == 1)
					<li class="nav-item">
						<a href="{{ route('language') }}" class="nav-link">
							<i class="nav-icon fa-solid fa-globe"></i>
							<p>
								{{ trans('trans.language') }}
							</p>
						</a>
					</li>
					@endif
					<li class="nav-item">
						<a href="#" class="nav-link">
							<i class="nav-icon fa-solid fa-globe"></i>
							<p>
								{{ trans('trans.language') }}
								<i class="fas fa-angle-left right"></i>
							</p>
						</a>
						<ul class="nav nav-treeview">
							@php
								echo getTranslationForCurrentLanguage();
							@endphp
						</ul>
					</li>
					<li class="nav-item">
						<a href="{{ route('logout') }}" class="nav-link">
							<i class="nav-icon fas fa-sign-out-alt"></i>
							<p>
								{{ trans('trans.logout') }}
							</p>
						</a>
					</li>
				</ul>
			</nav>
		</div>
	</aside>

	<div class="content-wrapper">
		@yield('content')
	</div>
	<footer class="main-footer">
		<strong>Copyright &copy; 2023</strong>
		All rights reserved.
	</footer>
	<aside class="control-sidebar control-sidebar-dark"></aside>
</div>
<script>
	$('#reservationdate').datetimepicker({
        format:'YYYY-MM-DD'
    });
	
	$('.user_id').change(function() {
		$.ajax({
			url:'https://emkologin.com/getSchoolBoardIDList/'+$(this).val(),
			type:'GET',
			data:{},
			dataType:'json',
			success:function(result) {
				$('.board_id').html('');
				var returns = '';
				$.each(result, function(key, value) {
					returns += '<option value="'+value.id+'">'+value.mac_address+' ('+value.name+')</option>';
				});
				$('.board_id').html(returns);
			}
		});
	});
	
	$('#group_school_id').change(function() {
		$.ajax({
			url:'https://emkologin.com/getSchoolIDBoardLists/'+$(this).val(),
			type:'GET',
			data:{},
			dataType:'json',
			success:function(result) {
				$('.checkboxlar').html('');
				var returns = '';
				$.each(result, function(key, value) {
					returns += '<input type="checkbox" name="board[]" value="'+value.id+'"> <span>'+value.mac_address+'</span><br />';
				});
				$('.checkboxlar').html(returns);
			}
		});
	});
	
	function tahtaDurum(id,durum) {
		$.ajax({
			url:'https://emkologin.com/api/getChangeBoardStatus',
			type:'POST',
			data:{'mac_address':id, 'status':durum},
			dataType:'json',
			success:function(result) {
				location.reload();
			}
		});
	}
	
	$('#timepicker').datetimepicker({
      format: 'HH:mm'
    });
</script>
<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
    });
  });
</script>
</body>
</html>