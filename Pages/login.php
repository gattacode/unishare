<?php
require_once('../Composants/header.php');
require_once('../Composants/navbar.php');

session_unset();

function isRegistered($email, $password)
{
    $result = createPostRequest(Routes::LoginRoute, ["Email" => $email, "Password" => $password]);

    if ($result["Statut"] === 200) {
        
        $result = $result["Data"][0];
        return ['SessionId' => $result['SessionId'], 'Pseudo' => $result['Pseudo'],"Id" => $result['Id']];
    }
    else {
    return false;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email']) && isset($_POST['password'])) {
    $registrationData = false;
    if ($_POST['email'] == 'admin' && $_POST['password'] == 'azerty' ) {
        session_destroy();
        if (isset($_SERVER['HTTP_COOKIE'])) {
            $cookies = explode(';', $_SERVER['HTTP_COOKIE']);
            foreach($cookies as $cookie) {
                $parts = explode('=', $cookie);
                $name = trim($parts[0]);
                setcookie($name, '', time()-1000);
                setcookie($name, '', time()-1000, '/');
            }
        }
        session_id('sessionadmin');
        session_start();
        header('Location: '. './categories.php');
    } else { $registrationData = isRegistered($_POST['email'], $_POST['password']);
    if (is_array($registrationData)) {
        echo 'Information valide';
        session_destroy();
        if (isset($_SERVER['HTTP_COOKIE'])) {
            $cookies = explode(';', $_SERVER['HTTP_COOKIE']);
            foreach($cookies as $cookie) {
                $parts = explode('=', $cookie);
                $name = trim($parts[0]);
                setcookie($name, '', time()-1000);
                setcookie($name, '', time()-1000, '/');
            }
        }
        session_id($registrationData['SessionId']);
        session_start();
        $_SESSION['IdUser'] = $registrationData['Id'];
        $_SESSION['Pseudo'] = $registrationData['Pseudo'];
        header('Location: Feed.php');
    }
    else{
        echo 'Erreur de login';
    }
}
}

?>
<div class="bg-gray-100 w-full h-full flex items-center justify-center">
    <div class="bg-white w-96 h-96 rounded-3xl shadow-lg flex flex-col">
        <div class="flex flex-row flex-wrap text-center text-lg w-full justify-center my-4 h-10">
            <a href="<?php echo Pages::LoginPage?>" class="font-bold text-gray-300 w-5/12">S'incrire</a>
            <p class="font-bold text-orange-400 w-5/12 ">Se connecter</p>
            <div class="h-px bg-gray-300 w-5/12"></div>
            <div class="h-px bg-orange-400 w-5/12 "></div>
        </div>
        <form method="POST">
            <div class="flex flex-col mx-20 mt-6 gap-10">
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