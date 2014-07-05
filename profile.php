<?php
$page = "profile";
include('./includes/constantes.php');
include(INCLUDES.DS.'header.php');
include(INCLUDES.DS.'sidebar.php');
include(INCLUDES.DS.'DBFunctions.php');
$db = new DBFunctions();
?>
<input type="hidden" id="user" value="<?php echo $_SESSION['username']; ?>"/>
<div class="main-content">
	<div class="breadcrumbs fixed" id="breadcrumbs">
		<ul class="breadcrumb">
			<li>
				<i class="icon-home home-icon"></i>
				<a href="#">Accueil</a>
				<span class="divider">
					<i class="icon-angle-right arrow-icon"></i>
				</span>
			</li>
			<li class="active">Profil</li>
		</ul><!--.breadcrumb-->
	</div>
	<div class="page-content">
		<div class="page-header position-relative">
			<h1>
				Mon profil
			</h1>
		</div><!--/.page-header-->
		<div class="row-fluid">
			<div class="span12">
				<!--PAGE CONTENT BEGINS-->
				<div class="row-fluid">
					<div id="user-profile-1" class="user-profile row-fluid">
						<div class="span3 center">
							<div>
								<div class="space-4"></div>
								<div class="width-80 label label-info label-large arrowed-in arrowed-in-right">
									<div class="inline position-relative">
										<a href="#" class="user-title-label dropdown-toggle" data-toggle="dropdown">
											<span  id="puce-status">
										<?php 
											$public=$db->get_public($_SESSION['username']);
											$data=$public->fetch();
														if($data['compte_public']==0)
														 {
														?>
													<i class="icon-circle light-red middle"></i>													
													<?php
														 }
															else
														 {
														?>
															<i class="icon-circle light-green middle"></i>	
														<?php
														}
														?>
												</span>
												&nbsp;
											<span class="white middle bigger-120"><?php echo $_SESSION['firstname'].' '.$_SESSION['lastname']; ?></span>
										</a>
										<ul class="align-left dropdown-menu dropdown-caret dropdown-lighter">
											<li class="nav-header"> Changer le status </li>
											<li>
												<a href="#" id="0" onClick="javascript:public_update(1)">
													<i class="icon-circle green"></i>
													&nbsp;
													<span class="green">Public</span>
												</a>
											</li>
											<li>
												<a href="#"  id="1" onClick="javascript:public_update(0)">
													<i class="icon-circle red"></i>
													&nbsp;
													<span class="red">Privé</span>
												</a>
											</li>
										</ul>
									</div>
								</div>
							</div>
							<div class="space-6"></div>
							Vue par défaut:
							<select id="defaultView">
								<?php
									$views = $db->retrieveViews();
									while($view = $views->fetch()){
										echo '<option value="'.$view['calview_id'].'">'.$view['calview_label'].'</option>';
									}
								?>
							</select>
							<div class="hr hr16 dotted"></div>
						</div>
						<div class="span9">
							<div class="space-12"></div>
							<div class="profile-user-info profile-user-info-striped">
								<div class="profile-info-row">
									<div class="profile-info-name"> Nom d'utilisateur </div>
									<div class="profile-info-value">
										<span class="editable" id="username"><?php echo $_SESSION['username'];?></span>
									</div>
								</div>
								<div class="profile-info-row">
									<div class="profile-info-name"> Nom </div>
									<div class="profile-info-value">
										<span class="editable" id="lastname"><?php echo $_SESSION['lastname'];?></span>
									</div>
								</div>
								<div class="profile-info-row">
									<div class="profile-info-name"> Prénom </div>
									<div class="profile-info-value">
										<span class="editable" id="firstname"><?php echo $_SESSION['firstname'];?></span>
									</div>
								</div>
								<div class="profile-info-row">
									<div class="profile-info-name"> Activité </div>
									<div class="profile-info-value">
										<span class="editable" id="activity"><?php echo $_SESSION['activity'];?></span>
									</div>
								</div>
								<div class="profile-info-row">
									<div class="profile-info-name"> Date de naissance </div>
									<div class="profile-info-value">
										<span class="editable" id="birthday"><?php echo $_SESSION['birthday'];?></span>
									</div>
								</div>
							</div>
							<div class="space-20"></div>
							<div class="widget-box transparent">
								<div class="widget-header widget-header-small">
									<h4 class="blue smaller">
										<i class="icon-rss orange"></i>
										Activité récente
									</h4>
									<div class="widget-toolbar action-buttons">
										<a href="#" data-action="reload">
											<i class="icon-refresh blue"></i>
										</a>
										&nbsp;
										<a href="#" class="pink">
											<i class="icon-trash"></i>
										</a>
									</div>
								</div>
								<div class="widget-body">
									<div class="widget-main padding-8">
										<div id="profile-feed-1" class="profile-feed">
											<?php 
												$objects=$db->getallactivities($_SESSION['username']); 									   
												while($data=$objects->fetch())
												{
											?>											
													<div class="profile-activity clearfix">
														<div>
															<?php echo $historique[$data['object_id']]; ?> 
															<div class="time">
																<i class="icon-time bigger-110"></i>
																<?php echo date('d M Y \à H\hi',$data['log_datetime']); ?>
															</div>
														</div>
														<div class="tools action-buttons">
															<a href="#" class="blue">
																<i class="icon-pencil bigger-125"></i>
															</a>
															<a href="#" class="red">
																<i class="icon-remove bigger-125"></i>
															</a>
														</div>
													</div>
											<?php
												}
											?>
										</div>
									</div>
								</div>
							</div>
							<div class="hr hr2 hr-double"></div>
							<div class="space-6"></div>
							<div class="center">
								<a href="#" class="btn btn-small btn-primary">
									<i class="icon-rss bigger-150 middle"></i>
									View more activities
									<i class="icon-on-right icon-arrow-right"></i>
								</a>
							</div>
						</div>
					</div>
				</div> <!-- row-fluid -->
			</div> <!-- span12 -->
		</div> <!-- row-fluid -->
	</div> <!-- page-content -->
</div> <!-- main-content -->
</div> <!-- main-container -->
<?php include(INCLUDES.DS.'footer.php'); ?>
		<!--page specific plugin scripts-->
		<!--[if lte IE 8]>
		  	<script src="assets/js/excanvas.min.js"></script>
		<![endif]-->
		<script src="<?php echo ASSETS.'js/jquery-ui-1.10.3.custom.min.js';?>"></script>
		<script src="<?php echo ASSETS.'js/jquery.ui.touch-punch.min.js';?>"></script>
		<script src="<?php echo ASSETS.'js/jquery.gritter.min.js';?>"></script>
		<script src="<?php echo ASSETS.'js/bootbox.min.js';?>"></script>
		<script src="<?php echo ASSETS.'js/jquery.slimscroll.min.js';?>"></script>
		<script src="<?php echo ASSETS.'js/jquery.easy-pie-chart.min.js';?>"></script>
		<script src="<?php echo ASSETS.'js/jquery.hotkeys.min.js';?>"></script>
		<script src="<?php echo ASSETS.'js/bootstrap-wysiwyg.min.js';?>"></script>
		<script src="<?php echo ASSETS.'js/select2.min.js';?>"></script>
		<script src="<?php echo ASSETS.'js/date-time/bootstrap-datepicker.min.js';?>"></script>
		<script src="<?php echo ASSETS.'js/fuelux/fuelux.spinner.min.js';?>"></script>
		<script src="<?php echo ASSETS.'js/x-editable/bootstrap-editable.min.js';?>"></script>
		<script src="<?php echo ASSETS.'js/x-editable/ace-editable.min.js';?>"></script>
		<script src="<?php echo ASSETS.'js/jquery.maskedinput.min.js';?>"></script>
		<!--ace scripts-->
		<script src="<?php echo ASSETS.'js/ace-elements.min.js';?>"></script>
		<script src="<?php echo ASSETS.'js/ace.min.js';?>"></script>
		<!--inline scripts related to this page-->
		<script>
			function public_update(id)
			{
				$.ajax({
								url: 'rdv_query.php?action=public',
								data: 'username='+ $('#user').val()+'&public='+id,
								type: "POST",
								success: function(reponse) {
									if(reponse == 'ok') {
										if($('#puce-status').html() == '<i class="icon-circle light-red middle"></i>'){
											$('#puce-status').html('<i class="icon-circle light-green middle"></i>');
										}
										else{
											$('#puce-status').html('<i class="icon-circle light-red middle"></i>');
										}
										$.gritter.add({
											title: 'SUCCES',
											text: 'Votre profil a bien été modifier',
											class_name: 'gritter-success gritter-light'
										});
									}
									else{
										$.gritter.add({
											title: 'ERREUR',
											text: 'Une erreur est survenue lors de la modification de votre visibilité',
											class_name: 'gritter-error gritter-light'
										});
									}
								}
									
							});
			}
		</script>
		<script type="text/javascript">
		  	$(function() {
				//editables on first profile page
				$.fn.editable.defaults.mode = 'inline';
				$.fn.editableform.loading = "<div class='editableform-loading'><i class='light-blue icon-2x icon-spinner icon-spin'></i></div>";
				$.fn.editableform.buttons = '<button type="submit" class="btn btn-info editable-submit"><i class="icon-ok icon-white"></i></button>'+
				'<button type="button" class="btn editable-cancel"><i class="icon-remove"></i></button>';    
				
				//editables 
				$('#username').editable({
					type: 'text',
					name: 'username'
				});
				
				$('#lastname').editable({
					pk: '1',
					type: 'text',
					name: $('#user').val(),
					url:  'rdv_query.php?action=updatelastname',
					success: function(reponse) {
						if(reponse == 'ok') {
							$.gritter.add({
								title: 'SUCCES',
								text: 'Votre nom a bien été modifié, veuillez vous reconnecter pour que ce soit pris en compte',
								class_name: 'gritter-success gritter-light'
							});
						}
						else{
							$.gritter.add({
								title: 'ERREUR',
								text: 'Une erreur est survenue lors de la modification de votre nom',
								class_name: 'gritter-error gritter-light'
							});
						}
					}
					 

				});

				$('#firstname').editable({
					pk: '1',
					type: 'text',
					name: $('#user').val(),
					url:  'rdv_query.php?action=updatefirstname',
					success: function(reponse) {
									if(reponse == 'ok') {
										$.gritter.add({
											title: 'SUCCES',
											text: 'Votre prénom a bien été modifié, veuillez vous reconnecter pour que ce soit pris en compte',
											class_name: 'gritter-success gritter-light'
										});
									}
									else{
										$.gritter.add({
											title: 'ERREUR',
											text: 'Une erreur est survenue lors de la modification de votre prénom',
											class_name: 'gritter-error gritter-light'
										});
									}
								}
				});

				$('#birthday').editable({
					pk : '1',
					type: 'date',
					format: 'yyyy-mm-dd',
					viewformat: 'dd/mm/yyyy',
					datepicker: {
						weekStart: 1
					},
					name: $('#user').val(),
					url:  'rdv_query.php?action=updatebirthday',
					success: function(reponse) {
						if(reponse == 'ok') {
							$.gritter.add({
								title: 'SUCCES',
								text: 'Votre date de naissance  été modifié, veuillez vous reconnecter pour que ce soit pris en compte',
								class_name: 'gritter-success gritter-light'
							});
						}
						else{
							$.gritter.add({
								title: 'ERREUR',
								text: 'Une erreur est survenue lors de la modification de votre date de naissance ',
								class_name: 'gritter-error gritter-light'
							});
						}
					}
				});


				var activities = [];
				$.ajax({
					url : 'rdv_query.php?action=getActivities',
					data: {},
					type: 'POST',
					async: false,
					success: function(data){
						var obj = $.parseJSON(data);
						$.each(obj, function(k, v){
							activities.push({id: v.id, text: v.value});
						});
					}
				});

				//console.debug(activities);

				$('#activity').editable({
					pk: '1',
					type : 'select2',
					source : activities,
					name: $('#user').val(),
					url:  'rdv_query.php?action=updateactivity',
					success: function(reponse) {
									if(reponse == 'ok') {
										$.gritter.add({
											title: 'SUCCES',
											text: 'Votre activité a bien été modifié, veuillez vous reconnecter pour que ce soit pris en compte',
											class_name: 'gritter-success gritter-light'
										});
									}
									else{
										$.gritter.add({
											title: 'ERREUR',
											text: 'Une erreur est survenue lors de la modification de votre activité',
											class_name: 'gritter-error gritter-light'
										});
									}
								}
				});
				
				
				$('#age').editable({
					type: 'spinner',
					name : 'age',
					spinner : {
						min : 16, max:99, step:1
					}
				});
				
				$('#login').editable({
			        type: 'slider',//$range.type == 'range' ? 'range' : 'slider',
			        name : 'login',
			        slider : {
			        	min : 1, max:50, width:100
			        },
			        success: function(response, newValue) {
			        	if(parseInt(newValue) == 1)
			        		$(this).html(newValue + " hour ago");
			        	else $(this).html(newValue + " hours ago");
			        }
			    });
				$('#about').editable({
					mode: 'inline',
					type: 'wysiwyg',
					name : 'about',
					wysiwyg : {
						//css : {'max-width':'300px'}
					},
					success: function(response, newValue) {
					}
				});
				$('#profile-feed-1').slimScroll({
					height: '250px',
					alwaysVisible : true
				});

				$('#defaultView').change(function(){
					var idView = $('#defaultView option:selected').val();
					$.ajax({
						url: 'rdv_query.php?action=changeView',
						data: 'view='+idView+'&username='+$('#username').val(),
						type: 'post',
						success: function(reponse){
							if(reponse == 'ok') {
								$.gritter.add({
									title: 'SUCCES',
									text: 'Votre vue par défaut a bien été modifiée. Veuillez vous reconnecter pour voir les modifications',
									class_name: 'gritter-success gritter-light'
								});
							}
							else{
								$.gritter.add({
									title: 'ERREUR',
									text: 'Une erreur est survenue lors de la modification de votre vue par défaut.',
									class_name: 'gritter-error gritter-light'
								});
							}
						}
					});
				});
			});
		</script>
