<?php
include('../formulaire/csrf_token.php'); 
if(isset($_SESSION['client'])){
    header("Location: ../index.php");
    exit;
}

?>


<html>
<head>
<title>Connexion</title>
<link rel="stylesheet" href="../styles/style.css">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link href="https://fonts.googleapis.com/css2?family=Spectral:wght@200&display=swap" rel="stylesheet">
<script type="text/javascript" src="connexion.js"></script>

</head>
<body>
<img src="../images/pandouille.png" alt="Logo de mon site web" class="logo">

<div class="page-nouveau">
<h1> Se connecter </h1>  

<div class="container">
<form id="connexion_formulaire" method="post" autocomplete="off">
<p>
Adresse e-mail :
<input type="text" name="mail" value="<?php echo isset($_GET['mail']) ? $_GET['mail'] : ''; ?>" required/>
</p>
<p>
Mot de passe :
<input type="password" name="mdp1" value="" required/>
</p>
<p>
<input type="submit" id="submitButtonConnexion" disabled value="Connexion">
</p>
<input type="hidden" name="csrf_token" id="csrf_token" value=<?php echo $_SESSION['csrf_token'] ?> ><br><br>
</form>

</div>
<div id="message" ></div>
<p id="test">  </p>
</div>

<footer class="page-footer">
        <div class="button-container">
			<a href="../index.php" class="oval-button">Retour</a>
            <a href="nouveau.php" class="oval-button">S'inscrire</a>
        </div>
    </footer>
</body>
</html>