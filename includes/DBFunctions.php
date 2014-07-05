<?php
session_start();
class DBFunctions {
	private $connect;
    private $db;
    //put your code here
    // constructor
    function __construct() {
        require_once 'DBConnect.php';
        // connecting to database
        $this->connect = new DBConnect();
        $this->db = $this->connect->connect();
		$this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    
	// destructor
    function __destruct() {
        
    }
	
	
	function getUserByUsernameAndPassword($username, $password){
		$query = $this->db->prepare("SELECT members.username, right_to.organisation_id, organisation_name, right_to.role_id, role_label, 
										person_firstname, person_lastname, person_birthday, activity_label, person_id_supervisor, calview_code
									FROM members
										JOIN calviews ON (members.calview_id = calviews.calview_id)
										JOIN right_to ON ( members.username = right_to.username ) 
										JOIN organisation ON ( organisation.organisation_id = right_to.organisation_id ) 
										JOIN roles ON ( roles.role_id = right_to.role_id ) 
										JOIN persons ON ( members.person_id = persons.person_id ) 
										JOIN hierarchy ON ( persons.person_id = hierarchy.person_id ) 
										JOIN activities ON ( persons.activity_id = activities.activity_id ) 
									WHERE members.username = :username AND password=:password");
		$query->bindValue(':username',$username, PDO::PARAM_STR);
		$query->bindValue(':password',$password, PDO::PARAM_STR);
		$query->execute();
		
		$count = $query->rowCount();
		echo '<font color="#ffffff">'.$count.'</font>';
		if($count >0){
			$data=$query->fetch();
			return $data;
		}
		else{
			return false;
		}
	}
	
	function retrieveAllEvents($username){
		$json = array();
		$query = "SELECT * 
			FROM rdvs
			JOIN members ON ( members.username = rdvs.username ) 
			JOIN persons ON ( rdvs.person_id = persons.person_id ) 
			JOIN places ON (rdvs.place_id = places.place_id)
			JOIN activities ON (persons.activity_id = activities.activity_id)
			WHERE rdvs.username =  '{$username}'";
		$resultat = $this->db->query($query)  or die("ERROR: " . implode(":", $this->db->errorInfo()));
		return ($resultat->fetchAll(PDO::FETCH_ASSOC));
	}
	
	function updateEvent($id, $title, $start, $end, $person, $place){
		$query = $this->db->prepare("UPDATE rdvs SET title=:title, start=:start, end=:end, person_id=:person, place_id=:place WHERE rdv_id=:id");
		$query->bindValue(':title', $title, PDO::PARAM_STR);
		$query->bindValue(':start', $start, PDO::PARAM_STR);
		$query->bindValue(':end', $end, PDO::PARAM_STR);
		$query->bindValue(':person', $person, PDO::PARAM_INT);
		$query->bindValue(':place', $place, PDO::PARAM_INT);
		$query->bindValue(':id', $id, PDO::PARAM_INT);
		if($query->execute() or die("ERREUR: " . implode(":", $this->db->errorInfo()))) return true;
		else return false;
	}
	
	function addEvent($title, $start, $end, $allDay, $person, $place, $username, $className){
		$query = $this->db->prepare("INSERT INTO rdvs (title, start, end, allDay, person_id, place_id, username, className) VALUES (:title, :start, :end, :allDay, :person, :place, :username, :className)");
		$query->bindValue(':title', $title, PDO::PARAM_STR);
		$query->bindValue(':start', $start, PDO::PARAM_STR);
		$query->bindValue(':end', $end, PDO::PARAM_STR);
		$query->bindValue(':username', $username, PDO::PARAM_STR);
		$query->bindValue(':className', $className, PDO::PARAM_STR);
		$query->bindValue(':allDay', $allDay, PDO::PARAM_STR);
		$query->bindValue(':person', $person, PDO::PARAM_INT);
		$query->bindValue(':place', $place, PDO::PARAM_INT);
		
		$r = $query->execute()  or die("ERROR: " . implode(":", $this->db->errorInfo()));
		if($r) return true;
		else return false;
	}
	
	function removeEvent($id){
		$query = "DELETE FROM rdvs WHERE rdv_id={$id}";
		if($this->db->query($query)) return true;
		else return false;
	}
	
	function getPersonsBySearch($q,$username){
		$json = array();
		$query = "SELECT person_id, person_lastname, person_firstname, activity_label FROM persons NATURAL JOIN activities WHERE (person_lastname LIKE '%{$q}%' OR person_firstname LIKE '%{$q}%') AND username = '{$username}' ORDER BY person_lastname, person_firstname";
		$resultat = $this->db->query($query);
		while($data = $resultat->fetch()){
			$json_row['id'] = $data['person_id'];
			$json_row['value'] = $data['person_lastname'].' '.$data['person_firstname']. ' - '.$data['activity_label'];
			array_push($json, $json_row);
		}
		return $json;
	}

	function getPersonsByOrganisation($organisation){
		$json = array();
		$query = "SELECT person_id, person_lastname, person_firstname, activity_label 
					FROM persons 
						NATURAL JOIN activities 
						NATURAL JOIN organisation_activities
					WHERE organisation_id =  {$organisation}
					ORDER BY person_lastname, person_firstname";
		$resultat = $this->db->query($query);
		while($data = $resultat->fetch()){
			$json_row['id'] = $data['person_id'];
			$json_row['value'] = $data['person_lastname'].' '.$data['person_firstname']. ' - '.$data['activity_label'];
			array_push($json, $json_row);
		}
		return $json;
	}
	
	function getPlacesBySearch($q){
		$json = array();
		$query = "SELECT place_id, place_name, place_addr FROM places WHERE place_name LIKE '%{$q}%' OR place_addr LIKE '%{$q}%' ORDER BY place_name";
		$resultat = $this->db->query($query);
		while($data = $resultat->fetch()){
			$json_row['id'] = $data['place_id'];
			$json_row['value'] = $data['place_name'].' - '.$data['place_addr'];
			array_push($json, $json_row);
		}
		return $json;
	}
	
	function getAdressesByUser($username){
		$query = "SELECT * FROM places WHERE username = '{$username}'";
		$resultat = $this->db->query($query);
		return $resultat;
	}
	
	function addAddr($username, $name, $addr){
		$query = $this->db->prepare("INSERT INTO places (place_name, place_addr, username) VALUES (:name, :addr, :username)");
		$query->bindValue(':name', $name, PDO::PARAM_STR);
		$query->bindValue(':addr', $addr, PDO::PARAM_STR);
		$query->bindValue(':username', $username, PDO::PARAM_STR);
		if($query->execute()) return true;
		else return false;
	}
	
	function getActivities($q){
		$json = array();
		$query = "SELECT * FROM activities WHERE activity_label LIKE '%{$q}%'";
		$resultat = $this->db->query($query);
		while($data = $resultat->fetch()){
			$json_row['id'] = $data['activity_id'];
			$json_row['value'] = $data['activity_label'];
			array_push($json, $json_row);
		}
		return $json;
	}
	
	function addContact($name, $firstname, $naiss, $activity_id, $username){
		$query = $this->db->prepare("INSERT INTO persons (person_lastname, person_firstname, person_birthday, activity_id, username) VALUES (:name, :firstname, :naiss, :activity, :username)");
		$query->bindValue(':name', $name, PDO::PARAM_STR);
		$query->bindValue(':firstname', $firstname, PDO::PARAM_STR);
		$query->bindValue(':naiss', $naiss, PDO::PARAM_STR);
		$query->bindValue(':activity', $activity_id, PDO::PARAM_INT);
		$query->bindValue(':username', $username, PDO::PARAM_STR);
		if($query->execute()) return true;
		else return false;
	}
	
	function getPersons($username){
		$query = "SELECT * FROM persons NATURAL JOIN activities WHERE username = '{$username}'";
		$resultat = $this->db->query($query);
		return $resultat;
	}
	
	function getUsersByOrganisation($organisation_id){
		$query = "SELECT * FROM persons
					JOIN members ON (members.person_id = persons.person_id)
					JOIN right_to ON (right_to.username = members.username)
					JOIN hierarchy ON (persons.person_id = hierarchy.person_id)
					JOIN activities ON (persons.activity_id = activities.activity_id)
					WHERE right_to.organisation_id = {$organisation_id}";
		$resultat = $this->db->query($query);
		return $resultat;
	}
	
	function getUserById($id){
		$query = "SELECT members.username, person_firstname, person_lastname 
					FROM persons 
						JOIN members ON (persons.person_id = members.person_id)
					WHERE persons.person_id = {$id}";
		$resultat = $this->db->query($query);
		return $resultat->fetch();
	}
	function settingsSaveOrganisation($organisation_id, $organisation_name){
		$query = $this->db->prepare("UPDATE organisation SET organisation_name = ':name' WHERE organisation_id=:id");
		$query->bindValue(':name', $organisation_name, PDO::PARAM_STR);
		$query->bindValue(':id', $organisation_id, PDO::PARAM_INT);
		if($query->execute()){
			return true;
		}else{
			return false;
		}
	}
	function getUsernameById($sup_id){
		$query = $this->db->query("SELECT username, person_firstname, person_lastname 
									FROM persons 
										JOIN hierarchy ON (persons.person_id = hierarchy.person_id_supervisor)
									WHERE person_id_supervisor={$sup_id}");
		$resultat = $query->fetch();
		return $resultat;
	}
	function log($object,$username)
	{
	
		$query_action = $this->db->query("SELECT action_id FROM objects WHERE object_id ={$object}");
		$action = $query_action->fetch();
		
		$query_type_action=$this->db->query("SELECT actions_type_id FROM actions WHERE action_id =".$action['action_id']);
		$action_type =$query_type_action->fetch();
	
		$query = $this->db->prepare("INSERT INTO logs (log_datetime, action_id, username, actions_type_id, object_id) VALUES (:log_datetime, :action_id, :username, :action_type_id, :object_id)");
		$query->bindValue(':log_datetime', time(), PDO::PARAM_STR);
		
		$query->bindValue(':action_id', $action['action_id'], PDO::PARAM_STR);
		$query->bindValue(':username', $username, PDO::PARAM_STR);
		$query->bindValue(':action_type_id', $action_type['actions_type_id'], PDO::PARAM_STR);
		$query->bindValue(':object_id', $object, PDO::PARAM_STR);
	
		
		$r = $query->execute()  or die("ERROR: " . implode(":", $conn->errorInfo()));
		if($r) return true;
		else return false;
	}
	function retrieveViews(){
		$query = $this->db->query("SELECT * FROM calviews") or die("ERROR: " . implode(":", $this->db->errorInfo()));
		return $query;
	}
	
	function getallactivities($username)
	{
		$query_action = $this->db->query("SELECT * FROM logs WHERE username ='{$username}' AND (object_id=1 OR object_id=5 OR object_id=8 OR object_id=9 OR object_id=11 OR object_id=14 OR object_id=15) ORDER BY log_datetime desc") ;
		return $query_action;
	}
	
	

	function getActivitiesByOrganisation($organisation){
		$query = $this->db->query("SELECT * FROM activities
										NATURAL JOIN organisation_activities
										WHERE organisation_id={$organisation}");
		return $query;
	}

	function getActivitiesByOrganisation2($organisation){
		$json = array();
		$query = "SELECT * FROM activities
					NATURAL JOIN organisation_activities
					WHERE organisation_id={$organisation}
					ORDER BY activity_label";
		$resultat = $this->db->query($query);
		while($data = $resultat->fetch()){
			$json_row['id'] = $data['activity_id'];
			$json_row['value'] = $data['activity_label'];
			array_push($json, $json_row);
		}
		return $json;
	}

	function addActivity($label, $organisation){
		$query = $this->db->prepare("INSERT INTO activities (activity_label) VALUES (:label)");
		$query->bindValue(':label', $label, PDO::PARAM_STR);
		if($query->execute() or die("ERROR: " . implode(":", $this->db->errorInfo()))){
			$activity_id = $this->db->lastInsertId();
			$query2 = $this->db->prepare("INSERT INTO organisation_activities (organisation_id, activity_id) VALUES (:organisation, :activity)");
			$query2->bindValue(':organisation', $organisation, PDO::PARAM_INT);
			$query2->bindValue(':activity', $activity_id, PDO::PARAM_INT);
			if($query2->execute() or die("ERROR: " . implode(":", $this->db->errorInfo())))
				return true;
			else
				return false;
		}
		else
			return false;
	}

	function addUser($lastname, $firstname, $birth, $username, $email, $supervisor, $activity, $password, $organisation){
		$query = $this->db->prepare("INSERT INTO persons (person_lastname, person_firstname, email, person_birthday, activity_id)
										VALUES (:lastname, :firstname, :email, :birth, :activity)");
		$query->bindValue(':lastname', $lastname, PDO::PARAM_STR);
		$query->bindValue(':firstname', $firstname, PDO::PARAM_STR);
		$query->bindValue(':email', $email, PDO::PARAM_STR);
		$query->bindValue(':birth', $birth, PDO::PARAM_STR);
		$query->bindValue(':activity', $activity, PDO::PARAM_STR);

		if($query->execute() or die("ERROR: " . implode(":", $this->db->errorInfo()))){
			$person_id = $this->db->lastInsertId();
			$query2 = $this->db->prepare("INSERT INTO members (username, password, person_id) VALUES (:username, :password, :person_id)");
			$query2->bindValue(':username', $username, PDO::PARAM_STR);
			$query2->bindValue(':password', $password, PDO::PARAM_STR);
			$query2->bindValue(':person_id', $person_id, PDO::PARAM_INT);

			if($query2->execute() or die("ERROR: " . implode(":", $this->db->errorInfo()))){
				$query3 = $this->db->prepare("INSERT INTO hierarchy (person_id, role_id, person_id_supervisor) 
												VALUES (:person, 2, :supervisor)");
				$query3->bindValue(':person', $person_id, PDO::PARAM_INT);
				//$query3->bindValue(':role', 2, PDO::PARAM_INT);
				$query3->bindValue(':supervisor', $supervisor, PDO::PARAM_INT);
				if($query3->execute() or die("ERROR: " . implode(":", $this->db->errorInfo()))){
					$query4 = $this->db->prepare("INSERT INTO right_to (role_id, organisation_id, username) VALUES (2,:organisation, :username)");
					//$query4->bindValue(':role', 2, PDO::PARAM_INT);
					$query4->bindValue(':organisation', $organisation, PDO::PARAM_INT);
					$query4->bindValue(':username', $username, PDO::PARAM_STR);
					if($query4->execute() or die("ERROR: " . implode(":", $this->db->errorInfo()))){
						return true;
					}
					else return false;
				}
				else return false;				
			}
			else return false;
		}
		else return false;

	}
	
		function updatelastname($data,$username)
	{
		$query_action = $this->db->query("UPDATE persons SET person_lastname='{$data}' WHERE username ='{$username}'");
		// $query->bindValue(':data', $data, PDO::PARAM_STR);
		// $query->bindValue(':user', $username, PDO::PARAM_STR);
		$r = $query_action->execute()  or die("ERROR: " . implode(":", $conn->errorInfo()));
		if($r) return true;
		else return false;
	}
	
	function updatefirstname($data,$username)
	{
		$query_action = $this->db->query("UPDATE persons SET person_firstname='{$data}' WHERE username ='{$username}'");
		// $query->bindValue(':data', $data, PDO::PARAM_STR);
		// $query->bindValue(':user', $username, PDO::PARAM_STR);
		$r = $query_action->execute()  or die("ERROR: " . implode(":", $conn->errorInfo()));
		if($r) return true;
		else return false;
	}
	
	function updateactivity($data,$username)
	{
			$query_action = $this->db->query("UPDATE persons SET activity_id='{$data}' WHERE username ='{$username}'");
		// $query->bindValue(':data', $data, PDO::PARAM_STR);
		// $query->bindValue(':user', $username, PDO::PARAM_STR);
		$r = $query_action->execute()  or die("ERROR: " . implode(":", $conn->errorInfo()));
		if($r) return true;
		else return false;
	}
	
	
	function updatebirthday($data,$username)
	{
			$query_action = $this->db->query("UPDATE persons SET person_birthday='{$data}' WHERE username ='{$username}'");
		// $query->bindValue(':data', $data, PDO::PARAM_STR);
		// $query->bindValue(':user', $username, PDO::PARAM_STR);
		$r = $query_action->execute()  or die("ERROR: " . implode(":", $conn->errorInfo()));
		if($r) return true;
		else return false;
	}
	
	function update_public($data,$username)
	{
		$query_action = $this->db->query("UPDATE members SET compte_public='{$data}' WHERE username ='{$username}'");
		// $query->bindValue(':data', $data, PDO::PARAM_STR);
		// $query->bindValue(':user', $username, PDO::PARAM_STR);
		$r = $query_action->execute()  or die("ERROR: " . implode(":", $conn->errorInfo()));
		if($r) return true;
		else return false;
		
	}
	
	function get_public($username)
	{
		$query = $this->db->query("SELECT * FROM members WHERE username ='{$username}'");
		
		return $query;
	}

	function changeView($username, $view){
		$query = $this->db->prepare("UPDATE members SET calview_id = :view WHERE username = :username");
		$query->bindValue(':view', $view, PDO::PARAM_INT);
		$query->bindValue(':username', $username, PDO::PARAM_STR);
		return ($query->execute());
	}
}
?>