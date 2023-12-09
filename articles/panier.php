<?php
include('../formulaire/csrf_token.php'); 

if (!isset($_SESSION['client'])) {
    header('Location: ../formulaire/connexion.php'); 
    exit();
}

$panier = isset($_SESSION['panier']) ? $_SESSION['panier'] : array();
require_once('../fichier bd.php');
$bdd = getBD();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Panier</title>
    <link rel="stylesheet" href="../styles/style.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Spectral:wght@200&display=swap" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script type="text/javascript" src="verif_stock.js"></script>

</head>
<body>
<img src="../images/pandouille.png" alt="Logo de mon site web" class="logo">
<div class= "page-accueil">
    <?php
    if (count($panier) == 0) {
       echo" <h1>Votre panier est vide</h1> " ;}
    else{   
    echo"<h1>Contenu de votre panier</h1>";} ?>
    <table>
        <tr>
            <th>Numéro Identifiant</th>
            <th>Nom</th>
            <th>Prix</th>
            <th>Quantité</th>
            <th>Prix Total</th>
        </tr>
        <?php $prixcommande =0 ?>
        <?php foreach ($panier as $article) : ?>
            <tr>
                <td><?php echo $article['id_article']; ?></td>
                <td><?php
                $id_article = $article['id_article'];
                    $query = "SELECT nom FROM articles WHERE id_art = :id_article";
                    $stmt = $bdd->prepare($query);
                    $stmt->bindParam(':id_article', $id_article, PDO::PARAM_INT);
                    $stmt->execute();
                    $result = $stmt->fetch(PDO::FETCH_ASSOC);
                    
                    $article['nom'] = $result ? $result['nom'] : 'Nom non trouvé'; 
                    echo htmlspecialchars($article['nom']);
                    ?></td>
                    

                <td><?php 
                $id_article = $article['id_article'];
                    $query_prix = "SELECT prix FROM articles WHERE id_art = :id_article";
                    $stmt_prix = $bdd->prepare($query_prix);
                    $stmt_prix->bindParam(':id_article', $id_article, PDO::PARAM_INT);
                    $stmt_prix->execute();
                    $result_prix = $stmt_prix->fetch(PDO::FETCH_ASSOC);

                    $article['prix'] = $result_prix ? $result_prix['prix'] : 'Prix non trouvé'; 
                    echo htmlspecialchars($article['prix']);
                    ?></td>
                <td><?php echo htmlspecialchars($article['quantite']); ?></td>
                <td><?php
                
                echo htmlspecialchars($total_prix_article = $article['quantite'] * $article['prix']); 
                $prixcommande+= $total_prix_article;?></td>
            </tr>
        <?php endforeach; ?>
    </table>
    <?php echo"Votre commannde vous coutera : $prixcommande euros"?>

    <form id="connexion_formulaire" method="post" autocomplete="off">
    <input type="hidden" name="panier" value=<?php if (count($panier)>0)echo htmlspecialchars(json_encode($panier)) ?>>
    <input type="hidden" name="csrf_token" id="csrf_token" value=<?php echo $_SESSION['csrf_token'] ?> ><br><br>
    <input  class='oval-button' type="submit" id="verif_stock"  value="Passer la commande">
    </form>

  
        <footer class="page-footer">
        <div class="button-container">
            <a href="../index.php" class="oval-button">Retour</a>
        </div>
    </footer>
    <?php $bdd = null; ?>    
</body>
</html>
