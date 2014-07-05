<?php
	$page = "shared_calendars";
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
						<li class="active">Calendriers partagés</li>
					</ul><!--.breadcrumb-->
				</div>
				<div class="page-content">
					<div class="page-header position-relative">
						<h1>
							Calendrier
							<small>
								<i class="icon-double-angle-right"></i>
								
								<?php echo $_SESSION['supervisor_firstname'].' '.$_SESSION['supervisor_lastname']; ?>							
							</small>
						</h1>
					</div><!--/.page-header-->
					<div class="row-fluid">
						<div class="span12">
							<!--PAGE CONTENT BEGINS-->
							<div class="row-fluid">
								<div class="span9">
									<div class="space"></div>
									<div id="calendar"></div>
								</div>
								<div class="span3">
									<div class="widget-box transparent">
										<div class="widget-header">
											<h4>Evènements</h4>
										</div>
										<div class="widget-main">
											<div id="external-events">
												<div class="external-event label-grey" data-class="label-grey">
													<i class="icon-move"></i>
													Rdv perso
												</div>
												<div class="external-event label-success" data-class="label-success">
													<i class="icon-move"></i>
													Consultation
												</div>
												<div class="external-event label-important" data-class="label-important">
													<i class="icon-move"></i>
													Réunion
												</div>
												<div class="external-event label-purple" data-class="label-purple">
													<i class="icon-move"></i>
													Repas
												</div>
												<div class="external-event label-yellow" data-class="label-yellow">
													<i class="icon-move"></i>
													Déplacement
												</div>
												<div class="external-event label-pink" data-class="label-pink">
													<i class="icon-move"></i>
													Type 6
												</div>
												<div class="external-event label-info" data-class="label-info">
													<i class="icon-move"></i>
													Type 7
												</div>
												<label class="hide">
													<input type="checkbox" class="ace-checkbox" id="drop-remove" />
													<span class="lbl"> Supprimer après positionnement</span>
												</label>
											</div>
										</div>
									</div>
								</div>
							</div>
							<!--PAGE CONTENT ENDS-->
						</div><!--/.span-->
					</div><!--/.row-fluid-->
				</div><!--/.page-content-->
			</div><!--/.main-content-->
		</div><!--/.main-container-->
		
<?php include(INCLUDES.DS.'footer.php'); ?>
<!--page specific plugin scripts-->
		
		<script src="<?php echo JS.'jquery-ui.js';?>"></script>
		<script src="<?php echo ASSETS.'js/jquery-ui-1.10.3.custom.min.js';?>"></script>
		<script src="<?php echo ASSETS.'js/jquery.ui.touch-punch.min.js';?>"></script>
		<script src="<?php echo ASSETS.'js/fullcalendar.min.js';?>"></script>
		<script src="<?php echo ASSETS.'js/bootbox.min.js';?>"></script>
		<script src="<?php echo ASSETS.'js/jquery.gritter.min.js';?>"></script>
		<script src="<?php echo ASSETS.'js/chosen.jquery.min.js';?>"></script>
		<!--ace scripts-->
		<script src="<?php echo ASSETS.'js/ace-elements.min.js';?>"></script>
		<script src="<?php echo ASSETS.'js/ace.min.js';?>"></script>
		<!--inline scripts related to this page-->
		<script type="text/javascript">
			$(function() {
/* initialize the external events
	-----------------------------------------------------------------*/
	$('#external-events div.external-event').each(function() {
		// create an Event Object (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)
		// it doesn't need to have a start or end
		var eventObject = {
			title: $.trim($(this).text()) // use the element's text as the event title
		};
		// store the Event Object in the DOM element so we can get to it later
		$(this).data('eventObject', eventObject);
		// make the event draggable using jQuery UI
		$(this).draggable({
			zIndex: 999,
			revert: true,      // will cause the event to go back to its
			revertDuration: 0  //  original position after the drag
		});
		
	});
	
	$(".chzn-select").chosen();
	/* initialize the calendar
	-----------------------------------------------------------------*/
	var date = new Date();
	var d = date.getDate();
	var m = date.getMonth();
	var y = date.getFullYear();
	var localOptions = {
		buttonText: {
			today: 'Aujourd\'hui',
			month: 'Mois',
			day: 'Jour',
			week: 'Semaine'
		},
		monthNames: ['Janvier','Février','Mars','Avril','Mai','Juin','Juillet','Août','Septembre','Octobre','Novembre','Decembre'],
		monthNamesShort: ['Jan','Fév','Mar','Avr','Mai','Jun','Jul','Aoû','Sept','Oct','Nov','Dec'],
		dayNames: ['Dimanche','Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi'],
		dayNamesShort: ['Di','Lu','Ma','Me','Je','Ve','Sa']
	}
	
	var calendar = $('#calendar').fullCalendar($.extend({
		titleFormat: {
			month: 'MMMM yyyy',
			week:"'Semaine du' dd [yyyy] {'au' [MMM] dd MMM yyyy}",
			day: "dddd dd MMM yyyy"
		},
		columnFormat: {
			month: 'ddd',
			week: 'ddd dd/MM',
			day: 'dddd dd/MM' 
		},
		firstDay : 1,
		allDaySlot: false,
		allDay: false,
		defaultEventMinutes: 60,
		axisFormat: 'HH:mm',
		timeFormat: { // for event elements
			agenda : 'HH:mm'
		},
		 buttonText: {
			prev: '<i class="icon-chevron-left"></i>',
			next: '<i class="icon-chevron-right"></i>'
		},
	
		header: {
			left: 'prev,next today',
			center: 'title',
			right: 'month,agendaWeek,agendaDay'
		},
		events: "rdv_query.php?action=events&username="+$('#supervisor_username').val(),
		// Convert the allDay from string to boolean
		eventRender: function(event, element, view) {
			if (event.allDay === 'true') {
				event.allDay = true;
			} else {
				event.allDay = false;
			}
		},
		editable: true,
		droppable: true, // this allows things to be dropped onto the calendar !!!
		drop: function(date, allDay) { // this function is called when something is dropped
		
			// retrieve the dropped element's stored Event Object
			var originalEventObject = $(this).data('eventObject');
			var $extraEventClass = $(this).attr('data-class');
			
			
			// we need to copy it, so that multiple events don't have a reference to the same object
			var copiedEventObject = $.extend({}, originalEventObject);
			
			// assign it the date that was reported
			copiedEventObject.start = date;
			copiedEventObject.allDay = allDay;
			if($extraEventClass) copiedEventObject['className'] = [$extraEventClass];
			
			// render the event on the calendar
			// the last `true` argument determines if the event "sticks" (http://arshaw.com/fullcalendar/docs/event_rendering/renderEvent/)
			$('#calendar').fullCalendar('renderEvent', copiedEventObject, true);
			var form = $("<form class='form-horizontal'></form>");
			form.append("<div class='control-group'><label class='control-label'>Nom de l'évènement *</label><div class='controls'><input autocomplete=off type=text  name='title' value='" + copiedEventObject.title + "'/></div></div> ");
			//form.append("<div class='control-group'><label class='control-label'>Participant</label><div class='controls'><input type=text  name='person' id='txt_person' value=''/><input type='hidden' name='person_id' id='person_id' value=''/></div></div> ");
			//form.append("<div class='control-group'><label class='control-label'>Emplacement</label><div class='controls'><input type=text name='place' id='txt_place' value=''/><input type='hidden' name='place_id' id='place_id' value=''/> </div></div>");
			form.append("<div class='control-group'><label class='control-label'>Participant *</label><div class='controls'><select class='chzn-select' id='select-persons' data-placeholder='Sélectionnez un contact...'></select></div></div>");
			form.append("<div class='control-group'><label class='control-label'>Emplacement *</label><div class='controls'><select class='chzn-select' id='select-places' data-placeholder='Sélectionnez un emplacement...'></select></div></div>");
			
			var div = bootbox.dialog(form,
				[
				{
					"label" : "<i class='icon-ok'></i> Sauvegarder",
					"class" : "btn-small btn-success",
					"callback": function() {
						var start = $.fullCalendar.formatDate(copiedEventObject.start, "yyyy-MM-dd HH:mm:ss");
						var end = $.fullCalendar.formatDate(copiedEventObject.end, "yyyy-MM-dd HH:mm:ss");
						var title = form.find('input[name=title]').val();
						var person_id = form.find('#select-persons option:selected').val();
						var place_id = form.find('#select-places option:selected').val();
						//var person = form.find('input[name=person]').val();
						//var person_id = form.find('input[name=person_id]').val();
						//var place = form.find('input[name=place]').val();
						//var place_id = form.find('input[name=place_id]').val();
						
						var allDay;
						
						if(copiedEventObject.allDay == true) allDay = 'true';
						else allDay = 'false';
						
						if(title != '' && person_id != '' && place_id != ''){
							$.ajax({
								url: 'rdv_query.php?action=addEvent',
								data: 'title='+ title+'&start='+ start +'&end='+ end + '&allDay='+ allDay +'&person='+ $('#supervisor_id').val() +'&place='+ place_id +'&username='+$('#supervisor_username').val()+'&className='+$extraEventClass,
								type: "POST",
								success: function(reponse) {
									if(reponse == 'ok') {
										$.gritter.add({
											title: 'SUCCES',
											text: 'Le rdv a bien été enregistré.',
											class_name: 'gritter-success gritter-light'
										});
									}
									else{
										$.gritter.add({
											title: 'ERREUR',
											text: 'Une erreur est survenue lors de l\'enregistrement du rdv.',
											class_name: 'gritter-error gritter-light'
										});
									}
								}
							});
						}
						else{
							div.modal("hide");
							$.gritter.add({
								title: 'ATTENTION',
								text: 'Merci de renseigner tous les champs du formulaire d\'ajout de rendez-vous.',
								class_name: 'gritter-warning gritter-light'
							});
						}
					}
				},
				{
					"label" : "<i class='icon-trash'></i> Annuler",
					"class" : "btn-small btn-danger",
					"callback": function() {
						$('#calendar').fullCalendar('removeEvents' , function(ev){
							return (ev._id == copiedEventObject._id);
						})
					}
				}
				]
				,
				{
					// prompts need a few extra options
					"onEscape": function(){
						$('#calendar').fullCalendar('removeEvents' , function(ev){
							return (ev._id == copiedEventObject._id);
						})
					}
				}
			);
			
			/* Rechercher les contacts */
			$.ajax({
				url: 'rdv_query.php?action=getPersonsBySearch&username='+$('#supervisor_username').val(),
				type: 'get',
				async: false,
				success: function(data){
					var opt = $.parseJSON(data);
					$.each(opt, function(){
						$('#select-persons').append($("<option></option>").val(this.id).html(this.value));
					});
				}
			});
			/* Rechercher les emplacements */
			$.ajax({
				url: 'rdv_query.php?action=getPlacesBySearch&username='+$('#supervisor_username').val(),
				type: 'get',
				async: false,
				success: function(data){
					var opt = $.parseJSON(data);
					$.each(opt, function(){
						$('#select-places').append($("<option></option>").val(this.id).html(this.value));
					});
				}
			});
			$(".chzn-select").chosen();
			
			// is the "remove after drop" checkbox checked?
			if ($('#drop-remove').is(':checked')) {
				// if so, remove the element from the "Draggable Events" list
				$(this).remove();
			}
			
		}
		,
		selectable: true,
		selectHelper: false,
		
		
		// TODO
		select: function(start, end, allDay) {
			var form = $("<form class='form-horizontal'></form>");
			form.append("<div class='control-group'><label class='control-label'>Nom de l'évènement *</label><div class='controls'><input autocomplete=off type=text  name='title'/></div></div> ");
			form.append("<div class='control-group'><label class='control-label'>Participant *</label><div class='controls'><select class='chzn-select' id='select-persons' data-placeholder='Sélectionnez un contact...'></select></div></div>");
			form.append("<div class='control-group'><label class='control-label'>Emplacement *</label><div class='controls'><select class='chzn-select' id='select-places' data-placeholder='Sélectionnez un emplacement...'></select></div></div>");
			$.ajax({
				url: 'rdv_query.php?action=log',
				data: 'username='+ $('#username').val()+'&object_id='+$("#select_id").val(),
				type: "POST",
				success: function() {}
					
			});
			
			var div = bootbox.dialog(form,
				[
				{
					"label" : "<i class='icon-ok'></i> Sauvegarder",
					"class" : "btn-small btn-success",
					"callback": function() {
						start = $.fullCalendar.formatDate(start, "yyyy-MM-dd HH:mm:ss");
						end = $.fullCalendar.formatDate(end, "yyyy-MM-dd HH:mm:ss");
						
						var title = form.find('input[name=title]').val();
						var person_id = form.find('#select-persons option:selected').val();
						var place_id = form.find('#select-places option:selected').val();
						
						if(allDay == true) allDay = 'true';
						else allDay = 'false';
						
						if(title != '' && person_id != '' && place_id!= ''){
							$.ajax({
								url: 'rdv_query.php?action=addEvent',
								data: 'title='+ title+'&start='+ start +'&end='+ end + '&allDay='+ allDay +'&person='+ $('#supervisor_id').val() +'&place='+ place_id +'&username='+$('#supervisor_username').val(),
								type: "POST",
								success: function(reponse) {
									if(reponse == 'ok') {
										$.gritter.add({
											title: 'SUCCES',
											text: 'Le rdv a bien été enregistré.',
											class_name: 'gritter-success gritter-light'
										});
									}
									else{
										$.gritter.add({
											title: 'ERREUR',
											text: 'Une erreur est survenue lors de l\'enregistrement du rdv.',
											class_name: 'gritter-error gritter-light'
										});
									}
								}
							});
							calendar.fullCalendar('renderEvent',
								{
									title: title,
									start: start,
									end: end,
									allDay: allDay
								},
								true // make the event "stick"
							);
						}
						else{
							div.modal("hide");
							$.gritter.add({
								title: 'ATTENTION',
								text: 'Merci de renseigner tous les champs du formulaire d\'ajout de rendez-vous.',
								class_name: 'gritter-warning gritter-light'
							});
						}
						$.ajax({
							url: 'rdv_query.php?action=log',
							data: 'username='+ $('#username').val()+'&object_id='+$('#save_create_id').val(),
							type: "POST",
							success: function() {}
								
						});
					}
				}
				,
				{
					"label" : "<i class='icon-remove'></i> Fermer",
					"class" : "btn-small"
				}
				]
				,
				{
					// prompts need a few extra options
					"onEscape": function(){
					$.ajax({
						url: 'rdv_query.php?action=log',
						data: 'username='+ $('#username').val()+'&object_id='+$('#close_create_id').val(),
						type: "POST",
						success: function() {}
							
					});
					div.modal("hide");}
				}
			).find("div.modal-content").css("height", "500px");;
			
			
			/* Rechercher les contacts */
			$.ajax({
				url: 'rdv_query.php?action=getPersonsBySearch&username='+$('#supervisor_username').val(),
				type: 'get',
				async: false,
				success: function(data){
					var opt = $.parseJSON(data);
					$.each(opt, function(){
						$('#select-persons').append($("<option></option>").val(this.id).html(this.value));
					});
				}
			});
			/* Rechercher les emplacements */
			$.ajax({
				url: 'rdv_query.php?action=getPlacesBySearch&username='+$('#supervisor_username').val(),
				type: 'get',
				async: false,
				success: function(data){
					var opt = $.parseJSON(data);
					$.each(opt, function(){
						$('#select-places').append($("<option></option>").val(this.id).html(this.value));
					});
				}
			});
			$(".chzn-select").chosen();
			
			calendar.fullCalendar('unselect');
			
		}
		,
		// Déplacement des rdv
		eventDrop: function(event, delta) {
			var start = $.fullCalendar.formatDate(event.start, "yyyy-MM-dd HH:mm:ss");
			var end = $.fullCalendar.formatDate(event.end, "yyyy-MM-dd HH:mm:ss");
			//alert(end);
			$.ajax({
				url: 'rdv_query.php?action=updateEvent',
				data: 'title='+ event.title+'&start='+ start +'&end='+ end +'&id='+ event.rdv_id +'&person='+ event.person_id +'&place='+ event.place_id,
				type: "POST",
				success: function(reponse) {
					if(reponse == 'ok') {
						$.gritter.add({
							title: 'SUCCES',
							text: 'Le rdv a bien été mis à jour.',
							class_name: 'gritter-success gritter-light'
						});
					}
					else{
						$.gritter.add({
							title: 'ERREUR',
							text: 'Une erreur est survenue lors de la mise à jour du rdv.',
							class_name: 'gritter-error gritter-light'
						});
					}
				}
			});
		}
		,
		// Redimentionnement des rdv
		eventResize: function(event) {
			start = $.fullCalendar.formatDate(event.start, "yyyy-MM-dd HH:mm:ss");
			end = $.fullCalendar.formatDate(event.end, "yyyy-MM-dd HH:mm:ss");
			$.ajax({
				url: 'rdv_query.php?action=updateEvent',
				data: 'title='+ event.title+'&start='+ start +'&end='+ end +'&id='+ event.rdv_id +'&person='+ event.person_id +'&place='+ event.place_id,
				type: "POST",
				success: function(reponse) {
					if(reponse == 'ok') {
						$.gritter.add({
							title: 'SUCCES',
							text: 'Le rdv a bien été mis à jour.',
							class_name: 'gritter-success gritter-light'
						});
					}
					else{
						$.gritter.add({
							title: 'ERREUR',
							text: 'Une erreur est survenue lors de la mise à jour du rdv.',
							class_name: 'gritter-error gritter-light'
						});
					}
				}
			});
		}
		,
		//Affichage et modification d'un rdv suite à un clic
		eventClick: function(calEvent, jsEvent, view) {
			$.ajax({
				url: 'rdv_query.php?action=log',
				data: 'username='+ $('#username').val()+'&object_id='+$("#select_click_event_id").val(),
				type: "POST",
				success: function() {}
					
			});
			
			var form = $("<form class='form-horizontal'></form>");
			form.append("<div class='control-group'><label class='control-label'>Nom de l'évènement</label><div class='controls'><input autocomplete=off type=text  name='title' value='" + calEvent.title + "'/></div></div> ");
			form.append("<div class='control-group'><label class='control-label'>Participant *</label><div class='controls'><select class='chzn-select' id='select-persons' data-placeholder='Sélectionnez un contact...'></select></div></div>");
			form.append("<div class='control-group'><label class='control-label'>Emplacement *</label><div class='controls'><select class='chzn-select' id='select-places' data-placeholder='Sélectionnez un emplacement...'></select></div></div>");
			
			var div = bootbox.dialog(form,
				[
				{
					"label" : "<i class='icon-ok'></i> Sauvegarder",
					"class" : "btn-small btn-success",
					"callback": function() {
						$.ajax({
							url: 'rdv_query.php?action=log',
							data: 'username='+ $('#username').val()+'&object_id='+$("#save_click_event_id").val(),
							type: "POST",
							success: function() {}
								
						});
						var start = $.fullCalendar.formatDate(calEvent.start, "yyyy-MM-dd HH:mm:ss");
						var end = $.fullCalendar.formatDate(calEvent.end, "yyyy-MM-dd HH:mm:ss");
						
						var title = form.find('input[name=title]').val();
						var person = form.find('input[name=person]').val();
						var person_id = form.find('input[name=person_id]').val();
						var place = form.find('input[name=place]').val();
						var place_id = form.find('input[name=place_id]').val();
						
						var allDay;
						
						if(calEvent.allDay == true) allDay = 'true';
						else allDay = 'false';
						
						if(title != '' && person_id != '' && place_id != ''){
							$.ajax({
								url: 'rdv_query.php?action=updateEvent',
								data: 'id='+calEvent.rdv_id+'&title='+ title+'&start='+ start +'&end='+ end + '&allDay='+ allDay +'&person='+ $('#supervisor_id').val() +'&place='+ place_id +'&username='+$('#supervisor_username').val(),
								type: "POST",
								success: function(reponse) {
									if(reponse == 'ok') {
										calEvent.title = title;
										calEvent.person = person;
										calEvent.person_id = person_id;
										calEvent.place = place;
										calEvent.place_id = place_id;
										calendar.fullCalendar('updateEvent', calEvent);
										$.gritter.add({
											title: 'SUCCES',
											text: 'Le rdv a bien été enregistré.',
											class_name: 'gritter-success gritter-light'
										});
									}
									else{
										$.gritter.add({
											title: 'ERREUR',
											text: 'Une erreur est survenue lors de l\'enregistrement du rdv.',
											class_name: 'gritter-error gritter-light'
										});
									}
								}
							});
						}
					}
				},
				{
					"label" : "<i class='icon-trash'></i> Supprimer",
					"class" : "btn-small btn-danger",
					"callback": function() {
						$.ajax({
							url: 'rdv_query.php?action=log',
							data: 'username='+ $('#username').val()+'&object_id='+$("#delete_click_event_id").val(),
							type: "POST",
							success: function() {}
								
						});
						$.ajax({
							url: 'rdv_query.php?action=removeEvent',
							data: 'id='+ calEvent.rdv_id ,
							type: "POST",
							success: function(reponse) {
								if(reponse == 'ok') {
									$.gritter.add({
										title: 'SUCCES',
										text: 'Le rdv a bien été supprimé.',
										class_name: 'gritter-success gritter-light'
									});
								}
								else{
									$.gritter.add({
										title: 'ERREUR',
										text: 'Une erreur est survenue lors de la suppression du rdv.',
										class_name: 'gritter-error gritter-light'
									});
								}
							}
						});
						calendar.fullCalendar('removeEvents' , function(ev){
							return (ev._id == calEvent._id);
						})
					}
				}
				,
				{
					"label" : "<i class='icon-remove'></i> Fermer",
					"class" : "btn-small"
				}
				]
				,
				{
					// prompts need a few extra options
					"onEscape": function(){
						$.ajax({
							url: 'rdv_query.php?action=log',
							data: 'username='+ $('#username').val()+'&object_id='+$("#close_click_event_id").val(),
							type: "POST",
							success: function() {}
						});
						div.modal("hide");}
				}
			);
			
			/* Rechercher les contacts */
			$.ajax({
				url: 'rdv_query.php?action=getPersonsBySearch&username='+$('#supervisor_username').val(),
				type: 'get',
				async: false,
				success: function(data){
					var opt = $.parseJSON(data);
					$.each(opt, function(){
						if(this.value == (calEvent.person_lastname + " "+ calEvent.person_firstname +" - " + calEvent.activity_label)){
							$('#select-persons').append($("<option selected></option>").val(this.id).html(this.value));
						}
						else{
							$('#select-persons').append($("<option></option>").val(this.id).html(this.value));
						}
					});
				}
			});
			/* Rechercher les emplacements */
			$.ajax({
				url: 'rdv_query.php?action=getPlacesBySearch&username='+$('#supervisor_username').val(),
				type: 'get',
				async: false,
				success: function(data){
					var opt = $.parseJSON(data);
					$.each(opt, function(){
						if(this.value == (calEvent.place_name + " - " + calEvent.place_addr)){
							$('#select-places').append($("<option selected></option>").val(this.id).html(this.value));
						}
						else{
							$('#select-places').append($("<option></option>").val(this.id).html(this.value));
						}
					});
				}
			});
			$(".chzn-select").chosen();
		},
		
		
	}, localOptions));
});
		</script>