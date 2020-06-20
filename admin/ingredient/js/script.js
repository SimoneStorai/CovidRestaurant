// Get modal DOM reference and configure it.
var modal = document.getElementById("add-modal");

// Get open button DOM reference and configure it.
var openButton = document.getElementById("new-ingredient-button");
openButton.onclick = function() { modal.style.display = "block"; }

// Configure close button.
var closeButton = document.getElementsByClassName("close")[0];
closeButton.onclick = function() { modal.style.display = "none"; }

// Configure confirm button.
confirmButton = document.getElementById("confirm-button");
confirmButton.onclick = function()
{
    // Add new user.
    $.post("../../../api/ingredient/addIngredient.php",
        {
            name: document.getElementById("add-name").value,
            quantity: document.getElementById("add-quantity").value
        }).done(function(data) { if (data) alert(data); });
}

// Configure window.
window.onclick = function(event) 
{
    // Close modal.
    if (event.target == modal)
        modal.style.display = "none";
}

$(document).ready(function() {
    $.get("../../api/ingredient/getIngredients.php", function data() { })
            .done(function(ingredients) {
                for (i = 0; i < ingredients.length; i++)
                {
                    // Populate a new box with ingredient info.
                    // Append it to the slider.
                    var ingredient = ingredients[i];
                    $('#table').append(`
                    <tbody>
                        <tr>
                            <th scope="row" id="id">${ingredient["id"]}</th>
                            <td id="name">${ingredient["name"]}</td>
                            <td id="quantity">${ingredient["quantity"]}</td>
                        </tr>
			  	    </tbody>`);
                }

                // Load the table.
                var example1 = new BSTable("table", {
                    editableColumns: "0, 1, 2, 3, 4",
                    onAdd: function($row)
                    {
                        $.post("../../../api/ingredient/addIngredient.php",
                            {
                                name: "Nome",
                                quantity: 0.00,
                            }).done(function(data) { if (data) alert(data); });
                    },
                    onEdit: function($row)
                    {
                        $.post("../../../api/ingredient/updateIngredient.php", 
                            { 
                                id: $row.children("#id").text(),
                                name: $row.children("#name").text(),
                                quantity: $row.children("#quantity").text(),
                            }).done(function(data) { if (data) alert(data); });
                    },
                    onBeforeDelete: function($row) 
                    {
                        $.post("../../../api/ingredient/removeIngredient.php", 
                            { 
                                ingredient_id: $row.children("#id").text() 
                            }.done(function(data) { if (data) alert(data); }));         
                        return true;
                    }
                });
                example1.init();
            });
});