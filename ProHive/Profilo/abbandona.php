<?php
    $roba = $_POST['titoli'];
    $mail = trim($_POST['mail']);
    $daUccidere = explode(',', $roba);
    $db = pg_connect("host=localhost dbname=ProHive user=Leonardo");
    $countMale = 0;
    $countAbbandonati = 0;
    for($x = 0; $x<count($daUccidere); $x++){
        $current = trim($daUccidere[$x]);
        $queryForAdmin = 'select a.idprog, admin from appartenenza a join progetto p on a.idprog = p.idprog where mail = $1 and p.nomeprogetto = $2';
        $res = pg_query_params($db, $queryForAdmin, array($mail, $current));
        if(!$res) echo 'Error during query';
        $rows = pg_fetch_row($res);
        $queryCheck = "select count(*) from appartenenza where idprog = $1 and admin=1";
        $id = $rows[0];
        $r = pg_query_params($db, $queryCheck, array($id));
        $count=intval(pg_fetch_result($r, 'count'));
        if($count==1){  //Does Nothing
            $countMale++;
        }
        else{
        //Abbandono il progetto
        $countAbbandonati++;
        $queryForAbandon = "delete from appartenenza where idprog = $1 and mail = $2";
        pg_query_params($db, $queryForAbandon, array($id, $mail));
        }
        }
    echo "Progetti Abbandonati: " . $countAbbandonati . " Progetti non abbandonabili: " . $countMale;
    pg_close($db);
?>