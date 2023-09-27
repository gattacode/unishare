<?php

    class Users{

        public static function manageAll($url,$method,$methodData){
            if ($method !== 'GET'){
                $result = new Exception('Methode non Valide');
            }
            else{
            switch(count($url)){
                case 1 : $result = Users::getAll();
                break;
                case 2 : $result = Users::crudUser($url[1],$method,$methodData);
                default : $result = new Exception('Endpoint non valide');
                break; 
            }
        }
            return $result;
        }

        public static function getAll(){
            // Code pour renvoyer tous les Users
            return 'allUsers';
        }

        public static function crudUser($id,$method,$methodData){
            // Code pour gerer les methodes USER
            return 'crud';
        }

        public static function getUser($id){
            // Code pour recuperer un User
        }
    }
?>