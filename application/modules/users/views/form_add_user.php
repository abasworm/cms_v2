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
						<form id='frm' method='POST' name='frm' action='<?=base_url('login-process')?>' novalidate>
							<input type="hidden" id="csrf_name" value="<?=$this->security->get_csrf_token_name();?>"/>
							<input type="hidden"id="csrf_hash" value="<?=$this->security->get_csrf_hash();?>"/>
							<div id="msg">
								
							</div>
							<div class="form-group">
								<?=$fusername;?>
							</div>
							<div class="form-group">
								<?=$fpassword;?>
							</div>
							<div class="form-group">
								<?=$fconfpassword;?>
							</div>
							<div class="form-group">
								<?=$ffullname;?>
							</div>
							<div class="form-group">
								<?=$femail;?>
							</div>
							<div class="form-group">
								<?=$fphone;?>
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

			function validate_value(fname, validate_value, fmessage){
				var field = $('#' + fname);
				var message = $('#message_'+fname);
				message.html(fmessage);
				if(validate_value){
					field.removeClass('is-invalid');
					field.addClass('is-valid');
					message.removeClass('invalid-feedback');
					message.addClass('valid-feedback');
				}else{
					field.removeClass('is-valid');
					field.addClass('is-invalid');
					message.removeClass('valid-feedback');
					message.addClass('invalid-feedback');
				}
				return true;
			}

			function check_password(){
				var pwd = fpassword.val();
				var cpwd = fconfpassword.val();

				if(pwd == "" || cpwd == ""){
					validate_value('password',false,'Passwod tidak boleh kosong');
				}else if(pwd!=cpwd){
					validate_value('confpassword',false,'Passwod tidak sama. mohon diperiksa');
				}else if(pwd==cpwd){
					validate_value('password',true,'');
					validate_value('confpassword',true,'Password Oke');
				}
			}
 
			function check_existing(){
				$.ajax({
					url: link_api('check_existing'),method: 'POST',contentType: 'application/x-www-form-urlencoded',dataType: 'json',
					data:{
						<?=$this->security->get_csrf_token_name();?> : fcsrf_hash.val(),
						username : fusername.val(),
						email: femail.val(),
						phone: fphone.val()
					},
					complete:function(rs, ret){
						var res = rs.responseJSON;
						if(res.status){
							if(fusername.val()==''){
								validate_value('username',false,'username tidak boleh kosong.');
							}else if(femail.val()==''){
								validate_value('email',false,'email tidak boleh kosong.');
							}else if(fphone.val()==''){
								validate_value('phone',false,'phone tidak boleh kosong.');
							}else{
								validate_value('username',res.status,res.message);
								validate_value('email',true,'');
								validate_value('phone',true,'');
							}

						}else{
							validate_value('username',res.status,res.message);
						}
					}
				});
			}

			function submit(){
				$.ajax({
					url: link_api('insert'),method: 'POST',contentType: 'application/x-www-form-urlencoded',dataType: 'json',
					data:{
						<?=$this->security->get_csrf_token_name();?> : fcsrf_hash.val(),
						username : fusername.val(),
						password : fpassword.val(),
						confpassword : fconfpassword.val(),
						fullname : ffullname.val(),
						email : femail.val(),
						phone : fphone.val()
					},
					complete:function(rs, ret){
						var res = rs.responseJSON;
						if(res.status){
							alert('sukses');
						}else{
							alert(res.message);
							//console.log(Object.keys(res.result).length);
							if(Object.keys(res.result).length > 0){
								var crs = res.result;
								if(crs.username!=''){validate_value('username',false,crs.username);}
								if(crs.password!=''){validate_value('password',false,crs.password);}
								if(crs.confpassword!=''){validate_value('confpassword',false,crs.confpassword);}
								if(crs.email!=''){validate_value('email',false,crs.email);}
								if(crs.phone!=''){validate_value('phone',false,crs.phone);}	
							}
						}
					}
				});
			}

			$(document).ready(function(){
				message.html("");

				$('#username, #phone, #email').on('focusout',function(){
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