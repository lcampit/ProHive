function checkInput() {
    var mail = document.formCrea.mail.value;
    if(mail==""){
        alert("Inserisci la tua mail");
        return false;
    }
    var pass = document.formCrea.pass.value;
    if(pass==""){
        alert("Inserisci una Password");
        return false;
    }
    return true;
}
