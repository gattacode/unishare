<?php

    require_once('pdo.php');

    class Users{

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
            return 'allUsers';
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
                    $data = Users::postUser($id); // à modifier aprés pour mettre la method Data
                    break;
                default : $data = new Exception('Methode non reconnue');
            }
            return $data;
        }

        public static function getUser($id){
            // Code pour recuperer un User
            return 'User' . $id . 'Get';
        }

        public static function postUser($id){
            // Code pour poster un User
            return 'User' . $id . 'Post';
        }
    }
?>