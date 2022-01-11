<?php
session_start();
    if(!$_SESSION['cle']){
        header('Location: connexion_vue.php');
    }else{
        header('Location: accueil.php');
    }
?>