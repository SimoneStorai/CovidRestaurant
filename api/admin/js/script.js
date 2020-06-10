$(document).ready(function() {
    $.get("../../api/getDishes.php", function data() { })
            .done(function(dishes) {
                alert("fuck");
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
                            <td id="description">${dish["description"]}</td>
                            <td id="image_url">${dish["image_url"]}</td>
                            <td id="units">${dish["units"]}</td>
                        </tr>
			  	    </tbody>`);
                }

                // Load the table.
                var example1 = new BSTable("table", {
                    editableColumns: "0, 1, 2, 3, 4",
                    onEdit: function($row)
                    {
                        $.post("../../api/updateDish.php", 
                            { 
                                id: $row.children("#id").text(),
                                name: $row.children("#name").text(),
                                price: $row.children("#price").text(),
                                waiting_time: $row.children("#waiting_time").text(),
                                description: $row.children("#description").text(),
                                image_url: $row.children("#image_url").text()
                            })
                            .done(function(data) {
                                alert(JSON.stringify(data));
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