$(document).ready(function () {

	$('.star').on('click', function () {
      $(this).toggleClass('star-checked');
    });

    $('.ckbox label').on('click', function () {
      $(this).parents('tr').toggleClass('selected');
    });

    $('.ckboxPart label').on('click', function () {
      $(this).parents('tr').toggleClass('selected');
    });
 });

var clicksPass=1;
var clicksAdd=1;
var clicksOption = 1;
var clicksUtente = 1;
var clicksPartecipanti = 1;

function curtainPass () {
  if (clicksOption%2==0 || clicksUtente%2==0 || clicksAdd==2||clicksPartecipanti%2==0){}
  else{
    clicksPass += 1;
    if (clicksPass%2==0) {
      var allchecks = document.getElementsByName('ck');
      var i = 0;
      var n = allchecks.length;
      for(; i < n; i++){
        allchecks[i].disabled=true;
      }
      $('.ckbox label').off('click');
      return openCurtainPass();
    }
    else {
      var allchecks = document.getElementsByName('ck');
      var i = 0;
      var n = allchecks.length;
      for(; i < n; i++){
        allchecks[i].disabled=false;
      }
      $('.ckbox label').on('click', function () {
        $(this).parents('tr').toggleClass('selected');
      });
      return closeCurtainPass();
    }
    document.getElementById("clicksPass").innerHTML = clicksPass;
    }
}

function curtainOptions () {
  if(clicksPass%2==0 || clicksUtente%2==0 || clicksAdd==2 || clicksPartecipanti%2==0){}
  else{
    clicksOption += 1;
    if (clicksOption%2==0) {
      var allchecks = document.getElementsByName('ck');
      var i = 0;
      var n = allchecks.length;
      for(; i < n; i++){
        allchecks[i].disabled=true;
      }
      $('.ckbox label').off('click');
      return openCurtainOptions();
    }
    else {
      var allchecks = document.getElementsByName('ck');
      var i = 0;
      var n = allchecks.length;
      for(; i < n; i++){
        allchecks[i].disabled=false;
      }
      $('.ckbox label').on('click', function () {
        $(this).parents('tr').toggleClass('selected');
      });
      return closeCurtainOptions();
    }
    document.getElementById("clicksOption").innerHTML = clicksOption;
    
  }
}

function curtainUtente () {
  if (clicksPass%2==0 || clicksOption%2==0 || clicksAdd==2||clicksPartecipanti%2==0){}
  else{
    clicksUtente += 1;
    if (clicksUtente%2==0) {
      var allchecks = document.getElementsByName('ck');
      var i = 0;
      var n = allchecks.length;
      for(; i < n; i++){
        allchecks[i].disabled=true;
      }
      $('.ckbox label').off('click');
      return openCurtainUtente();
    }
    else {
      var allchecks = document.getElementsByName('ck');
      var i = 0;
      var n = allchecks.length;
      for(; i < n; i++){
        allchecks[i].disabled=false;
      }
      $('.ckbox label').on('click', function () {
        $(this).parents('tr').toggleClass('selected');
      });
      return closeCurtainUtente();
    }
    document.getElementById("clicksUtente").innerHTML = clicksUtente;
 
  }
}

function curtainPartecipanti () {
  if (clicksOption%2==0 || clicksUtente%2==0 || clicksAdd==2||clicksPass%2==0){}
  else{
    clicksPartecipanti += 1;
    if (clicksPartecipanti%2==0) {
      var allchecks = document.getElementsByName('ck');
      var i = 0;
      var n = allchecks.length;
      for(; i < n; i++){
        allchecks[i].disabled=true;
      }
      $('.ckbox label').off('click');
      return openCurtainPartecipanti();
    }
    else {
      var allchecks = document.getElementsByName('ck');
      var i = 0;
      var n = allchecks.length;
      for(; i < n; i++){
        allchecks[i].disabled=false;
      }
      $('.ckbox label').on('click', function () {
        $(this).parents('tr').toggleClass('selected');
      });
      return closeCurtainPartecipanti();
    }
    document.getElementById("clicksPartecipanti").innerHTML = clicksPartecipanti;
    }
}

function openCurtainOptions() {
  document.getElementById("myCurtainOption").style.border = "1px solid rgb(130, 130, 130)";
  document.getElementById("myCurtainOption").style.height = "55%";
}

function closeCurtainOptions() {
  document.getElementById("myCurtainOption").style.height = "0%";
  document.getElementById("myCurtainOption").style.border = "0px";
}

function openCurtainPass() {
  document.getElementById("myCurtainPass").style.border = "1px solid rgb(130, 130, 130)";
  document.getElementById("myCurtainPass").style.height = "50%";
}

function closeCurtainPass() {
  document.getElementById("myCurtainPass").style.height = "0%";
  document.getElementById("myCurtainPass").style.border = "0px";
}

function openCurtainUtente() {
  document.getElementById("myCurtainUtente").style.border = "1px solid rgb(130, 130, 130)";
  document.getElementById("myCurtainUtente").style.height = "45%";
}

function closeCurtainUtente() {
  document.getElementById("myCurtainUtente").style.height = "0%";
  document.getElementById("myCurtainUtente").style.border = "0px";
}

function openCurtainPartecipanti() {
  document.getElementById("myCurtainPartecipanti").style.left = "57.7%";
}

function closeCurtainPartecipanti() {
  document.getElementById("myCurtainPartecipanti").style.left = "95.5%";
}

function resCambiaPassword() {
  document.getElementById('changeResult').innerHTML="Password Errata";
}

function insertProject(){
  if (clicksUtente%2==0 || clicksPass%2==0 || clicksOption%2==0||clicksPartecipanti%2==0) {}
  else {
    if(clicksAdd==1){
      var allchecks = document.getElementsByName('ck');
      var i = 0;
      var n = allchecks.length;
      for(; i < n; i++){
        allchecks[i].disabled=true;
      }
      $('.ckbox label').off('click');
      clicksAdd=2;
      document.getElementById('rowAgg').style = '';
      document.getElementById('plusButton').setAttribute('class', 'btn btn-sm navbar-btn glyphicon glyphicon-minus'); 
      document.getElementById('nomeProg').focus();
    }
    else {
      var allchecks = document.getElementsByName('ck');
      var i = 0;
      var n = allchecks.length;
      for(; i < n; i++){
        allchecks[i].disabled=false;
      }
      $('.ckbox label').on('click', function () {
        $(this).parents('tr').toggleClass('selected');
      });
      clicksAdd=1;
      document.getElementById('rowAgg').style = 'display:none;';
      document.getElementById('plusButton').setAttribute('class', 'btn btn-sm navbar-btn glyphicon glyphicon-plus');
      document.getElementById('nomeProg').blur();
      document.getElementById('nomeProg').value='';
      document.getElementById('descProg').value='';
      document.getElementById('dataScad').value='';
    }
  }
}


function checkProgInfo() {
  if(document.formInserisci.nomeProg.value == ""){
    alert("Inserisci un nome per il nuovo progetto");
    return false;
  }
  if(document.formInserisci.descProg.value == ""){
    alert("Inserisci una breve descrizione del progetto");
    return false;
  }
  if(document.formInserisci.dataScad.value == ""){
    alert("Inserisci la data di scadenza del progetto");
    return false;
  }

  return true;
}

function selezioneElimina(){
  var allchecks = document.getElementsByName('ck');
  var i = 0;
  var n = allchecks.length;

  for(; i < n; i++){
    if(allchecks[i].checked) {
      document.getElementById('plusButton').style.pointerEvents = 'none';
      document.getElementById('menuButton').style.pointerEvents = 'none';
      document.getElementById('optionsButton').style.pointerEvents = 'none';
      document.getElementById('userButton').style.pointerEvents = 'none';
      document.getElementById('partecipantiButton').style.pointerEvents = 'none';
      document.getElementById('deleteButton').setAttribute('style', ' float:left;');
      return;
    }
  }

  document.getElementById('deleteButton').setAttribute('style', "display:none;");
  document.getElementById('plusButton').style.pointerEvents = 'auto';
  document.getElementById('menuButton').style.pointerEvents = 'auto';
  document.getElementById('optionsButton').style.pointerEvents = 'auto';
  document.getElementById('partecipantiButton').style.pointerEvents = 'auto';
  document.getElementById('userButton').style.pointerEvents = 'auto';
}

function eliminaMembri() {
  var allchecks = document.getElementsByName('part');
  var i = 0;
  var n = allchecks.length;

  for(; i < n; i++){
    if(allchecks[i].checked) {
      document.getElementById('plusButton').style.pointerEvents = 'none';
      document.getElementById('menuButton').style.pointerEvents = 'none';
      document.getElementById('optionsButton').style.pointerEvents = 'none';
      document.getElementById('userButton').style.pointerEvents = 'none';
      document.getElementById('partecipantiButton').style.pointerEvents = 'none';
      document.getElementById('elimButton').setAttribute('style', ' float: center;');
      return;
    }
  }

  document.getElementById('elimButton').setAttribute('style', "display:none;");
  document.getElementById('plusButton').style.pointerEvents = 'auto';
  document.getElementById('menuButton').style.pointerEvents = 'auto';
  document.getElementById('optionsButton').style.pointerEvents = 'auto';
  document.getElementById('partecipantiButton').style.pointerEvents = 'auto';
  document.getElementById('userButton').style.pointerEvents = 'auto';
}