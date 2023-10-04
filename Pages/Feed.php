<?php
session_start();
include_once('../Composants/header.php');
include_once('../Composants/footer.php');
include_once('../Composants/navbar.php');
include_once('../Composants/Feed_Article.php');
// Faire une logique pour récuperer le pseudo, Titre, Description , idListe, Pseudo
$article = array('Pseudo' => 'test','Titre' => 'Fuck les noirs','Description' => 'Article pour dire à quel point je n aime pas les noirs sauf gatta biensur','Categorie1' => 'Politique','Categorie2' => 'Actualités','Categorie3' => 'Informatique');
 
headerVue();
display_Navbar();
?>
    <div class="w-5/6 ml-44 mt-16 flex flex-wrap gap-10 h-max justify-evenly bg-transparent">
    <?php 
        for($i = 0;$i < 4;$i++){
            display_Article($article);
        }
    ?>
    </div>
<?php
footerVue();
?>