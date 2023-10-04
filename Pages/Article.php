<?php
    session_start();
    require_once('../Composants/header.php');
    require_once('../Composants/navbar.php');
    require_once('../Composants/footer.php');
    require_once('../Composants/Article_Comment.php');
    headerVue();
    display_Navbar();

    $lorem = "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce dapibus in mauris sit amet finibus. Maecenas odio dui, commodo sed mauris eget, accumsan semper ligula. Duis pellentesque ante nec tristique efficitur. Etiam ac augue et felis vehicula pellentesque. Aliquam ultrices porta dolor. Morbi pretium a mauris imperdiet scelerisque. Curabitur sit amet libero eget diam gravida tristique quis non lacus. Nunc vehicula ex arcu, ut aliquet erat elementum at. Pellentesque vehicula lectus ac quam eleifend interdum. Mauris eros sem, elementum a odio non, placerat aliquam ante. Quisque mattis mi nec libero aliquet hendrerit. Integer ex libero, venenatis non finibus ac, congue vel libero.

    Etiam fringilla volutpat tincidunt. Praesent et tortor lacinia, tempor sem vel, bibendum magna. Morbi non pharetra risus. Duis lorem mi, faucibus vitae tincidunt rhoncus, gravida lacinia lectus. Etiam lorem ligula, venenatis sit amet urna sit amet, dignissim interdum est. Nulla quis feugiat risus. Proin venenatis metus in erat tincidunt dictum. Vestibulum malesuada quam dolor, ut sodales libero vulputate eu. Nam at ultricies orci, a egestas augue. Maecenas commodo dui felis, id suscipit ligula ullamcorper et. In a ex sit amet libero sagittis suscipit eu a diam. Etiam vel dolor sed nibh malesuada convallis. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
    
    Ut eleifend vehicula ultrices. Donec id nibh neque. Nulla id tortor lectus. Aliquam sed bibendum ex. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec viverra, arcu quis egestas tempus, libero mauris efficitur mauris, et lacinia ipsum tortor sed sapien. Maecenas viverra orci sapien, non elementum nisi commodo id. Maecenas eleifend et tortor a maximus. Morbi fermentum nisl ac magna volutpat hendrerit. Donec convallis, sem sodales molestie fringilla, dui odio rutrum dolor, vitae aliquam lectus enim id quam. Proin ornare vestibulum lorem, eu semper lectus porta vel. Donec ullamcorper fermentum mollis. Nulla consectetur, augue eu tristique ultrices, turpis justo tincidunt odio, at consequat purus erat a erat. Nulla sit amet enim condimentum, suscipit orci sed, auctor erat. Sed tincidunt dapibus tincidunt.
    
    Quisque quis iaculis nulla. Nulla facilisi. Donec consequat feugiat mattis. In non diam velit. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Fusce ut nulla eget dui rhoncus euismod. Maecenas mollis vitae mauris sed laoreet. Aenean dapibus porttitor lorem id feugiat. Nulla ac scelerisque sapien. Nulla placerat odio ut nulla lacinia, ac semper quam varius. Nulla arcu massa, gravida vel vulputate pulvinar, pharetra sit amet mauris.
    
    Maecenas mattis ac tortor sit amet rutrum. Vestibulum nec sapien lacus. Pellentesque elementum quis dolor at auctor. Quisque eget mollis arcu. Duis feugiat luctus scelerisque. Cras vehicula augue nec imperdiet accumsan. Curabitur semper nec purus vel rhoncus. Duis et lorem lacus. Curabitur sed quam id lorem euismod ultrices.";

    // Code pour récuperer l'article en question 'Parametre en Post de l'ID'
    $article = array("Titre" => "TestTitre","Description" => $lorem,"Pseudo" => "Jasser","Categorie1" => 'Actualités',"Categorie2" => 'Politique',"Categorie3" => "Informatique");

    // Fonction pour display une catégorie
    function displayCategorie($name,$color){
        echo '<div class="border border-black w-max h-3/6 m-5 text-center text-white font-semibold p-1 ' . $color . '" >' . $name .'</div>';
    }

    $nbComments = 10;
    $comment = array("Pseudo" => "Abdou","Description" => "Trés bon article Shagay, mais en vrai va te faire foutre frere commment le site est moche c'est trop une frauduleuse campagne de recrutement")
?>
    <div class="flex ">
    <div class=" w-7/12 h-max ml-32 mt-5 bg-white">
        <img class="w-max h-72" src="../images/DefaultArticlePhoto.png" alt="Photo Article"/>
        <div class=" h-max">
            <div class="flex justify-between border-b border-black">
                <div class=" flex">
                    <?php
                        for($i=1;$i<=3;$i++){
                            $index = "Categorie" . $i;
                            switch($i){
                                case 1 : $color = 'bg-yellow-400';
                                    break;
                                case 2 : $color = 'bg-orange-500';
                                    break;
                                case 3 : $color = 'bg-orange-500';
                                    break;
                                default : $color='';
                                break;
                            }
                            displayCategorie($article[$index],$color);
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
    <div class=" ml-16 w-3/12 mt-5">
        <div class="flex">
            <h1 class="font-bold m-3">Commentaires</h1>
            <?php echo '<div class="font-bold m-3">' . $nbComments . '</div>' ?>
        </div>
        <div class="flex flex-wrap">
            <?php 
                for($i=0;$i<$nbComments;$i++){
                    display_Comment($comment);
                }
            ?>
        </div>
    </div>
    </div>
<?php
    footerVue();
?>