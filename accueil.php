<?php

include_once('bdd.php');
require('authentification.php');

    $afficher = $bdd->prepare("SELECT * FROM `participant`");
    $afficher->execute();
    $afficher->setFetchMode(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- CSS only -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">    
        <title>Points</title>
        <!-- JavaScript Bundle with Popper -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</head>
<body>
    <br>
    <br>
    <br>
<section class="section container-fluid">
    <div class="row" id="table-hover-row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h2 style="text-align: center; text-decoration: underline;">Liste des Participants</h2>
                </div>
            <div class="card-content">
                <div class="table-responsive">
                    <table class="table table-light mb-0">
                        <thead>
                            <tr>
                                <th>Nom</th>
                                <th>Description</th>
                                <th>Points</th>
                                <th>Augmenter</th>
                                <th>Diminuer</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while($ligne = $afficher->fetch()){?>
                                <tr>
                                    <td class="text-bold-500"><?php echo $ligne['nom'] ;?></td>
                                    <td><?php echo $ligne['descript'] ;?></td>
                                    <td class="text-bold-500"><?php echo $ligne['point'] ;?></td>
                                    <td><a style="text-decoration: none;" href="points.php?n=<?php echo $ligne['id'] ;?>"><strong style="color: green; ">Augmenter le point</strong></a></td>
                                    <td><a style="text-decoration: none;" href="points.php?d=<?php echo $ligne['id'] ;?>"><strong style="color: red; ">Diminuer le point</strong></a></td>
                                </tr>
                            <?php } ?> 
                        </tbody>
                    </table>
                </div>
            </div>
            </div>
        </div>
    </div>
</section>
</body>
</html>