$(document).ready(function() {
    $.get("../../api/getDishIngredients.php", function data() { })
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
                    $addButton: $('#new-ingredient-button'),
                    onAdd: function($row)
                    {
                        $.post("../../../api/addDishIngredient.php",
                            {
                                name: "Nome",
                                quantity: 0.00,
                            });
                    },
                    onEdit: function($row)
                    {
                        $.post("../../../api/updateDishIngredient.php", 
                            { 
                                id: $row.children("#id").text(),
                                name: $row.children("#name").text(),
                                quantity: $row.children("#quantity").text(),
                            });
                    },
                    onBeforeDelete: function($row) 
                    {
                        $.post("../../../api/removeDishIngredient.php", 
                            { 
                                ingredient_id: $row.children("#id").text() 
                            });
                    }
                });
                example1.init();
            });
});