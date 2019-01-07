<?php
session_start();
    include('../Login/LoginCheck.php');
    include('../Registrazione/RegistrazioneCheck.php');
    $_SESSION['idp'] = $_GET['idprog'];
    $_SESSION['nomeP'] = $_GET['titolo'];
    $_SESSION['giorno'] = $_GET['day'];
    $_SESSION['mese'] = $_GET['month'];
    $_SESSION['anno'] = $_GET['year'];
    $_SESSION['mailUtenti'] = [];
    $db = pg_connect("host=localhost dbname=ProHive user=Leonardo"); 
    $result = pg_query($db, 'select mail from utente');
    $arrayResult = pg_fetch_all($result);
    $x=0;
    for(; $x < count($arrayResult); $x++){
        array_push($_SESSION['mailUtenti'],$arrayResult[$x]['mail']);
    }
    pg_close($db);
    $valid_session = isset($_SESSION['idSessione']) ? $_SESSION['idSessione'] === session_id() : FALSE;
    if (!$valid_session) {
        echo "<script type='text/javascript'>alert('Stai cercando di visualizzare una pagina non visualizzabile dopo aver effettuato il logout!'); window.location.href='../../index.html';</script>";
        exit();
    }
   
?>  

<html>
    <head>

        <meta charset=“UTF-8”>
        <link href="../bootstrap-3.3.7-dist/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
        <script src="../bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>
        <script src="../AddOns/jquery.min.js"></script>

        <link href="../AddOns/styleProfilo.css" rel="stylesheet">
        <script src="../AddOns/funcProg.js"></script>


        <title>ProHive</title>  
        
        <script type="text/javascript">
        function autocomplete(inp, arr) {
            var currentFocus;
            inp.addEventListener("input", function(e) {
                var a, b, i, val = this.value;
                closeAllLists();
                if (!val) { return false;}
                currentFocus = -1;
                a = document.createElement("DIV");
                a.setAttribute("id", this.id + "autocomplete-list");
                a.setAttribute("class", "autocomplete-items");
                this.parentNode.appendChild(a);
                for (i = 0; i < arr.length; i++) {
                    if (arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
                    b = document.createElement("DIV");
                    b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
                    b.innerHTML += arr[i].substr(val.length);
                    b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
                        b.addEventListener("click", function(e) {
                        inp.value = this.getElementsByTagName("input")[0].value;
                        closeAllLists();
                    });
                    a.appendChild(b);
                    }
                }
            });
            inp.addEventListener("keydown", function(e) {
                var x = document.getElementById(this.id + "autocomplete-list");
                if (x) x = x.getElementsByTagName("div");
                if (e.keyCode == 40) {
                    currentFocus++;
                    addActive(x);
                } else if (e.keyCode == 38) {
                    currentFocus--;
                    addActive(x);
                } else if (e.keyCode == 13) {
                    e.preventDefault();
                    if (currentFocus > -1) {
                    if (x) x[currentFocus].click();
                    }
                }
            });
            function addActive(x) {
                if (!x) return false;
                removeActive(x);
                if (currentFocus >= x.length) currentFocus = 0;
                if (currentFocus < 0) currentFocus = (x.length - 1);
                x[currentFocus].classList.add("autocomplete-active");
            }
            function removeActive(x) {
                for (var i = 0; i < x.length; i++) {
                x[i].classList.remove("autocomplete-active");
                }
            }
            function closeAllLists(elmnt) {
                var x = document.getElementsByClassName("autocomplete-items");
                for (var i = 0; i < x.length; i++) {
                if (elmnt != x[i] && elmnt != inp) {
                x[i].parentNode.removeChild(x[i]);
                }
            }
            }
            document.addEventListener("click", function (e) {
                closeAllLists(e.target);
            });
            }

            function richiestaEliminazione() {
                var checks = document.getElementsByName('ck');
                var rows = document.getElementsByName('rowEsistente');
                var names = [];
                for(var i = 0; i < checks.length; i++){
                    if(checks[i].checked){
                        var currentRow = rows[i];
                        var currenttitle = document.getElementById('nomeFileEsistente'+i).innerHTML;
                        names.push(currenttitle);
                    }
                }

                
                var xhr;
                if (window.XMLHttpRequest) { 
                    xhr = new XMLHttpRequest();
                } else if (window.ActiveXObject) { 
                    xhr = new ActiveXObject("Microsoft.XMLHTTP");
                }
                var data = "idprog="+document.getElementById('idprog').innerHTML + "&nomi=" + names;
                xhr.open("POST", "delete.php", true); 
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

            function richiestaDownload() {
                var checks = document.getElementsByName('ck');
                var rows = document.getElementsByName('rowEsistente');
                var names = [];
                for(var i = 0; i < checks.length; i++){
                    if(checks[i].checked){
                        var currentRow = rows[i];
                        var currenttitle = document.getElementById('nomeFileEsistente'+i).innerHTML;
                        names.push(currenttitle);
                    }
                }

                
                var xhr;
                if (window.XMLHttpRequest) { 
                    xhr = new XMLHttpRequest();
                } else if (window.ActiveXObject) { 
                    xhr = new ActiveXObject("Microsoft.XMLHTTP");
                }

                for(var j = 0; j < names.length; j++){
                    var data = "idprog="+document.getElementById('idprog').innerHTML + "&name=" + names[j];
                    xhr.open("POST", "download.php", true);
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
            }

            function sendAlert(){
                var retVal = confirm("Sei sicuro di voler eliminare i membri selezionati?");
                if(retVal == true){return richiestaMembri();}
                else return false;
                }

            function calcolaScadenza(anno, mese, giorno) {
                var dataScad = new Date(anno, mese -1, giorno);
                var today = new Date();
                var diff = dataScad.getTime() - today.getTime();
                days= Math.ceil(diff/86400000);
                daysNeg = Math.floor(diff/86400000)+1;
                if (days>0){
                    document.getElementById("scadenza").innerHTML=days+' giorni mancanti';
                }
                else if (daysNeg<0){
                    document.getElementById("scadenza").innerHTML='Scaduto da '+Math.abs(daysNeg)+' giorni';
                }
                else {
                    document.getElementById("scadenza").innerHTML='Progetto scaduto oggi';
                }
                if ((diff)<=0){
                    document.getElementById("scadenza").setAttribute('style','font-size:17px; margin:0px; top:13px; color:#d9534f');
                }
                else if ((diff)<604800000 && (diff)>0){
                   document.getElementById("scadenza").setAttribute('style','font-size:17px; margin:0px; top:13px; color:#f0ad4e');
                }
                else {
                    document.getElementById("scadenza").setAttribute('style','font-size:17px; margin:0px; top:13px; color:#5cb85c');
                }
            }


            function richiestaMembri() {
                var checks = document.getElementsByName('part');
                var mails = [];
                for(var i = 0; i < checks.length; i++){
                    if(checks[i].checked){
                        var currenttitle = document.getElementById('mailPart'+i).innerHTML;
                        mails.push(currenttitle);
                    }
                }
                var xhr;
                if (window.XMLHttpRequest) { 
                    xhr = new XMLHttpRequest();
                } else if (window.ActiveXObject) { 
                    xhr = new ActiveXObject("Microsoft.XMLHTTP");
                }
                var data = "idprog="+document.getElementById('idprog').innerHTML + "&mails=" + mails;
                xhr.open("POST", "cancellaMembri.php", true); 
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
            var listaMail = <?php echo '["' . implode('", "', $_SESSION['mailUtenti']) . '"]' ?>;
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
                        <div class="btn btn-sm navbar-btn glyphicon glyphicon-arrow-left" onclick = "window.location.href = '../Profilo/Profilo.php'"></div>
                        <ul class="nav navbar-nav navbar-right">
                        <li class="navbar-text collapse navbar-collapse no-hover" id="scadenza"></li>
                        <li><a onclick="return curtainUtente();" id="userButton"><span class="glyphicon glyphicon-user" style="margin:1px"></span></a></li>
                          <li class="navbar-text collapse navbar-collapse no-hover" style="font-size:17px; margin:0px; top:13px">Benvenuto, <?php echo($_SESSION['utenteNome']);?>!</li>
                          <li><a href="../Profilo/Logout.php"><span class="glyphicon glyphicon-log-in" style="margin:1px"></span></a></li>
                        </ul>
                      </div>
                    </div>
                  </nav>
                  <p id='changeResult'></p>
                  <p hidden id="idprog"><?php echo $_SESSION['idp']?> </p>
                  
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
                        <h3 style='text-align:center'>Made by: Francesca Fiani e Leonardo Campitelli</h3>
                        <h3 style='text-align:center'>Contatti: fiani.1760333@studenti.uniroma1.it, campitelli.1765175@studenti.uniroma1.it</h3>
                        <h3 style='text-align:center'>Vuoi lasciarci un feedback sulla tua esperienza?</h3>
                        <form action="feedback.php" target="_self" method="POST">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Scrivi qui il tuo feedback (massimo 500 caratteri)" size="500" name="feedback" required>
                            </div>
                            <button type="submit" class="btn btn-primary btn-lg login-button" name="mandaFeedback"> Manda il tuo Feedback
                        </form>
                    </div>
                </section>
            </div>
        </div>

        <div class="container">
            <div class="row">
                <section class="content">
                    <div id="myCurtainPartecipanti" class="overlayMenu">
                    <div class="btn btn-sm navbar-btn glyphicon glyphicon-envelope pull-left" onclick="return curtainPartecipanti();" id="partecipantiButton"></div>
                    <h2 style="text-align:center; ">Partecipanti</h2>
                    <div class='overlayMenu-content'>
                        
                        <?php //script stampa partecipanti

                            $conn = pg_connect("host=localhost dbname=ProHive user=Leonardo"); 
                            $query = "select u.nome, u.cognome, u.mail, a.admin
                                      from utente u join appartenenza a on a.mail = u.mail
                                      where idprog = " . $_SESSION['idp'] ." order by a.admin desc, u.cognome";
                            $res = pg_query($conn, $query);
                            
                            $queryforAdmin = "select a.admin from appartenenza a where a.idprog = $1 and a.mail = $2";
                            $resAdmin = pg_query_params($conn, $queryforAdmin, array($_SESSION['idp'], $_SESSION['utenteMail']));
                            $isAdmin = pg_fetch_result($resAdmin, 'admin');

                            if(!$res) {pg_close($conn);}
                            else {
                                $arrayResult = pg_fetch_all($res);
                                $x = 0;
                                $color;
                                echo "<table class='table table-filter'>" ;
                                for(; $x < count($arrayResult); $x++){
                                    if(intval($arrayResult[$x]['admin']) == 1) $color = "#2BBCDE;";
                                    else $color = "black;";
                                    echo "<tr name='rigaPart'><td>";
                                    if($isAdmin == 1) {
                                        echo "<div class='ckboxPart' id='ckBox".$x."'><input name='part' type='checkbox' id='part".$x."'><label for='part".$x."'></label></div></td><td>";
                                        echo '<script> document.getElementById("part'.$x.'").setAttribute("onclick", "eliminaMembri();");</script>'; 
                                        if($arrayResult[$x]['mail']==$_SESSION['utenteMail']){
                                            echo "<script>document.getElementById('ckBox".$x."').setAttribute('style', 'visibility:hidden;');</script>";
                                        }
                                    }
                                    echo "<h4 style='text-align:center;color:".$color."'>".$arrayResult[$x]['nome']. " " . $arrayResult[$x]['cognome']."</h4>";
                                    echo "<h4 style='text-align:center;color:".$color."'><p id='mailPart".$x."'>".$arrayResult[$x]['mail']."</p></h4>";
                                    echo "</td></tr>";
                                }
                                echo "</table>";
                                if($isAdmin){
                                    echo '<input type="button" value="Cancella Partecipanti" id="elimButton" style="display:none;" name="elimButton"  class="btn btn-primary btn-lg" onclick="return sendAlert();"><br>';
                                }

                                if($isAdmin==1){    //Posso inserire membri 
                                   echo "<form autocomplete='off' target='_self' method='POST' action='aggiungiMembri.php'>";
                                   echo "<h3> Aggiungi un membro al progetto o cambia il suo ruolo</h3></br>";
                                   echo "<div class='autocomplete'>";
                                   echo "<input type='mail' name='mailDaAgg' id='mailDaAgg' class='form-control' placeholder='Inserisci la mail del tuo collega' size='40' required></input>";
                                   echo "</div><br><br>";
                                   echo "<input type='radio' name='admin' value='admin'>  Amministratore &nbsp &nbsp &nbsp &nbsp</input><input type='radio' name='admin' value='nonAdmin'>  Non Amministratore</input><br>";
                                   echo "<div style=' margin:0 auto; display:block;'><button type='submit' class='btn btn-primary btn-lg login-button' style='left:0%' id='modificaBtn'>Modifica Membri</div>";
                                   echo "</form>";
                                }
                                pg_close($conn);
                            }
                            echo "<script>autocomplete(document.getElementById('mailDaAgg'),listaMail);</script>";
                        ?>
                        
                        </div>
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
                  

                    <h1 class="small-text" style="color:rgb(250, 250, 250); font-family:inherit; left:6%"><?php echo $_SESSION['nomeP']; ?></h1>
                    <div class="col-md-8 col-md-offset-2">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="pull-left">
                                    <div class="btn-group">
                                <!-- QUI VA BOTTONE ELIMINA SELEZIONATI,-->
                                        <input type="button" value="Elimina Selezionati" id="deleteButton" style="display:none;" name="deleteButton"  class="btn btn-primary btn-filter" onclick="var retVal = confirm('Sei sicuro di voler cancellare i file selezionati?');if(retVal == true){return richiestaEliminazione();}else return false;">
                                    </div>
                                </div>
                                
                                    <table class="table table-filter">
                                        <tbody id='table'>
                                        <?php           //caricamento file pre-esistenti
                                                            $conn = pg_connect("host=localhost dbname=ProHive user=Leonardo");
                                                            $querySel = "select * from files where idprog = $1";
                                                            $res = pg_query_params($conn, $querySel, array($_SESSION['idp']));
                                                            $fileArray = pg_fetch_all($res);
                                                            echo "<script type='text/javascript'>calcolaScadenza(".$_SESSION['anno'].", ".$_SESSION['mese'].", ".$_SESSION['giorno'].");</script>";
                                                            
                                                            if($fileArray == false) {} //Handles empty rows

                                                            else {
                                                                for($x = 0; $x < count($fileArray); $x++) {
                                                                    echo "<tr name='rowEsistente' data-status='' id='row".$x."'>";
                                                                    echo "<td>";
                                                                    echo "<div class='ckbox'>";
                                                                    echo "<input name='ck' type='checkbox' id='checkbox".$x."'>";
                                                                    echo "<label for='checkbox".$x."' ></lable>";
                                                                    echo "</div>";
                                                                    echo "</td>";
                                                                    echo "<td>";
                                                                    echo "</td>";
                                                                    echo "<td>";
                                                                    echo "<div class='media'>";
                                                                    echo "<a href='#' class='pull-left'>";
                                                                    echo "<img src='../AddOns/file.png' class='media-photo'>";
                                                                    echo "</a>";
                                                                    echo "<div class='media-body'>";
                                                                    echo "<span class='media-meta pull-right'>" . $fileArray[$x]['uploaded'] ."</span>";
                                                                    echo "<h4 class='title'><a id='nomeFileEsistente" . $x . "' href='download.php?name=" . $fileArray[$x]['nome'] . "&idprog=" . $_SESSION['idp'] . "'>" . $fileArray[$x]['nome'] . "</a></h4>";
                                                                    echo "<p class='summary'>" . round($fileArray[$x]['dim']/1024,2) . " KB</p>";
                                                                    echo "</div></div>";
                                                                    echo "</td></tr>";
                                                                    echo '<script> document.getElementById("checkbox'.$x.'").setAttribute("onclick", "selezioneElimina();");</script>';
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
                                                         <span class="media-meta">
                                                             <table>
                                                                <form target="_self" action="carica.php" method="POST" enctype="multipart/form-data" name="formAdd"> 
                                                                <h4 class="title">Carica un File</h4>
                                                                <input type="file" name="fileToUpload" id="fileToUpload" required>
                                                                <div style="text-align: center;"><button type="submit" class="btn btn-default btn-filter" name="carica">Carica</div>
                                                                <form>
                                                            </table>
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
                <script> </script>
            </div>
        </div>
    </body>
</html>