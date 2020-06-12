var _dish_id = 0;

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

$(document).ready(function() {
    // Parse dish ID.
    _dish_id = findGetParameter("id");

    $.get(`../../api/getDishIngredients.php?id=${_dish_id}`, function data(){})
            .done(function(ingredient) {
                // Populate a new box with ingredient info.
                // Append it to the slider.
                $('#table').append(`
                <tbody>
                    <tr>
                        <th scope="row" id="ingredient_id">${ingredient["id"]}</th>
                        <td id="name">${ingredient["name"]}</td>
                        <td id="stock_quantity">${ingredient["stock_quantity"]}</td>
                        <td id="required_quantity">${ingredient["required_quantity"]}</td>
                    </tr>
                </tbody>`);

                // Load the table.
                var example1 = new BSTable("table", {
                    editableColumns: "2",
                    $addButton: $('#new-ingredient-button'),
                    onAdd: function($row)
                    {
                        $.post("../../../api/addDishIngredient.php",
                            {
                                dish_id: _dish_id,
                                ingredient_id: $row.children("#ingredient_id").text(),
                                quantity: $row.children("#quantity").text()
                            });
                    },
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
                            }).done(function(data) { alert(JSON.stringify(data)); });
                    }
                });
                example1.init();
            });
});