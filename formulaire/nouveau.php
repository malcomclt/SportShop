<?php
include('../formulaire/csrf_token.php'); 

if (isset($_SESSION['client'])) {
    header('Location:../index.php');
}

?>

<html>
<head>
<title>Nouveau Client</title>
<link rel="stylesheet" href="../styles/style.css">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Spectral:wght@200&display=swap" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script type="text/javascript" src="nouveau.js"></script>

</head>
<body>
<img src="../images/pandouille.png" alt="Logo de mon site web" class="logo">

<div class="page-nouveau">
<h1> Nouveau Client </h1>  
<div class="container">
<form  method="post" id="nouveau_formulaire" autocomplete="off">
<p>
Nom :
<input type="text" name="n" value=""required/>
<span class="validation"></span>
</p>

<p>
Prénom :
<input type="text" name="p" value=""required/>
<span class="validation"></span>
</p>

<p>
Adresse :
<input type="text" name="adr" value=""required/>
<span class="validation"></span>
</p>

<p>
Numéro de Téléphone :
<input type="text" name="num" value=""required/>
<span class="validation"></span>
</p>

<p>
Adresse e-mail :
<input type="text" name="mail" value=""required/>
<span class="validation"></span>
</p>

<p>
Mot de passe :
<input type="password" name="mdp1" value=""required/>
<span class="validation"></span>
</p>

<p>
Confirmer votre mot de passe :
<input type="password" name="mdp2" value=""required class="invalid"/>
<span class="validation"></span>
</p>

<p>
<button type="submit" id="submitButton" disabled> Envoyer </button>
</p>
<input type="hidden" name="csrf_token" id="csrf_token" value=<?php echo $_SESSION['csrf_token'] ?> >
</form>
<div id="message" ></div>
</div>
</div>

<footer class="page-footer">
        <div class="button-container">
			<a href="../index.php" class="oval-button">Retour</a>
        </div>
    </footer>
</body>
</html>