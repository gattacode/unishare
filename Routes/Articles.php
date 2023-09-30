<?php
require_once('./pdo.php');
require_once('./Utils.php');
// Changer nom classe apres 

class Articles
{
    public const TableName = 'Articles';
    public const ParamsNames = '(id,Titre,Description,IdListe,Pseudo)';
    public const ListeParamsNames = '(id,Categorie1,Categorie2,Categorie3)';

    public const ListeTableName = 'articlecategories';
    public static function manageAll($url, $method, $methodData)
    {
        switch (count($url)) {
            case 1:
                $result = Articles::getAllArticles($method);
                break;
            case 2:
                $result = Articles::crudArticle($url[1], $method, $methodData);
                break;
            case 3:
                $result = Articles::getAllComments($url[1], $method, $url[2]); // Penser à verifier que c bien comments
                break;
            default:
                $result = new Exception('Endpoint non valide');
                break;
        }
        return $result;
    }

    public static function getAllArticles($method)
    {
        // Code pour renvoyer tous les Articles
        if ($method === 'GET') {
            $data = getAllAPI(Articles::TableName);
        } else {
            $data = new Exception('Mauvaise méthode');
        }
        return $data;
    }

    public static function crudArticle($id, $method, $methodData)
    {
        // Code pour manager en fonction de la méthode quelle CRUD action faire.
        switch ($method) {
            case 'GET':
                $data = Articles::getArticle($id);
                break;
            case 'POST':
                $data = Articles::postArticle($id, $methodData); // à modifier aprés pour mettre la method Data
                break;
            case 'PUT':
                $data = Articles::putArticle($id, $methodData);
                break;
            case 'DELETE':
                $data = Articles::deleteArticle($id);
                break;
            default:
                $data = new Exception('Methode non reconnue');
        }
        return $data;
    }
    public static function getArticle($id)
    {
        // Code pour recuperer un article;
        if (is_numeric($id)) {
            $result = getSpecific(Articles::TableName, $id, 'id');
        } else {
            $result = getSpecific(Articles::TableName, $id, 'Titre');
        }
        return $result;
    }
    public static function postArticle($id, $PostData)
    {
        // Code pour Poster un article
        $Article = Articles::createArticle($id, $PostData);
        $Categorie = Articles::createCategorie($id, $PostData);

        // Verification du resultat des 2 operations 
        if ($Article instanceof Exception or $Categorie instanceof Exception) {
            return $Article instanceof Exception ? $Article : $Categorie;
        } else {
            $result = postSpecific(Articles::TableName, Articles::ParamsNames, $id, $Article);
            $result2 = postSpecific(Articles::ListeTableName, Articles::ListeParamsNames, $id, $Categorie);

            if ($result instanceof Exception) {
                deleteSpecific(Articles::ListeTableName, $id);
                return $result;
            } else if ($result2 instanceof Exception) {
                deleteSpecific(Articles::TableName, $id);
                return $result2;
            } else {
                return $result;
            }
        }
    }
    public static function putArticle($id, $PutData)
    {
        // Code pour Modifier un article
        $updates = createQueryUpdates($id, $PutData);
        $result = putSpecific(Articles::TableName, $updates, $id);
        return $result;
    }
    public static function deleteArticle($id)
    {
        // Code pour supprimer un article
        $result = deleteSpecific(Articles::TableName, $id);
        $result2 = deleteSpecific(Articles::ListeTableName, $id);
        return $result;
    }

    public static function getAllComments($id, $method, $route)
    {
        // Code pour récuperer tous les commentaiires d'un article
        if ($method === 'GET' and $route == 'Comments') {
            $result = getAllComents($id);
            return $result;
        } else {
            return new Exception("Mauvaise Méthode ou Endpoint");
        }
    }

    public static function createArticle($id, $methodData)
    {
        if (!empty($methodData['Titre']) and !empty($methodData['Description']) and !empty($methodData['Pseudo'])) {
            if (is_string($methodData['Titre']) and is_string($methodData['Description']) and is_string($methodData['Pseudo'])) {
                $result = array("id" => $id, "Title" => $methodData['Titre'], "Description" => $methodData['Description'], "idListe" => $id, "Pseudo" => $methodData['Pseudo']);
                return $result;
            }
        }
        return new Exception('Données non integres');
    }

    public static function createCategorie($id, $methodData)
    {
        if (!empty($methodData['Categories'])) {
            $data = $methodData['Categories'];
            if (is_array($data)) {
                $test = true;
                foreach ($data as $idCategorie) {
                    if (!is_numeric($idCategorie)) {
                        $test = false;
                    }
                }
                if (count($data) > 3) {
                    $test = false;
                }
                if ($test) {
                    return array("id" => $id, "Categorie1" => $data[0], "Categorie2" => $data[1], "Categorie3" => $data[2]);
                }
            }
        }
        return new Exception('Données non integres');

    }

}
?>