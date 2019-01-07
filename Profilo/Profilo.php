<?php
    include('../Login/LoginCheck.php');
    include('../Registrazione/RegistrazioneCheck.php');
    $valid_session = isset($_SESSION['idSessione']) ? $_SESSION['idSessione'] === session_id() : FALSE;
    if (!$valid_session) {
        echo "<script type='text/javascript'>alert('Stai cercando di visualizzare una pagina non visualizzabile dopo aver effettuato il logout!'); window.location.href='../../index.html';</script>";
        exit();
    }
?>  

<html>
    <head>
        <meta charset="UTF-8">
        <link href="../bootstrap-3.3.7-dist/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
        <script src="../bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>
        <script src="../AddOns/jquery.min.js"></script>

        <link href="../AddOns/styleProfilo.css" rel="stylesheet">
        <script src="../AddOns/funcProf.js"></script>
        

        <title>ProHive</title>  
        
        <script type="text/javascript">
            function richiestaEliminazione() {
                var checks = document.getElementsByName('ck');
                var rows = document.getElementsByName('rowEsistente');
                var titles = [];
                for(var i = 0; i < checks.length; i++){
                    if(checks[i].checked){
                        var currentRow = rows[i];
                        var currenttitle = document.getElementById('nomeProgEsistente'+i).innerHTML;
                        titles.push(currenttitle);
                    }
                }
                
                var xhr;
                if (window.XMLHttpRequest) { 
                    xhr = new XMLHttpRequest();
                } else if (window.ActiveXObject) { 
                    xhr = new ActiveXObject("Microsoft.XMLHTTP");
                }
                var data = "mail="+document.getElementById('mailUt').innerHTML + "&titoli=" + titles;
                xhr.open("POST", "elimina.php", true); 
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");                  
                xhr.send(data);
	            xhr.onreadystatechange = display_data;
	            function display_data() {
	                if (xhr.readyState == 4) {
                        if (xhr.status == 200) {
                            alert(xhr.responseText);	   
                            window.location.reload();
                        } else {
                            alert('There was a problem with the request.');
                        }
                    }
	            }
            }

            function richiestaAbbandono(){
                var checks = document.getElementsByName('ck');
                var rows = document.getElementsByName('rowEsistente');
                var titles = [];
                for(var i = 0; i < checks.length; i++){
                    if(checks[i].checked){
                        var currentRow = rows[i];
                        var currenttitle = document.getElementById('nomeProgEsistente'+i).innerHTML;
                        titles.push(currenttitle);
                    }
                }

                
                var xhr;
                if (window.XMLHttpRequest) { 
                    xhr = new XMLHttpRequest();
                } else if (window.ActiveXObject) { 
                    xhr = new ActiveXObject("Microsoft.XMLHTTP");
                }
                var data = "mail="+document.getElementById('mailUt').innerHTML + "&titoli=" + titles;
                xhr.open("POST", "abbandona.php", true); 
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");                  
                xhr.send(data);
	            xhr.onreadystatechange = display_data;
	            function display_data() {
	                if (xhr.readyState == 4) {
                        if (xhr.status == 200) {
                            alert(xhr.responseText);	   
                            window.location.reload();
                        } else {
                            alert('There was a problem with the request.');
                        }
                    }
	            }
            }
        </script>

    </head>

    <body>
            <nav class="navbar navbar-default">
                    <div class="container-fluid">
                    <div><img class="media" src="../AddOns/LogoProHiveV3.png" style="float:left; width:7%; margin:4px"></div>
                    <div class="collapse navbar-collapse" id="myNavbar">
                        <div class="btn btn-sm navbar-btn glyphicon glyphicon-lock pull-left" onclick="return curtainPass();" id="menuButton"> </div>
                        <div class="btn btn-sm navbar-btn glyphicon glyphicon-plus" onclick="return insertProject();" id="plusButton"></div>
                        <div class="btn btn-sm navbar-btn glyphicon glyphicon-refresh" onclick="window.location.reload()"></div>
                        <div class="btn btn-sm navbar-btn glyphicon glyphicon-info-sign pull-left" onclick="return curtainOptions();" id="optionsButton"></div>
                        <ul class="nav navbar-nav navbar-right">
                          <li><a onclick="return curtainUtente();" id="userButton"><span class="glyphicon glyphicon-user" style="margin:1px"></span></a></li>
                          <li class="navbar-text collapse navbar-collapse no-hover" style="font-size:17px; margin:0px; top:13px">Benvenuto, <?php echo($_SESSION['utenteNome']);?>!</li>
                          <li><a href="Logout.php"><span class="glyphicon glyphicon-log-in" style="margin:1px"></span></a></li>
                        </ul>
                      </div>
                    </div>
                  </nav>
                  <p id='changeResult'></p>
                  <p hidden id="mailUt"><?php echo $_SESSION['utenteMail']?> </p>
                  
        <div class="container">
            <div class="row">
                <section class="content">
                    <div id="myCurtainPass" class="overlay">
                        <h1>Cambia la tua password</h1>
                        <form action="cambia.php" target="_self" method="POST">
                            <div class="small-text">Inserisci la vecchia password:</div>
                            <div class="input-group">
                                <input type="password" class="form-control" placeholder="Vecchia password ..." size="20" name="vecchiaPass">
                            </div>
                            <div class="small-text">Inserisci la nuova password:</div>
                            <div class="input-group">
                                <input type="password" class="form-control" placeholder="Nuova password ..." size="20" name="nuovaPass">
                            </div>
                            <button type="submit" class="btn btn-primary btn-lg login-button" name="cambiaPassword"> Cambia la password
                        </form>
                    </div>
                </section>
            </div>
        </div>

        <div class="container">
            <div class="row">
                <section class="content">
                    <div id="myCurtainOption" class="overlay">
                        <h1>Info sugli sviluppatori</h1>
                        <h3 style='text-align:center'>Made by: Francesca Fiani e Leonardo Campitelli </h3>
                        <h3 style='text-align:center'>Contatti: fiani.1760333@studenti.uniroma1.it, campitelli.1765175@studenti.uniroma1.it</h3>
                        <h3 style='text-align:center'>Vuoi lasciarci un feedback sulla tua esperienza?</h3>
                        <form action="feedback.php" target="_self" method="POST">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Scrivi qui il tuo feedback (massimo 500 caratteri)" size="500" name="feedback" required>
                            </div>
                            <button type="submit" class="btn btn-primary btn-lg login-button" name="mandaFeedback" value="mandaFeedback"> Manda il tuo Feedback
                        </form>
                    </div>
                </section>
            </div>
        </div>

        <div class="container">
            <div class="row">
                <section class="content">
                    <div id="myCurtainUtente" class="overlay" style="left:50%">
                        <h1>Informazioni Utente</h1>
                        <h3 style='text-align:center'>Nome Utente: <?php echo($_SESSION['utenteNome']);?></h3>
                        <h3 style='text-align:center'>Cognome Utente: <?php echo($_SESSION['utenteCognome']);?></h3>
                        <h3 style='text-align:center'>Mail Utente: <?php echo($_SESSION['utenteMail']);?></h3>
                        <h3 style='text-align:center'>Progetti di cui fai parte:  <?php $db = pg_connect("host=localhost dbname=ProHive user=Leonardo"); 
                            $result = pg_query_params($db, 'select count(*) from progetto p join appartenenza a on a.idprog=p.idprog where a.mail=$1', array($_SESSION['utenteMail']));
                            $row = pg_fetch_row($result);
                            echo($row[0]);
                            pg_close($db);
                            ?>
                        </h3>
                        <h3 style='text-align:center'>Progetti di cui sei amministratore: <?php $db = pg_connect("host=localhost dbname=ProHive user=Leonardo"); 
                            $result = pg_query_params($db, 'select count(*) from progetto p join appartenenza a on a.idprog=p.idprog where a.admin=1 AND a.mail=$1', array($_SESSION['utenteMail']));
                            $row = pg_fetch_row($result);
                            echo($row[0]);
                            pg_close($db);
                            ?></h3>
                    </div>
                    
                    <h1 class="small-text" style="color:rgb(250, 250, 250); font-family:inherit; left:6%">Resoconto dei progetti</h1>
                    <div class="col-md-8 col-md-offset-2">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="pull-right">
                                    <div class="btn-group">
                                        <button type="button" id='buttCorso' class="btn btn-success btn-filter" data-target="incorso">In Corso</button>
                                        <button type="button" id='buttScadenza' class="btn btn-warning btn-filter" data-target="inscadenza">In Scadenza</button>
                                        <button type="button" id='buttScaduti' class="btn btn-danger btn-filter" data-target="scaduti">Scaduti</button>
                                        <button type="button" id='buttAll' class="btn btn-default btn-filter" data-target="all">Tutti</button>
                                    </div>
                                </div>
                                <!-- QUI VA BOTTONE ELIMINA SELEZIONATI--> 
                                <div class="btn-group pull-left">
                                    <input type="button" value="Elimina Selezionati" id="deleteButton" style="display:none;" name="deleteButton"  class="btn btn-primary btn-filter" onclick="var retVal = confirm('Sei sicuro di voler cancellare/abbandonare i progetti selezionati?');if(retVal == true){return richiestaEliminazione();}else return false;">
                                    <input type="button" value="Abbandona Selezionati" id="abbandonaButton" style="display:none;" name="deleteButton"  class="btn btn-primary btn-filter" onclick="var retVal = confirm('Sei sicuro di voler abbandonare i progetti selezionati?');if(retVal == true){return richiestaAbbandono();}else return false;">
                                </div>
                                    <table class="table table-filter">
                                        <tbody id='table'>
                                        <?php           //caricamento progetti pre-esistenti
                                                            $conn = pg_connect("host=localhost dbname=ProHive user=Leonardo");
                                                            $querySel = "select u.nome, p.nomeprogetto, p.idprog, p.scadenza, p.descrizione
                                                                        from utente u, appartenenza a, progetto p
                                                                        where  $1 = a.mail AND a.idprog=p.idprog AND u.mail = a.mail";
                                                            $res = pg_query_params($conn, $querySel, array($_SESSION['utenteMail']));
                                                            $progArray = pg_fetch_all($res);
                                                            
                                                            if($progArray == false) {} //Handles empty rows

                                                            else {
                                                                for($x = 0; $x < count($progArray); $x++) {
                                                                    $parse = explode('/', $progArray[$x]['scadenza']);
                                                                    $year = $parse[2];
                                                                    $month = $parse[1] ;
                                                                    $day = $parse[0];
                                                                    $rowDaAgg = '<tr name="rowEsistente" data-status="" id="row'.$x.'"> 
                                                                    <td>
                                                                    <div class="ckbox">
                                                                    <input name="ck" type="checkbox" id="checkbox' . $x . '">
                                                                    <label for="checkbox' . $x . '"></label>
                                                                    </div>
                                                                    </td>
                                                                    <td>
                                                                    </td>
                                                                    <td> 
                                                                    <div class="media">
                                                                    <a href="#" class="pull-left">
                                                                    <img src="../AddOns/project.png" class="media-photo">
                                                                    </a>
                                                                    <div class="media-body">
                                                                    <span class="media-meta pull-right">' . $progArray[$x]['scadenza'] . '</span>
                                                                    <h4 class="title"><a href="../Progetto/Progetto.php?titolo='. $progArray[$x]['nomeprogetto'] .'&idprog='. $progArray[$x]['idprog'].'&day='.$day.'&month='.$month.'&year='.$year.'" id="nomeProgEsistente'.$x.'">' . $progArray[$x]['nomeprogetto'] . '</a>
                                                                    <span class="pull-right" id="flag' . $x . '"></span>
                                                                    </h4>
                                                                    <p class="summary">' . $progArray[$x]["descrizione"] . '</p>
                                                                    </div>
                                                                    </div>
                                                                    </td>
                                                                    </tr>
                                                                    <script> calcolaStatus(' . $year . ',' . $month . ',' . $day. ','.$x.' );</script>';
                                                                    
                                                                    echo($rowDaAgg);
                                                                }
                                                            pg_close($conn);
                                                            }

                                            ?>
                                            
                                             <tr data-status="" id="rowAgg" style="display:none;">
                                             <td></td>
                                             <td></td>
                                             <td>
                                                 <div class="media">
                                                     <div class="media-body">
                                                     <form target="_self" method="POST" name='formInserisci' action="inserisci.php" onsubmit="return checkProgInfo();"> 
                                                         <span class="media-meta pull-right">
                                                                <h4 class="title">Inserisci la data di scadenza</h4>
                                                                <input type="text" id="dataScad" name="dataScad" size="40" pattern="^[0-9]{1,2}\/[0-9]{1,2}\/[0-9]{4}">
                                                                </br></br>
                                                                <div style="text-align: center;"><button type="submit" class="btn btn-default" name="aggiungi">Aggiungi</div>
                                                        </span>
                                                            <h4 class="title">Nuovo Progetto &nbsp &nbsp</h4>
                                                            <input type="text" id="nomeProg" size="40" name="nomeProg">
                                                            <p class="title">Descrizione &nbsp &nbsp &nbsp &nbsp &nbsp</p>
                                                            <input type="text" id="descProg" size="40" name="descProg">
                                                        </form>
                                                    </div>
                                                </div>
                                            </td>
                                             </tr>
                                            <!--Tabella vista dei progetti dell'utente, con varie opzioni-->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="content-footer">
                        </div>
                    </div>
                </section>
                
            </div>
        </div>
    </body>
</html>