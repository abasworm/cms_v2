<html>

<head>
	<title>Welcome to login</title>
	<script type="text/javascript" src="<?=base_url('public/plugins/jquery-3.3.1.min.js');?>"></script>
	<script type="text/javascript" src="<?=base_url('public/plugins/bootstrap/js/bootstrap.min.js');?>"></script>
	<link rel="stylesheet" href="<?=base_url('public/plugins/bootstrap/css/bootstrap.min.css');?>"/>
</head>
<body class="container-fluid">
	<div class="col-md-6">
		<div class="card">
			<div class="card-body">
				<div class="card-title">Login Page</div>
			</div>
			<div class="card-text">
				<div class="row">
					<div class="col-md-12">
						<form id='frm' method='POST' name='frm' action='<?=base_url('login-process')?>'>
							<div id="msg">
								
							</div>
							<div class="form-group">
								<label class="form-control-label col-md-6">USERNAME</label>
								<div class="col-md-6">
									<input type='text' name='<?=$username;?>' id='<?=$username;?>' class="form-control" autocomplete="new-password" />
								</div>
							</div>
							<div class="form-group">
								<label class="form-control-label col-md-6">PASSWORD</label>
								<div class="col-md-6">
									<input type='password' name='<?=$password;?>' id='<?=$password;?>' class="form-control" autocomplete="new-password"/>
								</div>
							</div>
							<div class="form-group">
								<label class="form-control-label col-md-6">CAPTCHA</label>
								<div class="col-md-6" id="captcha_image">
									<?=$captcha;?>
								</div>
							</div>
							<div class="form-group">
								<label class="form-control-label col-md-6"></label>
								<div class="col-md-6 input-group">
									
									<input type='text' name='<?=$fcaptcha;?>' id='<?=$fcaptcha;?>' class="form-control" autocomplete="new-password"/>
									<div class="input-group-append">
										<a href="javascript:refresh_captcha()" class="input-group-text btn">refresh</a>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label class="form-control-label col-md-6">ROLE AKSES</label>
								<div class="col-md-6">
									<select name='<?=$role_akses;?>' id='<?=$role_akses;?>' class="form-control" autocomplete="new-password">
										<option value="0">Please Choice</option>
									</select>
								</div>
							</div>
							<div class="btn btn-group">	
								<a href="javascript:submit()" class="btn btn-info">Login</a>
							</div>
						</form>
					</div>
				</div>

			</div>

		</div>
		
		<script>
			var fusername = $('#<?=$username;?>');
			var fpassword = $('#<?=$password;?>');
			var fcaptcha = $('#<?=$fcaptcha;?>');

			var captcha_image = $('#captcha_image');
			var message = $('#msg');

			var link_api = function(url){return "<?=base_url($ci_mod.'/api');?>/"+url;};
			var link = function(url){return "<?=base_url($ci_mod);?>/"+url;};

			function submit(){
				$.ajax({
					url: link_api('check_login'),
					method: 'POST',
					contentType: 'application/x-www-form-urlencoded',
					dataType: 'json',
					data:{
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
			});
		</script>
	</div>
</body>

</html>