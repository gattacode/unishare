<?php
$categories = ['Actualités', 'Evenement', 'Prix', 'Sortie']
    ?>

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

    <?php for ($i = 0; $i < count($categories); $i++) {
        if (array_key_exists('delete-button', $_POST)) {
            /** Ajouter fonction supprimer catégorie */
        }
        ?>
        <div
            class="bg-white font-bold text-orange-400 text-lg w-96 h-20 rounded-2xl shadow-lg flex flex-row justify-center p-6">
            <?php echo $categories[$i] ?>
            <form method="POST" class="flex flex-row ml-auto gap-3">
                <button type="submit" name="edit-button">
                    <img class="h-6 w-6" alt="edut" src="./images/edit-icon.png" />
                </button>
                <button type="submit" name="delete-button">
                    <img class="h-6 w-6" alt="delete" src="./images/delete-icon.png" />
                </button>
            </form>
        </div>
    <?php } ?>


</div>