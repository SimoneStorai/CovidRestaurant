SELECT d.id, d.name, d.price, d.waiting_time, d.image, 
MIN(FLOOR(i.quantity / di.quantity)) AS units FROM dish_ingredient di
JOIN dish d ON di.dish_id = d.id
JOIN ingredient i ON di.ingredient_id = i.id 
HAVING units > 0;