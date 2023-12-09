<?php
session_start();
if (!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
    header("Location: ../mechant.html");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['panier'])) {
        $panier = json_decode($_POST['panier'],true);
        if (is_null($panier)){
            echo "Panier Vide";
            exit;
        }
        // Vérification de la disponibilité de chaque article dans le panier
        $disponibilite = verifierDisponibilitePanier($panier); // Fonction à implémenter
        if ($disponibilite) {
            echo 'success';
        } else {
            echo 'Pas assez de produits en stock, Sportshop vous présente leurs excuses.';
        }
    }
}

// Fonction pour vérifier la disponibilité de chaque article dans le panier
function verifierDisponibilitePanier($panier) {
    require_once('../fichier bd.php');
    $bdd = getBD();
    for($i = 0; $i<count($panier); $i++){
        $article_id = $panier[$i]["id_article"];
        $quantide_id = $panier[$i]["quantite"];
        $query = "SELECT quantite FROM articles WHERE id_art = $article_id";
        $stmt = $bdd->prepare($query);
        $stmt->execute();
        $results = $stmt->fetch();
        if ($results[0] < $quantide_id){
            $bdd = null;
            return FALSE;
        }

    }
    return TRUE;


    
}
?>
