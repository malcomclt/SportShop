<?php

include('../formulaire/csrf_token.php'); 

if (!isset($_SESSION['client']) ) {
    exit();
}
?>

<html>
<head>
    <meta charset="UTF-8">
    <title>Chat</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" src="app_message.js"></script>
    
    <link href="https://fonts.googleapis.com/css2?family=Spectral:wght@200&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="../styles/style.css">
</head>
<body class ="chat_body">
    <header class="chat_titre">
        <h1>Chat mon poto</h1>
    </header>
   <section class="chat">
    <div class="messages">
    </div>
    <div class="user-inputs">
        <form action="bd_message.php?task=write" method="POST" >
        <input type="hidden" name="id_client" id="id_client" value = <?php echo $_SESSION["client"]["id_client"] ?>>
        <input type="text" name="content" id="content" placeholder="Entre ton message ?">
        <input type="hidden" name="csrf_token" value=<?php echo $_SESSION['csrf_token'] ?> >
        <button type ="submit"> Send !</button>
        </form>
    </div>

   </section>
    
</body>
</html>
