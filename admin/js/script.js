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
                            <th scope="row">${dish["id"]}</th>
                            <td>${dish["name"]}</td>
                            <td>${dish["price"]}</td>
                            <td>${dish["waiting_time"]}</td>
                            <td>${dish["description"]}</td>
                            <td>${dish["image_url"]}</td>
                            <td>${dish["units"]}</td>
                        </tr>
			  	    </tbody>`);
                }

                // Load the table.
                var example1 = new BSTable("table", {
                    editableColumns: "0, 1, 2, 3, 4",
                    onBeforeDelete: function($row) 
                    {
                        $.post("../../api/removeDish.php", { dish_id: $row.children().html() })
                            .done(function(data) {
                                alert(JSON.stringify(data));
                            });
                    }
                });
                example1.init();
            });
});