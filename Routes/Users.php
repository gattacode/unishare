<?php

    require_once('pdo.php');

    class Users{

        public const TableName = 'Users';
        public const ParamsNames = '(Id,Email,Pseudo,Password,Admin,SessionId)';

        public static function manageAll($url,$method,$methodData){
            
            switch(count($url)){
                case 1 : $result = Users::getAll($method);
                break;
                case 2 : $result = Users::crudUser($url[1],$method,$methodData);
                break;
                default : $result = new Exception('Endpoint non valide');
                break; 
            }
            return $result;
        }

        public static function getAll($method){
            // Code pour renvoyer tous les Users
            if ($method === 'GET'){
                $result = getAllAPI(Users::TableName);
                return $result;
            }
            else return new Exception('Mauvaise Methode');
        }

        public static function crudUser($id,$method,$methodData){
            // Code pour gerer les methodes USER
            switch($method){
                case 'GET' : 
                    $data = Users::getUser($id);
                    break;
                case 'POST' :
                    $data = Users::postUser($id,$methodData); // à modifier aprés pour mettre la method Data
                    break;
                default : $data = new Exception('Methode non reconnue');
            }
            return $data;
        }

        public static function getUser($id){
            // Code pour recuperer un User
            $result = getSpecific(Users::TableName,$id);
            return $result;
        }

        public static function postUser($id,$PostData){
            // Code pour poster un User
            $User = Users::createUser($id,$PostData);
            if ($User instanceof Exception){
                return $User;
            }
            else{
                $result = postSpecific(Users::TableName,Users::ParamsNames,$id,$User);
                return $result;
            }
        }
        public static function putUser($id,$PutData){
            $updates = createQueryUpdates($id,$PutData);
            $result = putSpecific(Users::TableName,$updates,$id);
            return $result;
        }

        public static function createUser($id,$PostData){
            if (!empty($PostData["Email"]) and !empty($PostData["Password"]) and !empty($PostData['Pseudo']) and !empty($PostData["Password"]) and !empty($PostData["SessionId"])){

                // Verification de si c'est l'admin ou pas
                $admin = ($PostData["Email"] === "admin@localhost.fr" and $PostData["Password"] === "admin69IUT") ? 1 : 0;
                
                return Array("Id" => $id,"Email" => $PostData["Email"],"Pseudo" => $PostData["Pseudo"],"Password" => $PostData["Password"],"Admin" => $admin,"SessionId" => $PostData["SessionId"]);
            }
            return new Exception("Données non integres");
        }
    }
?>