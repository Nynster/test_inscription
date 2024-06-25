<?php
// Connexion à la base de données
$connexion = new PDO('mysql:host=localhost;dbname=base_user_1', 'root', '');

// Récupérer les données des utilisateurs
$requete = $connexion->prepare("SELECT username, mail FROM user");
$requete->execute();
$utilisateurs = $requete->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des utilisateurs</title>
    <link href="style.css" rel="stylesheet">
</head>
<body>
    <div id="container_table">
        <h1>Liste des utilisateurs</h1>
        <table border="1">
            <tr>
                <th>Nom d'utilisateur</th>
                <th>Email</th>
            </tr>
            <?php
            // Afficher les données des utilisateurs dans la table
            foreach ($utilisateurs as $utilisateur) {
                echo '<tr>';
                echo '<td>' . htmlspecialchars($utilisateur['username']) . '</td>';
                echo '<td>' . htmlspecialchars($utilisateur['mail']) . '</td>';
                echo '</tr>';
            }
            ?>
        </table>
    </div>
</body>
</html>
