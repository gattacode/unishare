<?php
require_once('pdo.php');

class Comments
{
    public static function manageAll($url, $method,$methodData)
    {
        switch (count($url)) {
            case 1:
                $result = Comments::getAllComments($method);
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

    public static function getAllComments($method)
    {
        // Code pour renvoyer tous les Articles
        if ($method === 'GET'){
        return 'Toutes les categories';
        }
        else{
            return new Exception('Mauvaise méthode');
        }
    }

    public static function crudComments($id,$method,$methodData)
    {
        // Code pour manager en fonction de la méthode quelle CRUD action faire.
        switch($method){
            case 'GET' : 
                $data = Comments::getComment($id);
                break;
            case 'POST' :
                $data = Comments::postComment($id); // à modifier aprés pour mettre la method Data
                break;
            case 'PUT' :
                $data = Comments::putComment($id);
                break;
            case 'DELETE' : 
                $data = Comments::deleteComment($id);
                break;
            default : $data = new Exception('Methode non reconnue');
        }
        return $data;
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