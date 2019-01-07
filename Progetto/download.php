<?php
    session_start();
    $conn = pg_connect("host=localhost dbname=ProHive user=Leonardo");
    $query = "select a from files where nome = $1 and idprog = $2";
    $res = pg_query_params($conn, $query, array($_GET['name'], $_GET['idprog']));
    if(!$res) echo "error during query";
    $toDownload = pg_fetch_result($res, 0, 'a');
    $data = pg_unescape_bytea($toDownload);

    $openedFile = fopen($_GET['name'], 'w');
    fwrite($openedFile, $data);
    fclose($openedFile);

    header('Content-Description: File Transfer');
    header("Content-Disposition: attachment; filename=" . $_GET['name'] . "");
    header("Content-Length: " . filesize($_GET['name']));
    header("Content-Type: application/octet-stream;");
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    ob_clean();
    flush();

    readfile($_GET['name']);

    unlink($_GET['name']);
    pg_close($conn);
    exit();
?>