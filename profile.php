<?php

include_once('./Utils.php');
function display_Article($article)
{
    echo '
    <div class="border border-black w-1/3 h-96 bg-white h=">
        <img class="w-max h-1/2" src="../images/DefaultArticlePhoto.png" alt="Photo Article"/>
        <div class=" w-5/6 h-auto mt-2 ml-8">
            <h1 class="text-center font-medium"> ' . $article["Pseudo"] . ' </h1>

            <div class="w-11/12 h-20 m-3">
                <h1 class="font-semibold "> ' . $article["Titre"] . '</h1>
                <p class=" font-normal"> ' . $article["Description"] . ' </p> ' . // Ajouter une logique pour ajouter 3 points si la desc est trop longue
        '
            </div>

            <div class=" w-96 -ml-3 h-10 m-3 flex flex-row gap-1 justify-start">
                ';
    for ($i = 1; $i <= 3; $i++) {
        $index = "Categorie" . $i;
        switch ($i) {
            case 1:
                $color = 'bg-yellow-400';
                break;
            case 2:
                $color = 'bg-orange-500';
                break;
            case 3:
                $color = 'bg-orange-500';
                break;
            default:
                $color = '';
                break;
        }
        displayCategorie($article[$index], $color);
    }
    echo '
            <p class=" mt-2 text-orange-500"><a href="http://localhost/Blog/Front/Pages/Article.php?id= ' . $article['Id'] . '">Lire la suite...</a></p>
            </div>
        </div>
    </div>';
}
function displayCategorie($name, $color)
{
    echo '<div class="border border-black w-max p-1 h-5/6 m-1 text-center text-white font-semibold ' . $color . '" >' . $name . '</div>';
}

function display_Comment($comment, $user_id)
{
    if($user_id == $comment["Pseudo"])
    echo '
        <div class="rounded-2xl shadow-lg m-3 p-6 w-11/12 h-max bg-white">
            <div class="m-2 font-semibold">' . $comment["Pseudo"] . '</div>
            <div class="m-2"><p class="font-normal"> ' . $comment["Description"] . '</p></div>
        </div>';
}

$user = array("Pseudo" => "Abdou", "Articles" => "");

$nbComments = 10;
$comment = array("Pseudo" => $user['Pseudo'], "Description" => "Trés bon article Shagay, mais en vrai va te faire foutre frere comment le site est moche c'est trop une frauduleuse campagne de recrutement")
    ?>
<div class="flex ">
    <div class=" w-7/12 h-max ml-32 mt-5 bg-white">
        <div class=" h-max">
            <div class="flex justify-between border-b border-black">
                <div class="text-center text-xl	 m-5 p-10 font-medium">
                    <?php echo $user["Pseudo"] ?>
                </div>
            </div>
            <div class="m-4 flex flex-col gap-5">
                <p class="font-semibold text-xl ">Mes articles</p>
                <div>
                    <?php  // Cette partie ne marche pas
                        $articles = array();
                        // Rajouter un truc pour la recherche d'un article
                        $reqArticles = createGetRequest('http://localhost/Blog/API/index.php/Articles');
                        
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
                    ?>
                    <div class="w-5/6 ml-44 mt-16 flex flex-wrap gap-10 h-max justify-evenly bg-transparent">
                        <?php
                        if ($ErrorCheck)
                            echo '<h1 class="font-bold">Erreur : ' . $req["Message"] . '</h1>';
                        else {
                            for ($i = 0; $i < $nbArticles; $i++) {
                                display_Article($articles[$i]);
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class=" ml-16 w-3/12 mt-5">
        <div class="flex">
            <p class="font-semibold text-xl m-3">Commentaires</p>
            <?php echo '<div class="font-semibold text-xl m-3">' . $nbComments . '</div>' ?>
        </div>
        <div class="flex flex-wrap">
            <?php
            for ($i = 0; $i < $nbComments; $i++) {
                display_Comment($comment, $user["Pseudo"]);
            }
            ?>
        </div>
    </div>
</div>