<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta name="viewport" content="width=1,initial-scale=1,user-scalable=1" />
	<title>Login - {{ $settings->nama_perusahaan }}	</title>
	
	<link href="http://fonts.googleapis.com/css?family=Lato:100italic,100,300italic,300,400italic,400,700italic,700,900italic,900" rel="stylesheet" type="text/css">
	<link rel="stylesheet" type="text/css" href="{{asset('assets/auth/bootstrap/css/bootstrap.min.css')}}" />
	<link rel="stylesheet" type="text/css" href="{{asset('assets/auth/css/styles.css')}}" />

	<!-- FONT AWESOME STYLE  -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
	
	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
	@yield('content')

	{{-- <section class="container">
			<section class="login-form">
				<form method="post" action="" role="login">
					<img src="assets/images/logo.png" class="img-responsive" alt="" />
				
					<input type="email" name="email" placeholder="Email" required class="form-control input-lg" />
					<input type="password" name="password" placeholder="Password" required class="form-control input-lg" />
					
					<input type="checkbox" name="remember" value="1" /> Remember me<br />
					<input type="checkbox" name="tos" value="1" /> You agree to <a href="#" class="text-primary">Terms</a> and 
					<a href="#" class="text-primary">Privacy Policy</a>
					
					<button type="submit" name="go" class="btn btn-lg btn-block btn-primary">Sign in</button>
				</form>
				<div class="form-links">
					<a href="#" class="text-primary">Create account</a> or <a href="#" class="text-primary">reset password</a>
				</div>
			</section>
	</section> --}}
	
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
	<script src="{{asset('assets/auth/bootstrap/js/bootstrap.min.js')}}"></script>

	<script>
		$(document).ready(function(){
		    $('#checkbox').on('change', function(){
		        $('#password').attr('type',$('#checkbox').prop('checked')==true?"text":"password"); 
		    });
		});
	</script>
</body>
</html>