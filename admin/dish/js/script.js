// Get modal DOM reference and configure it.
var modal = document.getElementById("add-modal");

// Get open button DOM reference and configure it.
var openButton = document.getElementById("new-dish-button");
openButton.onclick = function() { modal.style.display = "block"; }

// Configure close button.
var closeButton = document.getElementsByClassName("close")[0];
closeButton.onclick = function() { modal.style.display = "none"; }

// Configure confirm button.
confirmButton = document.getElementById("confirm-button");
confirmButton.onclick = function()
{
    $.post("../../api/dish/addDish.php",
    {
        name: document.getElementById("add-name").value,
        price: document.getElementById("add-price").value,
        waiting_time: document.getElementById("add-waiting-time").value,
        category: document.getElementById("add-category").value,
        description: document.getElementById("add-description").value,
        image_url: document.getElementById("add-image-url").value
    })
    .done(function(data)
    {
        alert(JSON.stringify(data));
    })
}

// Configure window.
window.onclick = function(event) 
{
    // Close modal.
    if (event.target == modal)
        modal.style.display = "none";
}

$(document).ready(function() {
    $.get("../../api/dish/getDishes.php", function data() { })
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
                    editableColumns: "0, 1, 2, 3, 4, 5",
                    onEdit: function($row)
                    {
                        $.post("../../api/dish/updateDish.php", 
                            { 
                                id: $row.children("#id").text(),
                                name: $row.children("#name").text(),
                                price: $row.children("#price").text(),
                                waiting_time: $row.children("#waiting_time").text(),
                                category: $row.children("#category").text(),
                                description: $row.children("#description").text(),
                                image_url: $row.children("#image_url").text()
                            }).done(function(data) { if (data) alert(data); });
                    },
                    onBeforeDelete: function($row) 
                    {
                        $.post("../../api/dish/removeDish.php", 
                            { 
                                dish_id: $row.children("#id").text() 
                            }).done(function(data) { if (data) alert(data); });
                        return true;
                    }
                });
                example1.init();
            });
});