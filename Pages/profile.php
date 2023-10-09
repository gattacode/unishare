<?php
require_once('../Composants/header.php');
require_once('../Composants/navbar.php');

if (!checkUser(session_id())) {
    require_once('../Composants/askLogin.php');
    die();
}

if ($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['logout'])) {
    session_unset();
    // Suppression de tous les cookies
    if (isset($_SERVER['HTTP_COOKIE'])) {
        $cookies = explode(';', $_SERVER['HTTP_COOKIE']);
        foreach($cookies as $cookie) {
            $parts = explode('=', $cookie);
            $name = trim($parts[0]);
            setcookie($name, '', time()-1000);
            setcookie($name, '', time()-1000, '/');
        }
    }
}
function display_Article($article)
{
    echo '
    <div class="border border-black w-1/2 h-96 bg-white">
        <img class="w-max h-1/2" src="../images/DefaultArticlePhoto.png" alt="Photo Article"/>
        <div class=" w-5/6 h-auto mt-2 ml-8">
            <h1 class="text-center font-medium"> ' . $article["Pseudo"] . ' </h1>

            <div class="w-11/12 h-20 m-3">
                <h1 class="font-semibold "> ' . $article["Titre"] . '</h1>
                <p class=" font-normal truncate-lines"> ' . $article["Description"] . ' </p> ' .
        '
            </div>

            <div class=" w-96 -ml-3 h-10 m-3 flex flex-row gap-1 justify-start">
                ';
    for ($i = 1; $i <= 3; $i++) {
        $index = "Categorie" . $i;
        switch ($i) {
            case 1:
                $color = 'bg-yellow-400';
                break;
            case 2:
                $color = 'bg-orange-500';
                break;
            case 3:
                $color = 'bg-orange-500';
                break;
            default:
                $color = '';
                break;
        }
        displayCategorie($article[$index], $color);
    }
    echo '
            <p class=" mt-2 text-orange-500"><a href="http://localhost/Blog/Front/Pages/Article.php?id= ' . $article['Id'] . '">Lire la suite...</a></p>
            </div>
        </div>
    </div>';
}
function displayCategorie($name, $color)
{
    echo '<div class="border border-black w-max p-1 h-5/6 m-1 text-center text-white font-semibold ' . $color . '" >' . $name . '</div>';
}

function display_Comment($comment, $user_id)
{
    if ($user_id == $comment["Pseudo"])
        echo '
        <div class="rounded-2xl shadow-lg m-3 p-6 w-11/12 h-max bg-white">
            <div class="m-2 font-semibold">' . $comment["Pseudo"] . '</div>
            <div class="m-2"><p class="font-normal"> ' . $comment["Description"] . '</p></div>
        </div>';
}

$user = array("Pseudo" => "Abdou", "Articles" => "");
$lorem = "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce dapibus in mauris sit amet finibus. Maecenas odio dui, commodo sed mauris eget, accumsan semper ligula. Duis pellentesque ante nec tristique efficitur. Etiam ac augue et felis vehicula pellentesque. Aliquam ultrices porta dolor. Morbi pretium a mauris imperdiet scelerisque. Curabitur sit amet libero eget diam gravida tristique quis non lacus. Nunc vehicula ex arcu, ut aliquet erat elementum at. Pellentesque vehicula lectus ac quam eleifend interdum. Mauris eros sem, elementum a odio non, placerat aliquam ante. Quisque mattis mi nec libero aliquet hendrerit. Integer ex libero, venenatis non finibus ac, congue vel libero.
Etiam fringilla volutpat tincidunt. Praesent et tortor lacinia, tempor sem vel, bibendum magna. Morbi non pharetra risus. Duis lorem mi, faucibus vitae tincidunt rhoncus, gravida lacinia lectus. Etiam lorem ligula, venenatis sit amet urna sit amet, dignissim interdum est. Nulla quis feugiat risus. Proin venenatis metus in erat tincidunt dictum. Vestibulum malesuada quam dolor, ut sodales libero vulputate eu. Nam at ultricies orci, a egestas augue. Maecenas commodo dui felis, id suscipit ligula ullamcorper et. In a ex sit amet libero sagittis suscipit eu a diam. Etiam vel dolor sed nibh malesuada convallis. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
Ut eleifend vehicula ultrices. Donec id nibh neque. Nulla id tortor lectus. Aliquam sed bibendum ex. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec viverra, arcu quis egestas tempus, libero mauris efficitur mauris, et lacinia ipsum tortor sed sapien. Maecenas viverra orci sapien, non elementum nisi commodo id. Maecenas eleifend et tortor a maximus. Morbi fermentum nisl ac magna volutpat hendrerit. Donec convallis, sem sodales molestie fringilla, dui odio rutrum dolor, vitae aliquam lectus enim id quam. Proin ornare vestibulum lorem, eu semper lectus porta vel. Donec ullamcorper fermentum mollis. Nulla consectetur, augue eu tristique ultrices, turpis justo tincidunt odio, at consequat purus erat a erat. Nulla sit amet enim condimentum, suscipit orci sed, auctor erat. Sed tincidunt dapibus tincidunt.
Quisque quis iaculis nulla. Nulla facilisi. Donec consequat feugiat mattis. In non diam velit. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Fusce ut nulla eget dui rhoncus euismod. Maecenas mollis vitae mauris sed laoreet. Aenean dapibus porttitor lorem id feugiat. Nulla ac scelerisque sapien. Nulla placerat odio ut nulla lacinia, ac semper quam varius. Nulla arcu massa, gravida vel vulputate pulvinar, pharetra sit amet mauris.
Maecenas mattis ac tortor sit amet rutrum. Vestibulum nec sapien lacus. Pellentesque elementum quis dolor at auctor. Quisque eget mollis arcu. Duis feugiat luctus scelerisque. Cras vehicula augue nec imperdiet accumsan. Curabitur semper nec purus vel rhoncus. Duis et lorem lacus. Curabitur sed quam id lorem euismod ultrices.";

$article = array("Id" => 'index.php', "Titre" => "Lorem Ipsum Title", "Description" => $lorem, "Pseudo" => "Jasser", "Categorie1" => 'Actualités', "Categorie2" => 'Politique', "Categorie3" => "Informatique");
$nbComments = 10;
$comment = array("Pseudo" => $user['Pseudo'], "Description" => "Trés bon article Shagay, mais en vrai va te faire foutre frere comment le site est moche c'est trop une frauduleuse campagne de recrutement")
    ?>
<div class="flex ">
    <div class=" w-7/12 h-max ml-32 mt-5 bg-white">
        <div class="flex items-center justify-between border-b border-black">
            <div class="text-center text-xl	 m-5 p-10 font-medium">
                <?php echo $user["Pseudo"] ?>
            </div>
            <form method="POST" action="./profile">
                <input class="transition duration-150 ease-in-out text-red-600 hover:text-white border border-red-600 hover:bg-red-600 focus:ring-4 focus:outline-none focus:ring-red-600 font-bold rounded-lg px-5 py-2 cursor-pointer" name="logout" type="submit" value="Se déconnecter" />
            </form>
        </div>
        <div class="m-4 flex flex-col gap-5">
            <p class="font-semibold text-xl ">Mes articles</p>
            <div>
                <?php
                display_Article($article);
                ?>
            </div>
        </div>
    </div>
    <div class=" ml-16 w-3/12 mt-5">
        <div class="flex">
            <p class="font-semibold text-xl m-3">Commentaires</p>
            <?php echo '<div class="font-semibold text-xl m-3">' . $nbComments . '</div>' ?>
        </div>
        <div class="flex flex-wrap">
            <?php
            for ($i = 0; $i < $nbComments; $i++) {
                display_Comment($comment, $user["Pseudo"]);
            }
            ?>
        </div>
    </div>
</div>
<?php require_once('../Composants/footer.php'); ?>
