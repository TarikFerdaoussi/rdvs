<?php
	session_start();
	include('./includes/constantes.php');
	include(INCLUDES.DS.'DBFunctions.php');
	$db = new DBFunctions();
	
	$action = (isset($_GET['action']))? $_GET['action'] : '';
	
	switch($action)
	{
		case 'events':
		{
			$username = $_GET['username'];
			$events = $db->retrieveAllEvents($username);
			//print_r($events);
			echo json_encode($events);
			break;
		}
		
		case 'updateEvent' :
		{
			$id=$_POST['id'];
			$title=$_POST['title'];
			$start=$_POST['start'];
			$end=$_POST['end'];
			$person = $_POST['person'];
			$place = $_POST['place'];
			if ($db->updateEvent($id,$title,$start,$end,$person,$place)) echo 'ok';
			else echo 'ko';
			break;
		}
		
		case 'addEvent':
		{
			$title 	= $_POST['title'];
			$start 	= $_POST['start'];
			$end 	= $_POST['end'];
			$allDay = $_POST['allDay'];
			$person = $_POST['person'];
			$place 	= $_POST['place'];
			$username = $_POST['username'];
			$className = (isset($_POST['className'])) ? $_POST['className'] : '';
			
			if($db->addEvent($title, $start, $end, $allDay, $person, $place, $username, $className)) echo 'ok';
			else echo 'ko';
			break;
		}
		
		case 'removeEvent':
		{
			$id = $_POST['id'];
			if($db->removeEvent($id)) echo 'ok';
			else echo 'ko';
			break;
		}
		
		case 'getPersonsBySearch':
		{
			$q = (isset($_GET['term'])) ? $_GET['term'] : '';
			$username = $_GET['username'];
			$persons = $db->getPersonsBySearch($q,$username);
			echo json_encode($persons);
			break;
		}

		case 'getPersonsByOrganisation':
		{
			$organisation = $_GET['organisation'];
			$persons = $db->getPersonsByOrganisation($organisation);
			echo json_encode($persons);
			break;
		}
		
		case 'getPlacesBySearch':
		{
			$q = (isset($_GET['term'])) ? $_GET['term'] : '';
			$places = $db->getPlacesBySearch($q);
			echo json_encode($places);
			break;
		}
		
		case 'addAddr':
		{
			$name = $_POST['name'];
			$addr = $_POST['addr'];
			$username = $_POST['username'];
			if($db->addAddr($username, $name, $addr)) echo 'ok';
			else echo 'ko';
			break;
		}
		
		case 'getActivities':
		{
			$q = (isset($_GET['term'])) ? $_GET['term'] : '';
			$activities = $db->getActivities($q);
			echo json_encode($activities);
			break;
		}
		
		case 'getActivitiesByOrganisation':
		{
			$organisation = $_GET['organisation'];
			$activities = $db->getActivitiesByOrganisation2($organisation);
			echo json_encode($activities);
			break;
		}

		case 'addContact':
		{
			$name = $_POST['name'];
			$firstname = $_POST['firstname'];
			$activity_id = $_POST['activity_id'];
			$naiss = $_POST['naiss'];
			$naiss = explode('/', $naiss);
			$naiss = $naiss[2].'-'.$naiss[0].'-'.$naiss[1];
			$username = $_POST['username'];
			if($db->addContact($name, $firstname, $naiss, $activity_id, $username)) echo 'ok';
			else echo 'ko';			
			break;
		}
		case 'log' :
		{
			$object = $_POST['object_id'];
			$username=$_POST['username'];
			
			$db->log($object,$username);
			break;
		}

		case 'addActivity':
		{
			$label = ucwords($_POST['label']);
			$organisation = $_POST['organisation_id'];
			if($db->addActivity($label, $organisation)) echo 'ok';
			else echo 'ko';
			break;
		}

		case 'addUser':
		{
			$lastname= strtoupper($_POST['lastname']);
			$firstname= ucwords($_POST['firstname']);
			$birth= $_POST['birth'];
			$username= strtolower($_POST['username']);
			$email= strtolower($_POST['email']);
			$supervisor= $_POST['supervisor'];
			$activity= $_POST['activity'];
			$password= sha1($_POST['password']);
			$organisation = $_POST['organisation'];

			if($db->addUser($lastname, $firstname, $birth, $username, $email, $supervisor, $activity, $password, $organisation))
				echo 'ok';
			else
				echo 'ko';
			break;
		}
		
		case 'updatelastname' :
		{
			$data=$_POST['value'];
			$username=$_POST['name'];
			if($db->updatelastname($data,$username))
				echo 'ok';
			else
				echo 'nok';
			
			break;
		
		
		}
		
		case 'updatefirstname' :
		{
			$data=$_POST['value'];
			$username=$_POST['name'];
			if($db->updatefirstname($data,$username))
				echo 'ok';
			else
				echo 'nok';
			
			break;
		
		}
		
		case 'updateactivity' :
		{
			$data=$_POST['value'];
			$username=$_POST['name'];
			if($db->updateactivity($data,$username))
				echo 'ok';
			else
				echo 'nok';
				
			break;
		// $timestamp = strtotime($yourdatetime);
		
		}
		
		case 'updatebirthday' :
		{
			$data=$_POST['value'];
			$username=$_POST['name'];
			if($db->updatebirthday($data,$username)){
				$_SESSION['birthday']=$data;
				echo 'ok';
			}
			else
				echo 'nok';
				
			break;
		// $timestamp = strtotime($yourdatetime);
		
		}
		
		case 'public' :
		{
			$data=$_POST['public'];
			$username=$_POST['username'];
			if($db->update_public($data,$username))
				echo 'ok';
			else
				echo 'nok';
				
			break;
		}

		case 'changeView':
		{
			$view = $_POST['view'];
			$username = $_POST['username'];
			$result = $db->changeView($username, $view);
			if($result == true) {
				echo 'ok';
			}
			else echo 'ko';
			break;
		}
	}
?>