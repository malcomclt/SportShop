<?php
session_start(); 

require_once('../fichier bd.php');
if (!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
    header("Location: ../mechant.html");
    exit;
}

if (isset($_POST['mail']) && isset($_POST['mdp1'])) {
    $mail = $_POST['mail'];
    $mdp = $_POST['mdp1'];


    
        $bdd = getBD();
        $sql = "SELECT * FROM Clients WHERE mail = :mail";
        $stmt = $bdd->prepare($sql);
        $stmt->bindParam(':mail', $mail);
        $stmt->execute();
        $client = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($client && password_verify($mdp, $client['mdp'])) { 
            $client_info = array(
                'id_client' => $client['id_client'],
                'nom' => $client['nom'],
                'prenom' => $client['prenom'],
                'mail' => $client['mail'],
                'adresse' => $client['adresse'],
                'ID_STRIPE' => $client['ID_STRIPE'],
                
            );
    
        
            $_SESSION['client'] = $client_info;
            echo"success";
        } 
        else {

            echo "Probleme connexion";
        }

}
else {
    echo "Probleme connexion";
}
$bdd = null;
?>
