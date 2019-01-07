<?php
    session_start();

    $id = $_POST['idprog'];
    $arMails = explode(',', $_POST['mails']);
    $x = 0;
    $countCanceled = 0;
    $conn = pg_connect("host=localhost dbname=ProHive user=Leonardo");
    for(; $x < count($arMails); $x++){
        $current = trim($arMails[$x]);
        if($_SESSION['utenteMail'] != $current) {       //Non ci si può cancellare da soli così
        $query = "delete from appartenenza where idprog = $1 and mail = $2";
        $res = pg_query_params($conn, $query, array($id, $current));
        if(!$res) echo 'There was a problem deleting members';
        else $countCanceled++;
        }
    }
    echo 'Membri Cancellati: '.$countCanceled;
?>