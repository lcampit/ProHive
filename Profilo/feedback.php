<?php
    if(isset($_POST['mandaFeedback'])){
        include("Profilo.php");
        include('../Login/LoginCheck.php');
        include('../Registrazione/RegistrazioneCheck.php');
        $feedback = $_POST['feedback'];
        $conn= pg_connect("host=localhost dbname=ProHive user=Leonardo");
        $queryIns = "insert into feedback values ($1)";
        pg_query_params($conn, $queryIns, array($feedback));
        unset($_POST['mandaFeedback']);
        pg_close($conn);
        echo "<script>alert('Feedback inviato correttamente'); window.location.href='Profilo.php'</script>";
    }

?>