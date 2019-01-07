<?php
    if(!isset($_SESSION)) {
		session_start();
	}
	if(isset($_POST['inviaReg'])) {
		$_SESSION['idSessione'] = session_id();
		$db = pg_connect("host=localhost dbname=ProHive user=Leonardo");
		$mail = strtolower($_POST['mail']);
		$query = 'select mail from utente where mail = $1';
		$result = pg_query_params($db, $query, array($mail));
		if(!$result) echo("Errore result");

		$gotted = pg_fetch_result($result, 'mail');
		if($gotted != null) {	 //utente già registrato
			pg_close($db);
            echo '<script>
                    alert("Utente già registrato, Accedi");
                    window.location.href = "../Login/Login.html";
                </script>';
        }
		else {  //Aggiorna database e apri pagina profilo
			$queryAgg = 'insert into utente values ($1, $2, $3, $4)';
			$resAgg = pg_query_params($db, $queryAgg, array($_POST['nome'], $_POST['cognome'], $mail, md5($_POST['pass1'])));
			if(!$resAgg) echo('Errore aggiunta account');
            echo '<script> alert("Account Creato Correttamente!" </script>';
			$_SESSION['utenteNome'] = $_POST['nome'];
			$_SESSION['utenteCognome'] = $_POST['cognome'];
			$_SESSION['utentePass'] = md5($_POST['pass1']);
			$_SESSION['utenteMail'] = $mail;
			pg_close($db);
			echo '<script>
				 window.location.href = "../Profilo/Profilo.php";
				 </script>';
		} 
	}
?>