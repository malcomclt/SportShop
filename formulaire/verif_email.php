<?php
require_once('../fichier bd.php');

try {
    $email = $_POST['email']; // Récupération de l'e-mail envoyé par la requête AJAX

    $bdd = getBD();
    $sql = "SELECT COUNT(*) FROM Clients WHERE mail = :email";
    $stmt = $bdd->prepare($sql);
    $stmt->bindParam(':email', $email); // Liaison de la valeur de l'e-mail à la requête SQL
    $stmt->execute();
    $count = $stmt->fetchColumn();
    $bdd = null;

    echo $count > 0 ? 'true' : 'false'; // Renvoi 'true' si l'e-mail existe, sinon 'false'
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
    return false;
}
?>
