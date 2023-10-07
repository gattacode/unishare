<?php
    function display_Article($article){
        echo '
        <div class="border border-black w-1/3 h-96 bg-white ">
            <img class="w-max h-1/2" src="../images/DefaultArticlePhoto.png" alt="Photo Article"/>
            <div class=" w-5/6 h-auto mt-2 ml-8">
                <h1 class="text-center font-medium"> ' .  $article["Pseudo"].' </h1>

                <div class="w-11/12 h-20 m-3">
                    <h1 class="font-semibold "> ' .  $article["Titre"] .'</h1>
                    <p class=" font-normal truncate-lines"> ' . $article["Description"] .' </p> ' . // Ajouter une logique pour ajouter 3 points si la desc est trop longue
                    '
                </div>

                <div class=" w-96 -ml-3 h-10 m-3 flex flex-row gap-1 justify-start">
                    ';
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
            if($article[$index] !== 'Undefined'){
            displayCategorie($article[$index],$color);
            }
        }
        echo'
                <p class=" mt-2 text-orange-500"><a href="http://localhost/Blog/Front/Pages/Article.php?id= ' . $article['Id'] .'">Lire la suite...</a></p>
                </div>
            </div>
        </div>';
    }
    function displayCategorie($name,$color){
        echo '<div class="border border-black w-max p-1 h-5/6 m-1 text-center text-white font-semibold ' . $color . '" >' . $name .'</div>';
    }
?>