<?php
require_once('pdo.php');
require_once('Utils.php');

class Categories
{
    public const TableName = 'Categories';
    public const ParamsNames = '(id,Name)';
    public const ArticlesTableName = 'Articles';

    public static function manageAll($url, $method, $methodData)
    {
        switch (count($url)) {
            case 1:
                $result = Categories::getAllCategories($method);
                break;
            case 2:
                $result = Categories::crudCategorie($url[1], $method, $methodData);
                break;
            case 3:
                $result = Categories::getAllArticles($url[1], $method, $url[2]);
            default:
                $result = new Exception('Endpoint non valide');
                break;
        }
        return $result;
    }

    public static function getAllCategories($method)
    {
        // Code pour renvoyer tous les Articles
        if ($method === 'GET') {
            $result = getAllAPI(Categories::TableName);
            return $result;
        } else
            return new Exception('Mauvaise methode');
    }

    public static function crudCategorie($id, $method, $methodData)
    {
        // Code pour manager en fonction de la méthode quelle CRUD action faire.
        switch ($method) {
            case 'GET':
                $data = Categories::getCategorie($id);
                break;
            case 'POST':
                $data = Categories::postCategorie($id, $methodData); // à modifier aprés pour mettre la method Data
                break;
            case 'PUT':
                $data = Categories::putCategorie($id, $methodData);
                break;
            case 'DELETE':
                $data = Categories::deleteCategorie($id);
                break;
            default:
                $data = new Exception('Methode non reconnue');
        }
        return $data;
    }
    public static function getCategorie($id)
    {
        // Code pour recuperer une categorie
        if (is_numeric($id)) {
            $result = getSpecific(Categories::TableName, $id, 'Id');
        } else {
            $result = getSpecific(Categories::TableName, $id, 'Name');
        }
        return $result;
    }
    public static function postCategorie($id, $PostData)
    {
        // Code pour Poster une categorie
        $Categorie = Categories::createCategorie($id, $PostData);
        if ($Categorie instanceof Exception) {
            return $Categorie;
        } else {
            $result = postSpecific(Categories::TableName, Categories::ParamsNames, $id, $Categorie);
            return $result;
        }
    }
    public static function putCategorie($id, $PutData)
    {
        // Code pour Modifier une categorie
        $updates = createQueryUpdates($id, $PutData);
        $result = putSpecific(Categories::TableName, $updates, $id);
        return $result;
    }
    public static function deleteCategorie($id)
    {
        // Code pour supprimer une categorie
        $result = deleteSpecific(Categories::TableName, $id);
        return $result;
    }

    public static function getAllArticles($id, $method, $route)
    {
        if ($method == 'GET' and $route = 'Articles') {
            // Requete sql compliquée ---> Faut parcourir la table articleCategories / recuperer les id contenant la categories 
            $rows = getAllAPI('articlesCategories');
            var_dump($rows);
            foreach ($rows as $row) {
            }
        } else
            return new Exception("Methode ou endpoint non valide");
    }

    public static function createCategorie($id, $PostData)
    {
        if (!empty($PostData['Name'])) {
            if (is_string($PostData['Name'])) {
                $result = array("id" => $id, "Name" => $PostData['Name']);
                return $result;
            }
        }
        return new Exception('Données non integres');
    }
}
?>