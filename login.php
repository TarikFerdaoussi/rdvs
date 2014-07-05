<?php
	include('./includes/config.php');
	include('./includes/constantes.php');
	
	session_start();
	if(!empty($_SESSION['username']) && !empty($_SESSION['role']))
	{
		header('location:home.php');
	}
?>
<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="utf-8" />
		<title>Login Page - RDV</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<!--basic styles-->
		<link href="<?php echo ASSETS.'css/bootstrap.min.css'; ?>" rel="stylesheet" />
		<link href="<?php echo ASSETS.'css/bootstrap-responsive.min.css'; ?>" rel="stylesheet" />
		<link rel="stylesheet" href="<?php echo ASSETS.'css/font-awesome.min.css'; ?>" />
		<!--[if IE 7]>
		  <link rel="stylesheet" href="assets/css/font-awesome-ie7.min.css" />
		<![endif]-->
		<!--page specific plugin styles-->
		<!--fonts-->
		<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400,300" />
		<!--ace styles-->
		<link rel="stylesheet" href="<?php echo ASSETS.'css/ace.min.css'; ?>" />
		<link rel="stylesheet" href="<?php echo ASSETS.'css/ace-responsive.min.css'; ?>" />
		<link rel="stylesheet" href="<?php echo ASSETS.'css/ace-skins.min.css'; ?>" />
		<!--[if lte IE 8]>
		  <link rel="stylesheet" href="assets/css/ace-ie.min.css" />
		<![endif]-->
		<!--inline styles related to this page-->
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /></head>
	
	
	<?php
		
		require_once "./includes/DBFunctions.php";
		$db = new DBFunctions();
		
		$username = (isset($_POST['username'])) ? $_POST['username'] : '';
		$password = (isset($_POST['password'])) ? sha1($_POST['password']) : '';
		//echo $password;
		if($username != '' && $password != '')
		{
			$user = $db->getUserByUsernameAndPassword($username, $password);
			if($user != false)
			{
				session_start();
				$_SESSION['username'] 			= $user['username'];
				$_SESSION['organisation_id'] 	= $user['organisation_id'];
				$_SESSION['organisation_name'] 	= $user['organisation_name'];
				$_SESSION['role'] 				= $user['role_id'];
				$_SESSION['role_label'] 		= $user['role_label'];
				$_SESSION['firstname'] 			= $user['person_firstname'];
				$_SESSION['lastname'] 			= $user['person_lastname'];
				$_SESSION['birthday'] 			= $user['person_birthday'];
				$_SESSION['activity']			= $user['activity_label'];
				$_SESSION['supervisor_id']		= $user['person_id_supervisor'];
				$_SESSION['calView']			= $user['calview_code'];
				
				$sup = $db->getUsernameById($user['person_id_supervisor']);
				$_SESSION['supervisor_username'] = $sup['username'];
				$_SESSION['supervisor_lastname'] = $sup['person_lastname'];
				$_SESSION['supervisor_firstname'] = $sup['person_firstname'];
				$db->log(LOGIN_ID,$_SESSION['username']);
				header("location:home.php");
				
				//echo $_SESSION['firstname'];
			}
			else
			{
				echo '<span style="color:#fff;">NOK</span>';
			}
		}
	?>
	
	
	<body class="login-layout">
		<div class="main-container container-fluid">
			<div class="main-content">
				<div class="row-fluid">
					<div class="span12">
						<div class="login-container">
							<div class="row-fluid">
								<div class="center">
									<h1>
										<i class="icon-leaf green"></i>
										<span class="red">RDV</span>
										<span class="white"></span>
									</h1>
									<h4 class="blue">TP Organisation de données</h4>
								</div>
							</div>
							<div class="space-6"></div>
							<div class="row-fluid">
								<div class="position-relative">
									<div id="login-box" class="login-box visible widget-box no-border">
										<div class="widget-body">
											<div class="widget-main">
												<h4 class="header blue lighter bigger">
													<i class="icon-coffee green"></i>
													Merci de saisir vos identifiants
												</h4>
												<div class="space-6"></div>
												<form method="POST" action="#">
													<fieldset>
														<label>
															<span class="block input-icon input-icon-right">
																<input type="text" class="span12" name="username" placeholder="Nom d'utilisateur" />
																<i class="icon-user"></i>
															</span>
														</label>
														<label>
															<span class="block input-icon input-icon-right">
																<input type="password" class="span12" name="password" placeholder="Mot de passe" />
																<i class="icon-lock"></i>
															</span>
														</label>
														<div class="space"></div>
														<div class="clearfix">
															<label class="inline">
																<input type="checkbox" />
																<span class="lbl"> Me connecter automatiquement</span>
															</label>
															<input type="submit" class="width-45 pull-right btn btn-small btn-primary" value="Se connecter">
														</div>
														<div class="space-4"></div>
													</fieldset>
												</form>
											</div><!--/widget-main-->
										</div><!--/widget-body-->
									</div><!--/login-box-->
									
								</div><!--/position-relative-->
							</div>
						</div>
					</div><!--/.span-->
				</div><!--/.row-fluid-->
			</div>
		</div><!--/.main-container-->
		<!--basic scripts-->
		<!--[if !IE]>-->
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
		<!--<![endif]-->
		<!--[if IE]>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<![endif]-->
		<!--[if !IE]>-->
		<script type="text/javascript">
			window.jQuery || document.write("<script src='assets/js/jquery-2.0.3.min.js'>"+"<"+"/script>");
		</script>
		<!--<![endif]-->
		<!--[if IE]>
<script type="text/javascript">
 window.jQuery || document.write("<script src='assets/js/jquery-1.10.2.min.js'>"+"<"+"/script>");
</script>
<![endif]-->
		<script type="text/javascript">
			if("ontouchend" in document) document.write("<script src='assets/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
		</script>
		<script src="assets/js/bootstrap.min.js"></script>
		<!--page specific plugin scripts-->
		<!--ace scripts-->
		<script src="assets/js/ace-elements.min.js"></script>
		<script src="assets/js/ace.min.js"></script>
		<!--inline scripts related to this page-->
		<script type="text/javascript">
			function show_box(id) {
			 $('.widget-box.visible').removeClass('visible');
			 $('#'+id).addClass('visible');
			}
		</script>
	</body>
</html>
