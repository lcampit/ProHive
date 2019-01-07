<?php
    if(isset($_POST['cambiaPassword'])){
        include("Profilo.php");
        include('../Login/LoginCheck.php');
        include('../Registrazione/RegistrazioneCheck.php');
        $vecchiaPass = $_POST['vecchiaPass'];
        $nuovaPass = $_POST['nuovaPass'];
        
        if(md5($vecchiaPass) != $_SESSION['utentePass']) {
            echo "<script>alert('Password Errata')</script>";
        }
        else {
            $conn= pg_connect("host=localhost dbname=ProHive user=Leonardo");
            $queryDel = "delete from utente where pass = $1";
            pg_query_params($conn, $queryDel, array(md5($vecchiaPass)));
            $queryIns = "insert into utente values ($1, $2, $3, $4)";
            pg_query_params($conn, $queryIns, array($_SESSION['utenteNome'], $_SESSION['utenteCognome'], strtolower($_SESSION['utenteMail']), md5($nuovaPass)));
            $_SESSION['utentePass'] = md5($nuovaPass);
            pg_close($conn);
            echo "<script>alert('Cambio Password eseguito correttamente'); window.location.href='Profilo.php'</script>";
        }
    }
    else echo "<script>window.location.href = 'Profilo.php';</script>";  
?>
