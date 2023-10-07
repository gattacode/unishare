<?php
    session_start();
    include('Utils.php');

    if (isset($_POST['Request'])){
        switch($_POST['Request']){

            case 'ArticlePageData': // Faire ca apres
                break;
            case 'FeedData' : // Faire ca apres
                break;
            case 'PostComment' :
                if (isset($_POST['Desc'])){
                    $data = array("IdArticle" => $_POST['IdArticle'],"Description" => $_POST["Desc"],"Pseudo" => "Ihoudi45","IdUser" => 2);
                    $comments = createGetRequest("http://localhost/Blog/API/index.php/Comments");
                    $i = 1;
                    $id = 0;
                    foreach($comments["Data"] as $comment){
                        if ($comment["id"] != $i){
                            $id = $i;
                        }
                        $i++;
                    }
                    if ($id==0) $id = $i +1;
                    $result = createPostRequest("http://localhost/Blog/API/index.php/Comments/" . $id,$data);
                    header('Location: Pages/Article.php?id=%20' . $_POST['IdArticle']);
                }
                break;
            case 'DeleteComment':
                break;
            default :
            header('Location: feed.php');
            break;
        }
    }
    
?>