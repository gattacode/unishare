<?php
    session_start();
    require_once('header.php');
    require_once('footer.php');
    require_once('navbar.php');
    require_once('Feed.php');
    // Verifier avec une fonction check ---> Connexion Back
    headerVue();
    display_Navbar();
    display_feed();
    footerVue();
?>