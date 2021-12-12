<?php
function augmenter($n){
    include_once('bdd.php');

    $selection = $bdd->prepare("UPDATE `participant` SET point = point + 1 WHERE id = '$n'");
    $selection->execute();

}
function diminuer($d){
    include_once('bdd.php');

    $selection = $bdd->prepare("UPDATE `participant` SET point = point - 1 WHERE id = '$d'");
    $selection->execute();

}

if(isset($_REQUEST['n'])){
    $id = $_REQUEST['n'] ;
    augmenter($id);
    header('Location: accueil.php');
}
if(isset($_REQUEST['d'])){
    $id = $_REQUEST['d'] ;
    diminuer($id);
    header('Location: accueil.php');
}
?>
