<?php
    require_once('pdo.php');
    require_once('Users.php');

    class Check{

        public static function manage($url){
            if (count($url) > 2){ return new Exception('Endpoint Non valide');};
            $result = getSpecific(Users::TableName,$url[1],'SessionId');
            return $result;
        }
    }
?>