<?php
require_once('../Composants/header.php');
require_once('../Composants/navbar.php');

/** Ajouter fonction verification admin */
$isAdmin = true;

$requestData = createGetRequest('http://localhost/blog-tp-note-php/api/index.php/Categories');

$categories = [];
foreach ($requestData['Data'] as $categorie) {
    $categories[] = $categorie['Name'];
    $categoryIds[] = $categorie['Id'];
}

if (isset($_POST['newCatName']) && !empty($_POST['newCatName'])) {
    $newCatName = $_POST['newCatName'];
    $newCatId = count($categories) + 1;
    createPostRequest('http://localhost/blog-tp-note-php/api/index.php/Categories/' . $newCatId, ["Name" => $newCatName]);
    echo "<meta http-equiv='refresh' content='0'>";
}

if (isset($_POST['delete-button'])) {
    $categoryIdToDelete = array_key_first($_POST['delete-button']);
    echo $categoryIdToDelete;
    createDeleteRequest('http://localhost/blog-tp-note-php/api/index.php/Categories/' . $categoryIdToDelete);
    echo "<meta http-equiv='refresh' content='0'>";
}


if ($isAdmin) {
    echo '

<div class="bg-gray-100 pt-20 w-full flex flex-col items-center justify-center gap-3 min-h-full">
    <div class="bg-white font-bold text-lg w-96 h-20 rounded-2xl shadow-lg flex flex-col justify-center p-6">
        <form method="POST" class="m-0 flex flex-row" action="http://localhost/blog-tp-note-php/Pages/categories.php">
            <input class="w-full outline-0 " type="text" placeholder="Créer une catégorie"
                name="newCatName" required>
            <input 
                class="transition duration-150 ease-in-out text-orange-400 hover:text-white border border-orange-400 hover:bg-orange-400 focus:ring-4 focus:outline-none focus:ring-orange-400 font-bold rounded-full px-2 cursor-pointer"
                 type="submit"  value="+"/>
        </form>
    </div>
';
    for ($i = 0; $i < count($categories); $i++) {
        echo '
<div class="bg-white font-bold text-orange-400 text-lg w-96 h-20 rounded-2xl shadow-lg flex flex-row justify-center p-6">
    ' . $categories[$i] . '
    <form method="POST" class="flex flex-row ml-auto gap-3">
        <button type="submit" name="delete-button[' . $categoryIds[$i] . ']">
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