<?php
require('bdd.php');

//Vérifier si le formulaire est soumis
if (isset($_POST['validate'])) {

    //Vérifier si l'utilisateur a entrer toutes les données
    if (!empty($_POST['nom']) && !empty($_POST['prenom']) && !empty($_POST['email']) && !empty($_POST['pseudo']) && !empty($_POST['mdp'])) {
        
        //Les données de l'utilisateurs
        $nom = htmlspecialchars($_POST['nom']);
        $prenom = htmlspecialchars($_POST['prenom']);
        $email = htmlspecialchars($_POST['email']);
        $pseudo = htmlspecialchars($_POST['pseudo']);
        $mdp = password_hash($_POST['mdp'], PASSWORD_DEFAULT);


        //Vérifier si l'utilisateurs existe déja
        $request = $bdd->prepare('SELECT email FROM membres WHERE email = ?');
        $request->execute(array($email));

        //Si l'utilisateur n'existe pas donc = 0
        if($request->rowCount() == 0){
            //Insérer l'utilisateur dans la base de donnée
            $insert = $bdd->prepare('INSERT INTO `membres`(`nom`, `prenom`, `email`, `pseudo`, `mdp`) VALUES (?, ?, ?, ?, ?)');
            $insert->execute(array($nom, $prenom, $email, $pseudo, $mdp));

            //Récupérer les informations de l'utilisateur
            $select = $bdd->prepare('SELECT id, nom, prenom, email, pseudo FROM membres WHERE nom = ? AND prenom = ? AND email = ? AND pseudo = ?');
            $select->execute(array($nom, $prenom, $email, $pseudo));

            $membreInfo = $select->fetch();

            //authentifier l'utilisateur sur le site et récupérer ces données dans des variables globales session
            $_SESSION['auth'] = true;
            $_SESSION['id'] = $membreInfo['id'];
            $_SESSION['nom'] = $membreInfo['nom'];
            $_SESSION['prenom'] = $membreInfo['prenom'];
            $_SESSION['email'] = $membreInfo['email'];
            $_SESSION['pseudo'] = $membreInfo['pseudo'];

            //redirige l'utilisateur vers la page d'accueil
            header('Location: accueil.php');

        }else{
            $error = "L'utilisateur existe déja";
        }
    }else{
        $error = "Veuillez compléter tous les champs!!!";
    }
}

?>