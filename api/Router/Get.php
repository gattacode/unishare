<?php
    require_once('./Routes/Articles.php');
    require_once('./Routes/Users.php');
    require_once('./Routes/Comments.php');
    require_once('./Routes/Categories.php');
    require_once('./Routes/check.php');
    
    class Get{

        public static function Router($url,$GetData){
            // On Determine la route 
            switch ($url[0]) {
                case 'Articles':
                    $data = Articles::manageAll($url, 'GET', $GetData);
                    break;
                case 'Users':
                    $data = Users::manageAll($url, 'GET', $GetData);
                    break;
                case 'Categories':
                    $data = Categories::manageAll($url, 'GET', $GetData);
                    break;
                case 'Comments':
                    $data = Comments::manageAll($url, 'GET', $GetData);
                    break;
                case 'Check' : 
                    $data = Check::manage($url);
                    break;
                default:
                    $data = new Exception("Endpoint Non valide");
                }   
                return $data;
        }
    }
?>