<?php
$verif = FALSE;
session_start();
require_once('../fichier bd.php');
// Fonction pour vérifier si une chaîne est un entier positif
function estEntierPositif($valeur)
{
    return preg_match('/^[1-9][0-9]*$/', $valeur);
}



// Vérification des données reçues
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        header("Location: ../mechant.html");
        exit;
    }
    // Vérification de la validité des données
    if (
        isset($_POST['article_id']) &&
        isset($_POST['quantite']) &&
        estEntierPositif($_POST['article_id']) &&
        estEntierPositif($_POST['quantite'])
    ) {
        // Récupération des données du formulaire
        $articleId = $_POST['article_id']; // Récupérer l'ID de l'article
        $quantiteDemandee = $_POST['quantite']; // Récupérer la quantité demandée
        $bdd = getBD();
        $query = "SELECT * FROM articles WHERE id_art = $articleId";
        $stmt = $bdd->prepare($query);
        $stmt->execute();
        $results = $stmt->fetch();
        $bdd = null;

        // Vérifier si la requête a retourné des résultats
        if (!$results) {
            // L'article avec l'ID renseigné n'existe pas dans la base de données
            echo 'L\'article demandé n\'existe pas.';
            exit; // Arrêter le script ici ou gérer la suite du code en conséquence
        }
        $quantiteStock = $results['quantite'];

        $articleDansPanier = false;
        if (isset($_SESSION['panier'])) {
            foreach ($_SESSION['panier'] as $article) {
                if ($article['id_article'] == $articleId) {
                    $articleDansPanier = true;
                    break;
                }
            }
        }

        if ($articleDansPanier) {

            foreach ($_SESSION['panier'] as &$article) {
                if ($article['id_article'] == $articleId) {
                    $quantiteTotale = $article['quantite'] + $quantiteDemandee;
                    // Vérification si la quantité totale ne dépasse pas la quantité en stock
                    if ($quantiteTotale <= $quantiteStock) {
                        $verif = TRUE;
                        
                    } else {
                        // Tu peux ajouter ici un message d'erreur indiquant que la quantité dépasse le stock
                        echo 'La quantité demandée dépasse la quantité en stock.';
                    }
                    break;
                }
            }
        } else {
            // Si l'article n'est pas dans le panier, l'ajouter
            if ($quantiteDemandee <= $quantiteStock) {
                $verif = TRUE;
            }
            else{
                echo "Quantité trop grande";
            }
        }
    } else {
        // Si les données reçues ne sont pas valides, retourner une erreur
        echo 'Données invalides';
    }
}
else {
    // Si la méthode de requête n'est pas POST, retourner une erreur
    echo 'Méthode non autorisée';
}
if($verif){
    if (!isset($_SESSION['panier'])) {
        $_SESSION['panier'] = array(
            array(
                'id_article' => $_POST['article_id'], 
                'quantite' => $_POST['quantite'],
                
            )
        );
        echo "success";
    } else {
        for($i = 0; $i<count($_SESSION['panier']); $i++){
            if ($_SESSION['panier'][$i]["id_article"] == $_POST['article_id']){
                $_SESSION['panier'][$i]["quantite"] += $_POST['quantite'];
                echo "success1";
                exit;
            }

        }
    
        $nouvel_article = array(
            'id_article' => $_POST['article_id'],
            'quantite' => $_POST['quantite']
        );
        $_SESSION['panier'][] = $nouvel_article;
        echo "success";
    }
}    

?>
