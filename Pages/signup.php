<?php
require_once('../Composants/header.php');
require_once('../Composants/navbar.php');

// Gestion de la session pour un nouvel utilisateur tout en utilisant le même navigateur
if ($_SERVER['REQUEST_METHOD'] !== 'POST' and isset($_SERVER['HTTP_COOKIE'])) {
    session_destroy();
    $cookies = explode(';', $_SERVER['HTTP_COOKIE']);
    foreach ($cookies as $cookie) {
        $parts = explode('=', $cookie);
        $name = trim($parts[0]);
        setcookie($name, '', time() - 1000);
        setcookie($name, '', time() - 1000, '/');
    }
    session_start();
}

// Récupération des utilisateurs
$users = createGetRequest(Routes::AllUsersRoute);
$usedId = array();
foreach ($users["Data"] as $user) {
    array_push($usedId, $user['Id']);
}

// Détermination d'un ID disponible pour un éventuel nouvel utilisateur
$stop = false;
$id = 0;
for ($i = 1; $i <= count($usedId); $i++) {
    if (!in_array($i, $usedId) and !$stop) {
        $id = $i;
        $stop = true;
    }
}if($id ==0) $id = count($usedId) +1;

// Traitement du formulaire d'inscription
if (isset($_POST['pseudo']) && isset($_POST['email']) && isset($_POST['password'])) {
    $pseudo = $_POST['pseudo'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $sessionId = session_id();
    // Création du nouvel utilisateur
    createPostRequest(Routes::UsersRoute . $id, ["Email" => $email, "Password" => $password, "Pseudo" => $pseudo, "Admin" => 0, "SessionId" => $sessionId]);
    $_SESSION['IdUser'] = $id;
    $_SESSION['Pseudo'] = $pseudo;
    // Redirection vers la page Feed.php
    header('Location: Feed.php');
}

?>
<!-- HTML pour le formulaire d'inscription -->
<div class="bg-gray-100 w-full h-full flex items-center justify-center">
    <div class="bg-white w-96 h-96 rounded-3xl shadow-lg flex flex-col">
        <div class="flex flex-row flex-wrap text-center text-lg w-full justify-center mt-4 mb-2 h-10">
            <p class="font-bold text-orange-400 w-5/12 ">S'incrire</p>
            <a href="<?php echo Pages::LoginPage ?>" class="font-bold text-gray-300 w-5/12">Se connecter</a>
            <div class="h-px bg-orange-400 w-5/12 "></div>
            <div class="h-px bg-gray-300 w-5/12"></div>
        </div>
        <form method="POST">
            <div class="flex flex-col mx-20 gap-4">
                <input class="w-full p-2 border-b-2 outline-0" type="text" placeholder="Pseudo" name="pseudo" required>
                <input class="w-full p-2 border-b-2 outline-0" type="text" placeholder="Email" name="email" required>
                <input class="w-full p-2 border-b-2 outline-0" type="password" placeholder="Mot de passe"
                    name="password" required>
                <button
                    class="w-full p-2 transition duration-150 ease-in-out text-orange-400 hover:text-white border border-orange-400 hover:bg-orange-400 focus:ring-4 focus:outline-none focus:ring-orange-400 font-bold rounded-lg px-5 py-2 mt-4 cursor-pointer"
                    type="submit">
                    Valider
                </button>
            </div>
        </form>
    </div>
</div>
<?php require_once('../Composants/footer.php'); ?>