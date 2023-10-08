<?php
    require_once('./Routes/Articles.php');
    require_once('./Routes/Comments.php');
    require_once('./Routes/Categories.php');

    class Put{
        public static function Router($url,$PutData){

            switch($url[0]){
                case 'Articles' : 
                    $data = Articles::manageAll($url,'PUT',$PutData);
                    break;
                case 'Categories':
                    $data = Categories::manageAll($url,'PUT',$PutData);
                    break;
                case 'Comments':
                    $data = Comments::manageAll($url,'PUT',$PutData);
                    break;
                default :
                    $data = new Exception("Endpoint non valide");
            }
            return $data;
        }
    }
?>