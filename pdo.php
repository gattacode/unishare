<?php

$connexion = null;
try {
	$connexion = new PDO('mysql:host=localhost;dbname=unishare', 'root', '');
	$GLOBALS['connexion'] = $connexion;
} catch (Exception $e) {
	die("Erreur co bdd" . $e->getMessage());
}

// Fonctions de requetage Basiques
function getAllAPI($table)
{
	$conn = $GLOBALS['connexion'];
	$stmt = $conn->query("SELECT * FROM $table;");
	$rows = $stmt->fetchAll();
	if (count($rows) != 0) {
		return $rows;
	} else {
		return new Exception('Table ' . $table . ' vide');
	}
}
function getSpecific($table, $id)
{
	$conn = $GLOBALS['connexion'];
	$stmt = $conn->query("SELECT * from $table where id=$id;");
	$row = $stmt->fetchAll();
	if (count($row) == 1) {
		return $row;
	} else {
		return new Exception('Erreur dans la bd : id inexistant ou multiple');
	}
}

function postSpecific($table, $id, $PostData)
{
	$conn = $GLOBALS['connexion'];

	// Prepare le nombre de parametres en fonction de la data envoyée
	$sqlParams = '';
	for ($i = 0; $i < count($PostData); $i++) {
		if ($i != count($PostData)-1){
		$sqlParams += "?,";
		}
		else{
			$sqlParams += "?";
		}
	}

	$sql = "INSERT into $table values(" . $sqlParams . ");";
	$stmt = $conn->prepare($sql);
	
	// Remplit les parametres en fonction de la data envoyée
}
?>