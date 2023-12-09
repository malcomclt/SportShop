<?php
session_start();
?>


<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">

  <title>Merci Pour votre commande</title>
  <link rel="stylesheet" href="../styles/style.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Spectral:wght@200&display=swap" rel="stylesheet">

<?php


if (!isset($_SESSION['client'])) {
    header('Location: ../formulaire/connexion.php'); 
    exit();
}


$panier = isset($_SESSION['panier']) ? $_SESSION['panier'] : array();

require_once('../fichier bd.php');
$bdd = getBD();


$id_client = $_SESSION['client']['id_client'];


foreach ($panier as $article) {
    $id_article = $article['id_article'];
    $quantite = $article['quantite'];

    
    $query = "INSERT INTO Commandes (id_art, id_client, quantite) VALUES (:id_art, :id_client, :quantite)";
    $stmt = $bdd->prepare($query);
    $stmt->bindParam(':id_art', $id_article, PDO::PARAM_INT);
    $stmt->bindParam(':id_client', $id_client, PDO::PARAM_INT);
    $stmt->bindParam(':quantite', $quantite, PDO::PARAM_INT);
    $stmt->execute();

    $query_stock ="UPDATE Articles Set quantite = quantite-:quantite Where id_art=:id_article ";
    $stmt_stock = $bdd->prepare($query_stock);
    $stmt_stock->bindParam(':id_article', $id_article, PDO::PARAM_INT);
    $stmt_stock->bindParam(':quantite', $quantite, PDO::PARAM_INT);
    $stmt_stock->execute();


}


unset($_SESSION['panier']);
?>


</head>
<body>
<img src="../images/pandouille.png" alt="Logo de mon site web" class="logo">
<div class= "page-accueil">
    <h1> Merci pour votre commande, A bientot ! </h1>
</div>
        <footer class="page-footer">
        <div class="button-container">
            <a href="../index.php" class="oval-button">Accueil</a>
        
        </div>
    </footer>	
    <?php $bdd = null; ?>      
</body>
</html>

