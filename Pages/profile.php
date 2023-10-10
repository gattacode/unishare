<?php
require_once('../Composants/header.php');

// Vérification de l'utilisateur et gestion de la déconnexion
if (!checkUser(session_id())) {
    require_once('../Composants/askLogin.php');
    die();
}


require_once('../Composants/navbar.php');
include_once('../Composants/Article_Comment.php');

if (isset($_POST['logout'])) {
    session_unset();
    // Suppression de tous les cookies
    if (isset($_SERVER['HTTP_COOKIE'])) {
        $cookies = explode(';', $_SERVER['HTTP_COOKIE']);
        foreach ($cookies as $cookie) {
            $parts = explode('=', $cookie);
            $name = trim($parts[0]);
            setcookie($name, '', time() - 1000);
            setcookie($name, '', time() - 1000, '/');
        }
    }
    header('Location: Feed.php');
}
function display_Article($article)
{
    echo '
    <div class="border border-black w-1/2 h-96 pb-16 bg-white ">
        <img class="w-max h-1/2" src="../images/DefaultArticlePhoto.png" alt="Photo Article"/>
        <div class=" w-5/6 h-auto mt-2 ml-8">
            <h1 class="text-center font-medium"> ' . $article["Pseudo"] . ' </h1>

            <div class="w-11/12 h-20 m-3">
                <h1 class="font-semibold "> ' . $article["Titre"] . '</h1>
                <p class=" font-normal truncate-lines"> ' . $article["Description"] . ' </p> ' .
        '
            </div>

            <div class=" w-96 h-10 m-3 flex flex-row gap-1 justify-start">
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
        if ($article[$index] !== 'Undefined') {
            displayCategorie($article[$index], $color);
        }
    }
    echo '
            
            </div>
            <p class=" mt-2 text-orange-500"><a href="' . Pages::ArticlePage . $article['Id'] . '">Lire la suite...</a></p>
        </div>
    </div>';
}
function displayCategorie($name, $color)
{
    echo '<div class="w-max p-1 h-5/6 m-1 text-center text-white font-semibold rounded-lg ' . $color . '" >' . $name . '</div>';
}


// Récupération des informations utilisateur
if (isset($_SESSION['IdUser'])) {
    $reqUser = createGetRequest(Routes::UsersRoute . $_SESSION['IdUser']);

    if ($reqUser["Statut"] === 200) {
        $user = $reqUser["Data"][0];
    } else {
        echo "Pas de User Trouvé";
        die();
    }
}
// Récupération et traitement des catégories
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

// Récupération des commentaires
$reqComments = createGetRequest(Routes::AllCommentsRoute);
$comments = array();
if ($reqComments["Statut"] === 200) {
    $data = $reqComments["Data"];
    foreach ($data as $comment) {
        if ($comment['IdUser'] == $_SESSION['IdUser']) {
            array_push($comments, $comment);
        }
    }
} else {
    echo "Pas de commentaires Trouvés";
}
// Affichage de la page principale et des articles
?>
<div class="flex ">
    <div class=" w-9/12 h-max ml-32 mt-5 bg-white">
        <div class="flex items-center justify-between border-b border-black">
            <div class="text-center text-xl	 m-5 p-10 font-medium">
                <?php echo $user["Pseudo"] ?>
            </div>
            <form method="POST" action="./profile">
                <input
                    class="transition duration-150 ease-in-out text-red-600 hover:text-white border border-red-600 hover:bg-red-600 focus:ring-4 focus:outline-none font-bold rounded-lg px-5 py-2 cursor-pointer"
                    name="logout" type="submit" value="Se déconnecter" />
            </form>
        </div>
        <div class="m-4 flex flex-col gap-5 justify-between">
            <?php
            if (session_id() == 'sessionadmin') {
                echo '
            <p class="w-1/2 transition duration-150 ease-in-out text-gray-500 hover:text-white border border-gray-500 hover:bg-gray-500 focus:ring-4 focus:outline-none font-bold rounded-lg px-5 py-2 cursor-pointer flex flex-row justify-center items-center [&>img]:hover:invert"><img class="w-6 mr-3" src="../images/setting.png" alt="settings"/><a href="' . Pages::CategoriesPage . '">Gérer les catégories</a></P>
            ';
            }
            ?>
            <p class="font-semibold text-xl ">Mes articles</p>

            <button
                class="w-1/3 mx-auto transition duration-150 ease-in-out text-orange-500 hover:text-white border border-orange-500 hover:bg-orange-500 focus:ring-4 focus:outline-none font-bold rounded-lg px-5 py-2 cursor-pointer flex flex-row justify-center items-center">
                <a href="<?php echo Pages::PostArticle ?>">Créer un article</a></button>
            <div class="flex flex-wrap gap-4">
                <?php
                foreach ($articles as $article) {
                    display_Article($article);
                    echo '<div>
                <a class="flex flex-row font-semibold hover:font-bold mt-12 mb-4" href="' . Pages::EditArticle . $article['Id'] . '"><img class="w-6 mr-2" src="../images/edit-icon.png"/>Éditer</a>
                <form name="form" action="../Controller.php" method="post"> 
                <input name="Request" value="DeleteArticle" hidden/>
                <input name="Id" value ="' . $article['Id'] . '"hidden/>
                <button class="flex flex-row font-semibold hover:font-bold"><img class="w-6 mr-2" src="../images/delete-icon.png"/>Supprimer</button>
                </form>
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
            foreach ($comments as $comment) {
                display_Comment($comment, 'profile');
            }
            ?>
        </div>
    </div>
</div>
<?php require_once('../Composants/footer.php'); ?>