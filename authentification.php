<?php
if(!isset($_SESSION['auth'])){
    header('Location: connexion_vue.php');
}
?>