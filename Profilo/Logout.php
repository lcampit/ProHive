<?php 
    session_start();
    session_unset();
    session_destroy();
    header('Location: ../../index.html');
    die("Redirecting to: ../../index.html");
?>