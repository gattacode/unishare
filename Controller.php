<?php
include('Utils.php');
include('Models/Routes.php');
include('Models/Pages.php');

if (isset($_POST['Request'])) {
    switch ($_POST['Request']) {

        case 'PostComment':
            if (isset($_POST['Desc'])) {
                $data = array("IdArticle" => $_POST['IdArticle'], "Description" => $_POST["Desc"], "Pseudo" => $_POST['Pseudo'], "IdUser" => $_POST['IdUser']); // Utiliser les variables session pour le pseudo et l'IDUser
                $comments = createGetRequest(Routes::AllCommentsRoute);
                // Code pour incrémenter les comments
                $usedId = array();
                foreach ($comments["Data"] as $comment) {
                    array_push($usedId, $comment['id']);
                }
                $stop = false;
                $id = 0;
                for ($i = 1; $i <= count($usedId); $i++) {
                    if (!in_array($i, $usedId) and !$stop) {
                        $id = $i;
                        $stop = true;
                    }
                }
                $result = createPostRequest(Routes::CommentsRoute . $id, $data);

                header('Location: Pages/Article.php?id=%20' . $_POST['IdArticle']);

            } else
                echo 'error veuillez retournez à la page précedente';
            break;
        case 'DeleteComment':
            if (isset($_POST['Id']) and isset($_POST['IdArticle'])) {
                createDeleteRequest(Routes::CommentsRoute . $_POST['Id']);
                header('Location: Pages/Article.php?id=%20' . $_POST['IdArticle']);
            } else
                echo 'error veuillez retournez à la page précedente';
            break;
        case 'PostArticle':
            if (!isset($_POST["Cancel"])) {
                if (isset($_POST['Title']) and isset($_POST['Desc']) and isset($_POST['Categorie1']) and isset($_POST['Categorie2']) and isset($_POST['Categorie3'])) {

                    $_POST['Categorie1'] = ($_POST['Categorie1'] !== 'No') ? createGetRequest(Routes::CategoriesRoute . $_POST['Categorie1'])["Data"][0]["Id"] : 0;
                    $_POST['Categorie2'] = ($_POST['Categorie2'] !== 'No') ? createGetRequest(Routes::CategoriesRoute . $_POST['Categorie2'])["Data"][0]["Id"] : 0;
                    $_POST['Categorie3'] = ($_POST['Categorie3'] !== 'No') ? createGetRequest(Routes::CategoriesRoute . $_POST['Categorie3'])["Data"][0]["Id"] : 0;

                    $articles = createGetRequest(Routes::AllArticlesRoute);

                    $usedId = array();
                    foreach ($articles["Data"] as $comment) {
                        array_push($usedId, $comment['id']);
                    }
                    $stop = false;
                    $id = 0;
                    for ($i = 1; $i <= count($usedId); $i++) {
                        if (!in_array($i, $usedId) and !$stop) {
                            $id = $i;
                            $stop = true;
                        }
                    }

                    $newArticle = array("Titre" => $_POST['Title'], "Description" => $_POST['Desc'], "Pseudo" => $_POST['Pseudo'], "Categories" => [(int) $_POST['Categorie1'], (int) $_POST['Categorie2'], (int) $_POST['Categorie3']]);

                    $result = createPostRequest(Routes::ArticlesRoute . $id, $newArticle);

                    header('Location: Pages/Article.php?id=%20' . $id);
                }
            } else
                header('Location: Pages/Profile.php');
            break;
        case 'UpdateArticle':
            if (!isset($_POST["Cancel"])) {
                if (isset($_POST["IdArticle"])) {

                    $oldArticle = createGetRequest(Routes::ArticlesRoute . $_POST['IdArticle']);
                    $oldCategories = createGetRequest(Routes::AllCategoriesArticle($_POST['IdArticle']));

                    if ($oldArticle["Statut"] === 200 and $oldCategories["Statut"] === 200) {
                        $oldArticle = $oldArticle["Data"][0];
                        $oldCategories = $oldCategories["Data"][0];

                        $newArticle = array();
                        if ($_POST['Title'] != $oldArticle["Titre"]) {
                            $newArticle["Titre"] = $_POST['Title'];
                        }
                        if ($_POST['Desc'] != $oldArticle["Description"]) {
                            $newArticle["Description"] = $_POST["Desc"];
                        }


                        $_POST['Categorie1'] = ($_POST['Categorie1'] !== 'No') ? createGetRequest(Routes::CategoriesRoute . $_POST['Categorie1'])["Data"][0]["Id"] : 0;
                        $_POST['Categorie2'] = ($_POST['Categorie2'] !== 'No') ? createGetRequest(Routes::CategoriesRoute . $_POST['Categorie2'])["Data"][0]["Id"] : 0;
                        $_POST['Categorie3'] = ($_POST['Categorie3'] !== 'No') ? createGetRequest(Routes::CategoriesRoute . $_POST['Categorie3'])["Data"][0]["Id"] : 0;

                        $categories = array();
                        if ($_POST['Categorie1'] != $oldCategories["Categorie1"]) {
                            array_push($categories, (int) $_POST['Categorie1']);
                        }
                        if ($_POST['Categorie2'] != $oldCategories["Categorie2"]) {
                            array_push($categories, (int) $_POST['Categorie2']);
                        }
                        if ($_POST['Categorie3'] != $oldCategories["Categorie3"]) {
                            array_push($categories, (int) $_POST['Categorie3']);
                        }
                        $newArticle["Categories"] = $categories;
                        $result = createPutRequest(Routes::ArticlesRoute . (int)$_POST["IdArticle"], $newArticle);
                        header('Location: Pages/Article.php?id=%20' . $_POST["IdArticle"]);

                    }
                } else
                    header('Location: Pages/Profile.php');
            } else {
                header('Location: Pages/Profile.php');
            }
            break;
        case 'DeleteArticle':
            if (isset($_POST['Id'])){
             createDeleteRequest(Routes::ArticlesRoute . $_POST['Id']);
            }
            header('Location: Pages/Profile.php');
            break;
        default:
            header('Location: Pages/Feed.php');
            break;
    }
}

?>