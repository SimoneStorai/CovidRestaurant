// Local dish ID.
var _dish_id = 0;

// Ingredient add modal.
var has_loaded = false;
var _ingredient_id = 0;

// Get modal DOM reference and configure it.
var modal = document.getElementById("add-modal");

// Get dropdown content DOM reference.
var dropdownButton = document.getElementById("ingredient-dropdown-button");
var dropdownContent = document.getElementById("ingredient-dropdown-content");

// Get open button DOM reference and configure it.
var openButton = document.getElementById("new-dish-ingredient-button");
openButton.onclick = function()
{
    // Open modal.
    modal.style.display = "block";

    if (!has_loaded)
    {
        $.get("../../api/getIngredients.php", function data() { })
            .done(function(ingredients) {
                var html = "";
                for (var i = 0; i < ingredients.length; i++)
                {
                    // Get ingredient reference.
                    var ingredient = ingredients[i];
                    html += `<a href="#" onclick="setIngredient(${ingredient["id"]}, '${ingredient["name"]}')">${ingredient["name"]}</a>`;
                }
                dropdownContent.innerHTML = html;
                has_loaded = true;
            });
    }
}

// Configure close button.
var closeButton = document.getElementsByClassName("close")[0];
closeButton.onclick = function() { modal.style.display = "none"; }

// Configure confirm button.
confirmButton = document.getElementById("confirm-button");
confirmButton.onclick = function()
{
    if (_ingredient_id > 0)
    {
        alert(document.getElementById("ingredient-quantity").innerText);
        // Add new dish ingredient.
        $.post("../../../api/addDishIngredient.php",
            {
                dish_id: _dish_id,
                ingredient_id: _ingredient_id,
                quantity: document.getElementById("ingredient-quantity").value
            });
    }
}

// Configure window.
window.onclick = function(event) 
{
    // Close modal.
    if (event.target == modal)
        modal.style.display = "none";
}

$(document).ready(function() {
    // Parse dish ID.
    _dish_id = findGetParameter("id");

    $.get(`../../api/getDishIngredients.php?id=${_dish_id}`, function data(){})
            .done(function(ingredients) 
            {
                // Populate a new box with ingredient info.
                for (var i = 0; i < ingredients.length; i++)
                {
                    // Get ingredient reference.
                    var ingredient = ingredients[i];

                    // Append info to the slider.
                    $('#table').append(`
                    <tbody>
                        <tr>
                            <th scope="row" id="ingredient_id">${ingredient["id"]}</th>
                            <td id="name">${ingredient["name"]}</td>
                            <td id="stock_quantity">${ingredient["stock_quantity"]}</td>
                            <td id="required_quantity">${ingredient["required_quantity"]}</td>
                        </tr>
                    </tbody>`);
                }

                // Load the table.
                var example1 = new BSTable("table", {
                    editableColumns: "2",
                    onEdit: function($row)
                    {
                        $.post("../../../api/updateDishIngredient.php", 
                            { 
                                dish_id: _dish_id,
                                ingredient_id: $row.children("#ingredient_id").text(),
                                quantity: $row.children("#required_quantity").text()
                            });
                    },
                    onBeforeDelete: function($row) 
                    {
                        $.post("../../../api/removeDishIngredient.php", 
                            { 
                                dish_id: _dish_id,
                                ingredient_id: $row.children("#ingredient_id").text()
                            });
                    }
                });
                example1.init();
            });
});

function findGetParameter(parameterName) 
{
    var result = null,
        tmp = [];
    var items = location.search.substr(1).split("&");
    for (var index = 0; index < items.length; index++) {
        tmp = items[index].split("=");
        if (tmp[0] === parameterName) result = decodeURIComponent(tmp[1]);
    }
    return result;
}

function setIngredient(id, name)
{
    // Select new ingredient.
    _ingredient_id = id;
    dropdownButton.textContent = name;
}