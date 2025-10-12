document.getElementById('registration').addEventListener('submit',function(event){
    // gets the values inputed in password and confirm password locations
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('confirm_password').value;

    // checks thats passwords match.
    if(password !== confirmPassword){
        alert('Passwords do not match!');
        event.preventDefault(); //prevents form submission
    }
});
