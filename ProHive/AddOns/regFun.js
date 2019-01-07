function checkInput() {
    var cn = document.formCrea.nome.value;
    if(cn == "") {
        alert("Inserisci il tuo Nome");
        return false;
    }
    var nm = document.formCrea.cognome.value;
    if(nm =="") {
        alert("Inserisci il tuo Cognome");
        return false;
    }
    var mail = document.formCrea.mail.value;
    if(mail==""){
        alert("Inserisci la tua mail");
        return false;
    }
    var pass1 = document.formCrea.pass1.value;
    if(pass1==""){
        alert("Inserisci una Password");
        return false;
    }
    if(pass1.length < 8) {
        alert("La password deve essere lunga almeno 8 caratteri");
        return false;
    }
    var pass2 = document.formCrea.pass2.value;
    if(pass2==""){
        alert("Scrivi nuovamente la tua password");
        return false;
    }
    if(pass1 != pass2) {
        alert("Le password devono coincidere");
        document.formCrea.pass1.value = "";
        document.formCrea.pass2.value = "";
        return false;
    }
    return true;
}