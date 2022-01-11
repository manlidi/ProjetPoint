<?php
require_once ('bdd.php');
require_once ('PHPMailer/PHPMailerAutoload.php') ;


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

            $longueurkey = 15;
            $key = "";
            for($i=1;$i<$longueurkey;$i++){
                $key .= mt_rand(0,9); 
            }
            //Insérer l'utilisateur dans la base de donnée
            $insert = $bdd->prepare('INSERT INTO `membres`(`nom`, `prenom`, `email`, `pseudo`, `mdp`,  `confirmekey`) VALUES (?, ?, ?, ?, ?, ?)');
            $insert->execute(array($nom, $prenom, $email, $pseudo, $mdp, $key));

            /*$destinataire = $email;
            $sujet = "Confirmation de compte";
            $messages = '
                <html>
                    <body>
                        <div align="center">
                            <a href="http://localhost/projetpoint/confirmation.php?pseudo='.urlencode($pseudo).'&key='.$key.'">Confirmer votre compte</a>
                        </div>                    
                    </body>
                </html>
            ';
            $headers="MIME-Version: 1.0\r\n";
            $headers.='From: mdtech3007@gmail.com'."\n";
            $headers.='Content-Type:text/html; charset="utf-8"'."\n";
            $headers.='Content-Transfer-Encoding: 8bit';
            mail($destinataire, $sujet, $messages, $headers);*/

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

            function smtpmailer($to, $from, $from_name, $subject, $body){
                $mail = new PHPMailer;

                //$mail->SMTPDebug = 3;                               // Enable verbose debug output

                $mail->isSMTP();                                      // Set mailer to use SMTP
                $mail->SMTPAuth = true;                               // Enable SMTP authentication
                $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
                $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
                $mail->Port = 465;                                    // TCP port to connect to
                $mail->Username = 'mdtech3007@gmail.com';                 // SMTP username
                $mail->Password = 'mdtech123456';                           // SMTP password

                $mail->isHTML(true);                                  // Set email format to HTML
                $mail->From = "mdtech3007@gmail.com";
                $mail->FromName = $from_name;
                $mail->Sender = $from;
                $mail->AddReplyTo($from, $from_name);
                $mail->Subject = $subject;
                $mail->Body    = $body;
                $mail->addAddress($to);     // Add a recipient

                if(!$mail->send()) {
                    echo 'Votre message n\'a pu etre envoyé. Il s\'est produit une erreur. Réessayer .';
                    echo 'Mailer Error: ' . $mail->ErrorInfo;
                } else {
                    echo 'Message bien envoyé';
                }
            }

            $to = $email;
            $fro = 'mdtech3007@gmail.com';
            $name = 'MDcoder';
            $sub = 'Confirmation de compte';
            $msg = 'http://localhost/projetpoint/confirmation.php?id='.$_SESSION['id'].'&cle='.$key;

            $erreur = smtpmailer($to, $fro, $name, $sub, $msg);

            //redirige l'utilisateur vers la page d'accueil
            //header('Location: connexion_vue.php');

        }else{
            $error = "L'utilisateur existe déja";
        }
    }else{
        $error = "Veuillez compléter tous les champs!!!";
    }
}

?>