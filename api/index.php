<?php
require_once('./Router/Get.php');
require_once('./Router/Post.php');
require_once('./Router/Put.php');
require_once('./Router/Delete.php');

try {

    // Gerage des Requetes GET / TOUT GERER EN CODE
    // Alleger le code --> avec des Fichiers GET Et tout


    if ($_SERVER['REQUEST_METHOD'] === 'GET') {

        // On récupere l'Url Complete
        $BaseUrl = explode("/", filter_var($_SERVER['REQUEST_URI'], FILTER_SANITIZE_URL));

        // La partie de l'URL qui nous interesse est au quatrieme
        $url = array();
        for ($i = 4; $i < count($BaseUrl); $i++) {
            array_push($url, $BaseUrl[$i]);
        }

        // On define la data envoyée par un get (Nulle)
        $GetData = '';

        // On verifie si une route a bien eté rentrée
        if (count($url) > 0) {

            // On envoie au router des requetes GET
            $data = Get::Router($url, $GetData);
            if ($data instanceof Exception) {
                throw $data;
            }
        } else {
            throw new Exception("No Route Defined");
        }
    } else if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        // On récupere les Valeurs
        $BaseUrl = explode("/", filter_var($_SERVER['REQUEST_URI'], FILTER_SANITIZE_URL));
        $PostData = json_decode(file_get_contents('php://input'), true);

        // On récupere la partie de l'URL qui nous interesse
        $url = array();
        for ($i = 4; $i < count($BaseUrl); $i++) {
            array_push($url, $BaseUrl[$i]);
        }

        if (count($url) > 0) {

            // On envoie au routeur des requetes Get
            $data = Post::Router($url, $PostData);
            if ($data instanceof Exception) {
                throw $data;
            }
        } else {
            throw new Exception('Empty Request');
        }


    } else if ($_SERVER['REQUEST_METHOD'] === 'PUT') {

        // On recupere les valeurs
        $BaseUrl = explode("/", filter_var($_SERVER['REQUEST_URI'], FILTER_SANITIZE_URL));
        $PutData = json_decode(file_get_contents('php://input'), true);
        
        // On récupere la partie de l'URL qui nous interesse
        $url = array();
        for ($i = 4; $i < count($BaseUrl); $i++) {
            array_push($url, $BaseUrl[$i]);
        }

        if (count($url) > 0) {

            // On envoie au routeur des requetes PUT
            $data = Put::Router($url, $PutData);
            if ($data instanceof Exception) {
                throw $data;
            }
        } else {
            throw new Exception('Empty Request');
        }
    } else if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {

        // On recupere les valeurs
        $BaseUrl = explode("/", filter_var($_SERVER['REQUEST_URI'], FILTER_SANITIZE_URL));
        $DeleteData = '';

        // On récupere la partie de l'URL qui nous interesse
        $url = array();
        for ($i = 4; $i < count($BaseUrl); $i++) {
            array_push($url, $BaseUrl[$i]);
        }
        if (count($url) > 0){

            // On envoie au routeur des requetes DELETE
            $data = Delete::Router($url,$DeleteData);
            if($data instanceof Exception){
                throw $data;
            }
        }
        else{
            throw new Exception('Empty Request');
        }

    } else {
        throw new Exception('Methode ou parametre non reconnu');
    }
} catch (Exception $e) {
    $err = [
        "Statut" => 0,  
        "Message" => $e->getMessage(),
        "code" => $e->getCode()
    ];
    $data = $err;
}
echo json_encode($data);
?>