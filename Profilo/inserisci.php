<?php
    if(isset($_POST['aggiungi'])){
    include ("Profilo.php");
    
    $db = pg_connect("host=localhost dbname=ProHive user=Leonardo");
    $query = "insert into progetto values ($1, $2, $3, $4)";
    $queryID = "select max(idprog) as idprog from appartenenza";
    $resID = pg_query($db, $queryID);
    $ID = intval(pg_fetch_result($resID, 'idprog')) +1 ;
    $params = array($_POST['nomeProg'], $_POST['descProg'], $ID, $_POST['dataScad']);
    $resIns = pg_query_params($db, $query, $params);
    $finalquery = "insert into appartenenza values ($1, $2, $3)";
    pg_query_params($db, $finalquery, array($_SESSION['utenteMail'], $ID, 1));

    echo "<script>window.location.href = 'Profilo.php';</script>";  
    pg_close($db);

    }

    else echo "<script>window.location.href = 'Profilo.php';</script>";  
?>