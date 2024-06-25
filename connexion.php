<?php
// Connexion à la base de données avec gestion des exceptions
try {
    $connexion = new PDO('mysql:host=localhost;dbname=base_user_1', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}

if (isset($_POST['valider'])) {
    if (!empty($_POST['username']) && !empty($_POST['password'])) {
        $username = htmlspecialchars($_POST['username']);
        $password = $_POST['password'];

        // Récupération de l'utilisateur depuis la base de données
        $req = $connexion->prepare("SELECT * FROM user WHERE username = ?");
        $req->execute(array($username));
        $user = $req->fetch(PDO::FETCH_ASSOC);

        // Vérification du mot de passe
        if ($user && password_verify($password, $user['password'])) {
            // Initialiser la session ou les variables utilisateur
            session_start();
            $_SESSION['username'] = $username;

            // Redirection vers index.html
            header("Location: index.html");
            exit();
        } else {
            $message = "Désolé mais nous ne trouvons pas ce compte...";
        }
    } else {
        $message = "Veuillez remplir tous les champs";
    }
}
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>connexion</title>
    <link href="style.css" rel="stylesheet">
</head>
<body>
    <div id="container_connexion">
        <form action="" method="POST"> 
            <div id="connexion_items">
                <div>
                    <h1>Connexion</h1>
                </div>
                <div>
                    <input class="bat_inp" type="text" name="username" placeholder="votre pseudo" required>
                </div>
                <div>
                    <input class="bat_inp" type="password" name="password" placeholder="votre mot de passe" required>
                </div>
                <div>
                    <input class="bat_inp" type="submit" name="valider" value="connectez-vous">
                </div>
                <br>
                <div>
                <p>
                <i style="color:red">
                  <?php 
                  if(isset($message)){
                    echo $message;
                  }
                  ?>
                </i>
                <p>
                </div>
                <div>
                    <a href="inscription.php" class="button_co_form bat_inp">Inscrivez-vous</a>
                </div>
            </div>
        </form>
    </div>
</body>
</html>