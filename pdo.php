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
		return array('Statut' => 200,'Message' => "La récuperation des données a fonctionnée",'Data' => $rows);
	} else {
		return new Exception('Table ' . $table . ' vide');
	}
}
function getAllComents($id){
	$conn = $GLOBALS['connexion'];
	$stmt = $conn->query("SELECT * from Commentaires where IdArticle=$id;");	
	$result = $stmt->fetchAll();
	if (count($result) != 0){
		return array('Statut' => 200,'Message' => "La récuperation des données a fonctionnée",'Data' => $result);
	}
	else {
		return new Exception('Aucun commentaire trouvé');
	}
}
function getAllCategories($id){
	$conn = $GLOBALS['connexion'];
	$stmt = $conn->query("SELECT * from articleCategories where id=$id;");
	$result = $stmt->fetchAll();
	if (count($result) != 0){
		return array('Statut' => 200,'Message' => "La récuperation des données a fonctionnée",'Data' => $result);
	}
	else {
		return new Exception('Aucune categorie trouvée trouvé');
	}
}
function getSpecific($table, $id,$identificator)
{
	$conn = $GLOBALS['connexion'];
	$stmt = $conn->query("SELECT * from $table where $identificator='$id';");
	$row = $stmt->fetchAll();
	if (count($row) == 1) {
		return array('Statut' => 200,'Message' => "La récuperation des données a fonctionnée",'Data' => $row);
	} else {
		return new Exception('Erreur dans la bd : id inexistant ou multiple');
	}
}

function postSpecific($table, $sqlTables, $id, $PostData)
{
	$conn = $GLOBALS['connexion'];

	// Prepare le nombre de parametres en fonction de la data envoyée
	$sqlParams = '';
	$i = 0;
	foreach ($PostData as $param) {
		if (is_string($param)) {
			if ($i != count($PostData) - 1) {
				$sqlParams = $sqlParams . '"' . $param . '",';
			} else {
				$sqlParams = $sqlParams .'"' . $param . '"';
			}
		}
		else{
			if ($i != count($PostData) - 1) {
				$sqlParams = $sqlParams . $param . ',';
			} else {
				$sqlParams = $sqlParams . $param;
			}
		}
		$i++;
	}

	$sql = "INSERT into $table $sqlTables VALUES($sqlParams);";
	$stmt = $conn->prepare($sql);

	$result = $stmt->execute();
	if ($result == 1){
		return array('Statut' => 200,'Message' => "L'insertion des données a réussi");
	}
	else{
		return new Exception("L'insertion des Données a echoué : " . $result['message']);
	}
	// Remplit les parametres en fonction de la data envoyée
}
function putSpecific($table,$updates,$id){
	
	$conn = $GLOBALS['connexion'];
	$sql = "UPDATE $table SET $updates WHERE id=$id;";
	$stmt = $conn->prepare($sql);
	$result = $stmt->execute();
	if ($result == 1){
		return array('Statut' => 200,'Message' => 'La modification des données a réussi');
	}
	else{
		return new Exception("La modification des données a echoué :" . $result['message']);
	}
}
function deleteSpecific($table,$id){
	$conn = $GLOBALS['connexion'];

	$sql = "DELETE FROM $table WHERE id=$id";
	$stmt = $conn->prepare($sql);
	$result = $stmt->execute();
	if ($result == 1){
		return array('Statut' => 200,'Message' => 'La Supression des données a réussi');
	}
	else{
		return new Exception("La supression des données a echoué : " . $result['message']);
	}
}
?>