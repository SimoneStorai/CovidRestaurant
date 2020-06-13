// Get modal DOM reference and configure it.
var modal = document.getElementById("add-modal");

// Get open button DOM reference and configure it.
var openButton = document.getElementById("new-user-button");
openButton.onclick = function() { modal.style.display = "block"; }

// Configure close button.
var closeButton = document.getElementsByClassName("close")[0];
closeButton.onclick = function() { modal.style.display = "none"; }

// Configure confirm button.
confirmButton = document.getElementById("confirm-button");
confirmButton.onclick = function()
{
    // Add new user ingredient.
    $.post("../../../api/user/addUser.php",
        {
            mail: document.getElementById("add-mail").value,
            password: document.getElementById("add-password").value,
            name: document.getElementById("add-name").value
        })                            
        .done(function(data)
        {
            alert(JSON.stringify(data));
        });
}

// Configure window.
window.onclick = function(event) 
{
    // Close modal.
    if (event.target == modal)
        modal.style.display = "none";
}

$(document).ready(function() {
    $.get("../../api/user/getUsers.php", function data() { })
            .done(function(users) {
                for (i = 0; i < users.length; i++)
                {
                    // Populate a new box with user info.
                    // Append it to the slider.
                    var user = users[i];
                    $('#table').append(`
                    <tbody>
                        <tr>
                            <th scope="row" id="id">${user["id"]}</th>
                            <td id="mail">${user["mail"]}</td>
                            <td id="name">${user["name"]}</td>
                        </tr>
			  	    </tbody>`);
                }

                // Load the table.
                var example1 = new BSTable("table", {
                    editableColumns: "0, 1",
                    onEdit: function($row)
                    {
                        $.post("../../../api/user/updateUser.php", 
                            { 
                                id: $row.children("#id").text(),
                                name: $row.children("#name").text()
                            });
                    },
                    onBeforeDelete: function($row) 
                    {
                        $.post("../../../api/user/removeUser.php", 
                            { 
                                id: $row.children("#id").text()
                            });
                    }
                });
                example1.init();
            });
});