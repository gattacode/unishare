<?php
include_once('../Composants/header.php');
include_once('../Composants/Feed_Article.php');

// Vérification de l'authentification de l'utilisateur
if (!checkUser(session_id())) {
    require_once('../Composants/askLogin.php');
    die();
}

include_once('../Composants/navbar.php');

// Initialisation du tableau d'articles
$articles = array();

// Détermination si la page est en mode recherche ou affichage normal
if (isset($_GET['Search'])) {
    $reqArticles = createGetRequest(Routes::ArticlesRoute . $_GET['Search']);
} else {
    // Rajouter un truc pour la recherche d'un article
    $reqArticles = createGetRequest(Routes::AllArticlesRoute);
}

$ErrorCheck = true;
if ($reqArticles["Statut"] !== 0) {
    $data = $reqArticles["Data"];

    foreach ($data as $article) {
        $reqCategories = createGetRequest(Routes::ArticlesRoute . $article["id"] . '/Categories'); // a changer

        if ($reqCategories["Statut"] !== 0) {
            $categories = $reqCategories["Data"][0];

            $Categorie1 = createGetRequest(Routes::CategoriesRoute . $categories[1]);
            $Categorie2 = createGetRequest(Routes::CategoriesRoute . $categories[2]);
            $Categorie3 = createGetRequest(Routes::CategoriesRoute . $categories[3]);

            if ($Categorie1["Statut"] === 200 and $Categorie2["Statut"] === 200 and $Categorie3["Statut"] === 200) {
                $Categorie1 = $Categorie1["Data"][0]["Name"];
                $Categorie2 = $Categorie2["Data"][0]["Name"];
                $Categorie3 = $Categorie3["Data"][0]["Name"];


                $newArticle = array("Id" => $article["id"], "Titre" => $article["Titre"], "Description" => $article["Description"], "Pseudo" => $article["Pseudo"], "Categorie1" => $Categorie1, "Categorie2" => $Categorie2, "Categorie3" => $Categorie3);
                array_push($articles, $newArticle);
                $ErrorCheck = false;
            }
        }
    }
}

?>
<div class="w-full flex flex-wrap gap-10 h-max justify-evenly items-center pt-12 bg-gray-100">
    <?php

    if ($ErrorCheck) {
        echo '<h1 class="font-bold">Erreur  : Pas de données trouvées</h1>';
    } else {
        for ($i = 0; $i < count($articles); $i++) {
            display_Article($articles[$i]);
        }
    }
    ?>
</div>
<?php
include_once('../Composants/footer.php');
?>