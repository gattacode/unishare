<?php
    session_start();
    require_once('../Composants/header.php');
    require_once('../Composants/navbar.php');
    require_once('../Composants/footer.php');
    headerVue();
    display_Navbar();
?>
<div class="flex mt-6">
    <div class="rounded-3xl border border-black mt-20 ml-48 h-96 w-1/3 flex bg-white justify-center items-center">Upload Image</div>
    <div class=" mt-20 ml-40 w-1/3">
        <form class="m-5 flex flex-col gap-3"name="EditArticle" method="post" action="Controller.php">
            <label class="font-semibold ">Titre</label>
            <input name="Title" class="border-b border-black w-1/2"/>

            <label class="font-semibold">Description</label>
            <textarea name="Desc" class="border-b border-black w-3/5"></textarea>

            <label class="font-semibold">Catégorie(s)</label>
            <textarea name="Categories" class="border-b border-black w-3/5"></textarea> <?php // Faire un systeme de menu deroulant pour choisir une  catégorie?>

            <div class="flex justify-around mt-3 -ml-6">
                <button class="border border-black rounded-lg p-1 w-5/12"> Annuler </button>
                <button class="border border-black rounded-lg bg-orange-400 p-1 w-5/12"type="submit"> Publier</button>
            </div>
        </form>
    </div>
</div>
<?php
    footerVue()
?>