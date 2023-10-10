<?php
function display_Comment($comment, $source)
{
    // Affichage d'un commentaire avec option de suppression pour l'auteur
    echo '
        <div class="shadow-inner rounded-xl m-3 w-11/12 h-max bg-white">
            <div class="m-2 font-semibold flex justify-between ">' . $comment["Pseudo"] .

        '<form name="form" action="../Controller.php" method="post"> 
                <input name="Request" value="DeleteComment" hidden/>
                <input name="Source" value="' . $source . '" hidden/>
                <input name="Id" value ="' . $comment['id'] . '"hidden/>
                <input name="IdArticle" value ="' . $comment['IdArticle'] . '"hidden/>';

    // Vérification si l'utilisateur courant est l'auteur du commentaire pour afficher l'option de suppression
    echo ($_SESSION['IdUser'] == $comment['IdUser']) ? '<button type="submit" class="[&>span]:hover:invert hover:bg-red-400 rounded-xl p-1"><span class="material-symbols-outlined">delete</span>' : '';
    echo '</div></form>
            <div class="m-2"><p class="font-normal"> ' . $comment["Description"] . '</p></div>
        </div>';
}
?>