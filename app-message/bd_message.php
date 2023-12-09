<?php
session_start();

require_once('../fichier bd.php');
$bdd = getBD();
$task = "list";


if(array_key_exists("task", $_GET)){
    $task=$_GET['task'];
}

if($task == "write"){
    postMessage();
}
elseif($task == "delete"){
    deleteOldMessages();
}
else{
    getMessages();
}


function getMessages(){
    global $bdd;
    #On requete la base de donnée pour avoir les messages

    $resultats = $bdd->query("SELECT messages.*, clients.nom AS nom_client
    FROM messages
    JOIN clients ON messages.id_client = clients.id_client
    ORDER BY messages.date_time DESC");
    #On traite les messages

    $messages = $resultats->fetchall(PDO::FETCH_ASSOC);
        // Échappement des caractères spéciaux dans chaque message
    foreach ($messages as &$message) {
        $message['nom_client'] = htmlspecialchars($message['nom_client'], ENT_QUOTES, 'UTF-8');
        $message['content'] = htmlspecialchars($message['content'], ENT_QUOTES, 'UTF-8');
        // Ajoutez d'autres champs à échapper si nécessaire
    }

    #On affiche les données sous forme JSON
    echo json_encode($messages);
}

function postMessage(){
    global $bdd;
    #Analyser les paramètres en POST (id_client, content)

    if(!array_key_exists("id_client", $_POST)|| !array_key_exists("content", $_POST)){
        echo json_encode(["status"=> "error", "message"=>"Probleme envoie message"]);
        return;
    }

    $id_client = $_POST["id_client"];
    $content = $_POST["content"];
    #Requete pour insérer les données

    $query= $bdd->prepare("INSERT INTO messages SET id_client = :id_client, content = :content, date_time = NOW()");
    $query->execute([
        "id_client" =>$id_client,
        "content" =>$content,
    ]);

    #Donner un statut un succes ou d'erreur au format JSON

    echo json_encode(["status"=> "success"]);
    
}
function deleteOldMessages(){
    global $bdd;

    // Date et heure actuelle moins 10 minutes
    $duree = strtotime('-10 minutes');

    $query= $bdd->prepare("DELETE FROM messages WHERE date_time < DATE_SUB(NOW(), INTERVAL 10 MINUTE)");
    $query->execute();

    echo json_encode(["status"=> "success"]);


}





?>