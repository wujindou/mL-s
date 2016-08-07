<!DOCTYPE html>
<html>

<head>

	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<title>媒力指数| 后台登录</title>

	<link href="{{ URL::asset('/css/bootstrap.min.css')}}" rel="stylesheet">
	<link href="{{ URL::asset('/font-awesome/css/font-awesome.css')}}" rel="stylesheet">

	<link href="{{ URL::asset('/css/animate.css')}}" rel="stylesheet">
	<link href="{{ URL::asset('/css/style.css')}}" rel="stylesheet">

</head>

<body class="gray-bg">

	<div class="middle-box text-center loginscreen animated fadeInDown">
		<div>
			<div>

				<h1 class="logo-name">IN+</h1>

			</div>
			<h3>Welcome to IN+</h3>
			<!--
			<p>Perfectly designed and precisely prepared admin theme with over 50 pages with extra new web app views.
-->
				<!--Continually expanded and constantly improved Inspinia Admin Them (IN+)-->
<!--
			</p>
			<p>Login in. To see it in action.</p>
-->
			@if (count($errors)>0)
				{{$errors->first('msg')}}
			@endif
			<form class="m-t" id="loginForm" role="form" method="post" action="/admin/login">
				 <input type="hidden" name="_token" value="{{ csrf_token() }}">
				<div class="form-group">
					<input type="text" class="form-control" value="{{Input::old('username')}}" placeholder="学工号" name="username" required="">
				</div>
				<div class="form-group">

					<input type="password" class="form-control" placeholder="密码" name="password" required="">

				</div>
				<button type="submit" class="btn btn-primary block full-width m-b">Login</button>
				<!--
				<a href="#"><small>Forgot password?</small></a>
				<p class="text-muted text-center"><small>Do not have an account?</small></p>
				<a class="btn btn-sm btn-white btn-block" href="register.html">Create an account</a>
-->
			</form>
			<p class="m-t"> <small>媒力指数 &copy; 2016</small> </p>
		</div>
	</div>
	<!-- Mainly scripts -->
	<script src="{{ URL::asset('js/jquery-2.1.1.js')}}"></script>
	<script src="{{ URL::asset('js/plugins/validate/jquery.validate.min.js')}}"></script>
	<script src="{{URL::asset('js/bootstrap.min.js')}}"></script>
<script>
$(function(){
	$("#loginForm").validate({
		rules: {
			username: "required",
				password: {
					required: true,
						minlength: 5
				}
		},
		messages: {
					username: {
						required: "请输入用户名",
					},
					password: {
						required: "请输入密码",
					}


		}

	});
});

</script>



</body>

</html>


