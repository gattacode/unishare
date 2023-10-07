<?php
    function display_Comment($comment){
        // A finir ---> Créer le form pour delete le comm et mettre 
        echo '
        <div class="shadow-inner rounded-xl m-3 w-11/12 h-max bg-white">
            <div class="m-2 font-semibold flex justify-between">' .$comment["Pseudo"] .
            '<form name="form" action="../Controller.php" method="post">
                <input name="Request" value="DeleteComment" hidden/>
                <input name="Id" value ="' . $comment['id'] . '"hidden/>
                <input name="IdArticle" value ="' . $comment['IdArticle'] . '"hidden/>
                <button type="submit" class=" hover:bg-red-400 rounded-xl p-1"><span class="material-symbols-outlined">delete</span></div>
            </form>
            <div class="m-2"><p class="font-normal"> ' . $comment["Description"] . '</p></div>
        </div>';
    }
?>