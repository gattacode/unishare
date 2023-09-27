<?php
require_once('pdo.php');
// Changer nom classe apres 
class Articles
{
    public static function manageAll($url, $method,$methodData)
    {
        switch (count($url)) {
            case 1:
                $result = Articles::getAllArticles();
                break;
            case 2:
                $result = Articles::crudArticle($url[1],$method,$methodData);
            case 3:
                $result = Articles::getAllComments($url[1]);
                break;
            default:
                $result = new Exception('Endpoint non valide');
                break;
        }
        return $result;
    }

    public static function getAllArticles()
    {
        // Code pour renvoyer tous les Articles
        return 'Tous les Articles';
    }

    public static function crudArticle($id,$method,$methodData)
    {
        // Code pour manager en fonction de la méthode quelle CRUD action faire.
        return 'crud';
    }
    public static function getArticle($id)
    {
        // Code pour recuperer un article;
        return 'article' . $id . 'get';
    }
    public static function postArticle($id)
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

    public static function getAllComments($id)
    {
        // Code pour récuperer tous les commentaiires d'un article
        return 'Tous les comms';
    }
}
?>