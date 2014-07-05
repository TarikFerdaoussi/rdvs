<?php
	if($_SESSION['role'] != 1){
		header('Location:index.php');
	}
	$page = "parametres";
	include('./includes/constantes.php');
	include(INCLUDES.DS.'header.php');
	include(INCLUDES.DS.'sidebar.php');
	
	include(INCLUDES.DS.'DBFunctions.php');
	$db = new DBFunctions();
?>
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
						<li class="active">Paramètres</li>
					</ul><!--.breadcrumb-->
				</div>
				<div class="page-content">
					<div class="page-header position-relative">
						<h1>
							Paramètres
							<small>
								<i class="icon-double-angle-right"></i>
								<i class="icon-hand-right icon-animated-hand-pointer blue"></i>
								Tous les paramètres							
							</small>
						</h1>
					</div><!--/.page-header-->
					<div class="row-fluid">
						<div class="span12">
							<!--PAGE CONTENT BEGINS-->
							<div class="row-fluid">
								<div class="span12">
									<?php
										if(!empty($_POST['organisation_name']) && !empty($_POST['organisation_id']))
										{
											if($db->settingsSaveOrganisation($_POST['organisation_name'], $_POST['organisation_id'])){
												echo '<div class="alert alert-block alert-success">
														<button type="button" class="close" data-dismiss="alert"><i class="icon-remove"/></button>
														<strong>SUCCES</strong> Paramètres enregistrés avec succès !
													</div>';
											}
											else{
												echo '<div class="alert alert-block alert-error">
														<button type="button" class="close" data-dismiss="alert"><i class="icon-remove"/></button>
														<strong>ERREUR</strong> Une erreur est survenue lors de l\'enregistrement des paramètres !
													</div>';
											}
										}
									?>
									<div class="tabbable">
										<ul class="nav nav-tabs" id="myTab">
											<li class="active">
												<a data-toggle="tab" href="#home">
													<i class="green icon-home bigger-110"></i>
													Organisation
												</a>
											</li>
											<li>
												<a data-toggle="tab" href="#activities">
													<i class="green icon-home bigger-110"></i>
													Activités
												</a>
											</li>
											<li>
												<a data-toggle="tab" href="#users">
													<i class="green icon-group bigger-110"></i>
													Utilisateurs
													<span class="badge badge-important">4</span>
												</a>
											</li>
											
										</ul>
										<div class="tab-content">
											<div id="home" class="tab-pane in active">
												<form class="form-horizontal" method="POST" action="#">
													<div class="control-group">
														
														<label class="control-label" for="form-field-1">Nom de l'organisation</label>
														<div class="controls">
															<input type="text" id="form-field-1" value="<?php echo $_SESSION['organisation_name'];?>"/>
															<input type="hidden" value="<?php echo $_SESSION['organisation_id']; ?>" />
														</div>
													</div>
													
													<div class="form-actions">
														<button class="btn btn-info btn-small" type="submit">
															<i class="icon-ok bigger-110"></i>
															Enregistrer
														</button>
														
													</div>
												</form>
											</div>
											<div id="activities" class="tab-pane">
												<p>
													<i class="icon-hand-right icon-animated-hand-pointer blue"></i> 
													<a href="#modal-add-activities" role="button" class="green" data-toggle="modal">Ajouter une activité</a>
												</p>
												<div class="row-fluid">
													<div class="span8 label label-large label-info arrowed-in arrowed-right">
														<b>Les activités de l'organisation</b>
													</div>
												</div>
												<div class="row-fluid">
													<ul class="unstyled spaced">

														<?php
															$acts = $db->getActivitiesByOrganisation($_SESSION['organisation_id']);
															while($act = $acts->fetch())
															
															{
														?>
																<li><i class="icon-caret-right blue"></i><?php echo $act['activity_label']; ?></li>
														<?php 
															}
														?>
													</ul>
												</div>
											</div>
											<div id="users" class="tab-pane">
												<p>
													<i class="icon-hand-right icon-animated-hand-pointer blue"></i> 
													<a href="#modal-add-user" role="button" class="green" data-toggle="modal">Ajouter un utilisateur</a>
												</p>
												<table id="table" class="table table-striped table-bordered table-hover">
													<thead>
														<tr>
															<th class="center">
																<label>
																	<input type="checkbox" />
																	<span class="lbl"></span>
																</label>
															</th>
															<th>Login</th>
															<th>Nom</th>
															<th>Prénom</th>
															<th>Email</th>
															<th>Fonction</th>
															<th>Supérieur</th>
															<th></th>
														</tr>
													</thead>
													<tbody>
														<?php
															$users = $db->getUsersByOrganisation($_SESSION['organisation_id']);
															while($user = $users->fetch()){
														?>
																<tr>
																	<td class="center">
																		<label>
																			<input type="checkbox" />
																			<span class="lbl"></span>
																		</label>
																	</td>
																	<td>
																		<?php echo $user['username'];?>
																	</td>
																	<td>
																		<?php echo $user['person_lastname'];?>
																	</td>
																	<td>
																		<?php echo $user['person_firstname'];?>
																	</td>
																	<td>
																		<?php echo $user['email'];?>
																	</td>
																	<td>
																		<?php echo $user['activity_label'];?>
																	</td>
																	<?php
																		$sup = $db->getUserById($user['person_id_supervisor']);
																	?>
																	<td>
																		<?php echo $sup['person_firstname'].' '.$sup['person_lastname'];?>
																	</td>
																	<td class="td-actions">
																		<div class="hidden-phone visible-desktop action-buttons">
																			<a class="blue" href="#">
																				<i class="icon-zoom-in bigger-130"></i>
																			</a>
																			<a class="green" href="#">
																				<i class="icon-pencil bigger-130"></i>
																			</a>
																			<a class="red" href="#">
																				<i class="icon-trash bigger-130"></i>
																			</a>
																		</div>
																		<div class="hidden-desktop visible-phone">
																			<div class="inline position-relative">
																				<button class="btn btn-minier btn-yellow dropdown-toggle" data-toggle="dropdown">
																					<i class="icon-caret-down icon-only bigger-120"></i>
																				</button>
																				<ul class="dropdown-menu dropdown-icon-only dropdown-yellow pull-right dropdown-caret dropdown-close">
																					<li>
																						<a href="#" class="tooltip-info" data-rel="tooltip" title="View">
																							<span class="blue">
																								<i class="icon-zoom-in bigger-120"></i>
																							</span>
																						</a>
																					</li>
																					<li>
																						<a href="#" class="tooltip-success" data-rel="tooltip" title="Edit">
																							<span class="green">
																								<i class="icon-edit bigger-120"></i>
																							</span>
																						</a>
																					</li>
																					<li>
																						<a href="#" class="tooltip-error" data-rel="tooltip" title="Delete">
																							<span class="red">
																								<i class="icon-trash bigger-120"></i>
																							</span>
																						</a>
																					</li>
																				</ul>
																			</div>
																		</div>
																	</td>
																</tr>
														<?php
															}
														?>
													</tbody>
												</table>
											</div>
											
										</div>
									</div>
								</div><!--/span-->
							</div><!--/row-->
						</div><!--/.span-->
					</div><!--/.row-fluid-->
				</div><!--/.page-content-->	
			</div> <!-- main-container -->
		


		<div id="modal-add-activities" class="modal hide fade" tabindex="-1">
			<div class="modal-header no-padding">
				<div class="table-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					Ajouter une activité
				</div>
			</div>
			
			<div class="modal-body no-padding">
				<div class="row-fluid"><br />
					<form class='form-horizontal'>
						<div class='control-group'>
							<label class='control-label'>Activité</label>
							<div class='controls'>
								<input autocomplete="off" type="text"  name="modal_activity_label" id="modal_activity_label"/>
							</div>
						</div>
					</form>
				</div>
			</div>
			
			<div class="modal-footer">
				<button class="btn btn-small btn-danger pull-left" data-dismiss="modal">
					<i class="icon-remove"></i>
					Annuler
				</button>
				<button class="btn btn-small btn-success pull-right" data-dismiss="modal" onClick="javascript:addActivity()">
					<i class="icon-remove"></i>
					Enregistrer
				</button>
			</div>
		</div>



		<div id="modal-add-user" class="modal hide fade" tabindex="-1">
			<div class="modal-header no-padding">
				<div class="table-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					Ajouter un utilisateur
				</div>
			</div>
			
			<div class="modal-body no-padding">
				<div class="row-fluid"><br />
					<p>* Tous les champs sont obligatoires</p>
					<form class='form-horizontal'>
						<div class='control-group'>
							<label class='control-label'>Nom</label>
							<div class='controls'>
								<input autocomplete="off" type="text"  name="person_lastname" id="person_lastname"/>
							</div>
						</div>

						<div class='control-group'>
							<label class='control-label'>Prénom</label>
							<div class='controls'>
								<input autocomplete="off" type="text"  name="person_firstname" id="person_firstname"/>
							</div>
						</div>
						<div class='control-group'>
							<label class='control-label'>Date de naissance</label>
							<div class='controls'>
								<input class="date-picker" type="text"  name="person_birth" id="person_birth" data-date-format="yyyy-mm-dd"/>
								<span class="help-inline">(aaaa-mm-jj)</span>
							</div>
						</div>
						<div class='control-group'>
							<label class='control-label'>Activité</label>
							<div class='controls'>
								<!--<input type="text"  name="person_activity" id="person_activity" />
								<input type="hidden" name="activity_id" id="activity_id" />-->
								<select class="chzn-select" id="person_activity" data-placeholder="Sélectionnez une activité"><option value='' /></select>
							</div>
						</div>
						<div class='control-group'>
							<label class='control-label'>Email</label>
							<div class='controls'>
								<input autocomplete="off" type="text"  name="person_email" id="person_email"/>
							</div>
						</div>
						<div class='control-group'>
							<label class='control-label'>Nom d'utilisateur</label>
							<div class='controls'>
								<input autocomplete="off" type="text"  name="person_username" id="person_username"/>
							</div>
						</div>
						<div class='control-group'>
							<label class='control-label'>Mot de passe</label>
							<div class='controls'>
								<input autocomplete="off" type="password"  name="person_password" id="person_password"/>
							</div>
						</div>
						<div class='control-group'>
							<label class='control-label'>Supérieur</label>
							<div class='controls'>
								<!--<input autocomplete="off" type="text"  name="person_supervisor" id="person_supervisor"/>-->
								<select class="chzn-select" id="person_supervisor" data-placeholder="Sélectionnez une personne"><option value='' /></select>
							</div>
						</div>
					</form>
				</div>
			</div>
			
			<div class="modal-footer">
				<button class="btn btn-small btn-danger pull-left" data-dismiss="modal">
					<i class="icon-remove"></i>
					Annuler
				</button>
				<button class="btn btn-small btn-success pull-right" data-dismiss="modal" onClick="javascript:addUser()">
					<i class="icon-remove"></i>
					Enregistrer
				</button>
			</div>
		</div>
<?php include(INCLUDES.DS.'footer.php'); ?>
<!--page specific plugin scripts-->
		<script src="<?php echo ASSETS.'js/jquery-ui-1.10.3.custom.min.js';?>"></script>
		<script src="<?php echo ASSETS.'js/jquery.ui.touch-punch.min.js';?>"></script>
		<script src="<?php echo ASSETS.'js/jquery.gritter.min.js';?>"></script>
		<script src="<?php echo ASSETS.'js/jquery.dataTables.min.js';?>"></script>
		<script src="<?php echo ASSETS.'js/jquery.dataTables.bootstrap.js';?>"></script>
		<script src="<?php echo ASSETS.'js/bootbox.min.js';?>"></script>
		<script src="<?php echo ASSETS.'js/chosen.jquery.min.js';?>"></script>
		<!--ace scripts-->
		<script src="<?php echo ASSETS.'js/ace-elements.min.js';?>"></script>
		<script src="<?php echo ASSETS.'js/ace.min.js';?>"></script>
		
		<!--inline scripts related to this page-->
		<script>
			$(function() {
				var oTable1 = $('#table').dataTable({
					"aoColumns": [
					  { "bSortable": false },
					  null, null, null, null, null, null,
					  { "bSortable": false }
					],
					"iDisplayLength": 5,
					"aLengthMenu": [[3, 5, 10, -1], [3, 5, 10, "Tout"]],
					"oLanguage" : {
						"sProcessing": "Chargement...",
						"sLengthMenu": "Afficher _MENU_ enregistrements",
						"sZeroRecords": "Aucune adresse pour le moment",
						"sInfo": "Enregistrements _START_ à _END_ sur _TOTAL_",
						"sInfoEmpty": "Page 0 de 0 sur 0 entries",
						"sInfoFiltered": "(filtrer sur _MAX_ total enregistrements)",
						"sInfoPostFix": "",
						"sSearch": "Recherche:",
						"sUrl": "",
						"oPaginate": {
							"sFirst":    "Premier",
							"sPrevious": "Precedent",
							"sNext":     "Suivant",
							"sLast":     "Dernier"
						}
					}
				});
				
				$('table th input:checkbox').on('click' , function(){
					var that = this;
					$(this).closest('table').find('tr > td:first-child input:checkbox').each(function(){
						this.checked = that.checked;
						$(this).closest('tr').toggleClass('selected');
					});
						
				});

				$('#modal-add-user').on('shown', function(){
					$.ajax({
						url: 'rdv_query.php?action=getPersonsByOrganisation&organisation='+$('#organisation_id').val(),
						type: 'get',
						async: false,
						success: function(data){
							var opt = $.parseJSON(data);
							$.each(opt, function(){
								$('#person_supervisor').append($("<option></option>").val(this.id).html(this.value));
							});
						}
					});

					$.ajax({
						url: 'rdv_query.php?action=getActivitiesByOrganisation&organisation='+$('#organisation_id').val(),
						type: 'get',
						async: false,
						success: function(data){
							var opt = $.parseJSON(data);
							$.each(opt, function(){
								$('#person_activity').append($("<option></option>").val(this.id).html(this.value));
							});
						}
					});

					$(".chzn-select").chosen();
				});
			});

			function addActivity(){
				var label = $('#modal_activity_label').val();
				$.ajax({
					url : 'rdv_query.php?action=addActivity',
					data: 'label='+label+'&organisation_id='+$('#organisation_id').val(),
					type: 'post',
					success: function(reponse){
						if(reponse == 'ok') {
							$.gritter.add({
								title: 'SUCCES',
								text: "L'activité a bien été enregistrée. Raffraichissez la page pour la visualiser",
								class_name: 'gritter-success gritter-light'
							});
						}
						else{
							$.gritter.add({
								title: 'ERREUR',
								text: "Une erreur est survenue lors de l'enregistrement de l'activité.",
								class_name: 'gritter-error gritter-light'
							});
						}
					}
				});
			}

			function addUser(){
				var lastname = $('#person_lastname').val();
				var firstname = $('#person_firstname').val();
				var birth = $('#person_birth').val();
				var username = $('#person_username').val();
				var email = $('#person_email').val();
				var supervisor = $('#person_supervisor option:selected').val();
				var activity = $('#person_activity option:selected').val();
				var password = $('#person_password').val();

				$.ajax({
					url: "rdv_query.php?action=addUser",
					data: {'lastname': lastname, 'firstname':firstname, 'birth':birth, 'username':username, 'email':email, 'supervisor':supervisor, 'activity':activity, 'password':password, 'organisation':$('#organisation_id').val()},
					type: 'post',
					success: function(reponse){
						if(reponse == 'ok') {
							$.gritter.add({
								title: 'SUCCES',
								text: "L'utilisateur a bien été enregistré. Raffraichissez la page pour la visualiser",
								class_name: 'gritter-success gritter-light'
							});
						}
						else{
							$.gritter.add({
								title: 'ERREUR',
								text: "Une erreur est survenue lors de l'enregistrement de l'utilisateur.",
								class_name: 'gritter-error gritter-light'
							});
						}
					}
				});

			}
		</script>