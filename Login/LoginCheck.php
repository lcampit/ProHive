<?php
    if(!isset($_SESSION)) {
        session_start();
    }
	if(isset($_POST['submit'])) {
        $_SESSION['idSessione'] = session_id();
		$db = pg_connect("host=localhost dbname=ProHive user=Leonardo");
		$mail = strtolower($_POST['mail']);
		$query = 'select mail from utente where mail = $1';
            
        $result = pg_query_params($db, $query, array($mail));
            
        if(!$result) echo("Errore ricerca mail");
            
        $gotted = pg_fetch_result($result, 'mail');
            
        if($gotted == null) {	 //Utente non Registrato
            echo "<script>alert('Non sei registrato! Registrati!'); window.location.href = '../Registrazione/Registrazione.html';</script>";  
		}
        else {  //Verifica l'accesso e apri pagina profilo
            $queryControl = 'select * from utente where mail = $1';
            $resControl = pg_query_params($db, $queryControl, array($mail));
                    
            if(!$resControl) echo("Errore Controllo");
            $res=pg_fetch_row($resControl);
            if($res[3] == md5($_POST['pass'])) {
                $nome = pg_fetch_result($resControl, 'nome');
                $cognome =  pg_fetch_result($resControl, 'cognome');
                $_SESSION['utenteMail'] = $_POST['mail'];
                $_SESSION['utenteNome'] = $res[0];
                $_SESSION['utentePass'] = md5($_POST['pass']);
                $_SESSION['utenteCognome'] = $res[1];
                pg_close($db);
                echo "<script> window.location.href = '../Profilo/Profilo.php';</script>";  
                //Apri pagina profilo utente
            }

            else {
                pg_close($db);
                    echo "<script> alert('Mail o Password sono stati inseriti incorrettamente'); window.location.href = 'Login.html';</script>"; 

            }
	    }
    }
?>	