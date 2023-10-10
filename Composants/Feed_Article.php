<?php
function display_Article($article)
{
    // Affichage de la structure principale de l'article
    echo '
        <div class="w-1/3 h-96 pb-16 bg-white ">
            <img class="w-max h-1/2" src="../images/DefaultArticlePhoto.png" alt="Photo Article"/>
            <div class=" w-5/6 h-auto mt-2 ml-8">
                <h1 class="text-center font-medium"> ' . $article["Pseudo"] . ' </h1>

                <div class="w-11/12 h-20 m-3">
                    <h1 class="font-semibold "> ' . $article["Titre"] . '</h1>
                    <p class=" font-normal truncate-lines"> ' . $article["Description"] . ' </p> ' . // Ajouter une logique pour ajouter 3 points si la desc est trop longue
        '
                </div>

                <div class=" w-96 -ml-3 h-10 m-3 flex flex-row gap-1 justify-start">
                    ';
    // Boucle pour afficher jusqu'à 3 catégories avec des couleurs différentes
    for ($i = 1; $i <= 3; $i++) {
        $index = "Categorie" . $i;
        // Assignation de couleurs différentes pour chaque catégorie
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
        // Affichage de la catégorie si elle n'est pas définie
        if ($article[$index] !== 'Undefined') {
            displayCategorie($article[$index], $color);
        }
    }
    // Lien pour lire la suite de l'article
    echo '
                </div>
                <p class=" mt-2 text-orange-500 flex justify-end "><a class="hover:underline" href="' . Pages::ArticlePage . $article['Id'] . '">Lire la suite...</a></p>
            </div>
        </div>';
}
function displayCategorie($name, $color)
{
    // Affichage d'une catégorie avec une couleur spécifique
    echo '<div class="w-max p-1 h-5/6 m-1 text-center text-white font-semibold rounded-lg  ' . $color . '" >' . $name . '</div>';
}
?>