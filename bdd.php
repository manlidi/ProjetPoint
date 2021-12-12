<?php
try{
    session_start();
    $bdd = new PDO("mysql:host=localhost; dbname=points", "root", "");
    
}catch(Exception $e){
    die('Ue erreur a été trouver: ' .$e->getMessage());
}
?>