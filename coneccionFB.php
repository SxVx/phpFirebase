<?php 
/*
Documentación de consultas con la libreria
https://firebase-php.readthedocs.io/en/stable/realtime-database.html?highlight=getReference
*/

require_once './vendor/autoload.php';

use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;

class ConeccionFB
{
	private $database;
	private $dbname = 'libros';
	
	function __construct()
	{
		$serviceAccount = ServiceAccount::fromJsonFile(__DIR__.'/prueba-c67e7-d9bd02597f32.json');
		$firebase = (new Factory)->withServiceAccount($serviceAccount)->create();

		$this->database = $firebase->getDatabase();
	}

	// (C) CREATE
	public function insert(array $data){
		if(empty($data) || !isset($data) ) { return FALSE;}
		$this->database->getReference()->getChild($this->dbname)->push($data); //getChild($key)->set($value);
		return TRUE;
	}

	// (R) READ
	public function getXKey($userID = NULL){
		if(empty($userID) || !isset($userID)){ return FALSE;}
		//return $this->database->getReference($this->dbname)->getChild($userID)->getValue();
		return $this->database->getReference($this->dbname)->getChild($userID);
	}


	public function getAll(){
		//Trae Todo SELECT * FROM
		return $this->database->getReference($this->dbname)->getValue();
	}

	// (U) UPDATE
	public function update( $userID, array $data ){
		if(empty($data) || !isset($data) ) { return FALSE;}
		return $this->database->getReference($this->dbname)->getChild($userID)->update($data);
	}


	// (D) DELETE
	public function delete($userID){
		if(empty($userID) || !isset($userID)){ return FALSE;}

		if($this->database->getReference($this->dbname)->getChild($userID)){
			$this->database->getReference($this->dbname)->getChild($userID)->remove();
			return TRUE;
		}else{
			return FALSE;
		}
	}


}



$db = new ConeccionFB();

//-----------------INSERTAR JSON--------------------
// var_dump($db->insert([
// 	'title' => 'titulo3',
//     'athor' => 'autor3'
// ]));


// var_dump($db->getAll());
/*
var_dump($db->update("-LTGhDN-zATj5jkb9aUS",[
	'title' => 'titulo3',
	'athor' => 'autor3',
	'otro' => 'otro'
]));*/

?>