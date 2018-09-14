<html>

<head>
	<title><?=$_tab_title;?></title>
	<script type="text/javascript" src="<?=base_url('public/plugins/jquery-3.3.1.min.js');?>"></script>
	<script type="text/javascript" src="<?=base_url('public/plugins/bootstrap/js/bootstrap.min.js');?>"></script>
	<link rel="stylesheet" href="<?=base_url('public/plugins/bootstrap/css/bootstrap.min.css');?>"/>
</head>
<body class="container-fluid">
	<div class="col-md-6">
		<div class="card">
			<div class="card-body">
				<div class="card-title"><?=$_title;?></div>
			</div>
			<div class="card-text">
				<div class="row">
					<div class="col-md-12">
						<form id='frm' method='POST' name='frm' action='<?=base_url('login-process')?>'>
							<input type="hidden" id="csrf_name" value="<?=$this->security->get_csrf_token_name();?>"/>
							<input type="hidden"id="csrf_hash" value="<?=$this->security->get_csrf_hash();?>"/>
							<div id="msg">
								
							</div>
							<div class="form-group">
								<label for="username" class="form-control-label col-md-6">USERNAME</label>
								<div class="col-md-6">
									<input type='text' name='username' id='username' class="form-control" autocomplete="new-password" />
								</div>
							</div>
							<div class="form-group">
								<label for="password" class="form-control-label col-md-6">PASSWORD</label>
								<div class="col-md-6">
									<input type='password' name='password' id='password' class="form-control" autocomplete="new-password"/>
								</div>
							</div>
							<div class="form-group">
								<label for="confpassword" class="form-control-label col-md-6">CONFIRM PASSWORD</label>
								<div class="col-md-6">
									<input type='password' name='confpassword' id='confpassword' class="form-control" autocomplete="new-password"/>
								</div>
							</div>
							<div class="form-group">
								<label for="fullname" class="form-control-label col-md-6">FULLNAME</label>
								<div class="col-md-6">
									<input type='text' name='fullname' id='fullname' class="form-control" autocomplete="nope" />
								</div>
							</div>
							<div class="form-group">
								<label for="email" class="form-control-label col-md-6">E-MAIL</label>
								<div class="col-md-6">
									<input type='email' name='email' id='email' class="form-control" autocomplete="nope" />
								</div>
							</div>
							<div class="form-group">
								<label for="phone" class="form-control-label col-md-6">PHONE</label>
								<div class="col-md-6">
									<input type='text' name='phone' id='phone' class="form-control" autocomplete="nope" />
								</div>
							</div>
							
							
							<div class="form-group">
								<label class="form-control-label col-md-6">ROLE AKSES</label>
								<div class="col-md-6">
									<select name='role_akses' id='role_akses' class="form-control" autocomplete="new-password">
										<option value="0">Please Choice</option>
									</select>
								</div>
							</div>


							<div class="btn btn-group">	
								<a href="javascript:submit()" class="btn btn-info">Add</a>
							</div>
						</form>
					</div>
				</div>

			</div>

		</div>
		
		<script>

			var fusername = $('#username');
			var fpassword = $('#password');
			var fconfpassword = $('#confpassword');
			var ffullname = $('#fullname');
			var femail = $('#email');
			var fphone = $('#phone');

			var fcsrf_name = $('#csrf_name');
			var fcsrf_hash = $('#csrf_hash');

			var frole_akses = $('#role_akses');

			var message = $('#msg');

			var link_api = function(url){return "<?=base_url($ci_mod.'/api_users');?>/"+url;};
			var link = function(url){return "<?=base_url($ci_mod);?>/"+url;};

			function check_password(){
				var pwd = fpassword.val();
				var cpwd = fconfpassword.val();

				if (pwd!=cpwd){
					message.html("");
					message.append('<div class="alert alert-danger" role="alert">Password Tidak sama</div>');
					//return passwrd not match
				}else{
					message.html("");
				}
			}
 
			function check_existing(){
				$.ajax({
					url: link_api('check_existing'),method: 'POST',contentType: 'application/x-www-form-urlencoded',dataType: 'json',
					data:{
						CSRF_FL : fcsrf_hash.val(),
						username : fusername.val(),
						email: femail.val(),
						phone: fphone.val()
					},
					complete:function(rs, ret){
						var res = rs.responseJSON;
						if(res.status){
							message.html("");
							message.append('<div class="alert alert-success" role="alert">'+res.message+'</div>');
						}else{
							message.html("");
							message.append('<div class="alert alert-danger" role="alert">'+res.message+'</div>');
						}
					}
				});
			}

			function submit(){
				$.ajax({
					url: link_api('add_user'),method: 'POST',contentType: 'application/x-www-form-urlencoded',dataType: 'json',
					data:{
						CSRF_FL : fcsrf_hash.val(),
						username : fusername.val(),
						password : fpassword.val()
					},
					complete:function(rs, ret){
						var res = rs.responseJSON;
						if(res.status){
							message.html("");
							message.append('<div class="alert alert-success" role="alert">'+res.message+'</div>');
						}else{
							message.html("");
							message.append('<div class="alert alert-danger" role="alert">'+res.message+'</div>');
						}
					}
				});
			}

			function refresh_captcha(){
				$.ajax({
					url: link('refresh_captcha'),
					method: 'POST',
					contentType: 'application/x-www-form-urlencoded',
					dataType: 'json',
					
					complete:function(rs, ret){
						var res = rs.responseJSON;
						if(res.status){
							captcha_image.html("");
							captcha_image.append(res.captcha);
						}else{
							message.html("");
							message.append('<div class="alert alert-danger" role="alert">'+res.message+'</div>');
						}
					}
				});
			}

			$(document).ready(function(){
				message.html("")

				fusername.on('focusout',function(){
					check_existing();
				});

				fconfpassword.on('focusout',function(){
					check_password();
				});
			});
		</script>
	</div>
</body>

</html>