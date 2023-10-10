<?php
require_once('../Composants/header.php');

if (!checkUser(session_id())) {
    require_once('../Composants/askLogin.php');
    die();
}

require_once('../Composants/navbar.php');
include_once('../Composants/Article_Comment.php');  

if ($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['logout'])) {
    session_unset();
    // Suppression de tous les cookies
    if (isset($_SERVER['HTTP_COOKIE'])) {
        $cookies = explode(';', $_SERVER['HTTP_COOKIE']);
        foreach($cookies as $cookie) {
            $parts = explode('=', $cookie);
            $name = trim($parts[0]);
            setcookie($name, '', time()-1000);
            setcookie($name, '', time()-1000, '/');
        }
    }
}
function display_Article($article)
{
    echo '
    <div class="border border-black w-1/2 h-96 bg-white">
        <img class="w-max h-1/2" src="../images/DefaultArticlePhoto.png" alt="Photo Article"/>
        <div class=" w-5/6 h-auto mt-2 ml-8">
            <h1 class="text-center font-medium"> ' . $article["Pseudo"] . ' </h1>

            <div class="w-11/12 h-20 m-3">
                <h1 class="font-semibold "> ' . $article["Titre"] . '</h1>
                <p class=" font-normal truncate-lines"> ' . $article["Description"] . ' </p> ' .
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
                $color = 'bg-pink-400';
                break;
            default:
                $color = '';
                break;
        }
        if($article[$index] !== 'Undefined'){
            displayCategorie($article[$index],$color);
            }
    }
    echo '
            <p class=" mt-2 text-orange-500"><a href="' . Pages::ArticlePage . $article['Id'] . '">Lire la suite...</a></p>
            </div>
        </div>
    </div>';
}
function displayCategorie($name, $color)
{
    echo '<div class="border border-black w-max p-1 h-5/6 m-1 text-center text-white font-semibold ' . $color . '" >' . $name . '</div>';
}


// Recuperer les Users
$reqUser = createGetRequest(Routes::UsersRoute . $_SESSION['IdUser']);
if ($reqUser["Statut"] === 200){
    $user = $reqUser["Data"][0];
}
else{
    echo "Pas de User Trouvé";
    die();
}
// Recuperer les Articles
$reqArticles = createGetRequest(Routes::ArticlesRoute . $_SESSION['Pseudo']);
$articles = array();
if ($reqArticles["Statut"] !== 0) {
    $data = $reqArticles["Data"];
    $nbArticles = count($data);

    foreach ($data as $article) {
        $reqCategories = createGetRequest(Routes::ArticlesRoute . $article["id"] . '/Categories'); // a changer

        if ($reqCategories["Statut"] !== 0) {
            $categories = $reqCategories["Data"][0];

            $Categorie1 = createGetRequest(Routes::CategoriesRoute . $categories[1]);
            $Categorie2 = createGetRequest(Routes::CategoriesRoute . $categories[2]);
            $Categorie3 = createGetRequest(Routes::CategoriesRoute . $categories[3]);

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

// Recuperer les commentaires
$reqComments = createGetRequest(Routes::AllCommentsRoute);
$comments = array();
if ($reqComments["Statut"] === 200){
    $data = $reqComments["Data"];
    foreach($data as $comment){
        if ($comment['IdUser'] == $_SESSION['IdUser']){
        array_push($comments,$comment);
        }
    }
}
else{
    echo "Pas de commentaires Trouvés";
}
    ?>
<div class="flex ">
    <div class=" w-9/12 h-max ml-32 mt-5 bg-white">
        <div class="flex items-center justify-between border-b border-black">
            <div class="text-center text-xl	 m-5 p-10 font-medium">
                <?php echo $user["Pseudo"] ?>
            </div>
            <form method="POST" action="./profile">
                <input class="transition duration-150 ease-in-out text-red-600 hover:text-white border border-red-600 hover:bg-red-600 focus:ring-4 focus:outline-none focus:ring-red-600 font-bold rounded-lg px-5 py-2 cursor-pointer" name="logout" type="submit" value="Se déconnecter" />
            </form>
        </div>
        <div class="m-4 flex flex-col gap-5 justify-between">
            <?php 
            if (session_id() != 'sessionadmin'){
            echo '
            <p><a href="'. Pages::CategoriesPage . '">Gerer Catégories</a></P>
            ';
            }
            ?>
            <p class="font-semibold text-xl ">Mes articles</p>
            <!-- à mettre dans un form pour le profileController -->
            <button class="Fais le gatta"><a href="<?php echo Pages::PostArticle?>">+ Nouvel Article</a></button>
            <div class="flex flex-wrap gap-4">
                <?php
                foreach($articles as $article){
                display_Article($article);
                echo '<div>
                <a class="Fais le Gatta" href="'. Pages::EditArticle . $article['Id'] .'"> Modifier_Article</a>
                <button class="Fias le Gatta">Suppimer_Article</buton>
                </div>';
                }
                ?>
            </div>
        </div>
    </div>
    <div class=" ml-16 w-3/12 mt-5">
        <div class="flex">
            <p class="font-semibold text-xl m-3">Commentaires</p>
            <?php echo '<div class="font-semibold text-xl m-3">' . count($comments) . '</div>' ?>
        </div>
        <div class="flex flex-wrap">
            <?php
            foreach($comments as $comment) {
                display_Comment($comment,'profile');
            }
            ?>
        </div>
    </div>
</div>
<?php require_once('../Composants/footer.php'); ?>
