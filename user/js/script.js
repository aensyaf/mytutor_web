function rememberMe(){
    var email = document.forms["loginForm"]["emailid"].value;
    var password = document.forms["loginForm"]["passid"].value;
    var remember = document.forms["loginForm"]["rememberid"].checked;

    console.log("Form data: " + remember + "," + email + "," + password);

    if(!remember){
        setCookies("cemail", "", 0);
        setCookies("cpass", "", 0);
        setCookies("crem", false, 0);

        document.forms["loginForm"]["emailid"].value = "";
        document.forms["loginForm"]["passid"].value = "";
        document.forms["loginForm"]["rememberid"].checked = false;

        alert("Credentials has been removed succesfully")
    }else{
        if(email == "" && password == ""){
            document.forms["loginForm"]["rememberid"].checked = false;
            alert("Please enter you credentials");
            return false;
        }else{
            setCookies("cemail", email, 30);
            setCookies("cpass", password, 30);
            setCookies("crem", remember, 30);
            alert("Credentials has been stored succesfully");
        }
    }
}

function setCookies(cookiename, cookiedata, exdays){
    var d = new Date();
    d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
    var expires = "expires= " + d.toUTCString();
    document.cookie = cookiename + "=" + cookiedata + ";" + expires + ";path=/";
}

function getCookie(cname) {
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}

function loadCookies() {
    var email = getCookie("cemail");
    var password = getCookie("cpass");
    var remember = getCookie("crem");

    console.log("COOKIES:" + email + password + remember);
    
    document.forms["loginForm"]["emailid"].value = email;
    document.forms["loginForm"]["passid"].value = password;
    if (remember) {
        document.forms["loginForm"]["rememberid"].checked = true;
    } else {
        document.forms["loginForm"]["rememberid"].checked = false;
    }
}

function deleteCookie(cname) {
    const d = new Date();
    d.setTime(d.getTime() + (24 * 60 * 60 * 1000));
    let expires = "expires=" + d.toUTCString();
    document.cookie = cname + "=;" + expires + ";path=/";
}

function acceptCookieConsent() {
    deleteCookie('user_cookie_consent');
    setCookies('user_cookie_consent', 1, 30);
    document.getElementById("cookieNotice").style.display = "none";
}

function previewFile(){
    const preview = document.querySelector('.w3-image');
    const file = document.querySelector('input[type=file]').files[0];
    const reader = new FileReader();
    reader.addEventListener("load", function() {
        preview.src = reader.result;
    }, false);

    if(file){
        reader.readAsDataURL(file);
    }
}

function confirmDialog(){
    var r = confirm("Register your account now?");
    if(r == true){
       return true;
    } else{
         return false;
    }
 }