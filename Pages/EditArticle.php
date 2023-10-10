<?php
require_once('../Composants/header.php');

// On protege la route 
if (!checkUser(session_id())) {
    require_once('../Composants/askLogin.php');
    die();
}


// On récupere l'id de l'article , et si il existe ou pas (on detecte ainsi si il s'agit d'une modification de l'article ou d'une création)
$url = explode("/", filter_var($_SERVER['REQUEST_URI'], FILTER_SANITIZE_URL));
if (isset($url[3])){
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
foreach($reqCategories["Data"] as $Categorie){
    if ($Categorie["Name"] !== "Undefined"){
    array_push($Categories,$Categorie["Name"]);
    }
}

require_once('../Composants/navbar.php');
;
?>
<div class="flex mt-6">
    <div class="rounded-3xl border border-black mt-20 ml-48 h-96 w-1/3 flex bg-white justify-center items-center">Upload
        Image</div>
    <div class=" mt-20 ml-40 w-1/3">
        <form class="m-5 flex flex-col gap-3" name="EditArticle" method="post" action="../Controller.php">
            <input name="Pseudo" value="<?php echo $_SESSION['Pseudo']?>"hidden/>
            <label class="font-semibold" >Titre</label>
            <input name="Request" value="<?php echo $Request?>" hidden/>
            <input name="Title" class="border-b border-black w-1/2" value="<?php echo $Titre?>"/>

            <?php
                if($Request == 'PutArticle'){
                    echo '<input name="IdArticle" value='. $idArticle .' hidden/>';
                }
            ?>

            <label class="font-semibold">Description</label>
            <textarea name="Desc" class="border-b border-l border-black w-full h-80" ><?php echo $Desc ?></textarea>

            <label class="font-semibold">Catégorie 1 </label>
            <select name="Categorie1">
                <option value="No"></option>
                <?php 
                    foreach($Categories as $categorie){
                        echo '<option value="' . $categorie . '">' .$categorie . '</option>';
                    }
                ?>
            </select>

            <label class="font-semibold">Catégorie 2 </label>
            <select name="Categorie2">
            <option value="No"></option>
                <?php 
                    foreach($Categories as $categorie){
                        echo '<option value="' . $categorie . '">' .$categorie . '</option>';
                    }
                ?>
            </select>

            <label class="font-semibold">Catégorie 3 </label>
            <select name="Categorie3">
            <option value="No"></option>
                <?php 
                    foreach($Categories as $categorie){
                        echo '<option value="' . $categorie . '">' .$categorie . '</option>';
                    }
                ?>
            </select>

            <div class="flex justify-around mt-3 -ml-6">
                <button class="border border-black rounded-lg p-1 w-5/12" type="submit" name="Cancel" value=1> Annuler </button>
                <button class="border border-black rounded-lg bg-orange-400 p-1 w-5/12" type="submit"> Publier</button>
            </div>
        </form>
    </div>
</div>
<?php

require_once('../Composants/footer.php');
    ?>