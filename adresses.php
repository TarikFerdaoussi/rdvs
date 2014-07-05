<?php
	$page = "adresses";
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
							Mes adresses
							<small>
								<i class="icon-double-angle-right"></i>
								<i class="icon-hand-right icon-animated-hand-pointer blue"></i>
								<a href="#modal-table" role="button" class="green" data-toggle="modal"> Ajouter une adresse </a>
							
							</small>
						</h1>
					</div><!--/.page-header-->
					<div class="row-fluid">
						<div class="span12">
							<!--PAGE CONTENT BEGINS-->
							
							<div class="row-fluid">
								<div class="table-header">
									Liste des adresses enregistrées
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
											<th>Adresse</th>
											<th></th>
										</tr>
									</thead>
									<tbody>
										<?php
											$adresses = $db->getAdressesByUser($_SESSION['username']);
											while($adresse = $adresses->fetch()){
										?>
											<tr>
												<td class="center">
													<label>
														<input type="checkbox" />
														<span class="lbl"></span>
													</label>
												</td>
												<td>
													<?php echo $adresse['place_name'];?>
												</td>
												<td>
													<?php echo $adresse['place_addr'];?>
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
										Ajouter une adresse
									</div>
								</div>
								
								<div class="modal-body no-padding">
									<div class="row-fluid"><br />
										<form class='form-horizontal'>
											<div class='control-group'>
												<label class='control-label'>Nom de l'adresse</label>
												<div class='controls'>
													<input autocomplete=off type=text  name='addr_name' id="addr_name"/>
												</div>
											</div>
											<div class='control-group'>
												<label class='control-label'>Adresse</label>
												<div class='controls'>
													<input autocomplete=off type=text  name='addr_addr' id="addr_addr"/>
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
									<button class="btn btn-small btn-success pull-right" data-dismiss="modal" onClick="javascript:addAddr()">
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
		
		<input type="hidden" id="add_adress" value="<?php echo add_adress; ?>" />
		
<?php include(INCLUDES.DS.'footer.php'); ?>
<!--page specific plugin scripts-->
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
					  null, null,
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
					$(this).closest('table').find('tr > td:first-child input:checkbox')
					.each(function(){
						this.checked = that.checked;
						$(this).closest('tr').toggleClass('selected');
					});
						
				});
			
			
				
			});
			
			function addAddr(){
			
				var name = $('#addr_name').val();
				var addr = $('#addr_addr').val();
				$.ajax({
					url : "rdv_query.php?action=addAddr",
					data: "name="+name+"&addr="+addr+"&username="+$('#username').val(),
					type: "POST",
					success : function(data){
						if(reponse == 'ok') {
							$.gritter.add({
								title: 'SUCCES',
								text: "L'adresse a bien été enregistrée. Raffraichissez la page pour la visualiser",
								class_name: 'gritter-success gritter-light'
							});
						}
						else{
							$.gritter.add({
								title: 'ERREUR',
								text: "Une erreur est survenue lors de l\'enregistrement de l'adresse.",
								class_name: 'gritter-error gritter-light'
							});
						}
					}
				});
				$.ajax({
								url: 'rdv_query.php?action=log',
								data: 'username='+ $('#username').val()+'&object_id='+$("#add_adress").val(),
								type: "POST",
								success: function() {}
									
							});
			}
		</script>