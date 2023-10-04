<?php
    function display_Comment($comment){
        echo '
        <div class="shadow-inner rounded-xl m-3 w-11/12 h-max bg-white">
            <div class="m-2 font-semibold">' .$comment["Pseudo"] . '</div>
            <div class="m-2"><p class="font-normal"> ' . $comment["Description"] . '</p></div>
        </div>';
    }
?>