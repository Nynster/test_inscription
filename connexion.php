<?php
$connexion = new PDO('mysql:host=localhost;dbname=base_user_1', 'root', '');
if(isset($_POST['valider'])){
    if(!empty($_POST['username']) AND !empty($_POST['password'])){
        $username = htmlspecialchars($_POST['username']);
        $password = sha1($_POST['password']);
        $req = $connexion -> prepare("SELECT * FROM user WHERE username =? AND password = ?");
        $req->execute(array($username,$password));
        $cpt = $req->rowCount();
        
        if($cpt==1){
            $message = "votre compte a bien été trouvé";
             // Redirection vers index.html
             header("Location: index.html");
             exit();
        }else{
            $message = "Désolé mais nous ne trouvons pas ce compte...";
        }
    }else{
        $message="Veuillez remplir tous les champs";
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
                    <input class="bat_inp" type="text" name="username" placeholder="votre mot de passe" required>
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