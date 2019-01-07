<?php
        session_start();
        date_default_timezone_set('Europe/Rome');
        $up = date("d/m/Y - G:i");
        $idprog = $_SESSION['idp']; 
        $nomeFile = $_FILES['fileToUpload']['name'];
        $conn = pg_connect("host=localhost dbname=ProHive user=Leonardo");
        $data = file_get_contents($_FILES['fileToUpload']['tmp_name']);
        $escaped = pg_escape_bytea($data);
        $query = "insert into files values ($1, $2, $3, $4, $5)";
        $res = pg_query_params($conn, $query, array($nomeFile, $idprog, $escaped, $_FILES['fileToUpload']['size'], $up));
        pg_close($conn);
        echo "<script>window.location.href = 'Progetto.php?titolo=". $_SESSION['nomeP'] . "&idprog=" . $_SESSION['idp'] ."&day=".$_SESSION['giorno']."&month=".$_SESSION['mese']."&year=".$_SESSION['anno']."';</script>";

?>