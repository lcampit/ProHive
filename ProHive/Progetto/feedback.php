<?php
session_start();
    if(isset($_POST['mandaFeedback'])){
        include('../Login/LoginCheck.php');
        include('../Registrazione/RegistrazioneCheck.php');
        $feedback = $_POST['feedback'];
        $conn= pg_connect("host=localhost dbname=ProHive user=Leonardo");
        $queryIns = "insert into feedback values ($1)";
        pg_query_params($conn, $queryIns, array($feedback));
        unset($_POST['mandaFeedback']);
        pg_close($conn);
        echo "<script>alert('Feedback inviato correttamente'); window.location.href='Progetto.php?titolo=". $_SESSION['nomeP'] . "&idprog=" . $_SESSION['idp'] ."&day=".$_SESSION['giorno']."&month=".$_SESSION['mese']."&year=".$_SESSION['anno']."'</script>";
    }

?>