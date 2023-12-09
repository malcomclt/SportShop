$(document).ready(function() {

    function validateEmail(email, callback) {
        var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email)) {
            callback({ isValid: false, message: 'Veuillez saisir une adresse email valide.' });
        } else {
            $.ajax({
                url: 'verif_email.php',
                method: 'POST',
                data: { email: encodeURIComponent(email) },
                success: function(response) {
                    var isValid = (response === 'false'); // 'false' signifie que l'e-mail n'existe pas
                    var message = isValid ? '' : 'Cette adresse e-mail existe déjà.';
                    callback({ isValid: isValid, message: message });
                },
                error: function() {
                    callback({ isValid: false, message: 'Erreur lors de la vérification de l\'adresse e-mail.' });
                }
            });
        }
    }
    function validatePassword(password) {
        var passwordRegex = /^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/;
        return passwordRegex.test(password);
    }

    function updateValidation(inputField, isValid, message) {
        var validationSpan = inputField.next('.validation');
        validationSpan.text(message);
        if (isValid) {
            inputField.removeClass('invalid').addClass('valid');
        } else {
            inputField.removeClass('valid').addClass('invalid');
        }
    }

    $('input[type="text"], input[type="password"]').on('input', function() {
        var inputField = $(this);
        var fieldValue = inputField.val();
        var fieldName = inputField.attr('name');

        switch (fieldName) {

            case 'mail':
                validateEmail(fieldValue, function(emailValidation) {
                    updateValidation(inputField, emailValidation.isValid, emailValidation.message);
                });
                break;
            case 'mdp1':
                var isValid = true;
                updateValidation(inputField, isValid, message);
                break;

            default:
                var isValid = fieldValue.trim() !== '';
                var message = isValid ? '' : 'Ce champ est requis.';
                updateValidation(inputField, isValid, message);
                break;
        }
        
        var allFieldsValid = ($('.invalid').length === 0); // Vérifie s'il y a des champs invalides
   
        $('#submitButtonConnexion').prop('disabled', !allFieldsValid); // Activation/Désactivation du bouton submit
    });

    $('#connexion_formulaire').submit(function(event) {
        event.preventDefault(); // Empêche la soumission classique du formulaire
        var csrfToken = $('#csrf_token').val();
        // Récupération des données du formulaire
        var formData = $(this).serialize();
        formData += '&csrf_token=' + encodeURIComponent(csrfToken);
        // Appel AJAX
        $.ajax({
            url: 'connecter.php',
            method: 'POST',
            data: formData,
            success: function(response) {
                // Gestion de la réponse
                var test = document.getElementById ("test");
                test.innerHTML = (response);
                if (response === 'success') {
                    $('#message').text('Compte connecté avec succès. Redirection vers l\'accueil...');
                    $('#message').css('color', 'green');
                    $('#message').css('display', 'block');
                    setTimeout(function() {
                        window.location.href = '../index.php'; // Redirection vers la page d'accueil
                    }, 1000);
                } else {
                    $('#message').text('Erreur lors de la connexion du compte.');
                    $('#message').css('color', 'red');
                    $('#message').css('display', 'block');
                }
            }
        });
    });




});
