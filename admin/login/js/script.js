var _mail = document.getElementById("mail");
var _password = document.getElementById("password");
var _loginButton = document.getElementById("login");

_loginButton.onclick = function()
{
    alert(_mail.value);
    $.post("../../../api/user/userLogin.php", {
        mail: _mail.value,
        password: _password.value
    })
    .done(function(result) {
        alert(JSON.stringify(result));
    })
}