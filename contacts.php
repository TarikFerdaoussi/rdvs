<?php
	$page = "contacts";
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
						<li class="active">Dashboard</li>
					</ul><!--.breadcrumb-->
				</div>
				<div class="page-content">
					<div class="page-header position-relative">
						<h1>
							Mes contacts
							<small>
								<i class="icon-double-angle-right"></i>
								<i class="icon-hand-right icon-animated-hand-pointer blue"></i>
								<a href="#modal-table" role="button" class="green" data-toggle="modal"> Ajouter un contact </a>
							
							</small>
						</h1>
					</div><!--/.page-header-->
					<div class="row-fluid">
						<div class="span12">
							<!--PAGE CONTENT BEGINS-->
							
							<div class="row-fluid">
								<div class="table-header">
									Liste des contacts enregistrés
								</div>
								
								<table id="sample-table-2" class="table table-striped table-bordered table-hover">
									<thead>
										<tr>
											<th class="center">
												<label>
													<input type="checkbox" />
													<span class="lbl"></span>
												</label>
											</th>
											<th>Nom</th>
											<th>Prénom</th>
											<th>Date de naissance</th>
											<th>Activité</th>
											<th></th>
										</tr>
									</thead>
									<tbody>
										<?php
											$persons = $db->getPersons($_SESSION['username']);
											while($person = $persons->fetch())
											{
										?>
												<tr>
													<td class="center">
														<label>
															<input type="checkbox" />
															<span class="lbl"></span>
														</label>
													</td>
													<td>
														<?php echo $person['person_lastname']; ?>
													</td>
													<td>
														<?php echo $person['person_firstname']; ?>
													</td>
													<td>
														<?php echo $person['person_birthday']; ?>
													</td>
													<td>
														<?php echo $person['activity_label']; ?>
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
							</div> <!-- row-fluid -->
							
							<div id="modal-table" class="modal hide fade" tabindex="-1">
								<div class="modal-header no-padding">
									<div class="table-header">
										<button type="button" class="close" data-dismiss="modal">&times;</button>
										Ajouter un contact
									</div>
								</div>
								
								<div class="modal-body no-padding">
									<div class="row-fluid"><br />
										<form class='form-horizontal'>
											<div class='control-group'>
												<label class='control-label'>Nom</label>
												<div class='controls'>
													<input autocomplete="off" type="text"  name="person_name" id="person_name"/>
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
												</div>
											</div>
											<div class='control-group'>
												<label class='control-label'>Activité</label>
												<div class='controls'>
													<input type="text"  name="person_activity" id="person_activity" />
													<input type="hidden" name="activity_id" id="activity_id" />
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
									<button class="btn btn-small btn-success pull-right" data-dismiss="modal" onClick="javascript:addContact()">
										<i class="icon-remove"></i>
										Enregistrer
									</button>
								</div>
							</div>
							
						</div> <!-- span12 -->
					</div> <!-- row-fluid -->
				</div> <!-- page-content -->
			</div> <!-- main-content -->
		</div> <!-- main-container -->
		<input type="hidden" id="add_contact" value="<?php echo add_contact; ?>" />
		
<?php include(INCLUDES.DS.'footer.php'); ?>
<!--page specific plugin scripts-->
		<script src="<?php echo JS.'jquery-ui.js';?>"></script>
		<script src="<?php echo ASSETS.'js/jquery-ui-1.10.3.custom.min.js';?>"></script>
		<script src="<?php echo ASSETS.'js/jquery.ui.touch-punch.min.js';?>"></script>
		<script src="<?php echo ASSETS.'js/jquery.gritter.min.js';?>"></script>
		<script src="<?php echo ASSETS.'js/jquery.dataTables.min.js';?>"></script>
		<script src="<?php echo ASSETS.'js/jquery.dataTables.bootstrap.js';?>"></script>
		
		<!--ace scripts-->
		<script src="<?php echo ASSETS.'js/ace-elements.min.js';?>"></script>
		<script src="<?php echo ASSETS.'js/ace.min.js';?>"></script>
		
		<!--inline scripts related to this page-->
		<script type="text/javascript">
			$(function() {
				var oTable1 = $('#sample-table-2').dataTable( {
					"aoColumns": [
					  { "bSortable": false },
					  null, null, null,null,
					  { "bSortable": false }
					],
					"iDisplayLength": 5,
					"aLengthMenu": [[3, 5, 10, -1], [3, 5, 10, "Tout"]],
					"oLanguage" : {
						"sProcessing": "Chargement...",
						"sLengthMenu": "Afficher _MENU_ enregistrements",
						"sZeroRecords": "Aucun contact pour le moment",
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
				
				$('.date-picker').datepicker().next().on(ace.click_event, function(){
					$(this).prev().focus();
				});
				
				$('table th input:checkbox').on('click' , function(){
					var that = this;
					$(this).closest('table').find('tr > td:first-child input:checkbox')
					.each(function(){
						this.checked = that.checked;
						$(this).closest('tr').toggleClass('selected');
					});
						
				});
			});
			
			$(document).ready(function(){
				var input = $('#person_activity');
				input.autocomplete({
					source: "rdv_query.php?action=getActivities",
					minLength: 2,
					select: function(event, ui) {
						$('#activity_id').val(ui.item.id);
					}
				});
			});
			
			function addContact(){
			
				var name = $('#person_name').val();
				var firstname = $('#person_firstname').val();
				var naiss = $('#person_birth').val();
				var activity = $('#person_activity').val();
				var activity_id = $('#activity_id').val();
				var username = $('#username').val();
				$.ajax({
								url: 'rdv_query.php?action=log',
								data: 'username='+ $('#username').val()+'&object_id='+$("#add_contact").val(),
								type: "POST",
								success: function() {}
									
							});
				$.ajax({
					url : "rdv_query.php?action=addContact",
					data: "name="+name+"&firstname="+firstname+"&naiss="+naiss+"&activity_id="+activity_id+"&username="+username,
					type: "POST",
					success : function(reponse){
						if(reponse == 'ok') {
							$.gritter.add({
								title: 'SUCCES',
								text: "Le contact a bien été enregistré. Raffraichissez la page pour le visualiser",
								class_name: 'gritter-success gritter-light'
							});
						}
						else{
							$.gritter.add({
								title: 'ERREUR',
								text: "Une erreur est survenue lors de l\'enregistrement du contact.",
								class_name: 'gritter-error gritter-light'
							});
						}
					}
				});
			}
		</script>