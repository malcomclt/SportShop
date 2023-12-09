function getMessages(){
    // Requete ajax pour connecter au serveur et fichier php
    const requeteAjax = new XMLHttpRequest();
    requeteAjax.open("GET", "bd_message.php")

    
    // Reception données, traite avec JSON et affiche en HTML
    requeteAjax.onload =function(){
        const resultat = JSON.parse(requeteAjax.responseText);
        const html = resultat.reverse().map(function(message){
            return `
            <div class="message">
                <span class="date">${message.date_time.substring(11,16)}</span>
                <span class="author">${message.nom_client}</span> dit :         
                <span class="content">${message.content}</span>
            </div>         
            `
            
        }).join('');

        const messages = document.querySelector('.messages');
        messages.innerHTML=html;
        messages.scrollTop = messages.scrollHeight;

    }


    // Envoie Requete

    requeteAjax.send();

}
// Envoie message et rafraichir les messages

function postMessage(event){
    // Stoper le submit du formulaire
    event.preventDefault();

    // Recup donnée formulaire

    const id_client = document.querySelector("#id_client");
    const content = document.querySelector("#content");


    // Contitionner les données

    const data = new FormData();
    data.append("id_client", id_client.value);
    data.append("content", content.value);
    
    // Configurer requete ajax en POST et envoyer les données

    const requeteAjax = new XMLHttpRequest();
    requeteAjax.open("POST","bd_message.php?task=write");

    requeteAjax.onload = function(){
        content.value="";
        content.focus();
        getMessages();
    }


    requeteAjax.send(data);
    
}
function deleteOldMessages(){
   
    const requeteAjax = new XMLHttpRequest();
    requeteAjax.open("GET", "bd_message.php?task=delete");
    
    requeteAjax.onload = function(){
        const response = JSON.parse(requeteAjax.responseText);
        if(response.status === "success") {
            console.log("Suppression des messages plus anciens que 10 minutes effectuée avec succès !");
        } else {
            console.error("Une erreur s'est produite lors de la suppression des messages.");
        }
    }
    
    requeteAjax.send();
}




$(document).ready(function() {


    document.querySelector("form").addEventListener("submit", postMessage);
    const interval = window.setInterval(getMessages, 3000); 
    const interval_delete = window.setInterval(deleteOldMessages, 3000); 
    // Pas forcèment la meilleur utilisation si il y a bcp d'utilisateur. 
    //Juste simulation temps réel.
    getMessages();
    deleteOldMessages();
})