<?php
session_start();


if (isset($_SESSION['client'])) {

    session_destroy();
}


header('Location: ../index.php');
exit;
?>
