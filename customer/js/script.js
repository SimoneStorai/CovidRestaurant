var TABLE_ID = 0;

function getMenu(cat) {
  $.get("../api/dish/getDishes.php", { category: cat, ignoreEmpty: true })
    .done(function(data) {
        var output = '';
        for (var i = 0; i < data.length; i++)
        {
          var id = data[i].id;
          var name = data[i].name;
          var price = data[i].price;
          var waiting_time = data[i].waiting_time;
          var description = data[i].description;
          var image_url = data[i].image_url;
          output += `
          <div class="menu-item-con">
            <div class="menu-item" id="${id}" onclick="addOrder(${id}, '${name}', ${price})" style="background: url('${image_url}') no-repeat center;>
              <div class="name-con"></div>
              <div class="item-info">
                ${name}<br>
                ${price}<br>
                ${waiting_time}<br>
                ${description}
              </div>
            </div>
          </div>`;
        }
        $('.super-inner-right').html(output);
        $('#categ').html(cat);
    });
}


function randomString(length) {
    var text = "";
    var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
    for(var i = 0; i < length; i++) {
        text += possible.charAt(Math.floor(Math.random() * possible.length));
    }
    return text;
}

function showOrders(){
  var result = "";
  var total = "";
  var orders = JSON.parse(localStorage.orders);
  for(var f=0;f<orders.length;f++) {
  result += '<div class="itembox" id="'+orders[f][0]+'"><div class="alignleft"><span class="plus" onclick="popUp(\''+orders[f][0]+'\',\''+orders[f][1]+'\',\''+orders[f][2]+'\',\''+f+'\')">+</span>&nbsp&nbsp'+orders[f][1].toLowerCase()
  +' ('+orders[f][3]+')</div><div class="alignright">'+orders[f][2]
  +'.00 &nbsp<span class="minus" onclick="removeOrder(\''+f+'\',\''
  +orders[f][2]
  +'\')">-</span></div><div style="clear: both;"></div></div>';
    if(orders[f][4].length > 0) {
      for(var g=0;g<orders[f][4].length;g++) {
        result += '<div class="itembox" id="'+orders[f][4][g][0]+'"><div class="alignleft">--'+orders[f][4][g][1].toLowerCase()
        +' ('+orders[f][4][g][3]+')</div><div class="alignright">'+orders[f][4][g][2]
        +'.00 &nbsp<span class="minus" onclick="removeAddOn(\''+f+'\',\''
        +g+'\',\''
        +orders[f][4][g][2] + '\')">-</span></div><div style="clear: both;"></div></div>';
      }
    }
    }
  result += '<div class="focus" tabindex="1"></div>';
  total = "Totale: " + localStorage.total + ".00";
  $('#bill').html(result);
  $('#bill-total').html(total);
}


function popUp(orderId, orderName, orderPrice, orderpos) 
{
  modal.style.display = "block";
  localStorage.origid = orderId;
  localStorage.origpos = orderpos;
  localStorage.change = 0;
  var orders = JSON.parse(localStorage.orders);
  if (orderId.indexOf('-') < 0)
  {
    if (!localStorage.addCode)
      localStorage.addCode = 1;
    var addCode = localStorage.addCode;
    var newId = orderId.toString() + "-" + addCode.toString();
    orders[orderpos][0] = newId;
    localStorage.addCode ++;
  }
  localStorage.orders = JSON.stringify(orders);
  showOrders();
}

function addOn(orderId,orderName,orderPrice) {
  var orders = JSON.parse(localStorage.orders);
  var parentId = localStorage.origid;
  var parentPos = localStorage.origpos;
  var addlist = [orderId,orderName,orderPrice,1];

  var counter = 0;
  var exist;
  for(var x=0;x<orders[parentPos][4].length;x++){
    if($.inArray(orderId, orders[parentPos][4][x]) !== -1) {
      counter ++;
      exist = x;
    }
  }
  if (counter > 0) {
    orders[parentPos][4][exist][3] += 1;
    var orderSum = parseInt(orders[parentPos][4][exist][2]);
    orderSum += parseInt(orderPrice);
    var orderTotal = parseInt(localStorage.total);
    orderTotal += parseInt(orderPrice);
    orders[parentPos][4][exist][2] = orderSum.toString();
    localStorage.total=orderTotal.toString();
  }
  else {
    var toPush=[orderId,orderName,orderPrice,1];
    orders[parentPos][4].push(toPush);
    var orderTotal = parseInt(localStorage.total);
    orderTotal += parseInt(orderPrice);
    localStorage.total=orderTotal.toString();
  }

  if(orders) {
  localStorage.orders = JSON.stringify(orders);
  showOrders();
  }
  localStorage.change = 1;
}



function addOrder(orderId,orderName,orderPrice) {
  if(!localStorage.orderId) {
    localStorage.orderId = randomString(11);
    var orders=[];
    localStorage.total="0";
  }
  else {
    orders = JSON.parse(localStorage.orders);
    var total = localStorage.total;
  }
  var counter = 0;
  var exist;
  for(var x=0;x<orders.length;x++){
    if($.inArray(orderId, orders[x]) !== -1) {
      counter ++;
      exist = x;
    }
  }
  if (counter > 0) {
    orders[exist][3] += 1;
    var orderSum = parseInt(orders[exist][2]);
    orderSum += parseInt(orderPrice);
    var orderTotal = parseInt(localStorage.total);
    orderTotal += parseInt(orderPrice);
    orders[exist][2] = orderSum.toString();
    localStorage.total=orderTotal.toString();
  }
  else {
    orders.push([orderId,orderName,orderPrice,1,[]]);
    var orderTotal = parseInt(localStorage.total);
    orderTotal += parseInt(orderPrice);
    localStorage.total=orderTotal.toString();
  }

  if(orders) {
  localStorage.orders = JSON.stringify(orders);
  showOrders();
  }
    $('.focus')[0].focus();
}

function removeOrder(pos, price) 
{
  orders = JSON.parse(localStorage.orders);
  if(orders[pos][4])
    for(var h=0;h<orders[pos][4].length;h++)
      localStorage.total=(
        + parseInt(localStorage.total)
        - parseInt(orders[pos][4][h][2])).toString();
  orders.splice(pos,1);
  localStorage.orders = JSON.stringify(orders);
  localStorage.total=(parseInt(localStorage.total)-parseInt(price)).toString();
  showOrders();
}

function clearOrder() 
{
  localStorage.clear();
  $('#bill').html("Nessun ordine.");
  $('#bill-total').html("Totale: 00.00");
}

function takeOrder() 
{
  // Get orders data, stored in local storage.
  var _orders = [];
  var orders = JSON.parse(localStorage.orders);
  for (var i = 0; i < orders.length; i++)
  {
    // Get order.
    var order = orders[i];

    // Append order to serialization orders array.
    _orders[i] = {
      id: order[0],
      quantity: order[3]
    }
    clearOrder();
  }

  $.post("../api/order/takeOrder.php", 
    { 
      table_id: TABLE_ID, 
      orders: _orders
    }).done(function(data) { if (data) alert(data); });
}


if(localStorage.orderId){
  showOrders();
}
else{
  $('#bill').html("Nessun ordine.");
}
getMenu('Dolci');