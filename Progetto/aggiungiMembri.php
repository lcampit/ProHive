<?php
    session_start();
    $mail = strtolower($_POST['mailDaAgg']);
    $id = $_SESSION['idp'];
    $admin = $_POST['admin'] == 'admin' ? 1 : 0;
    if($_SESSION['utenteMail'] == $mail) {
        echo "<script>alert('Non è possibile modificare il proprio ruolo');</script>";
        echo "<script>window.location.href = 'Progetto.php?titolo=". $_SESSION['nomeP'] . "&idprog=" . $_SESSION['idp'] ."&day=".$_SESSION['giorno']."&month=".$_SESSION['mese']."&year=".$_SESSION['anno']."';</script>";
    }
    else {
    $conn = pg_connect("host=localhost dbname=ProHive user=Leonardo");
    $queryForCheck = "select mail from utente where mail=$1";
    $res = pg_query_params($conn, $queryForCheck, array($mail));
    $mailOtt = pg_fetch_result($res, 'mail');
    if($mail != $mailOtt) {
        pg_close($conn);
        echo "<script>alert('L\'Utente selezionato non è iscritto al sistema');</script>";
        echo "<script>window.location.href = 'Progetto.php?titolo=". $_SESSION['nomeP'] . "&idprog=" . $_SESSION['idp'] ."&day=".$_SESSION['giorno']."&month=".$_SESSION['mese']."&year=".$_SESSION['anno']."';</script>";
    }
    else{
        $queryForAlreadyin = "select mail, admin from appartenenza where mail = $1 and idprog = $2";
        $resAlready = pg_query_params($conn, $queryForAlreadyin, array($mail, $id));
        $mailIns = pg_fetch_result($resAlready, 'mail');
        if($mailIns == $mail){
            $adminIns = pg_fetch_result($resAlready,'admin');
            if($adminIns != $admin){
                $q = "update appartenenza set admin = $1 where (idprog = $2 and mail = $3)";
                pg_query_params($conn, $q, array($admin, $_SESSION['idp'], $mailIns));
                echo "<script>alert('Cambio effettuato con successo');</script>";
                pg_close($conn);
                echo "<script>window.location.href = 'Progetto.php?titolo=". $_SESSION['nomeP'] . "&idprog=" . $_SESSION['idp'] ."&day=".$_SESSION['giorno']."&month=".$_SESSION['mese']."&year=".$_SESSION['anno']."';</script>";
            }
            else {
            pg_close($conn);
            echo "<script>alert('L\'Utente selezionato partecipa già al progetto nel ruolo indicato');</script>";
            echo "<script>window.location.href = 'Progetto.php?titolo=". $_SESSION['nomeP'] . "&idprog=" . $_SESSION['idp'] ."&day=".$_SESSION['giorno']."&month=".$_SESSION['mese']."&year=".$_SESSION['anno']."';</script>";
            }
        }
        else {
            $queryForInsert = "insert into appartenenza values ($1, $2, $3)";
            pg_query_params($conn, $queryForInsert, array($mail, $id, $admin));
            pg_close($conn);
            echo "<script>alert('Inserimento eseguito con successo');</script>";
            echo "<script>window.location.href = 'Progetto.php?titolo=". $_SESSION['nomeP'] . "&idprog=" . $_SESSION['idp'] ."&day=".$_SESSION['giorno']."&month=".$_SESSION['mese']."&year=".$_SESSION['anno']."';</script>";
        }
    }
}
?>