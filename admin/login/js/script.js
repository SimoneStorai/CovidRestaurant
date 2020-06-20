var _mail = document.getElementById("mail");
var _password = document.getElementById("password");
var _loginButton = document.getElementById("login");

_loginButton.onclick = function()
{
    $.post("../../../api/user/userLogin.php", {
        mail: _mail.value,
        password: _password.value
    })
    .done(function(result)
    {
        if (!result)
        {
            // Remember username.
            localStorage.username = _mail.value;

            // Go to main menu.
            location = "../menu.html";
        }
        else alert(result);
    });
}