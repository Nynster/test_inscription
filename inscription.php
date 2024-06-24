<?php
// Connexion à la base de données
$connexion = new PDO('mysql:host=localhost;dbname=base_user_1', 'root', '');

if (isset($_POST['valider'])) {
    if (!empty($_POST['username']) && !empty($_POST['mail']) && !empty($_POST['password'])) {
        $username = htmlspecialchars($_POST['username']);
        $mail = htmlspecialchars($_POST['mail']);
        $mdp = sha1($_POST['password']);

        if (strlen($_POST['password']) < 7) {
            $message = "Votre mot de passe est trop court*";
        } else {
            // Vérification de l'email
            $testmail = $connexion->prepare("SELECT * FROM user WHERE mail = ?");
            $testmail->execute(array($mail));
            $controlmail = $testmail->rowCount();

            // Vérification du nom d'utilisateur
            $testusername = $connexion->prepare("SELECT * FROM user WHERE username = ?");
            $testusername->execute(array($username));
            $controlusername = $testusername->rowCount();

            if ($controlmail == 0 && $controlusername == 0) {
                $insertion = $connexion->prepare("INSERT INTO user(username, mail, password) VALUES(?, ?, ?)");
                $insertion->execute(array($username, $mail, $mdp));
                $message = "Votre compte a bien été créé";
            
                // Redirection vers index.html
                header("Location: connexion.php");
                exit();
            } else {
                if ($controlmail > 0) {
                    $message = "Votre adresse mail existe déjà";
                } elseif ($controlusername > 0) {
                    $message = "Votre nom d'utilisateur existe déjà";
                }
            }
        }
    } else {
        $message = "Remplissez tous les champs*";
    }
}


echo'
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <link href="style.css" rel="stylesheet">
</head>
<body>
  <div id="container_form">
    <form action="" method="POST">
      <div id="container_box_form">
        <div class="one">
            <h1>Inscription</h1>
        </div>
        <div class="one">
            <h3>Remplissez tous les champs.</h3>
        </div>
        <div class="one">
            <input type="email" name="mail" placeholder="mail" required>
        </div>
        <div class="one">
            <input type="text" name="username" placeholder="pseudo" required>
        </div>
        <div class="one">
            <input type="password" name="password" placeholder="mot de passe" required>
        </div>
        <div class="one">
            <input type="submit" name="valider" value="inscrivez-vous">
            <br>
            <br>
            <p>
            <i style = "color:red">
            <?php
            if(isset($message)){
                echo $message;
            }
            ?></i>
            </p>
        </div>
        <div>
            <a href="connexion.php" class="button_co_form">connexion</a>
      </div>
    </form>
  </div>
</body>
</html>'

?>

