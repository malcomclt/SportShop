$(document).ready(function() {

    // Fonction pour valider l'email
    function validateEmail(email) {
        var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email)) {
            return { isValid: false, message: 'Veuillez saisir une adresse email valide.' };
        }
        var isValid = false;
        var message = '';
    
        $.ajax({
            url: 'verif_email.php',
            method: 'POST',
            async: false, // Attend la réponse de la requête avant de continuer
            data: { email: email },
            success: function(response) {
                isValid = (response === 'false'); // 'false' signifie que l'e-mail n'existe pas
                if (!isValid) {
                    message = 'Cette adresse e-mail existe déjà.';
                }
            },
            error: function() {
                message = 'Erreur lors de la vérification de l\'adresse e-mail.';
            }
        });
    
        return { isValid: isValid, message: message };
    }

    // Fonction pour valider le mot de passe
    function validatePassword(password) {
        var passwordRegex = /^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/;
        return passwordRegex.test(password);
    }
    function validatePhone(phone) {
        var phoneRegex = /^\+?[0-9]{3,}$/; // Expression régulière pour un numéro de téléphone de base (au moins 3 chiffres)
        return phoneRegex.test(phone);
    }
    

    // Fonction pour mettre à jour la validation
    function updateValidation(inputField, isValid, message) {
        var validationSpan = inputField.next('.validation');
        validationSpan.text(message);
        if (isValid) {
            inputField.removeClass('invalid').addClass('valid');
        } else {
            inputField.removeClass('valid').addClass('invalid');
        }
    }

    // Vérification en temps réel à chaque changement dans les champs
    $('input[type="text"], input[type="password"]').on('input', function() {
        var inputField = $(this);
        var fieldValue = inputField.val();

        var fieldName = inputField.attr('name');
        var isValid = true;
        var message = '';

        switch (fieldName) {
            case 'num':
                isValid = validatePhone(fieldValue);
                message = isValid ? '' : 'Veuillez saisir un numéro de téléphone valide.';
                break;
            case 'mail':
                var emailValidation = validateEmail(fieldValue);
                isValid = emailValidation.isValid;
                message = emailValidation.message;
                break;
            case 'mdp1':
                isValid = validatePassword(fieldValue);
                message = isValid ? '' : 'Le mot de passe doit contenir au moins 8 caractères, dont au moins une lettre, un chiffre et un caractère spécial.';
                break;
            case 'mdp2':
                var password1 = $('input[name="mdp1"]').val();
                isValid = (fieldValue === password1);
                message = isValid ? '' : 'Les mots de passe ne correspondent pas.';
                break;
            default:
                isValid = fieldValue.trim() !== '';
                message = isValid ? '' : 'Ce champ est requis.';
                break;
        }

        updateValidation(inputField, isValid, message);
        var allFieldsValid =($('.invalid').length === 0);
        $('#submitButton').prop('disabled', !allFieldsValid); // Activation/Désactivation du bouton submit 
    });

    // Empêcher la soumission du formulaire si des champs sont invalides
    $('#nouveau_formulaire').submit(function(event) {
        event.preventDefault(); // Empêche la soumission classique du formulaire
        var csrfToken = $('#csrf_token').val();
        // Récupération des données du formulaire
        var formData = $(this).serialize();
        formData += '&csrf_token=' + encodeURIComponent(csrfToken);


        // Appel AJAX
        $.ajax({
            url: 'enregistrement.php',
            method: 'POST',
            data: formData,
            success: function(response) {
                // Gestion de la réponse
                if (response === 'success') {
                    $('#message').text('Compte créé avec succès. Redirection vers l\'accueil...');
                    $('#message').css('color', 'green');
                    $('#message').css('display', 'block');
                    
                    $.ajax({
                        
                        url: 'connecter.php',
                        method: 'POST',
                        data: formData,
                        async:true,
                        success: function(response) {
                       
                    

                            if (response === 'success') {
                                setTimeout(function() {
                                    window.location.href = '../index.php'; // Redirection vers la page d'accueil
                                }, 1000);
                            } else {
                                
                                $('#message').text('Erreur lors de la connexion du compte.');
                                $('#message').css('color', 'red');
                                $('#message').css('display', 'block');
                            }
                            
                        },
                        error:function(){
                            
                            
                        }
                    
                    });
                    
                    
                } else {
                    $('#message').text(response);
                    $('#message').css('color', 'red');
                    $('#message').css('display', 'block');
                }
            }
        });
    });
});