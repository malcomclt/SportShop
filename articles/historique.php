<?php
session_start();
if (!isset($_SESSION['client'])) {
    header('Location: ../connexion.php');
    exit();
}

require_once('../fichier bd.php');
$bdd = getBD();
$id_client = $_SESSION['client']['id_client'];


$query = "SELECT c.id_commande, a.id_art, a.nom, a.prix, c.quantite, c.envoi
          FROM Commandes c
          INNER JOIN articles a ON c.id_art = a.id_art
          WHERE c.id_client = :id_client";
$stmt = $bdd->prepare($query);
$stmt->bindParam(':id_client', $id_client, PDO::PARAM_INT);
$stmt->execute();
$commandes = $stmt->fetchAll(PDO::FETCH_ASSOC);
$bdd = null;
?>


<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">

  <title>Historique des commandes</title>
  <link rel="stylesheet" href="../styles/style.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Spectral:wght@200&display=swap" rel="stylesheet">
</head>
<body>
<img src="../images/pandouille.png" alt="Logo de mon site web" class="logo">
<div class= "page-accueil">
<table>
        <tr>
            <th>Id Commande</th>
            <th>Id Article</th>
            <th>Nom</th>
            <th>Prix</th>
            <th>Quantité</th>
            <th>État de la commande</th>
        </tr>
        <?php foreach ($commandes as $commande) : ?>
            <tr>
                
                <td><?php echo htmlspecialchars($commande['id_commande']); ?></td>
                <td><?php echo htmlspecialchars($commande['id_art']); ?></td>
                <td><?php echo htmlspecialchars($commande['nom']); ?></td>
                <td><?php echo htmlspecialchars($commande['prix']); ?></td>
                <td><?php echo htmlspecialchars($commande['quantite']); ?></td>
                <td><?php echo htmlspecialchars($commande['envoi'] ? 'Envoyée' : 'Non envoyée'); ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>
        <footer class="page-footer">
        <div class="button-container">
            <a href="../index.php" class="oval-button">Accueil</a>
        
        </div>
    </footer>	    
</body>
</html>
