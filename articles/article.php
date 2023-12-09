<?php
include('../formulaire/csrf_token.php'); 
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">

  <title>SportShop</title>
  <link rel="stylesheet" href="../styles/style.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Spectral:wght@200;300&display=swap" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script type="text/javascript" src="article.js"></script>
</head>

<body>
<?php

$articleId = $_GET['id'];
if(!(is_numeric($articleId) && (int)$articleId == $articleId)){
  header("Location: ../index.php");
  exit;
}
require_once('../fichier bd.php');
$bdd = getBD();
$query = "SELECT * FROM articles WHERE id_art = $articleId";
$stmt = $bdd->prepare($query);
$stmt->execute();
$results = $stmt->fetch();
$bdd = null;

if (!$results){
  header("Location: ../index.php");
  exit;
}
$quantitePanier = 0;
if(isset($_SESSION['panier'])){
  foreach ($_SESSION['panier'] as $article) {
    if ($article['id_article'] == $articleId) {
        $quantitePanier = $article['quantite'];
        break;
    }
  }
}



?>
<img src="../images/pandouille.png" alt="Logo de mon site web" class="logo">

<h1 id="name-article"> <?php echo htmlspecialchars($results['nom']); ?> </h1>

<div class= "page-article">
<div><img id="picture-article" src=<?php echo $results['url_photo']; ?> alt="Image du Maillot"></div>
<div>
<?php
$description = $results['description'];
$quantite = $results['quantite'];
$elements = explode(',', $description);
?>

        <ul>
		<?php foreach ($elements as $element): ?>
        <li><?php echo trim($element); ?></li>
		<?php endforeach; ?>
        </ul>
		
<p>Tailles Disponibles : </p>		
	<table>
    <tbody>
      <tr>
        <td>S</td>
        <td>M</td>
        <td>L</td>
        <td>XL</td>
      </tr>
    </tbody>
  </table>
  <form id="ajout_article" method="post">
        <input type="hidden" name="article_id" value="<?php echo $articleId; ?>">
        <label for="quantite">Quantité :</label>
        <input type="number" name="quantite" id="quantite" min="1" max="<?php echo $quantite-$quantitePanier; ?>" required>
        <input type="hidden" name="csrf_token" id="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
        <input type="submit" value="Ajouter au panier">
    </form>
    <div id="test"> </div>


</div>	
</div>
    <footer class="page-footer">
        <div class="button-container">
            <a href="../index.php" class="oval-button">Retour</a>
        </div>
    </footer>	

</body>
</html>
