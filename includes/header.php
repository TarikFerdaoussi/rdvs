<?php
	session_start();
	if(!isset($_SESSION['username']) || !isset($_SESSION['role']) || empty($_SESSION['role_label']))
	{
		header('location:login.php');
	}
	
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<title>RDV - TP Organisation de Données </title>
		<meta name="description" content="with draggable and editable events" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<!--basic styles-->
		<link href="<?php echo ASSETS.'css/bootstrap.min.css'; ?>" rel="stylesheet" />
		<link href="<?php echo ASSETS.'css/bootstrap-responsive.min.css'; ?>" rel="stylesheet" />
		<link rel="stylesheet" href="<?php echo ASSETS.'css/font-awesome.min.css'?>" />
		<!--[if IE 7]>
		  <link rel="stylesheet" href="<?php echo ASSETS.'css/font-awesome-ie7.min.css';?>" />
		<![endif]-->
		<!--page specific plugin styles-->
		
		<link rel="stylesheet" href="<?php echo ASSETS.'css/datepicker.css';?>" />
		<link rel="stylesheet" href="<?php echo ASSETS.'css/fullcalendar.css'; ?>" />
		<link rel="stylesheet" href="<?php echo ASSETS.'css/jquery.gritter.css';?>" />
		<link rel="stylesheet" href="<?php echo ASSETS.'css/jquery-ui-1.10.3.custom.min.css';?>" />
		<link rel="stylesheet" href="<?php echo ASSETS.'css/chosen.css';?>" />
		<link rel="stylesheet" href="<?php echo ASSETS.'css/select2.css';?>" />
		<link rel="stylesheet" href="<?php echo ASSETS.'css/bootstrap-editable.css';?>" />
		
		<!--fonts-->
		<link rel="stylesheet" href="<?php echo STYLES.'googleFonts.css';?>" />
		<!--ace styles-->
		<link rel="stylesheet" href="<?php echo ASSETS.'css/ace.min.css'; ?>" />
		<link rel="stylesheet" href="<?php echo ASSETS.'css/ace-responsive.min.css'; ?>" />
		<link rel="stylesheet" href="<?php echo ASSETS.'css/ace-skins.min.css'; ?>" />
		<!--[if lte IE 8]>
		  <link rel="stylesheet" href="<?php echo ASSETS.'css/ace-ie.min.css';?>" />
		<![endif]-->
		<link rel="stylesheet" href="<?php echo STYLES.'jquery-ui.css'; ?>" />
		<!--inline styles related to this page-->
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	</head>
	<body class="navbar-fixed breadcrumbs-fixed">
		<input type="hidden" id="select_id" value ='<?php echo select_id; ?>' />
		<input type="hidden" id="drop_id" value ='<?php echo drop_id; ?>' />
		<input type="hidden" id="resize_id" value ='<?php echo resize_id; ?>' />
		<input type="hidden" id="save_create_id" value ='<?php echo save_create_id; ?>' />
		<input type="hidden" id="close_create_id" value='<?php echo close_create_id; ?>' />
		<input type="hidden" id="select_click_event_id" value='<?php echo select_click_event_id; ?>' />
		<input type="hidden" id="save_click_event_id" value='<?php echo save_click_event_id; ?>' />
		<input type="hidden" id="delete_click_event_id" value='<?php echo delete_click_event_id; ?>' />
		<input type="hidden" id="close_click_event_id" value='<?php echo close_click_event_id; ?>' />

		
		<div class="navbar navbar-fixed-top">
			<div class="navbar-inner">
				<div class="container-fluid">
					<a href="#" class="brand">
						<small>
							<i class="icon-calendar"></i>
							RDVS
						</small>
					</a><!--/.brand-->
					<ul class="nav ace-nav pull-right">
						<li class="purple">
							<a data-toggle="dropdown" class="dropdown-toggle" href="#">
								<i class="icon-bell-alt icon-animated-bell"></i>
								<span class="badge badge-important">4</span>
							</a>
							<ul class="pull-right dropdown-navbar navbar-pink dropdown-menu dropdown-caret dropdown-closer">
								<li class="nav-header">
									<i class="icon-warning-sign"></i>
									4 Notifications
								</li>
								<li>
									<a href="#">
										<div class="clearfix">
											<span class="pull-left">
												<i class="btn btn-mini no-hover btn-pink icon-comment"></i>
												User vous a ajouté un rdv
											</span>
											<span class="pull-right badge badge-info">+12</span>
										</div>
									</a>
								</li>
								<li>
									<a href="#">
										<i class="btn btn-mini btn-primary icon-user"></i>
										User vous a ajouté un rdv
									</a>
								</li>
								<li>
									<a href="#">
										<div class="clearfix">
											<span class="pull-left">
												<i class="btn btn-mini no-hover btn-success icon-shopping-cart"></i>
												User vous a ajouté un rdv
											</span>
											<span class="pull-right badge badge-success">+8</span>
										</div>
									</a>
								</li>
								<li>
									<a href="#">
										<div class="clearfix">
											<span class="pull-left">
												<i class="btn btn-mini no-hover btn-info icon-twitter"></i>
												User vous a ajouté un rdv
											</span>
											<span class="pull-right badge badge-info">+11</span>
										</div>
									</a>
								</li>
							</ul>
						</li>
						<li class="light-blue">
							<a data-toggle="dropdown" href="#" class="dropdown-toggle">
								<!--<img class="nav-user-photo" src="<?php echo ASSETS.'avatars/user.jpg';?>" alt="Jason's Photo" />-->
								<span class="user-info">
									<small>Bonjour,</small>
									<?php echo $_SESSION['username']; ?>
								</span>
								<i class="icon-caret-down"></i>
							</a>
							<ul class="user-menu pull-right dropdown-menu dropdown-yellow dropdown-caret dropdown-closer">
								<?php if($_SESSION['role'] == 1)
								{
								?>
								<li>
									<a href="settings.php"  id="<?php echo parametres; ?>" onClick="javascript:logs(this.id)"> 
										<i class="icon-cog"></i>
										Paramètres
									</a>
								</li>
								<?php
								}
								?>

								<li>
									<a href="profile.php"  id="<?php echo profil; ?>" onClick="javascript:logs(this.id)">
										<i class="icon-user"></i>
										Profil
									</a>
								</li>
								<li class="divider"></li>
								<li>
									<a href="logout.php" id="<?php echo LOGOUT_ID; ?>" onClick="javascript:logs(this.id)">
										<i class="icon-off"></i>
										Se déconnecter
									</a>
								</li>
							</ul>
						</li>
					</ul><!--/.ace-nav-->
				</div><!--/.container-fluid-->
			</div><!--/.navbar-inner-->
		</div>
		
		<input type="hidden" id="username" value="<?php echo $_SESSION['username'];?>" />
		<input type="hidden" id="supervisor_id" value="<?php echo $_SESSION['supervisor_id'];?>" />
		<input type="hidden" id="supervisor_username" value="<?php echo $_SESSION['supervisor_username'];?>" />
		<input type="hidden" id="calView" value="<?php echo $_SESSION["calView"];?>" />
		<input type="hidden" id="organisation_id" value="<?php echo $_SESSION['organisation_id']; ?>" />
		<script>
			function logs(id)
			{
				$.ajax({
						url: 'rdv_query.php?action=log',
						data: 'username='+ $('#username').val()+'&object_id='+id,
						type: "POST",
						success: function() {}
										
						});
				
				
			}
	
		</script>
		
		<div class="main-container container-fluid">