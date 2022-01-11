<?php
require_once ('bdd.php');
if(!empty($_GET['id']) && !empty($_GET['cle'])){
    $id = htmlspecialchars($_GET['id']);
    $key = htmlspecialchars($_GET['cle']);

    $requser = $bdd->prepare("SELECT * FROM membres WHERE id = ? AND confirmekey = ?");
    $requser->execute(array($id, $key));

    $userexistes = $requser->rowCount();

    if($userexistes == 1){
        $user = $requser->fetch();
        if($user['confirme'] == 0){
            $update_user = $bdd->prepare("UPDATE membres SET confirme = 1 WHERE id = ?");
            $update_user->execute(array($id));
            $_SESSION['cle'] = $key;
            header('Location: index.php');        
        }else{
            $_SESSION['cle'] = $key;
            header('Location: index.php');
        }
    }else{
        echo "L'utilisateur n'existe pas";
    }
}else{
    echo "Erreur";
}


?>