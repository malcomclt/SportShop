<?php
session_start();

if (!isset($_SESSION['client'])) {
    header('Location: ../formulaire/connexion.php'); 
    exit();
}

$panier = isset($_SESSION['panier']) ? $_SESSION['panier'] : array();
require_once('../fichier bd.php');
$bdd = getBD();

?>


<?php $panier_stripe =[];?>
<?php
foreach ($panier as &$article) {
    $id_article = $article['id_article'];
    $query_stripe = "SELECT ID_STRIPE FROM articles WHERE id_art = :id_article";
    $stmt_prix = $bdd->prepare($query_stripe);
    $stmt_prix->bindParam(':id_article', $id_article, PDO::PARAM_INT);
    $stmt_prix->execute();
    $result_stripe = $stmt_prix->fetch(PDO::FETCH_ASSOC);

    $article['ID_STRIPE'] = $result_stripe ? $result_stripe['ID_STRIPE'] : 'Id_Stripe non trouvé'; 
    $panier_stripe[] = ['price' => $article['ID_STRIPE'], 'quantity' => $article['quantite']];
}
unset($article); 

$data = [$_SESSION['client']['ID_STRIPE'], $panier_stripe]?>
</div>


<?php

require_once('../vendor/autoload.php');
require_once('../stripe.php');

$id_user = $data[0];
$liste = $data[1];
error_log($id_user);
// Création de la session de paiement avec Stripe
$checkout_session = $stripe->checkout->sessions->create([
    'customer' => $id_user,
    'success_url' => 'http://localhost/Carlet/articles/acheter.php',
    'cancel_url' => 'http://localhost/Carlet/articles/panier.php',
    'mode' => 'payment',
    'automatic_tax' => ['enabled' => false],
    'line_items' => $liste,
]);

// Redirection vers l'URL de la session de paiement sur Stripe

header("Location: " . $checkout_session->url);


?>    
