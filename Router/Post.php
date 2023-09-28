<?php
    require_once('./Routes/Articles.php');
    require_once('./Routes/Users.php');
    require_once('./Routes/Comments.php');
    require_once('./Routes/Categories.php');

    class Post{
        public static function Router($url,$PostData){
            switch ($url[0]) {
                // Gerer le cas Login et Register Aprés
                case 'Articles':
                    $data = Articles::manageAll($url,'POST', $PostData);
                    break;
                case 'Users':
                    $data = Users::manageAll($url,'POST', $PostData);
                    break;
                case 'Categories':
                    $data = Categories::manageAll($url,'POST', $PostData);
                    break;
                case 'Comments':
                    $data = Comments::manageAll($url,'POST', $PostData);
                    break;
                default:
                    $data = new Exception("Endpoint Non valide");
            }
            return $data;
        }
    }
?>