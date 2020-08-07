function validiateFrom(){
    // Showing The Error for the Userfeld if that are Empty:-
    var username = document.getElementById("nameValue").value;
    if(username==""){
        document.getElementById("userErr").innerText= "Username Field Are Mandoatory.";
        return false;
    }
    // Showing the Error for the Password Fields If they are Empty:-
    var  password = document.getElementById("passwordValue").value;
    if(password==""){
        document.getElementById("passwordErr").innerText= "Password Field Are Mandoatory.";
        return false;
    }
    return true
}

