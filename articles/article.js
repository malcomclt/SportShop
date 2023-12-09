$(document).ready(function() {


    $('#ajout_article').submit(function(event) {
        event.preventDefault(); // Empêche la soumission classique du formulaire
        var csrfToken = $('#csrf_token').val();
        // Récupération des données du formulaire
        var formData = $(this).serialize();
        formData += '&csrf_token=' + encodeURIComponent(csrfToken);

        // Appel AJAX
        $.ajax({
            url: 'ajouter.php',
            method: 'POST',
            data: formData,
            success: function(response) {
                
                // Gestion de la réponse
                var test = document.getElementById ("test");
                test.innerHTML = (response);
                if (response === 'success' || response === 'success1') {

                    setTimeout(function() {
                        window.location.href = 'panier.php'; 
                    }, 1000);
                } else {

                }
            }
        });
    });

});