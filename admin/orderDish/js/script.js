function findGetParameter(parameterName) {
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
    $.get(`../../api/getOrder.php?id=${findGetParameter("id")}`, function data() { })
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
                            <td id="name">${order["name"]}</td>
                            <td id="price">${order["price"]}</td>
                            <td id="waiting_time">${order["waiting_time"]}</td>
                            <td id="description">${order["description"]}</td>
                            <td id="category">${order["category"]}</td>
                            <td id="quantity">${order["quantity"]}</td>
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