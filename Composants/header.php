<<<<<<< HEAD
<?php 
session_start(); 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
=======
<?php
    function headerVue(){
    echo '<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="https://cdn.tailwindcss.com"></script>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
        <title>Unishare</title>
        <style>
>>>>>>> origin/main
        .truncate-lines {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
        }
<<<<<<< HEAD
    </style>
    <title>Unishare</title>
</head>

<body class="flex flex-col font-sans">
<?php 
include_once('../utils.php');
=======
        </style>
    </head>
    <body class="bg-slate-300 m-0">
    ';
    }
>>>>>>> origin/main
?>