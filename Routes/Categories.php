<?php
require_once('pdo.php');

class Categories
{
    public static function manageAll($url, $method,$methodData)
    {
        switch (count($url)) {
            case 1:
                $result = Categories::getAllCategories($method);
                break;
            case 2:
                $result = Categories::crudCategorie($url[1],$method,$methodData);
                break;
            default:
                $result = new Exception('Endpoint non valide');
                break;
        }
        return $result;
    }

    public static function getAllCategories($method)
    {
        // Code pour renvoyer tous les Articles
        if ($method === 'GET'){
        return 'Toutes les categories';
        }
        else return new Exception('Mauvaise methode');
    }

    public static function crudCategorie($id,$method,$methodData)
    {
        // Code pour manager en fonction de la méthode quelle CRUD action faire.
        switch($method){
            case 'GET' : 
                $data = Categories::getCategorie($id);
                break;
            case 'POST' :
                $data = Categories::postCategorie($id); // à modifier aprés pour mettre la method Data
                break;
            case 'PUT' :
                $data = Categories::putCategorie($id);
                break;
            case 'DELETE' : 
                $data = Categories::deleteCategorie($id);
                break;
            default : $data = new Exception('Methode non reconnue');
        }
        return $data;
    }
    public static function getCategorie($id)
    {
        // Code pour recuperer une categorie
        return 'Categorie ' . $id . 'Get';
    }
    public static function postCategorie($id)
    {
        // Code pour Poster une categorie
        return 'Categorie ' . $id . 'post';
    }
    public static function putCategorie($id)
    {
        // Code pour Modifier une categorie
        return 'Categorie ' . $id . 'put';
    }
    public static function deleteCategorie($id)
    {
        // Code pour supprimer une categorie
        return 'Categorie ' . $id . 'delete';
    }
}
?>