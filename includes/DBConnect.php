<?php
class DBConnect {
    // constructor
    function __construct() {
        
    }
    // destructor
    function __destruct() {
        // $this->close();
    }
    // Connecting to database
    public function connect() {
        require_once './includes/config.php';
       /* Connexion à la base de données */
		try
		{
			$db = new PDO("mysql:host=".HOST.";dbname=".DB, USER, PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
		}
		catch (Exception $e)
		{
			die('Erreur : ' . $e->getMessage());
		}
		return $db;
    }
    // Closing database connection
    public function close() {
        mysql_close();
    }
}
?>