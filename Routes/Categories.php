<?php
require_once('pdo.php');

class Categories
{
    public static function manageAll($url, $method,$methodData)
    {
        switch (count($url)) {
            case 1:
                $result = Categories::getAllCategories();
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

    public static function getAllCategories()
    {
        // Code pour renvoyer tous les Articles
        return 'Toutes les categories';
    }

    public static function crudCategorie($id,$method,$methodData)
    {
        // Code pour manager en fonction de la méthode quelle CRUD action faire.
        return 'Crud categorie';
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
        return 'Categorie ' . $id . 'dellete';
    }
}
?>