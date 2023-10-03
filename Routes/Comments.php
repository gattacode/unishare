<?php
require_once('pdo.php');
require_once('Utils.php');

class Comments
{
    public const TableName = "Commentaires";
    public const ParamNames = '(id,Description,IdArticle,Pseudo,IdUser)';

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
            $result = getAllAPI(Comments::TableName);
            return $result;
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
                $data = Comments::postComment($id,$methodData); // à modifier aprés pour mettre la method Data
                break;
            case 'PUT' :
                $data = Comments::putComment($id,$methodData);
                break;
            case 'DELETE' : 
                $data = Comments::deleteComment($id);
                break;
            default :
             $data = new Exception('Methode non reconnue');
        }
        return $data;
    }
    public static function getComment($id)
    {
        // Code pour recuperer une categorie
       $result = getSpecific(Comments::TableName,$id,'id');
       return $result;
    }
    public static function postComment($id,$PostData)
    {
        // Code pour Poster une categorie
        $Comment = Comments::createComment($id,$PostData);

        if ($Comment instanceof Exception){
            return $Comment;
        }
        else{
            $result = postSpecific(Comments::TableName,Comments::ParamNames,$id,$Comment);
            return $result;
        }
    }
    public static function putComment($id,$PutData)
    {
        // Code pour Modifier une categorie
        $updates = createQueryUpdates($id,$PutData);
        $result = putSpecific(Comments::TableName,$updates,$id);
        return $result;
    }
    public static function deleteComment($id)
    {
        // Code pour supprimer une categorie
        $result = deleteSpecific(Comments::TableName,$id);
        return $result;
    }

    public static function createComment($id,$methodData){
        if (!empty($methodData['Description']) and !empty($methodData['IdArticle']) and !empty($methodData['Pseudo']) and !empty($methodData['IdUser'])){
            if (is_string($methodData['Description']) and is_numeric($methodData['IdArticle']) and is_string($methodData['Pseudo']) and is_numeric($methodData['IdUser'])){
                $result = ["id" => $id,"Description" => $methodData['Description'],"IdArticle" => $methodData['IdArticle'],"Pseudo" => $methodData['Pseudo'],"IdUser" => $methodData['IdUser']];
                return $result;
            }
        }
        return new Exception('Données non integres');
    }
}
?>