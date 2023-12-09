<?php
session_start();
if (!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
    echo json_encode($_POST['csrf_token']);
    exit;
}

require_once('../fichier bd.php');
require_once('../vendor/autoload.php');
require_once('../stripe.php');

function emailExisteDeja($email) {
    try {
        $bdd = getBD();
        $sql = "SELECT COUNT(*) FROM Clients WHERE mail = :email";
        $stmt = $bdd->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $count = $stmt->fetchColumn();
        $bdd = null;
        return $count > 0;
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
        return false; 
    }
}


function enregistrer($nom, $prenom, $adresse, $mail, $numero, $mdp) {
    try {
        $customer = \Stripe\Customer::create([
            'email' => $mail,
        ]);
        $stripeCustomerId = $customer->id;
        $mdp_hash = password_hash($mdp, PASSWORD_DEFAULT);
        $bdd = getBD();
        $sql = "INSERT INTO Clients (nom, prenom, adresse, mail, numero, mdp, ID_STRIPE) VALUES (:nom, :prenom, :adresse, :mail, :numero, :mdp, :ID_STRIPE)";
        $stmt = $bdd->prepare($sql);
        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':prenom', $prenom);
        $stmt->bindParam(':adresse', $adresse);
        $stmt->bindParam(':mail', $mail);
        $stmt->bindParam(':numero', $numero);
        $stmt->bindParam(':mdp', $mdp_hash);
        $stmt->bindParam(':ID_STRIPE', $stripeCustomerId);
        $stmt->execute();
        $bdd = null;
        echo "success"; // Ajout du point-virgule
    } catch (PDOException $e) {
        $errorMessage = "Erreur lors de la création du compte : " . $e->getMessage();
        error_log($errorMessage, 0); // Enregistrement dans le fichier de log
        echo "Une erreur est survenue lors de la création du compte."; // Message générique
    }
}

// Assurez-vous que les données sont récupérées de manière sécurisée avant de les utiliser
if (
    isset($_POST['n'], $_POST['p'], $_POST['adr'], $_POST['mail'], $_POST['num'], $_POST['mdp1'], $_POST['mdp2']) &&
    $_POST['mdp1'] === $_POST['mdp2'] &&
    !emailExisteDeja($_POST['mail'])
) {
    enregistrer(htmlspecialchars($_POST['n']), htmlspecialchars($_POST['p']), htmlspecialchars($_POST['adr']), htmlspecialchars($_POST['mail']), htmlspecialchars($_POST['num']), htmlspecialchars($_POST['mdp1']));
}

?>
