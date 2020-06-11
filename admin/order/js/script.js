$(document).ready(function() {
    $.get("../../api/getOrders.php", function data() { })
            .done(function(orders) {
                for (i = 0; i < orders.length; i++)
                {
                    // Populate a new box with order info.
                    // Append it to the slider.
                    var order = orders[i];
                    $('#table').append(`
                    <tbody>
                        <tr>
                            <th scope="row" id="id">${order["id"]}</th>
                            <td id="table_id">${order["table_id"]}</td>
                            <td id="timestamp">${order["timestamp"]}</td>
                            <td id="price">${order["price"]}</td>
                            <td id="ref"><a href="../orderDish?order_id=${order["id"]}">Pietanze</a></td>
                        </tr>
			  	    </tbody>`);
                }

                // Load the table.
                var example1 = new BSTable("table", {
                    editableColumns: "",
                    advanced: { 
                        columnLabel: 'Azioni',
                        buttonHTML: `<div class="btn-group pull-right">
                              <button id="bEdit" type="button" class="btn btn-sm btn-default">
                                  <span class="fa fa-edit" > </span>
                              </button>
                              <button id="bAcep" type="button" class="btn btn-sm btn-default" style="display:none;">
                                  <span class="fa fa-check-circle" > </span>
                              </button>
                              <button id="bCanc" type="button" class="btn btn-sm btn-default" style="display:none;">
                                  <span class="fa fa-times-circle" > </span>
                              </button>
                          </div>`
                    }
                });
                example1.init();
            });
});