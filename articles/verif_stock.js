$(document).ready(function() { 
    $('#connexion_formulaire').on('submit', function(event) {
        event.preventDefault(); // Empêche la soumission classique du formulaire
        var csrfToken = $('#csrf_token').val();
        // Récupération des données du formulaire
        var formData = $(this).serialize();
        formData += '&csrf_token=' + encodeURIComponent(csrfToken);
        $.ajax({
            url: 'verif_stock.php',
            method: 'POST',
            data: formData,
            success: function(response) {
                if (response === 'success') {
                    setTimeout(function() {
                        window.location.href = 'commande.php'; 
                    }, 1000);
                } else {
                    alert(response);
                }
            }
        });
    });
});
