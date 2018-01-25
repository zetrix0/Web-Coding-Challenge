<?php
 /** Code Réalisé par EZHER Ayoub **/
class DAO {
	
	// fonction pour se connecter à la base de données 'ecommerce' 
	public static function connectToDb() 
	{
		return new PDO('mysql:host=127.0.0.1;dbname=ecommerce', 'root', '');
	}
	
	// fonction pour executer une requête de type select et retouner le résultat 
	public static function load($requtte) 
	{
		$bd = DAO::connectToDb();
		return $bd->query($requtte);
	}
	
	// fonction pour executer une requête de type select qui retouner un seul tuple 
	public static function loadOne($requtte) 
	{
		$bd = DAO::connectToDb();
		$clunmn = $bd->query($requtte);
		if($data = $clunmn->fetch()) 
		{
			return $data;
		}
		return null;
	}

	// fonction pour executer les requêtes update ,insert et delete
	public static function execRequest($requtte) 
	{
		$bd =  DAO::connectToDb();
		$bd->query($requtte);
	}
	
	// Enleve les quote pour éviter les attaques de type SQL-injection
	public static function supSimpleCote($str)
	{
		$bd = DAO::connectToDb();
		$str = $bd->quote($str);
		$str = substr($str,1,strlen($str)-2);
		return $str;
	}
}
?>