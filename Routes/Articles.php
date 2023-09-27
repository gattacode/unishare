<?php
require_once('./pdo.php');
// Changer nom classe apres 

class Articles
{
    public const TableName = 'Articles';
    public static function manageAll($url, $method,$methodData)
    {
        switch (count($url)) {
            case 1:
                $result = Articles::getAllArticles($method); 
                break;
            case 2:
                $result = Articles::crudArticle($url[1],$method,$methodData);
                break;
            case 3:
                $result = Articles::getAllComments($url[1],$method);
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
        if ($method === 'GET'){
            $data = getAllAPI(Articles::TableName);
        }
        else{
            $data = new Exception('Mauvaise méthode');
        }
        return $data;
    }

    public static function crudArticle($id,$method,$methodData)
    {
        // Code pour manager en fonction de la méthode quelle CRUD action faire.
        switch($method){
            case 'GET' : 
                $data = Articles::getArticle($id);
                break;
            case 'POST' :
                $data = Articles::postArticle($id); // à modifier aprés pour mettre la method Data
                break;
            case 'PUT' :
                $data = Articles::putArticle($id);
                break;
            case 'DELETE' : 
                $data = Articles::deleteArticle($id);
                break;
            default : $data = new Exception('Methode non reconnue');
        }
        return $data;
    }
    public static function getArticle($id)
    {
        // Code pour recuperer un article;
        $data = getSpecific(Articles::TableName,$id);
        return $data;
    }
    public static function postArticle($id,$PostData)
    {
        // Code pour Poster un article
        return 'article' . $id . 'post' ;
    }
    public static function putArticle($id)
    {
        // Code pour Modifier un article
        return 'article' . $id . 'put';
    }
    public static function deleteArticle($id)
    {
        // Code pour supprimer un article
        return 'article' . $id . 'delete';
    }

    public static function getAllComments($id,$method)
    {
        // Code pour récuperer tous les commentaiires d'un article
        if ($method === 'GET'){
        return 'Tous les comms de l article ' . $id;
        }
        else{
            return new Exception("Mauvaise Méthode");
        }
    }

    public static function checkIntegrity($PostData){
        
    }
}
?>