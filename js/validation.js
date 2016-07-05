function checkSignupForm() {
    var email = $("#signup-email").val(),
            password = $("#signup-password").val(),
            confirmPassword = $("#signup-confirm-password").val(),
            phone = $("#signup-phone").val(),
            firstName = $("#signup-firstName").val(),
            lastName = $("#signup-lastName").val();

    var result = [];
    result["msg"] = "OK";
    if (!isValidEmail(email)) {
        result["msg"] = "Invalid Email";
    } else if (!isValidPassword(password)) {
        result["msg"] = "Invalid Password";
    } else if (!isValidConfirmedPassword(password, confirmPassword)) {
        result["msg"] = "Passwords Don't Match";
    } else if (!isValidPhone(phone)) {
        result["msg"] = "Invalid Phone Number";
    } else if (!isValidName(firstName)) {
        result["msg"] = "Invalid First Name";
    } else if (!isValidName(lastName)) {
        result["msg"] = "Invalid Last Name";
    }
    return result;


}

function checkLoginForm(email, password) {
    var result = [];
    result["msg"] = "OK";
    if (!isValidEmail(email)) {
        result["msg"] = "Invalid Email";
    } else if (!isValidPassword(password)) {
        result["msg"] = "Invalid Password";
    }

        return result;
    }
function isValidEmail(email) {
    var emailPattern = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;

    if (!emailPattern.test(email)) {
        return false;
    }
    else {
        return true;
    }
}
function isValidPhone(phone) {
    var phonePattern = /[0-9]{10,15}/;
    if (!phonePattern.test(phone)) {
        return false;
    }
    else {
        return true;
    }
}
function isValidPassword(password) {
    if (password.length < 1)
        return false;
    return true;
}
function isValidConfirmedPassword(password, confirmPasswrod) {
    if (confirmPasswrod == "" || confirmPasswrod == null || confirmPasswrod != password) {
        return false;
    }
    else {
        return true;
    }
}
function isValidName(name) {
    return true;
}