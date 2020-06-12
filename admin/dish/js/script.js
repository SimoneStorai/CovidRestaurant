$(document).ready(function() {
    $.get("../../api/getDishes.php", function data() { })
            .done(function(dishes) {
                for (i = 0; i < dishes.length; i++)
                {
                    // Populate a new box with dish info.
                    // Append it to the slider.
                    var dish = dishes[i];
                    $('#table').append(`
                    <tbody>
                        <tr>
                            <th scope="row" id="id">${dish["id"]}</th>
                            <td id="name">${dish["name"]}</td>
                            <td id="price">${dish["price"]}</td>
                            <td id="waiting_time">${dish["waiting_time"]}</td>
                            <td id="category">${dish["waiting_time"]}</td>
                            <td id="description">${dish["description"]}</td>
                            <td id="image_url">${dish["image_url"]}</td>
                            <td id="units">${dish["units"]}</td>
                            <td id="ingredients"><a href="../dishIngredient?id=${dish["id"]}">Ingredienti</a></td>
                        </tr>
			  	    </tbody>`);
                }

                // Load the table.
                var example1 = new BSTable("table", {
                    editableColumns: "0, 1, 2, 3, 4",
                    $addButton: $('#new-dish-button'),
                    onAdd: function($row)
                    {
                        $.post("../../api/addDish.php",
                            {
                                name: "Nome",
                                price: 0.00,
                                waiting_time: "00:00:00",
                                waiting_time: "Nessuna",
                                description: "Descrizione",
                                image_url: "Immagine"
                            })
                            .done(function(data) {
                                $row.children("#id").text($data["id"]);
                            });
                    },
                    onEdit: function($row)
                    {
                        $.post("../../api/updateDish.php", 
                            { 
                                id: $row.children("#id").text(),
                                name: $row.children("#name").text(),
                                price: $row.children("#price").text(),
                                waiting_time: $row.children("#waiting_time").text(),
                                category: $row.children("#category").text(),
                                description: $row.children("#description").text(),
                                image_url: $row.children("#image_url").text()
                            });
                    },
                    onBeforeDelete: function($row) 
                    {
                        $.post("../../api/removeDish.php", 
                            { 
                                dish_id: $row.children("#id").text() 
                            })
                            .done(function(data) {
                                alert(JSON.stringify(data));
                            });
                    }
                });
                example1.init();
            });
});