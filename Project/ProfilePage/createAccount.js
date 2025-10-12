document.getElementById('registration').addEventListener('submit',function(event){
    // gets the values inputed in password and confirm password locations
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('confirmPassword').value;
    const passwordPattern = '/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/';
    // checks thats passwords match.
    if(password !== confirmPassword){
        alert('Passwords do not match!');
        event.preventDefault(); //prevents form submission
        return;
    }
    // check password requirements
    if (!passwordPattern.test(password)) {
        alert('Password does not meet requirements.\nMust contain at least one number, one uppercase, and one lowercase letter, and be at least 8 characters long.');
        event.preventDefault(); // prevents form submission
        return; // exit the function early
    }
});
function showPassAndConf(){
    var x = document.getElementById("password");
    var y = document.getElementById("confirmPassword");
    if(x.type === "password"){
        x.type = "text";
        y.type = "text";
    }else{
        x.type = "password";
        y.type = "password";
    }
}
