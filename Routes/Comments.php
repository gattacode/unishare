<?php
require_once('pdo.php');

class Comments
{
    public static function manageAll($url, $method,$methodData)
    {
        switch (count($url)) {
            case 1:
                $result = Comments::getAllComments();
                break;
            case 2:
                $result = Comments::crudComments($url[1],$method,$methodData);
                break;
            default:
                $result = new Exception('Endpoint non valide');
                break;
        }
        return $result;
    }

    public static function getAllComments()
    {
        // Code pour renvoyer tous les Articles
        return 'Toutes les categories';
    }

    public static function crudComments($id,$method,$methodData)
    {
        // Code pour manager en fonction de la méthode quelle CRUD action faire.
        return 'crud';
    }
    public static function getComment($id)
    {
        // Code pour recuperer une categorie
       return 'Comment ' . $id . 'Get';
    }
    public static function postComment($id)
    {
        // Code pour Poster une categorie
        return 'Comment ' . $id . 'Post';
    }
    public static function putComment($id)
    {
        // Code pour Modifier une categorie
        return 'Comment ' . $id . 'Put';
    }
    public static function deleteComment($id)
    {
        // Code pour supprimer une categorie
        return 'Comment ' . $id . 'Delete';
    }
}
?>