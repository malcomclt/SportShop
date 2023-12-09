<?php
session_start(); 
?>


<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">

  <title>SportShop</title>
  <link rel="stylesheet" href="styles/style.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Spectral:wght@200&display=swap" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script type="text/javascript" src="chat.js"></script>

</head>
<body>
<div id="iframeContainer">
    <iframe src="app-message/app_message.php"></iframe>
</div>
<?php if ( isset($_SESSION['client']) ) {

echo'<img src="images/chat.png" alt="Icone Chat" id ="icon_chat">';
echo '<img src="images/close.png" alt="Icone Chat" id ="icon_close">';
}


?>
<?php

require_once('fichier bd.php');

$bdd = getBD();
$query = "SELECT * FROM articles";
$stmt = $bdd->prepare($query);
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC)

?>
<img src="images/pandouille.png" alt="Logo de mon site web" class="logo">
<div class= "page-accueil">
<?php
  
    if (isset($_SESSION['client'])) {
        $nom = $_SESSION['client']['nom'];
        $prenom = $_SESSION['client']['prenom'];
        echo "<h1> Bienvenue sur SportShop $nom $prenom</h1> ";
    } else {
        
        echo "<h1> Bienvenue sur SportShop </h1>";
    }
    ?>



  <table>
    <thead>
      <tr>
        <th>Numéro identifiant </th>
        <th>Nom</th>
        <th>Quantité</th>
        <th>Prix</th>
      </tr>
    </thead>
    <tbody>
	<?php
        
        foreach ($results as $row) {
            echo "<td>" . $row['id_art'] . "</td>";
            echo "<td><a href='articles/article.php?id=" . $row['id_art'] . "'>" . $row['nom'] . "</a></td>";
            echo "<td>" . $row['quantite'] . "</td>";
            echo "<td>" . $row['prix'] . " €</td>";
            echo "</tr>";
        }
		$bdd = null;
    ?>

    </tbody>
  </table>
 
</div>
    <footer class="page-footer">
        <div class="button-container">
            <a href="contact/contact.html" class="oval-button">Contact</a>
    <?php

    if (!isset($_SESSION['client'])) {
			echo"<a href='formulaire/nouveau.php' class='oval-button'>Nouveau Client</a>";
      echo"<a href='formulaire/connexion.php' class='oval-button'>Se connecter</a>";
    } 
    else {
      echo"<a href='formulaire/deconnexion.php' class='oval-button'>Se déconnecter</a>";
      echo"<a href='articles/panier.php' class='oval-button'>Panier</a>";
      echo"<a href='articles/historique.php' class='oval-button'>Commandes passées</a>";
    }
    $bdd = null;
    ?>

        </div>
    </footer>
</body>
</html>
