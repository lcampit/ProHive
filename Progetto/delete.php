<?php
    $roba = $_POST['nomi'];
    $idprog = trim($_POST['idprog']);
    $daUccidere = explode(',', $roba);
    $db = pg_connect("host=localhost dbname=ProHive user=Leonardo");
    $countEliminati = 0;
    for($x = 0; $x<count($daUccidere); $x++){
        $current = trim($daUccidere[$x]);
        $query = 'delete from files where nome = $1 and idprog = $2';
        $res = pg_query_params($db, $query, array($current, $idprog));
        if(!$res) echo 'Error during query';
        $countEliminati++;
    }
    pg_close($db);
    echo 'File Eliminati: ' . $countEliminati;
    
?>