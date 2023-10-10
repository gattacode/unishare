<?php
require_once('../Composants/header.php');

// On protege la route 
if (!checkUser(session_id())) {
    require_once('../Composants/askLogin.php');
    die();
}


// On récupere l'id de l'article , et si il existe ou pas (on detecte ainsi si il s'agit d'une modification de l'article ou d'une création)
$url = explode("/", filter_var($_SERVER['REQUEST_URI'], FILTER_SANITIZE_URL));
if (isset($url[3])) {
    $idArticle = explode("EditArticle.php?id=%20", $url[3]);

}
if (isset($idArticle[1])) {
    // Code pour charger les valeurs
    $article = createGetRequest(Routes::ArticlesRoute . $idArticle[1])["Data"][0];

    $Titre = $article['Titre'];
    $Desc = $article['Description'];
    $id = $article['id'];
    $Request = 'UpdateArticle';
} else {
    $Titre = '';
    $Desc = '';
    $Request = 'PostArticle';
}

// Code pour récuperer toutes les categories
$reqCategories = createGetRequest(Routes::AllCategoriesRoute);
$Categories = array();
foreach ($reqCategories["Data"] as $Categorie) {
    if ($Categorie["Name"] !== "Undefined") {
        array_push($Categories, $Categorie["Name"]);
    }
}

require_once('../Composants/navbar.php');
;
?>
<div class="flex">
    <div class="w-full px-36 py-16">
        <form class="m-5 flex flex-col gap-3" name="EditArticle" method="post" action="../Controller.php">
            <input name="Pseudo" value="<?php echo $_SESSION['Pseudo'] ?>" hidden />
            <label class="font-semibold">Titre</label>
            <input name="Request" value="<?php echo $Request ?>" hidden />
            <input name="Title" class="border-b border-black w-1/2" value="<?php echo $Titre ?>" />

            <?php
            if ($Request == 'UpdateArticle') {
                echo '<input name="IdArticle" value=' . $id . ' hidden/>';
            }
            ?>

            <label class="font-semibold">Description</label>
            <textarea name="Desc" class="border border-black w-full h-80"><?php echo $Desc ?></textarea>

            <label class="font-semibold">Catégorie 1 </label>
            <select name="Categorie1" class="bg-gray-100 border">
                <option value="No"></option>
                <?php
                foreach ($Categories as $categorie) {
                    echo '<option value="' . $categorie . '">' . $categorie . '</option>';
                }
                ?>
            </select>

            <label class="font-semibold">Catégorie 2 </label>
            <select name="Categorie2" class="bg-gray-100 border">
                <option value="No"></option>
                <?php
                foreach ($Categories as $categorie) {
                    echo '<option value="' . $categorie . '">' . $categorie . '</option>';
                }
                ?>
            </select>

            <label class="font-semibold border">Catégorie 3 </label>
            <select name="Categorie3" class="bg-gray-100">
                <option value="No"></option>
                <?php
                foreach ($Categories as $categorie) {
                    echo '<option value="' . $categorie . '">' . $categorie . '</option>';
                }
                ?>
            </select>

            <div class="flex justify-around gap-4">
                <button
                    class="transition w-full duration-150 ease-in-out text-gray-500 hover:text-white border border-gray-500 hover:bg-gray-500 focus:ring-4 focus:outline-none font-bold rounded-lg px-5 py-2 cursor-pointer flex flex-row justify-center items-center"
                    type="submit" name="Cancel" value=1> Annuler </button>
                <button
                    class="transition w-full duration-150 ease-in-out text-orange-500 hover:text-white border border-orange-500 hover:bg-orange-500 focus:ring-4 focus:outline-none font-bold rounded-lg px-5 py-2 cursor-pointer flex flex-row justify-center items-center"
                    type="submit"> Publier</button>
            </div>
        </form>
    </div>
</div>
<?php

require_once('../Composants/footer.php');
?>