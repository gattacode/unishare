<?php
include('Utils.php');
include('Models/Pages.php');

// Vérification si une requête POST est envoyée
if (isset($_POST['Request'])) {
    switch ($_POST['Request']) {
        // Utilisation d'une structure switch pour gérer différentes requêtes POST
        case 'PostComment':
            // Vérification si une description est fournie
            if (isset($_POST['Desc'])) {
                $data = array("IdArticle" => $_POST['IdArticle'], "Description" => $_POST["Desc"], "Pseudo" => $_POST['Pseudo'], "IdUser" => $_POST['IdUser']); // Utiliser les variables session pour le pseudo et l'IDUser
                $comments = createGetRequest(Routes::AllCommentsRoute);
                // Code pour incrémenter les comments
                $usedId = array();
                if(isset($comments["Data"])){
                foreach ($comments["Data"] as $comment) {
                    array_push($usedId, $comment['id']);
                }
                // Initialisation des variables pour trouver un nouvel ID
                $stop = false;
                $id = 0;
                for ($i = 1; $i <= count($usedId); $i++) {
                    if (!in_array($i, $usedId) and !$stop) {
                        $id = $i;
                        $stop = true;
                    }
                }if($id == 0) $id =count($usedId) +1;
            }else $id = 1;
                // Envoi de la requête POST pour créer un nouveau commentaire
                $result = createPostRequest(Routes::CommentsRoute . $id, $data);
                header('Location: Pages/Article.php?id=%20' . $_POST['IdArticle']);
            
            } else
                echo 'error veuillez retournez à la page précedente';
            break;
        case 'DeleteComment':

            // Vérification si les paramètres nécessaires sont fournis
            if (isset($_POST['Id']) and isset($_POST['IdArticle']) and isset($_POST['Source'])) {
                // Envoi de la requête DELETE pour supprimer le commentaire
                createDeleteRequest(Routes::CommentsRoute . $_POST['Id']);
                if ($_POST['Source'] == 'profile') {
                    header('Location: Pages/Profile.php');
                } else {
                    header('Location: Pages/Article.php?id=%20' . $_POST['IdArticle']);
                }
            } else
                echo 'error veuillez retournez à la page précedente';
            break;
        case 'PostArticle':

            // Vérification si l'action n'est pas annulée et si les paramètres nécessaires sont fournis
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
                    }if($id == 0) $id = count($usedId) +1;

                    $newArticle = array("Titre" => $_POST['Title'], "Description" => $_POST['Desc'], "Pseudo" => $_POST['Pseudo'], "Categories" => [(int) $_POST['Categorie1'], (int) $_POST['Categorie2'], (int) $_POST['Categorie3']]);

                    $result = createPostRequest(Routes::ArticlesRoute . $id, $newArticle);

                    header('Location: Pages/Article.php?id=%20' . $id);
                }
            } else
                header('Location: Pages/Profile.php');
            break;
        case 'UpdateArticle':
            // Vérification si l'action n'est pas annulée
            if (!isset($_POST["Cancel"])) {
                if (isset($_POST["IdArticle"])) {

                    // Vérification si tous les champs nécessaires sont présents
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

                        // Conversion des noms de catégories en ID, ou assignation de 0 si 'No' est sélectionné
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
                        if (count($categories) != 0) {
                            $newArticle["Categories"] = $categories;
                        }

                        $result = createPutRequest(Routes::ArticlesRoute . (int) $_POST["IdArticle"], $newArticle);
                        header('Location: Pages/Article.php?id=%20' . $_POST["IdArticle"]);

                    }
                } else
                    header('Location: Pages/Profile.php');
            } else {
                header('Location: Pages/Profile.php');
            }
            break;
        case 'DeleteArticle':
            if (isset($_POST['Id'])) {
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