<?php
require_once('./Routes/Articles.php');
require_once('./Routes/Users.php');
require_once('./Routes/Comments.php');
require_once('./Routes/Categories.php');
require_once('./Router/Get.php');

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
            $data = Get::Router($url,$GetData);
            if ($data instanceof Exception){
                throw $data;
            }
        }
        else {
            throw new Exception("No Route Defined");
        }
    }
    
        else if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        // On récupere les Valeurs
        $baseurl = explode("/", filter_var($_SERVER['REQUEST_URI'], FILTER_SANITIZE_URL));
        $PostData = json_decode(file_get_contents('php://input'), true);

        $url = array();
        for ($i = 4; $i < $BaseUrl; $i++) {
            array_push($url, $BaseUrl[$i]);
        }
        if (count($url) > 0) {
            switch ($url[4]) {
                // Gerer le cas Login et Register Aprés
                case 'Articles':
                    $data = Articles::manageAll($url,'POST', $PostData);
                    if ($data instanceof Exception) {
                        throw $data;
                    }
                    break;
                case 'Users':
                    $data = Users::manageAll($url,'POST', $PostData);
                    if ($data instanceof Exception) {
                        throw $data;
                    }
                    break;
                case 'Categories':
                    $data = Categories::manageAll($url,'POST', $PostData);
                    if ($data instanceof Exception) {
                        throw $data;
                    }
                    break;
                case 'Comments':
                    $data = Comments::manageAll($url,'¨POST', $PostData);
                    if ($data instanceof Exception) {
                        throw $data;
                    }
                    break;
            }
        } else {
            throw new Exception('Empty Request');
        }

        var_dump($PostData);

    } else if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
        $_PUT = json_decode(file_get_contents('php://input'), true);
        echo $_PUT['action'];
    } else if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
        // A faire
        echo 'Delete Method';
    } else {
        throw new Exception('Methode ou parametre non reconnu');
    }
} catch (Exception $e) {
    $err = [
        "message" => $e->getMessage(),
        "code" => $e->getCode()
    ];
    print_r($err);
}
?>