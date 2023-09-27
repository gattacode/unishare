<?php
require_once('./Routes/Articles.php');
require_once('./Routes/Users.php');
require_once('./Routes/Comments.php');
require_once('./Routes/Categories.php');

try {

    // Gerage des Requetes GET / TOUT GERER EN CODE
    // Alleger le code --> avec des Fichiers GET Et tout

    if ($_SERVER['REQUEST_METHOD'] === 'GET') {

        // On récupere le endpoint
        $BaseUrl = explode("/", filter_var($_SERVER['REQUEST_URI'], FILTER_SANITIZE_URL));
        // La route qui nous interesse est au quatrieme
        $url = array();
        $GetData = '';

        for ($i = 4; $i < count($BaseUrl); $i++) {
            array_push($url, $BaseUrl[$i]);
        }
        var_dump($url);
        if (count($url) > 0) {
            switch ($url[0]) {
                case 'Articles':
                    $data = Articles::manageAll($url, 'GET', $GetData);
                    if ($data instanceof Exception) {
                        throw $data;
                    }
                    break;
                case 'Users':
                    $data = Users::manageAll($url, 'GET', $GetData);
                    if ($data instanceof Exception) {
                        throw $data;
                    }
                    break;
                case 'Categories':
                    $data = Categories::manageAll($url, 'GET', $GetData);
                    if ($data instanceof Exception) {
                        throw $data;
                    }
                    break;
                case 'Comments':
                    $data = Comments::manageAll($url, 'GET', $GetData);
                    if ($data instanceof Exception) {
                        throw $data;
                    }
                    break;
                // Faire le Case Check apres
                default:
                    throw new Exception("Endpoint Non valide");
            }
        } else {
            throw new Exception("Empty Request");
        }
    } else if ($_SERVER['REQUEST_METHOD'] === 'POST') {

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