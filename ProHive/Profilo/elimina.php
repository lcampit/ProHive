<?php
    $roba = $_POST['titoli'];
    $mail = trim($_POST['mail']);
    $daUccidere = explode(',', $roba);
    $db = pg_connect("host=localhost dbname=ProHive user=Leonardo");
    $countEliminati = 0;
    $countAbbandonati = 0;
    for($x = 0; $x<count($daUccidere); $x++){
        $current = trim($daUccidere[$x]);
        $queryForAdmin = 'select a.idprog, admin from appartenenza a join progetto p on a.idprog = p.idprog where mail = $1 and p.nomeprogetto = $2';
        $res = pg_query_params($db, $queryForAdmin, array($mail, $current));
        if(!$res) echo 'Error during query';
        $rows = pg_fetch_row($res);
        if($rows[1] == 1){       //cancello il progetto dal database se admin
            $id = $rows[0];
            $queryForDeleteApp = 'delete from appartenenza where idprog = $1';
            pg_query_params($db, $queryForDeleteApp, array($id));
            $queryForDeleteProg = 'delete from progetto where idprog = $1';
            pg_query_params($db, $queryForDeleteProg, array($id));
            $countEliminati++;
            $queryForFiles = "delete from files where idprog = $1";
            pg_query_params($db, $queryForFiles, array($id));
        }
        else {      //Abbandono il progetto
            $countAbbandonati++;
            $id = $rows[0];
            $queryForAbandon = "delete from appartenenza where idprog = $1 and mail = $2";
            pg_query_params($db, $queryForAbandon, array($id, $mail));
        }
    }
    pg_close($db);
    echo 'Progetti Abbandonati: ' . $countAbbandonati . ' Progetti Eliminati: ' . $countEliminati;
?>