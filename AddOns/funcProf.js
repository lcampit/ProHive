$(document).ready(function () {

	$('.star').on('click', function () {
      $(this).toggleClass('star-checked');
    });

    $('.ckbox label').on('click', function () {
      $(this).parents('tr').toggleClass('selected');
    });

    $('.btn-filter').on('click', function () {
      var $target = $(this).data('target');
      if ($target != 'all') {
        $('.table tr').css('display', 'none');
        $('.table tr[data-status="' + $target + '"]').fadeIn('slow');
      } else {
        $('.table tr[data-status="scaduti"]').css('display', 'none').fadeIn('slow');
        $('.table tr[data-status="inscadenza"]').css('display', 'none').fadeIn('slow');
        $('.table tr[data-status="incorso"]').css('display', 'none').fadeIn('slow');
      }
    });

 });

var clicksPass=1;
var clicksAdd=1;
var clicksOption = 1;
var clicksUtente = 1;

function curtainPass () {
  if (clicksOption%2==0 || clicksUtente%2==0 || clicksAdd==2){}
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
  if(clicksPass%2==0 || clicksUtente%2==0 || clicksAdd==2){}
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
  if (clicksPass%2==0 || clicksOption%2==0 || clicksAdd==2){}
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

function resCambiaPassword() {
  document.getElementById('changeResult').innerHTML="Password Errata";
}

function calcolaStatus(anno, mese, giorno, numID) {
  var dataScad = new Date(anno, mese -1, giorno);
  var today = new Date();
  var diff = dataScad.getTime() - today.getTime();
  if ((diff)<=0){
    document.getElementById("flag"+numID).innerHTML='Scaduto';
    document.getElementById("flag"+numID).classList.add("scaduti");
    document.getElementById('row'+numID).setAttribute('data-status', 'scaduti');
  }
  else if ((diff)<604800000 && (diff)>0){
    document.getElementById("flag"+numID).innerHTML='In scadenza';
    document.getElementById("flag"+numID).classList.add("inscadenza");
    document.getElementById('row'+numID).setAttribute('data-status', 'inscadenza');
  }
  else {
    document.getElementById("flag"+numID).innerHTML='In corso';
    document.getElementById("flag"+numID).classList.add("incorso");
    document.getElementById('row'+numID).setAttribute('data-status', 'incorso');
  }

  document.getElementById('checkbox'+numID).setAttribute('onclick', 'selezioneElimina();');
}

function insertProject(){
  if (clicksUtente%2==0 || clicksPass%2==0 || clicksOption%2==0) {}
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
      document.getElementById('buttAll').style.pointerEvents = 'none';
      document.getElementById('buttScadenza').style.pointerEvents = 'none';
      document.getElementById('buttCorso').style.pointerEvents = 'none';
      document.getElementById('buttScaduti').style.pointerEvents = 'none';
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
      document.getElementById('buttAll').style.pointerEvents = 'auto';
      document.getElementById('buttScadenza').style.pointerEvents = 'auto';
      document.getElementById('buttCorso').style.pointerEvents = 'auto';
      document.getElementById('buttScaduti').style.pointerEvents = 'auto';
      document.getElementById('nomeProg').value='';
      document.getElementById('descProg').value='';
      document.getElementById('dataScad').value='';
    }
  }
}


function checkProgInfo() {
  if(document.getElementById('nomeProg').value == ""){
    alert("Inserisci un nome per il nuovo progetto");
    return false;
  }
  if(document.getElementById('descProg').value == ""){
    alert("Inserisci una breve descrizione del progetto");
    return false;
  }
  if(document.getElementById('dataScad').value == ""){
    alert("Inserisci la data di scadenza del progetto");
    return false;
  }

  $("input[name=dataScad]")[0].oninvalid = function () {
    this.setCustomValidity("Inserisci una data corretta");
    this.setCustomValidity("");
};

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
      document.getElementById('deleteButton').setAttribute('style', ' float:left;');
      document.getElementById('abbandonaButton').setAttribute('style', ' float:left;');
      return;
    }
  }

  document.getElementById('deleteButton').setAttribute('style', "display:none;");
  document.getElementById('abbandonaButton').setAttribute('style', "display:none;");
  document.getElementById('plusButton').style.pointerEvents = 'auto';
  document.getElementById('menuButton').style.pointerEvents = 'auto';
  document.getElementById('optionsButton').style.pointerEvents = 'auto';
  document.getElementById('userButton').style.pointerEvents = 'auto';
}