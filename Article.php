<?php

    function display_Article($article){
        echo '
        <div class="border border-black w-1/3 h-96 bg-transparent">
            <img class="w-max h-1/2" src="./images/DefaultArticlePhoto.png" alt="Photo Article"/>
            <div class=" w-5/6 h-auto mt-2 ml-8">
                <h1 class="text-center font-medium"> ' .  $article["Pseudo"].' </h1>

                <div class="border border-black w-11/12 h-20 m-3">
                    <h1 class="font-semibold text-center"> ' .  $article["Titre"] .'</h1>
                    <p class="text-center font-normal"> ' . $article["Description"] .' </p>
                </div>

                <div class="border border-black w-11/12 h-10 m-3 flex flex-row gap-1 justify-center">
                    ';
        for($i=1;$i<=3;$i++){
            $index = "Categorie" . $i;
            displayCategorie($article[$index]);
        }
        echo'
                </div>
            </div>
        </div>';
    }
    function displayCategorie($name){
        echo '<div class="border border-black w-max h-5/6 m-1 text-center "> ' . $name .'</div>';
    }
?>