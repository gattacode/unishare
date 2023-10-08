<?php
    require_once('pdo.php');
    require_once("Users.php");

    class Login{

        static function manageAll($url,$postData){
            switch(count($url)){
                case 1 : $result = Login::LoginUser($postData);
                break;
                default : $result = new Exception('Mauvais Endpoint');
                break;
            }
            return $result;
        }

        static function LoginUser($postData){
            // Faire le code pour verifier l'email into le mot de passe
            $checkIntegrity = Login::checkIntegrity($postData);
            if ($checkIntegrity){
                $checkEmail = getSpecific(Users::TableName,$postData["Email"],'Email');
                if (!$checkEmail instanceof Exception){
                    if ($checkEmail["Data"][0]["Password"] === $postData["Password"]){
                        $result = $checkEmail;
                    }
                    else $result = new Exception('Mot de Passe non valide');
                }
                else{
                    $result = new Exception('Email Inexistant');
                }
            }
            else{
                $result = new Exception('Données non integres');
            }
            return $result;
        }

        static function checkIntegrity($data){
            return (!empty($data["Email"]) and !empty($data["Password"])) ? true : false;
        }
    }
?>