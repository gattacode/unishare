<?php
session_id("fosfjisd");
session_start();

include_once('../Composants/header.php');
include_once('../Composants/footer.php');
include_once('../Composants/navbar.php');
include_once('../Composants/Feed_Article.php');
include_once('../Utils.php');
// Faire une logique pour récuperer le pseudo, Titre, Description , idListe, Pseudo

// D'abord on check si l'User est loggé
if (!checkUser(session_id())) {
    echo '<h1> Veuillez vous connectez : <a href="http://localhost/Blog/Front/Pages/Login.php">Se connecter</a></h1>'; // Pour l'instant ca marche pas
    die();
}

$articles = array();
// On cherche si il s'agit d'une recherche ou d'un simple accueil
if (isset($_GET['Search'])){
    $reqArticles = createGetRequest('http://localhost/Blog/API/index.php/Articles/' . $_GET['Search']);
}
else{
// Rajouter un truc pour la recherche d'un article
$reqArticles = createGetRequest('http://localhost/Blog/API/index.php/Articles');
}

$ErrorCheck = true;

if ($reqArticles["Statut"] !== 0) {
    $data = $reqArticles["Data"];
    $nbArticles = count($data);

    foreach ($data as $article) {
        $reqCategories = createGetRequest('http://localhost/Blog/API/Index.php/Articles/' . $article["id"] . '/Categories');

        if ($reqCategories["Statut"] !== 0) {
            $categories = $reqCategories["Data"][0];

            $Categorie1 = createGetRequest('http://localhost/Blog/API/Index.php/Categories/' . $categories[1]);
            $Categorie2 = createGetRequest('http://localhost/Blog/API/Index.php/Categories/' . $categories[2]);
            $Categorie3 = createGetRequest('http://localhost/Blog/API/Index.php/Categories/' . $categories[3]);

            if($Categorie1["Statut"] === 200 and $Categorie2["Statut"] === 200 and $Categorie3["Statut"] === 200){
            $Categorie1 = $Categorie1["Data"][0]["Name"];
            $Categorie2 = $Categorie2["Data"][0]["Name"];
            $Categorie3 = $Categorie3["Data"][0]["Name"];


            $newArticle = array("Id" => $article["id"],"Titre" => $article["Titre"], "Description" => $article["Description"], "Pseudo" => $article["Pseudo"], "Categorie1" => $Categorie1, "Categorie2" => $Categorie2, "Categorie3" => $Categorie3);
            array_push($articles, $newArticle);
            $ErrorCheck = false;
            }
        }
    }
}

headerVue();
display_Navbar();
?>
<div class="w-5/6 ml-44 mt-16 flex flex-wrap gap-10 h-max justify-evenly bg-transparent">
    <?php

    if ($ErrorCheck){
        echo '<h1 class="font-bold">Erreur : ' . $reqArticles["Message"] . '</h1>';
    }
    else {
        for ($i = 0; $i < $nbArticles; $i++) {
            display_Article($articles[$i]);
        }
    }
    ?>
</div>
<?php
footerVue();
?>