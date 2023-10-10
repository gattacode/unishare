<?php
    require_once('../Composants/header.php');
    // Protection de la page
    if (!checkUser(session_id())) {
        require_once('../Composants/askLogin.php');
        die();
    }

    // Recuperer l'article et les commentaires liés à cet article  / Implementer un controller
    
    // On récupere l'id de l'article
    $url = explode("/", filter_var($_SERVER['REQUEST_URI'], FILTER_SANITIZE_URL));
    $idArticle = explode("Article.php?id=%20",$url[3])[1];
    $ErrorCheckArticle = false;
    $ErrorCheckComments = false;

    // On récupere l'article
    $reqArticle = createGetRequest(Routes::ArticlesRoute . $idArticle);
    if ($reqArticle['Statut'] == 200){
        // On recupère les catégories 
        $reqArticle = $reqArticle['Data'][0];
        
        $reqCategories = createGetRequest(Routes::ArticlesRoute . $idArticle . '/Categories');
        if($reqCategories['Statut'] === 200 ){
            $reqCategories = $reqCategories['Data'][0];
            
            // On récupere ensuite chaque nom pour chaque categorie
            $Categorie1 = createGetRequest( Routes::CategoriesRoute . $reqCategories[1]);
            $Categorie2 = createGetRequest( Routes::CategoriesRoute . $reqCategories[2]);
            $Categorie3 = createGetRequest( Routes::CategoriesRoute . $reqCategories[3]);

            if($Categorie1["Statut"] === 200 and $Categorie2["Statut"] === 200 and $Categorie3["Statut"] === 200){
            $Categorie1 = $Categorie1["Data"][0]["Name"];
            $Categorie2 = $Categorie2["Data"][0]["Name"];
            $Categorie3 = $Categorie3["Data"][0]["Name"];
            }

            $article = ["Id" => $reqArticle["id"],"Titre" => $reqArticle["Titre"],"Pseudo" => $reqArticle["Pseudo"],"Description" =>$reqArticle["Description"],"Categorie1" => $Categorie1,"Categorie2" => $Categorie2,"Categorie3" => $Categorie3];

        }
        else {
            $ErrorCheckArticle = true;
        }
    }
    else{
        $ErrorCheckArticle = true;
    }

    // On récupere les commentaires de l'article
    $reqComments = createGetRequest( Routes::AllCommentsArticle($idArticle));
    
    if($reqComments['Statut'] === 200){
        $Comments = $reqComments['Data'];
        $nbComments = count($Comments);
    }
    else{
        $ErrorCheckComments = true;
        $nbComments = 0;
    }

    
    require_once('../Composants/navbar.php');
    require_once('../Composants/Article_Comment.php');

    if($ErrorCheckArticle){
        echo '<h1>Pas d article dispo</h1>';
        require_once('../Composants/footer.php');
        die();
    }

    // Fonction pour display une catégorie
    function displayCategorie($name,$color){
        echo '<div class="rounded-lg w-max h-3/6 m-5 text-center text-white font-semibold py-2 px-4 ' . $color . '" >' . $name .'</div>';
    }
?>
    <div class="flex">
    <div class=" w-7/12 h-max ml-32 mt-5 bg-white">
        <img class="w-max h-72" src="../images/DefaultArticlePhoto.png" alt="Photo Article"/>
        <div class=" h-max">
            <div class="flex justify-between ">
                <div class=" flex ">
                    <?php
                        for($i=1;$i<=3;$i++){
                            $index = "Categorie" . $i;
                            switch($i){
                                case 1 : $color = 'bg-yellow-400';
                                    break;
                                case 2 : $color = 'bg-orange-500';
                                    break;
                                case 3 : $color = 'bg-pink-500';
                                    break;
                                default : $color='';
                                break;
                            }

                            if($article[$index] !== "Undefined"){
                            displayCategorie($article[$index],$color);
                            }
                        }
                    ?>
                </div>
                <div class="text-center m-5 font-medium"><?php echo $article["Pseudo"]?></div>
            </div>
            <div class="m-4 flex flex-col gap-5">
                <?php echo '<h1 class="font-semibold text-center">' . $article["Titre"]. '</h1>';?>
                <?php echo $article["Description"]?>
                </div>
        </div>
    </div>
    <div class="ml-16 w-3/12 mt-5">
        <div class="flex">
            <h1 class="font-bold m-3">Commentaires</h1>
            <?php echo '<div class="font-bold m-3">' . $nbComments . '</div>' ?>
        </div>
        <div>
            <form name="form" class="flex flex-col" action="../Controller.php" method="post"> 
                <input name='Request' value="PostComment" hidden/>
                <input name='IdArticle' value=<?php echo $article["Id"]?> hidden/>
                <input name='Pseudo'value="<?php echo $_SESSION['Pseudo']?>" hidden/>
                <input name='IdUser'value="<?php echo $_SESSION['IdUser']?>" hidden/>
                <textarea class="border-b-2" name='Desc' placeholder="Postez votre commentaire"></textarea>
                <button class="mt-4 transition duration-150 ease-in-out text-orange-400 hover:text-white border border-orange-400 hover:bg-orange-400 focus:ring-4 focus:outline-none focus:ring-orange-400 font-bold rounded-lg px-5 py-2 cursor-pointer" type="Submit">Envoyer</button>
            </form>
        </div>
        <div class="flex flex-wrap">
            <?php 
                if($ErrorCheckComments){
                    echo '<h1> Pas de commentaires à cet article</h1>';
                }
                else{
                for($i=0;$i<$nbComments;$i++){
                    display_Comment($Comments[$i],'Article');
                }
            }
            ?>
        </div>
    
    </div>
    </div>      
<?php
    require_once('../Composants/footer.php');
?>