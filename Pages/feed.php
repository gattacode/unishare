<?php 
require_once('../Composants/header.php'); 
require_once('../Composants/navbar.php');

/** Ajouter fonction verification admin */
$isAdmin = true;
$categories = ['Actualités', 'Evenement', 'Prix', 'Sortie'];

if ($isAdmin) {
    echo '

<div class="bg-gray-100 w-full h-full flex flex-col items-center justify-center gap-3">
    <div class="bg-white font-bold text-lg w-96 h-20 rounded-2xl shadow-lg flex flex-col justify-center p-6">
        <!-- Ajouter fonction ajout catégorie -->
        <form method="POST" class="m-0 flex flex-row">
            <input name="add-cat-button" class="w-full outline-0 " type="text" placeholder="Créer une catégorie"
                name="createcat" required>
            <button
                class="transition duration-150 ease-in-out text-orange-400 hover:text-white border border-orange-400 hover:bg-orange-400 focus:ring-4 focus:outline-none focus:ring-orange-400 font-bold rounded-full px-2 cursor-pointer"
                type="submit">+</button>
        </form>
    </div>
';
    for ($i = 0; $i < count($categories); $i++) {
        echo '
    <div class="bg-white font-bold text-orange-400 text-lg w-96 h-20 rounded-2xl shadow-lg flex flex-row justify-center p-6">
        ' . $categories[$i] . '
        <form method="POST" class="flex flex-row ml-auto gap-3">
            <button type="submit" name="edit-button[' . $i . ']">
                <img class="h-6 w-6" alt="edit" src="../images/edit-icon.png" />
            </button>
            <button type="submit" name="delete-button[' . $i . ']">
                <img class="h-6 w-6" alt="delete" src="../images/delete-icon.png" />
            </button>
        </form>
    </div>';
    }

} else {
    echo "Pas le droit d'être ici";
}

?> 
<?php require_once('../Composants/footer.php'); ?>