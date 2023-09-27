<?php
    require_once('./Routes/Articles.php');
    require_once('./Routes/Comments.php');
    require_once('./Routes/Categories.php');

    class Delete{
        public static function Router($url,$DeleteData){

            switch($url[0]){
                case 'Articles' : 
                    $data = Articles::manageAll($url,'DELETE',$DeleteData);
                    break;
                case 'Categories':
                    $data = Categories::manageAll($url,'DELETE',$DeleteData);
                    break;
                case 'Comments':
                    $data = Comments::manageAll($url,'DELETE',$DeleteData);
                    break;
                default: $data = new Exception("Endpoint non valide");
            }
            return $data;
        }
    }
?>